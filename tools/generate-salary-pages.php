<?php
// CLI generator: builds /salary/{slug}/index.php pages + sitemap.xml from config.php.
// Numbers are COMPUTED via sapc_breakdown() — never hand-typed.
// Usage: php tools/generate-salary-pages.php
require __DIR__ . '/../includes/config.php';

$base = dirname(__DIR__);
$date = '2026-10-10';

$intros = [
    'entry' => [
        "A {gross} monthly salary puts you in South Africa's {marginal} marginal tax bracket for the {year} tax year. After PAYE of {paye_m} a month and UIF of {uif_m}, your take-home pay is {net_m} — {net_a} a year. Your effective deduction rate is {eff}, meaning you keep about {keep} of every rand you earn.",
        "Earning {gross} a month in South Africa? Here's the {year} breakdown: PAYE takes {paye_m} monthly, UIF takes {uif_m}, and you keep {net_m} — an effective rate of {eff}. Your marginal bracket is {marginal}, so each extra rand you earn is taxed at {marginal}."
    ],
    'mid' => [
        "On {gross} a month, the {year} SARS tables put your marginal tax rate at {marginal}. PAYE comes to {paye_m} monthly and UIF is capped at {uif_m}, leaving take-home pay of {net_m} ({net_a} a year) — an effective deduction rate of {eff}.",
        "A {gross} monthly salary in South Africa means {paye_m} in PAYE and {uif_m} in UIF every month for {year}, for take-home pay of {net_m}. That's {net_a} annually at an effective rate of {eff}; your top slice of income is taxed at {marginal}."
    ],
    'senior' => [
        "At {gross} a month you're well into the {marginal} bracket for {year}. Monthly PAYE of {paye_m} plus capped UIF of {uif_m} leaves {net_m} take-home — {net_a} a year, an effective deduction rate of {eff}.",
        "{gross} a month in South Africa for {year}: SARS takes {paye_m} in PAYE, UIF takes its maximum of {uif_m}, and your take-home pay is {net_m} monthly ({net_a} yearly). Effective rate: {eff}; marginal bracket: {marginal}."
    ],
    'exec' => [
        "A {gross} monthly salary lands you in South Africa's {marginal} top bracket for {year}. After {paye_m} in monthly PAYE and the capped {uif_m} UIF, take-home pay is {net_m} — {net_a} a year — at an effective deduction rate of {eff}.",
        "Earning {gross} a month? For {year}, PAYE of {paye_m} and UIF of {uif_m} come off first, leaving {net_m} take-home pay ({net_a} annually). Your effective rate is {eff}, but every additional rand is taxed at {marginal}."
    ],
];

$facts = [
    "The R17,820 primary rebate wipes out the tax on your first R99,000 of annual income — everyone under 65 gets it.",
    "UIF stops growing once your salary passes R17,712 a month; above that it's always R177.12.",
    "South Africa's tax year runs 1 March to the end of February — these figures cover 2026/2027.",
    "Pension or RA contributions up to 27.5% of your salary reduce your taxable income — model it in the full calculator.",
    "On medical aid? You get R376 a month off your tax bill, plus R376 for your first dependant.",
];

function tier_of(int $lvl): string {
    if ($lvl <= 15000) return 'entry';
    if ($lvl <= 40000) return 'mid';
    if ($lvl <= 75000) return 'senior';
    return 'exec';
}

$tpl = <<<'TPL'
<?php
$pageTitle = "{{TITLE}}";
$pageDesc = "{{DESC}}";
$pageKeywords = "{{KEYWORDS}}";
$canonical = "{{CANONICAL}}";
$extraHead = '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org", "@type" => "FAQPage",
    "mainEntity" => [
        ["@type" => "Question", "name" => "{{FAQ1Q}}",
         "acceptedAnswer" => ["@type" => "Answer", "text" => "{{FAQ1A}}"]],
        ["@type" => "Question", "name" => "{{FAQ2Q}}",
         "acceptedAnswer" => ["@type" => "Answer", "text" => "{{FAQ2A}}"]],
        ["@type" => "Question", "name" => "{{FAQ3Q}}",
         "acceptedAnswer" => ["@type" => "Answer", "text" => "{{FAQ3A}}"]],
    ],
]) . '</script>';
require __DIR__ . '/../../includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:860px">
    <div class="kicker">Salary guide · {{YEAR}}</div>
    <h1 class="h2">{{H1}}</h1>
    <div class="answer-box"><strong>Short answer:</strong> {{SHORT}}</div>
    <p>{{INTRO}}</p>
    <p class="disclaimer">{{FACT}}</p>
    <!-- ADSENSE: paste in-article ad unit here (salary guide pages) -->
    <h2>Monthly breakdown</h2>
    <table class="ref-table">
      <tbody>
        <tr><td>Gross monthly salary</td><td class="num mono">{{GROSS_M}}</td></tr>
        <tr><td>PAYE (income tax)</td><td class="num mono">− {{PAYE_M}}</td></tr>
        <tr><td>UIF (1%{{UIF_NOTE}})</td><td class="num mono">− {{UIF_M}}</td></tr>
        <tr class="total"><td>Take-home pay (monthly)</td><td class="num mono">{{NET_M}}</td></tr>
      </tbody>
    </table>
    <h2>Annual breakdown</h2>
    <table class="ref-table">
      <tbody>
        <tr><td>Gross annual salary</td><td class="num mono">{{GROSS_A}}</td></tr>
        <tr><td>PAYE (income tax)</td><td class="num mono">− {{PAYE_A}}</td></tr>
        <tr><td>UIF</td><td class="num mono">− {{UIF_A}}</td></tr>
        <tr class="total"><td>Take-home pay (annual)</td><td class="num mono">{{NET_A}}</td></tr>
        <tr><td>Take-home per week</td><td class="num mono">{{NET_W}}</td></tr>
        <tr><td>Take-home per day</td><td class="num mono">{{NET_D}}</td></tr>
      </tbody>
    </table>
    <div class="grid2" style="margin-top:20px">
      <div class="card"><h3 style="margin-top:0">Effective rate</h3><p class="mono" style="font-size:1.6rem;font-weight:800;margin:0">{{EFF}}</p><p class="disclaimer">Share of salary lost to PAYE + UIF.</p></div>
      <div class="card"><h3 style="margin-top:0">Marginal bracket</h3><p class="mono" style="font-size:1.6rem;font-weight:800;margin:0">{{MARGINAL}}</p><p class="disclaimer">Tax rate on your next rand earned.</p></div>
    </div>
    <div class="faq" style="margin-top:32px">
      <h2 class="h2">Questions about a {{GROSS_M}} salary</h2>
      <details><summary>{{FAQ1Q}}</summary><p>{{FAQ1A}}</p></details>
      <details><summary>{{FAQ2Q}}</summary><p>{{FAQ2A}}</p></details>
      <details><summary>{{FAQ3Q}}</summary><p>{{FAQ3A}}</p></details>
    </div>
    <p class="disclaimer" style="margin-top:24px">Assumes under 65, no pension deduction and no medical aid. Add your own details in the <a href="/calculator/">full calculator</a>. Figures use SARS {{YEAR}} tables — estimate only, not tax advice.</p>
    <div class="pager">
      <div>{{PREV_LINK}}</div>
      <div>{{NEXT_LINK}}</div>
    </div>
    <p style="margin-top:16px"><a href="/salary/">All salary guides →</a> · <a href="/tax-brackets/">SARS {{YEAR}} tax tables →</a></p>
  </div>
</section>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
TPL;

$count = 0;
$levels = $GLOBALS['SALARY_LEVELS'];
foreach ($levels as $i => $lvl) {
    $b = sapc_breakdown($lvl);
    $slug = sapc_salary_slug($lvl);
    $grossFmt = 'R' . number_format($lvl, 0, '.', ' ');
    $tier = tier_of($lvl);
    $introTpl = $intros[$tier][$i % 2];
    $tokens = [
        '{{TITLE}}' => "$grossFmt Salary After Tax in South Africa ($TAX_YEAR_LABEL) | SA Paycheck",
        '{{DESC}}'  => "What is take-home pay on a $grossFmt salary in South Africa? " . sapc_r0($b['net_monthly']) . " per month after PAYE and UIF — full $TAX_YEAR_LABEL breakdown.",
        '{{KEYWORDS}}' => strtolower("$grossFmt salary after tax, take home pay $grossFmt south africa"),
        '{{CANONICAL}}' => "/salary/$slug/",
        '{{YEAR}}' => $TAX_YEAR_LABEL,
        '{{H1}}' => "$grossFmt salary after tax — South Africa $TAX_YEAR_LABEL",
        '{{SHORT}}' => "On $grossFmt a month you take home " . sapc_r0($b['net_monthly']) . " after " . sapc_r0($b['paye_monthly']) . " PAYE and " . sapc_r($b['uif_monthly']) . " UIF.",
        '{{INTRO}}' => str_replace(
            ['{gross}','{net_m}','{net_a}','{paye_m}','{uif_m}','{eff}','{marginal}','{year}','{keep}'],
            [$grossFmt, sapc_r0($b['net_monthly']), sapc_r0($b['net_annual']), sapc_r0($b['paye_monthly']),
             sapc_r($b['uif_monthly']), number_format($b['effective_rate']*100,1).'%',
             $b['marginal'], $TAX_YEAR_LABEL, number_format((1-$b['effective_rate'])*100,1).'%'],
            $introTpl),
        '{{FACT}}' => $facts[$i % count($facts)],
        '{{GROSS_M}}' => sapc_r0($b['gross_monthly']),
        '{{PAYE_M}}' => sapc_r($b['paye_monthly']),
        '{{UIF_M}}' => sapc_r($b['uif_monthly']),
        '{{UIF_NOTE}}' => $b['uif_monthly'] >= $UIF_CAP_MONTH - 0.005 ? ', capped' : '',
        '{{NET_M}}' => sapc_r($b['net_monthly']),
        '{{GROSS_A}}' => sapc_r0($b['gross_annual']),
        '{{PAYE_A}}' => sapc_r($b['paye_annual']),
        '{{UIF_A}}' => sapc_r($b['uif_annual']),
        '{{NET_A}}' => sapc_r($b['net_annual']),
        '{{NET_W}}' => sapc_r($b['net_weekly']),
        '{{NET_D}}' => sapc_r($b['net_daily']),
        '{{EFF}}' => number_format($b['effective_rate']*100,1).'%',
        '{{MARGINAL}}' => $b['marginal'],
        '{{FAQ1Q}}' => "How much is take-home pay on $grossFmt in South Africa?",
        '{{FAQ1A}}' => "For $TAX_YEAR_LABEL: " . sapc_r0($b['net_monthly']) . " per month (" . sapc_r0($b['net_annual']) . " per year) after PAYE and UIF.",
        '{{FAQ2Q}}' => "How much tax do I pay on a $grossFmt salary?",
        '{{FAQ2A}}' => "PAYE of " . sapc_r($b['paye_monthly']) . " per month (" . sapc_r($b['paye_annual']) . "/year) plus UIF of " . sapc_r($b['uif_monthly']) . " per month — an effective rate of " . number_format($b['effective_rate']*100,1) . "%.",
        '{{FAQ3Q}}' => "What tax bracket is $grossFmt a month?",
        '{{FAQ3A}}' => "Your marginal bracket is " . $b['marginal'] . " for $TAX_YEAR_LABEL, but your effective deduction rate is only " . number_format($b['effective_rate']*100,1) . "% thanks to the progressive brackets and the R17,820 primary rebate.",
        '{{PREV_LINK}}' => $i > 0
            ? '<a href="/salary/' . sapc_salary_slug($levels[$i-1]) . '/">← R' . number_format($levels[$i-1],0,'.',' ') . ' salary</a>' : '',
        '{{NEXT_LINK}}' => $i < count($levels)-1
            ? '<a href="/salary/' . sapc_salary_slug($levels[$i+1]) . '/">R' . number_format($levels[$i+1],0,'.',' ') . ' salary →</a>' : '',
    ];
    $out = str_replace(array_keys($tokens), array_values($tokens), $tpl);
    if (strpos($out, '{{') !== false) { fwrite(STDERR, "UNREPLACED TOKEN in $slug\n"); exit(1); }
    $dir = "$base/salary/$slug";
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    file_put_contents("$dir/index.php", $out);
    $count++;
}
echo "Generated $count salary pages.\n";

// ---- sitemap.xml ----
$urls = [
    ['/', 'weekly', '1.0'],
    ['/calculator/', 'weekly', '0.9'],
    ['/salary/', 'weekly', '0.8'],
    ['/tax-brackets/', 'yearly', '0.7'],
    ['/uif-calculator/', 'monthly', '0.7'],
    ['/faq/', 'monthly', '0.6'],
    ['/about/', 'yearly', '0.4'],
    ['/contact/', 'yearly', '0.4'],
    ['/privacy/', 'yearly', '0.3'],
];
foreach ($levels as $lvl) $urls[] = ["/salary/" . sapc_salary_slug($lvl) . "/", 'monthly', '0.8'];
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as [$path, $freq, $prio]) {
    $xml .= "  <url><loc>https://sapaycheck.co.za$path</loc><lastmod>$date</lastmod><changefreq>$freq</changefreq><priority>$prio</priority></url>\n";
}
$xml .= "</urlset>\n";
file_put_contents("$base/sitemap.xml", $xml);
echo "Wrote sitemap.xml with " . count($urls) . " URLs.\n";
