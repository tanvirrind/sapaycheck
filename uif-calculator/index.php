<?php
$pageTitle = "UIF Calculator South Africa (2026/2027) — 1% Contribution | SA Paycheck";
$pageDesc = "Free UIF calculator: work out your monthly Unemployment Insurance Fund deduction. 1% of salary, capped at R177.12/month for 2026/2027.";
$pageKeywords = "UIF calculator south africa, UIF deduction, unemployment insurance fund contribution";
$canonical = "/uif-calculator/";
$extraHead = '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@type" => "WebApplication",
    "name" => "SA Paycheck — UIF Calculator",
    "url" => "https://sapaycheck.co.za/uif-calculator/",
    "applicationCategory" => "FinanceApplication",
    "operatingSystem" => "Any",
    "offers" => ["@type" => "Offer", "price" => "0", "priceCurrency" => "ZAR"],
]) . '</script>';
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:760px">
    <div class="kicker">Free tool</div>
    <h1 class="h2">UIF calculator — South Africa <?php echo $TAX_YEAR_LABEL; ?></h1>
    <p class="sub">UIF (Unemployment Insurance Fund) is <strong>1% of your gross monthly salary</strong>, capped at <strong><?php echo sapc_r($UIF_CAP_MONTH); ?> per month</strong>. Your employer pays a matching 1% — it never comes out of your pay twice.</p>
    <div class="card">
      <form id="uifCalc" onsubmit="return false;">
        <div class="field">
          <label for="uif-salary">Gross monthly salary</label>
          <input type="number" id="uif-salary" value="35000" min="0" step="100" inputmode="decimal" aria-label="Gross monthly salary in Rand">
        </div>
      </form>
      <div class="answer-box"><span style="font-size:.9rem;color:var(--muted)">Your UIF deduction:</span><div id="uif-out" class="mono" style="font-size:1.4rem;font-weight:800" aria-live="polite"></div></div>
    </div>
    <script>var SAPC_TAX = <?php echo json_encode(['uif_rate' => $UIF_RATE, 'uif_cap' => $UIF_CAP_MONTH]); ?>;</script>
    <h2>How UIF works</h2>
    <ul>
      <li><strong>Rate:</strong> 1% employee + 1% employer, on remuneration up to R17,712/month.</li>
      <li><strong>Cap:</strong> once your salary passes R17,712/month, your deduction stays at <?php echo sapc_r($UIF_CAP_MONTH); ?> — earning more doesn't raise it.</li>
      <li><strong>What it's for:</strong> short-term relief if you lose your job, go on maternity leave, or can't work due to illness.</li>
      <li><strong>Who's excluded:</strong> workers under 24 hours/month, some government employees, and independent contractors (among others).</li>
    </ul>
    <div class="faq">
      <details><summary>Is UIF compulsory in South Africa?</summary><p>Yes, for most employees working more than 24 hours a month. Your employer must register with the UIF and deduct your 1% monthly.</p></details>
      <details><summary>What is the maximum UIF deduction?</summary><p><?php echo sapc_r($UIF_CAP_MONTH); ?> per month (<?php echo sapc_r($UIF_CAP_MONTH * 12); ?> per year) for <?php echo $TAX_YEAR_LABEL; ?> — 1% of the R17,712 remuneration ceiling.</p></details>
      <details><summary>Does my employer also pay UIF?</summary><p>Yes — a matching 1%, paid by the employer on top of your salary. It is not deducted from your pay.</p></details>
    </div>
    <p style="margin-top:24px"><a href="/calculator/" class="btn btn-primary">See your full take-home breakdown</a></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
