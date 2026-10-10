<?php
$pageTitle = "Salary After Tax Guides South Africa (2026/2027) | SA Paycheck";
$pageDesc = "Take-home pay breakdowns for common South African salaries — from R10,000 to R150,000 a month — using SARS 2026/2027 PAYE tables.";
$canonical = "/salary/";
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="kicker">Salary guides</div>
    <h1 class="h2">Take-home pay by salary — South Africa <?php echo $TAX_YEAR_LABEL; ?></h1>
    <p class="sub">Every guide shows the full monthly and annual breakdown: PAYE, UIF, take-home pay, effective rate and marginal bracket. All computed from the SARS <?php echo $TAX_YEAR_LABEL; ?> tables — no estimates, no rounding tricks.</p>
    <div class="salary-list">
      <?php foreach ($SALARY_LEVELS as $lvl):
        $b = sapc_breakdown($lvl); ?>
        <a href="/salary/<?php echo sapc_salary_slug($lvl); ?>/"><?php echo sapc_r0($lvl); ?> / month <small>take home <?php echo sapc_r0($b['net_monthly']); ?>/mo · <?php echo $b['marginal']; ?> bracket</small></a>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:28px">Salary not listed? <a href="/calculator/" class="btn btn-primary">Use the full calculator</a></p>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
