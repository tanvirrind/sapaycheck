<?php
$pageTitle = "About SA Paycheck — Free South African Salary Calculator";
$pageDesc = "SA Paycheck is a free South African take-home pay calculator built on the official SARS 2026/2027 tax tables. No signup, no tracking gimmicks.";
$canonical = "/about/";
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:760px">
    <div class="kicker">About</div>
    <h1 class="h2">About SA Paycheck</h1>
    <p>SA Paycheck answers one question South Africans ask every payday: <strong>what do I actually take home?</strong></p>
    <p>The calculator applies the official SARS <?php echo $TAX_YEAR_LABEL; ?> tables (1 March 2026 – 28 February 2027) — all seven PAYE brackets, the primary/secondary/tertiary rebates, the UIF cap, pension deduction limits and medical tax credits — and shows your monthly, annual, weekly and daily take-home instantly.</p>
    <h2>Our accuracy standard</h2>
    <ul>
      <li>Tax tables are verified against SARS publications every tax year; the verification date is shown on the <a href="/tax-brackets/">tax brackets page</a>.</li>
      <li>Calculator math is cross-checked against worked examples from SARS and major SA accounting firms before every tax-year update.</li>
      <li>When SARS announces the annual Budget changes (usually February), tables are updated within days.</li>
    </ul>
    <h2>What we don't do</h2>
    <ul>
      <li>No accounts, no signup, no paywall.</li>
      <li>Your salary inputs never leave your browser — calculations run locally in JavaScript.</li>
      <li>We don't give tax advice. Figures are estimates; consult a registered tax practitioner for personal advice.</li>
    </ul>
    <p><a href="/calculator/" class="btn btn-primary">Try the calculator</a></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
