# SA Paycheck — Tax Data Sources & Verification

Tax year: **2026/2027** (1 March 2026 – 28 February 2027). Last verified: **2026-10-10**.
All figures below ship in `includes/config.php` (single source of truth) and are injected
into the JS calculator as JSON, so PHP-rendered pages and the live calculator can never diverge.

## Verified figures

| Figure | Value | Source | Primary? |
|---|---|---|---|
| PAYE brackets (7) | 18% to R245,100; 26% to R383,100; 31% to R530,200; 36% to R695,800; 39% to R887,000; 41% to R1,878,600; 45% above | SARS "Guide for Employers in Respect of Employees' Tax (2027)" (sars.gov.za), cross-confirmed by PwC SA Budget 2026/27 tax card | Yes |
| Primary rebate (under 65) | R17,820 | SARS employer guide; PwC tax card | Yes |
| Secondary rebate (65+) | R9,765 additional → **R27,585 total** | SARS employer guide; PwC tax card | Yes |
| Tertiary rebate (75+) | R3,249 additional → **R30,834 total** | SARS employer guide; PwC tax card | Yes |
| Tax thresholds | R99,000 / R153,250 / R171,300 | SARS; PwC; Bloomberg Tax on SARS Budget 2026 FAQ | Yes |
| UIF employee rate | 1%, capped at **R177.12/month** (R17,712 ceiling) | Playroll, ElyForma, ourpower.co.za, gauteng.net (4 independent secondaries agree) | No — no primary SARS/UIF source located |
| Medical credits (monthly) | R376 main member / R376 first dependant / R254 additional | SARS 2027 quick reference card; ourpower.co.za; govchain.co.za | Yes |
| SDL | Employer-paid, never deducted from employee | SARS employer guide; govchain.co.za | Yes |
| Pension deduction cap | 27.5% of remuneration, max R350,000/yr | SARS retirement-funding rules (standard, long-standing) | Standard |

**Build correction log:** the first draft used secondary-blog figures (secondary rebate R9,444,
tertiary R3,145; medical credits R364/R364/R246). Verification against SARS caught both —
rebates are quoted by SARS as *additional* amounts (config stores the totals actually subtracted),
and medical credits rose to R376/R376/R254 for 2026/27. All pages regenerated after the fix.

## Cross-check test cases (all pass)

Computed with `sapc_breakdown()` / the JS calculator logic and matched against independent sources:

1. **R25,000/mo** (govchain.co.za PAYE table 2026/27, recomputed from SARS tables): PAYE R3,381/mo,
   UIF R177.12, **net R21,442/mo** — match.
2. **R35,000/mo** (payecalculator.co.za): PAYE R6,134.75/mo, UIF R177.12,
   **net R28,688.13/mo** — match.
3. **R50,000/mo** (incomepilot.co.za): PAYE R11,075.58/mo, UIF R177.12,
   **net R38,747.30/mo** — exact match.
4. **R10,000/mo** (taxplanners.co.za worked example): PAYE R315/mo, UIF R100,
   **net R9,585/mo** — match.
5. **R350,000/yr** (ourpower.co.za calculator): PAYE R53,572/yr, UIF R2,125.44,
   **net R294,302.56/yr** — match.
6. Rebate/threshold internal consistency: 17,820/0.18=99,000; 27,585/0.18=153,250;
   30,834/0.18=171,300 — all exact.

## Could not primary-verify / flagged

1. **UIF R17,712 ceiling** — no primary (SARS/UIF) source found; four reputable secondaries agree
   (Playroll, ElyForma, ourpower.co.za, gauteng.net). Risk: low. Re-check when SARS publishes the 2027 UIF guide.
2. **"UIF rose to 1.5% from Feb 2026"** — claimed by one content farm (infinitysmiledental.co.za);
   contradicts all reputable sources, no official record found. Dismissed; site uses 1%.
3. **SDL 1% / R500k payroll threshold** — secondary-only (Playroll); irrelevant to take-home math
   (employer cost only), not used anywhere on the site.

## Maintenance

SARS announces Budget changes each February. When the 2027/28 tables land: update the figures in
`includes/config.php`, bump `$TAX_YEAR_LABEL` / `$TAX_LAST_VERIFIED`, re-run
`php tools/generate-salary-pages.php`, and re-verify with fresh worked examples.
