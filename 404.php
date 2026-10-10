<?php
http_response_code(404);
$pageTitle = "Page not found | SA Paycheck";
$pageDesc = "The page you're looking for doesn't exist. Try the take-home pay calculator instead.";
$canonical = "/404.php";
require __DIR__ . '/includes/header.php';
?>
<section class="section center">
  <div class="wrap">
    <div class="kicker">404</div>
    <h1>That page doesn't exist</h1>
    <p class="sub" style="margin:0 auto 24px">The link may be broken, or the page moved. The calculator is this way:</p>
    <a href="/calculator/" class="btn btn-primary">Take-home pay calculator</a>
    <p style="margin-top:16px"><a href="/">Back to home</a></p>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
