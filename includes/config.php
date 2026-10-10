<?php
// SA Paycheck — single source of truth for site config and 2026/2027 SARS tax data.
// Tax year: 1 March 2026 – 28 February 2027.
// !! All figures below were verified against SARS / reputable SA sources —
//    see TAX_SOURCES.md for the source list and cross-check test cases.
//    "Last verified" date is shown on /tax-brackets/.

$SITE_NAME   = "SA Paycheck";
$SITE_TAGLINE = "Know your take-home pay.";
$SITE_URL    = "https://sapaycheck.co.za";   // production canonical; temp domain used on Hostinger until DNS cutover
$CONTACT_EMAIL = "contact@sapaycheck.co.za";

$TAX_YEAR_LABEL = "2026/2027";               // SARS naming: year ending 28 Feb 2027
$TAX_YEAR_RANGE = "1 March 2026 – 28 February 2027";
$TAX_LAST_VERIFIED = "2026-10-10";

// PAYE brackets: [upper_limit (annual, inclusive), rate]. Last bracket has no upper limit.
$TAX_BRACKETS = [
    [245100,   0.18],
    [383100,   0.26],
    [530200,   0.31],
    [695800,   0.36],
    [887000,   0.39],
    [1878600,  0.41],
    [PHP_INT_MAX, 0.45],
];

// Rebates (annual, TOTAL subtracted from computed tax).
// SARS quotes secondary/tertiary as additional amounts; totals below:
//   under 65: 17,820 | 65-74: 17,820+9,765=27,585 | 75+: 27,585+3,249=30,834
$REBATE_PRIMARY   = 17820;  // under 65
$REBATE_SECONDARY = 27585;  // 65 to 74 (total)
$REBATE_TERTIARY  = 30834;  // 75 and over (total)

// Tax thresholds (annual income below which no PAYE is payable) — rebate / 0.18
$THRESHOLD_UNDER65 = 99000;
$THRESHOLD_65_74   = 153250;
$THRESHOLD_75PLUS  = 171300;

// UIF — employee contribution
$UIF_RATE      = 0.01;
$UIF_CAP_MONTH = 177.12;    // 1% of the R17,712 monthly remuneration ceiling

// Medical scheme fees tax credits (monthly)
$MTC_MAIN_MEMBER      = 376;
$MTC_FIRST_DEPENDANT  = 376;
$MTC_ADDL_DEPENDANT   = 254;

// Retirement funding deduction cap: 27.5% of remuneration, max R350,000 per year
$PENSION_PCT_CAP = 0.275;
$PENSION_RAND_CAP = 350000;

// ---- shared calculation helpers (used by generated salary pages) ----
function sapc_paye_annual(float $taxableAnnual): float {
    global $TAX_BRACKETS;
    $tax = 0.0; $prev = 0;
    foreach ($TAX_BRACKETS as [$limit, $rate]) {
        if ($taxableAnnual <= $prev) break;
        $inBand = min($taxableAnnual, $limit) - $prev;
        $tax += $inBand * $rate;
        $prev = $limit;
    }
    return $tax;
}

function sapc_rebate(string $ageGroup): int {
    global $REBATE_PRIMARY, $REBATE_SECONDARY, $REBATE_TERTIARY;
    return match ($ageGroup) {
        '65-74' => $REBATE_SECONDARY,
        '75+'   => $REBATE_TERTIARY,
        default => $REBATE_PRIMARY,
    };
}

// Full breakdown for a gross MONTHLY salary, under-65, no deductions (salary pages).
function sapc_breakdown(float $grossMonthly): array {
    $annual = $grossMonthly * 12;
    $payeAnnual = max(0.0, sapc_paye_annual($annual) - sapc_rebate('under65'));
    $uifMonthly = min($grossMonthly * $GLOBALS['UIF_RATE'], $GLOBALS['UIF_CAP_MONTH']);
    $uifAnnual = $uifMonthly * 12;
    $netAnnual = $annual - $payeAnnual - $uifAnnual;
    // marginal bracket
    $bracket = '';
    $prev = 0;
    foreach ($GLOBALS['TAX_BRACKETS'] as [$limit, $rate]) {
        if ($annual > $prev) { $bracket = (int)($rate * 100) . '%'; }
        $prev = $limit;
    }
    return [
        'gross_monthly' => $grossMonthly,
        'gross_annual'  => $annual,
        'paye_annual'   => $payeAnnual,
        'paye_monthly'  => $payeAnnual / 12,
        'uif_monthly'   => $uifMonthly,
        'uif_annual'    => $uifAnnual,
        'net_annual'    => $netAnnual,
        'net_monthly'   => $netAnnual / 12,
        'net_weekly'    => $netAnnual / 52,
        'net_daily'     => $netAnnual / 365,
        'effective_rate'=> $annual > 0 ? ($payeAnnual + $uifAnnual) / $annual : 0,
        'marginal'      => $bracket,
    ];
}

function sapc_r(float $n): string {
    return 'R' . number_format($n, 2, '.', ' ');
}
function sapc_r0(float $n): string {
    return 'R' . number_format(round($n), 0, '.', ' ');
}

// Programmatic salary pages (monthly gross amounts)
$SALARY_LEVELS = [10000, 12500, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000, 60000, 75000, 100000, 125000, 150000];
function sapc_salary_slug(int $n): string {
    return 'r' . $n . '-after-tax';
}
