<?php
// Shared page head + navigation.
// Pages set BEFORE including this file:
//   $pageTitle, $pageDesc, $canonical (path, e.g. "/calculator/")
// Optional: $pageKeywords, $extraHead (extra <head> HTML, e.g. JSON-LD)
require_once __DIR__ . '/config.php';
$canonicalUrl = $SITE_URL . $canonical;
?>
<!DOCTYPE html>
<html lang="en-ZA">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
<meta name="description" content="<?php echo htmlspecialchars($pageDesc, ENT_QUOTES, 'UTF-8'); ?>">
<?php if (!empty($pageKeywords)): ?>
<meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords, ENT_QUOTES, 'UTF-8'); ?>">
<?php endif; ?>
<link rel="canonical" href="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="author" content="<?php echo htmlspecialchars($SITE_NAME, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_ZA">
<meta property="og:site_name" content="<?php echo htmlspecialchars($SITE_NAME, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($canonicalUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($pageDesc, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($pageDesc, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="robots" content="index, follow">
<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="stylesheet" href="/assets/css/style.css">
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"WebSite","name":"SA Paycheck","url":"https://sapaycheck.co.za/","description":"Free South African take-home pay calculator. Work out your salary after PAYE tax and UIF for the 2026/2027 SARS tax year."}
</script>
<?php if (!empty($extraHead)) echo $extraHead . "\n"; ?>
</head>
<body>
<nav class="nav">
  <div class="wrap nav-inner">
    <a href="/" class="brand"><span class="brand-mark" aria-hidden="true">R</span> SA Paycheck</a>
    <div class="nav-links">
      <a href="/calculator/">Calculator</a>
      <a href="/salary/">Salaries</a>
      <a href="/tax-brackets/">Tax Brackets</a>
      <a href="/uif-calculator/">UIF</a>
      <a href="/faq/">FAQ</a>
      <a href="/about/">About</a>
      <a href="/calculator/" class="btn btn-primary btn-sm">Calculate my pay</a>
    </div>
    <button class="nav-toggle" aria-label="Open menu" aria-expanded="false" id="navToggle"><span></span><span></span><span></span></button>
  </div>
  <div class="nav-menu" id="navMenu">
    <a href="/calculator/">Calculator</a>
    <a href="/salary/">Salaries</a>
    <a href="/tax-brackets/">Tax Brackets</a>
    <a href="/uif-calculator/">UIF Calculator</a>
    <a href="/faq/">FAQ</a>
    <a href="/about/">About</a>
    <a href="/contact/">Contact</a>
    <a href="/calculator/" class="btn btn-primary" style="margin-top:12px;text-align:center">Calculate my pay</a>
  </div>
</nav>
<!-- ADSENSE: paste responsive leaderboard ad unit below the nav (all pages) -->
<main>
