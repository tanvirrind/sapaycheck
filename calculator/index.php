<?php
$pageTitle = "Take-Home Pay Calculator South Africa (2026/2027) | SA Paycheck";
$pageDesc = "Calculate your South African take-home pay after PAYE and UIF. Free calculator with pension, medical aid, age rebates and marginal bracket — SARS 2026/2027 tables.";
$pageKeywords = "take home pay calculator south africa, net salary calculator, PAYE calculator 2026";
$canonical = "/calculator/";
$extraHead = '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@type" => "WebApplication",
    "name" => "SA Paycheck — Take-Home Pay Calculator",
    "url" => "https://sapaycheck.co.za/calculator/",
    "applicationCategory" => "FinanceApplication",
    "operatingSystem" => "Any",
    "offers" => ["@type" => "Offer", "price" => "0", "priceCurrency" => "ZAR"],
    "description" => "Free South African take-home pay calculator using SARS 2026/2027 PAYE tables, UIF, rebates and medical tax credits.",
]) . '</script>';
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="kicker">Free calculator</div>
    <h1 class="h2">Take-home pay calculator — South Africa <?php echo $TAX_YEAR_LABEL; ?></h1>
    <p class="sub">Enter your gross salary. The calculator applies the SARS <?php echo $TAX_YEAR_LABEL; ?> PAYE brackets, your age rebate, UIF (1%, capped at <?php echo sapc_r($UIF_CAP_MONTH); ?>/month), pension deduction and medical tax credits — instantly.</p>
    <?php require __DIR__ . '/../includes/calc-widget.php'; ?>
    <div class="answer-box" style="max-width:860px">
      <strong>Reading your result:</strong> the <em>effective rate</em> is what you actually lose to PAYE+UIF overall; the <em>marginal bracket</em> is the rate on your next rand earned — useful for judging raises and bonuses.
    </div>
    <h2>What the calculator includes</h2>
    <div class="grid2" style="max-width:900px">
      <div class="card"><h3 style="margin-top:0">PAYE on 7 brackets</h3><p class="sub" style="font-size:.95rem">From 18% up to 45%, with the primary rebate (R17,820), plus an extra R9,765 from age 65 and a further R3,249 from age 75, subtracted based on your age group.</p></div>
      <div class="card"><h3 style="margin-top:0">UIF, correctly capped</h3><p class="sub" style="font-size:.95rem">1% of gross salary, capped at <?php echo sapc_r($UIF_CAP_MONTH); ?> per month — the cap most quick calculators get wrong at higher salaries.</p></div>
      <div class="card"><h3 style="margin-top:0">Pension &amp; RA contributions</h3><p class="sub" style="font-size:.95rem">Retirement funding reduces taxable income (SARS limit: 27.5% of remuneration, max R350,000/year). The calculator enforces the cap.</p></div>
      <div class="card"><h3 style="margin-top:0">Medical tax credits</h3><p class="sub" style="font-size:.95rem"><?php echo sapc_r($MTC_MAIN_MEMBER); ?>/month for you, <?php echo sapc_r($MTC_FIRST_DEPENDANT); ?> for your first dependant, <?php echo sapc_r($MTC_ADDL_DEPENDANT); ?> for each additional dependant — subtracted from tax payable.</p></div>
    </div>
    <p style="margin-top:28px"><a href="/salary/">Browse pre-calculated salaries →</a> · <a href="/tax-brackets/">Full <?php echo $TAX_YEAR_LABEL; ?> tax tables →</a></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
