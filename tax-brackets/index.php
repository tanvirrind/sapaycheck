<?php
$pageTitle = "SARS Tax Brackets 2026/2027 — PAYE Tables, Rebates, UIF | SA Paycheck";
$pageDesc = "Full SARS 2026/2027 tax tables: 7 PAYE brackets, primary/secondary/tertiary rebates, tax thresholds, UIF cap and medical tax credits. Last verified 2026-10-10.";
$pageKeywords = "SARS tax brackets 2026, PAYE tax tables south africa, tax thresholds 2026/2027";
$canonical = "/tax-brackets/";
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:860px">
    <div class="kicker">Reference</div>
    <h1 class="h2">SARS tax tables — <?php echo $TAX_YEAR_LABEL; ?></h1>
    <p class="sub">Tax year <?php echo $TAX_YEAR_RANGE; ?>. Last verified against SARS publications: <strong><?php echo $TAX_LAST_VERIFIED; ?></strong>.</p>

    <h2>PAYE brackets (annual taxable income)</h2>
    <table class="ref-table">
      <thead><tr><th>Taxable income</th><th class="num">Rate</th></tr></thead>
      <tbody>
        <tr><td>R0 – R245,100</td><td class="num">18%</td></tr>
        <tr><td>R245,101 – R383,100</td><td class="num">26%</td></tr>
        <tr><td>R383,101 – R530,200</td><td class="num">31%</td></tr>
        <tr><td>R530,201 – R695,800</td><td class="num">36%</td></tr>
        <tr><td>R695,801 – R887,000</td><td class="num">39%</td></tr>
        <tr><td>R887,001 – R1,878,600</td><td class="num">41%</td></tr>
        <tr><td>R1,878,601 and above</td><td class="num">45%</td></tr>
      </tbody>
    </table>

    <h2>Rebates &amp; tax thresholds</h2>
    <table class="ref-table">
      <thead><tr><th>Age group</th><th class="num">Rebate</th><th class="num">Tax threshold</th></tr></thead>
      <tbody>
        <tr><td>Under 65 (primary)</td><td class="num">R17,820</td><td class="num">R99,000</td></tr>
        <tr><td>65 to 74 (primary + secondary)</td><td class="num">R27,585</td><td class="num">R153,250</td></tr>
        <tr><td>75 and over (primary + secondary + tertiary)</td><td class="num">R30,834</td><td class="num">R171,300</td></tr>
      </tbody>
    </table>
    <p class="disclaimer">The threshold is the income below which no PAYE is payable (rebate ÷ 18%). Rebates are subtracted from the tax computed on the brackets — they are not deductions from income.</p>

    <h2>UIF — Unemployment Insurance Fund</h2>
    <table class="ref-table">
      <tbody>
        <tr><td>Employee contribution</td><td class="num">1% of gross salary</td></tr>
        <tr><td>Monthly cap</td><td class="num">R177.12</td></tr>
        <tr><td>Remuneration ceiling</td><td class="num">R17,712 / month</td></tr>
        <tr><td>Employer contribution</td><td class="num">1% (matched, not deducted from you)</td></tr>
      </tbody>
    </table>
    <p><a href="/uif-calculator/">Try the UIF calculator →</a></p>

    <h2>Medical scheme fees tax credits (monthly)</h2>
    <table class="ref-table">
      <thead><tr><th>Member</th><th class="num">Credit / month</th></tr></thead>
      <tbody>
        <tr><td>Main member</td><td class="num">R376</td></tr>
        <tr><td>First dependant</td><td class="num">R376</td></tr>
        <tr><td>Each additional dependant</td><td class="num">R254</td></tr>
      </tbody>
    </table>
    <p class="disclaimer">Credits reduce the tax payable (not taxable income). Source: SARS medical credit tables for <?php echo $TAX_YEAR_LABEL; ?>.</p>

    <div class="notice"><strong>Note:</strong> SDL (Skills Development Levy, 1%) is paid by your employer and is never deducted from your salary. These tables cover employee PAYE only.</div>
    <p><a href="/calculator/" class="btn btn-primary">Calculate my take-home pay</a></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
