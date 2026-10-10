<?php
$pageTitle = "FAQ — South African Take-Home Pay, PAYE & UIF | SA Paycheck";
$pageDesc = "Answers to common questions about South African take-home pay: PAYE brackets, UIF, rebates, pension deductions and medical tax credits for 2026/2027.";
$canonical = "/faq/";
$faqs = [
    ["How is take-home pay calculated in South Africa?",
     "Gross salary minus PAYE (income tax) minus UIF. PAYE uses SARS progressive brackets (18%–45% for 2026/2027) minus your rebate; UIF is 1% capped at R177.12/month."],
    ["What is PAYE?",
     "Pay-As-You-Earn: the income tax your employer withholds monthly and pays to SARS on your behalf, based on the annual tax tables."],
    ["How much is UIF per month?",
     "1% of your gross monthly salary, capped at R177.12. Earn above R17,712/month and the deduction stays flat at the cap."],
    ["What are the SARS tax brackets for 2026/2027?",
     "18% to R245,100; 26% to R383,100; 31% to R530,200; 36% to R695,800; 39% to R887,000; 41% to R1,878,600; 45% above. See the full tables on our tax brackets page."],
    ["What is the primary rebate?",
     "R17,820 for taxpayers under 65 (2026/2027). It is subtracted from the tax computed on the brackets. Over-65s get an additional R9,765 (total R27,585); over-75s a further R3,249 (total R30,834)."],
    ["Do pension contributions reduce my PAYE?",
     "Yes. Retirement fund contributions reduce taxable income, up to 27.5% of remuneration (max R350,000/year). Add your contribution percentage in the calculator."],
    ["How do medical aid tax credits work?",
     "R376/month for yourself, R376 for your first dependant, R254 for each additional dependant. Credits reduce the tax you pay, not your taxable income."],
    ["What is the difference between marginal and effective tax rate?",
     "Your marginal rate is the tax on your next rand earned (your top bracket). Your effective rate is total PAYE+UIF divided by gross salary — always lower."],
    ["Is overtime taxed differently?",
     "No — but a big overtime month can push that month's PAYE into a higher bracket. SARS reconciles it at year end via your tax return."],
    ["Are bonuses taxed at a higher rate?",
     "Bonuses are taxed at your marginal rate. Employers often withhold PAYE on bonuses using your average rate, reconciled at assessment."],
    ["Do I pay SDL as an employee?",
     "No. The 1% Skills Development Levy is paid by your employer and never deducted from your salary."],
    ["Is this calculator tax advice?",
     "No. It's an estimate based on the published SARS 2026/2027 tables. For personal advice, consult a registered tax practitioner."],
];
$extraHead = '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org", "@type" => "FAQPage",
    "mainEntity" => array_map(fn($f) => ["@type" => "Question", "name" => $f[0],
        "acceptedAnswer" => ["@type" => "Answer", "text" => $f[1]]], $faqs),
]) . '</script>';
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="wrap" style="max-width:800px">
    <div class="kicker">Help</div>
    <h1 class="h2">Frequently asked questions</h1>
    <p class="sub">Straight answers about South African take-home pay, PAYE, UIF and rebates — <?php echo $TAX_YEAR_LABEL; ?> tax year.</p>
    <div class="faq" style="margin-top:24px">
      <?php foreach ($faqs as [$q, $a]): ?>
        <details><summary><?php echo htmlspecialchars($q); ?></summary><p><?php echo htmlspecialchars($a); ?></p></details>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:28px"><a href="/calculator/" class="btn btn-primary">Calculate my take-home pay</a></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
