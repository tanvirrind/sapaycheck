<?php
$pageTitle = "SA Paycheck — South African Take-Home Pay Calculator (2026/2027)";
$pageDesc = "Free SA salary calculator: work out your take-home pay after PAYE tax and UIF using the SARS 2026/2027 tax tables. Instant, accurate, no signup.";
$pageKeywords = "salary calculator south africa, take home pay calculator, PAYE calculator, salary after tax south africa";
$canonical = "/";
$extraHead = '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => [
        ["@type" => "Question", "name" => "How is take-home pay calculated in South Africa?",
         "acceptedAnswer" => ["@type" => "Answer", "text" => "Your employer deducts PAYE (income tax, using SARS progressive brackets minus rebates) and UIF (1% of salary, capped at R177.12/month). Take-home pay is your gross salary minus these deductions."]],
        ["@type" => "Question", "name" => "How much tax do I pay on my salary in South Africa?",
         "acceptedAnswer" => ["@type" => "Answer", "text" => "It depends on your income. For 2026/2027, rates run from 18% on income up to R245,100 to 45% above R1,878,600, reduced by the R17,820 primary rebate (under 65). Use the calculator above for your exact figure."]],
        ["@type" => "Question", "name" => "What is UIF and how much is deducted?",
         "acceptedAnswer" => ["@type" => "Answer", "text" => "UIF (Unemployment Insurance Fund) is 1% of your gross monthly salary, capped at R177.12 per month. Your employer matches it."]],
    ],
]) . '</script>';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="wrap">
    <h1>What will you actually take home?</h1>
    <p>South Africa's free PAYE calculator. Enter your salary and see your take-home pay after income tax and UIF — using the official SARS <?php echo $TAX_YEAR_LABEL; ?> tables.</p>
  </div>
</section>
<section class="section" style="padding-top:32px">
  <div class="wrap">
    <?php require __DIR__ . '/includes/calc-widget.php'; ?>
    <div class="grid3" style="margin-top:32px">
      <div class="card"><h3 style="margin-top:0">SARS <?php echo $TAX_YEAR_LABEL; ?> tables</h3><p class="sub" style="font-size:.95rem">All 7 PAYE brackets, rebates, UIF cap and medical credits verified against SARS publications. <a href="/tax-brackets/">See the tables</a>.</p></div>
      <div class="card"><h3 style="margin-top:0">Instant answers</h3><p class="sub" style="font-size:.95rem">No signup, no waiting. Monthly, annual, weekly and daily take-home, plus your effective and marginal rates.</p></div>
      <div class="card"><h3 style="margin-top:0">Pension &amp; medical aid</h3><p class="sub" style="font-size:.95rem">Add your retirement contribution and medical aid members — the calculator applies the SARS deduction and credits correctly.</p></div>
    </div>
  </div>
</section>
<section class="section" style="background:#fff;border-top:1px solid var(--line);border-bottom:1px solid var(--line)">
  <div class="wrap">
    <div class="kicker">Popular salaries</div>
    <h2 class="h2">Take-home pay by salary</h2>
    <p class="sub">Pre-calculated breakdowns for common South African salaries, <?php echo $TAX_YEAR_LABEL; ?> tax year.</p>
    <div class="salary-list">
      <?php foreach ($SALARY_LEVELS as $lvl):
        $b = sapc_breakdown($lvl); ?>
        <a href="/salary/<?php echo sapc_salary_slug($lvl); ?>/"><?php echo sapc_r0($lvl); ?> <small>take home <?php echo sapc_r0($b['net_monthly']); ?>/mo</small></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section class="section">
  <div class="wrap">
    <div class="kicker">How it works</div>
    <h2 class="h2">Three deductions stand between you and your pay</h2>
    <div class="grid3" style="margin-top:20px">
      <div class="card"><h3 style="margin-top:0">1. PAYE income tax</h3><p class="sub" style="font-size:.95rem">SARS taxes you on progressive brackets from 18% to 45%, then subtracts your rebate (R17,820 if you're under 65).</p></div>
      <div class="card"><h3 style="margin-top:0">2. UIF</h3><p class="sub" style="font-size:.95rem">1% of your salary goes to the Unemployment Insurance Fund, capped at R177.12 a month.</p></div>
      <div class="card"><h3 style="margin-top:0">3. Your take-home</h3><p class="sub" style="font-size:.95rem">What's left is yours. Pension contributions and medical aid credits adjust the numbers — the calculator handles both.</p></div>
    </div>
    <div class="faq" style="margin-top:36px;max-width:800px">
      <h2 class="h2">Quick answers</h2>
      <details><summary>How is take-home pay calculated in South Africa?</summary><p>Your employer deducts PAYE (income tax on SARS progressive brackets, minus your rebate) and UIF (1%, capped at R177.12/month). Take-home pay is gross salary minus these deductions.</p></details>
      <details><summary>How much tax do I pay on my salary?</summary><p>For <?php echo $TAX_YEAR_LABEL; ?>, rates run 18%–45% across 7 brackets, reduced by the primary rebate of R17,820 (under 65). Enter your salary above for the exact figure.</p></details>
      <details><summary>Do pension contributions reduce my tax?</summary><p>Yes. Retirement fund contributions reduce your taxable income (up to 27.5% of remuneration, capped at R350,000/year). Add your percentage in the calculator.</p></details>
      <p><a href="/faq/">More questions, answered →</a></p>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
