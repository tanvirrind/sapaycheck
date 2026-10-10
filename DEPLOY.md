# SA Paycheck — Deploy Guide

Static PHP site, zero dependencies, no build step. Requires **PHP 8.x** + Apache.

## Deploy to Hostinger (temp domain first)

1. In Hostinger hPanel, create the temp subdomain/website (e.g. `sapaycheck.<temp-domain>`).
2. Upload the **contents** of this folder into that site's `public_html/` (File Manager or FTP):
   `includes/`, `assets/`, `calculator/`, `salary/`, `tax-brackets/`, `uif-calculator/`,
   `faq/`, `about/`, `contact/`, `privacy/`, `tools/`, plus `index.php`, `404.php`,
   `.htaccess`, `robots.txt`, `sitemap.xml`, `favicon.svg`.
   (Keep `TAX_SOURCES.md` and `DEPLOY.md` out of `public_html` — they're documentation.)
3. That's it — no composer, no npm, no build. `.htaccess` handles clean URLs, security
   headers, gzip and the 404 page (requires mod_rewrite/mod_headers/mod_deflate;
   each is wrapped in `<IfModule>` so the site still works if a module is missing).
4. Contact form uses PHP `mail()` — works on Hostinger out of the box. Test it once
   after deploy; mail lands at `contact@sapaycheck.co.za` (set in `includes/config.php`).

## Temp-domain phase (important)

Canonical tags point at `https://sapaycheck.co.za`. While on the temp domain, either:
- add `<meta name="robots" content="noindex">` temporarily, or
- password-protect the temp site in hPanel,

to avoid Google indexing the temp URLs before the real domain cutover. Remove the
block when `sapaycheck.co.za` goes live, then submit `sitemap.xml` in Search Console.

## Post-deploy smoke test

- `/` and `/calculator/` load; move the salary slider → numbers update instantly.
- `/salary/r50000-after-tax/` shows net R38 747.30/mo.
- `/tax-brackets/` shows the 2026/2027 tables with the verification date.
- `/contact/` sends (check inbox) and the honeypot doesn't break real submissions.
- `curl -I https://<domain>/nope` returns 404 with the custom page.

## Yearly maintenance

Every February after the SARS Budget: update figures in `includes/config.php`,
bump `$TAX_YEAR_LABEL` and `$TAX_LAST_VERIFIED`, run
`php tools/generate-salary-pages.php` to rebuild the 15 salary pages + sitemap,
and re-verify against fresh worked examples (see TAX_SOURCES.md).
