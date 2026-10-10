/* SA Paycheck — vanilla JS. Calculator math mirrors includes/config.php exactly. */
(function () {
  "use strict";

  // Mobile nav
  var toggle = document.getElementById("navToggle"), menu = document.getElementById("navMenu");
  if (toggle && menu) {
    toggle.addEventListener("click", function () {
      var open = menu.classList.toggle("open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
  }

  function fmtR(n) {
    var neg = n < 0; n = Math.abs(Math.round(n));
    var s = n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return (neg ? "-R" : "R") + s;
  }
  function fmtR2(n) {
    var neg = n < 0; n = Math.abs(n);
    var s = n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return (neg ? "-R" : "R") + s;
  }

  // ---- main PAYE calculator ----
  var form = document.getElementById("payeCalc");
  if (form && typeof SAPC_TAX !== "undefined") {
    var T = SAPC_TAX;
    var grossEl = document.getElementById("gross"),
        periodBtns = form.querySelectorAll("[data-period]"),
        ageEl = document.getElementById("age"),
        pensionEl = document.getElementById("pension"),
        medEl = document.getElementById("medical"),
        period = "monthly";

    periodBtns.forEach(function (b) {
      b.addEventListener("click", function () {
        periodBtns.forEach(function (x) { x.classList.remove("active"); });
        b.classList.add("active");
        period = b.getAttribute("data-period");
        grossEl.setAttribute("aria-label", period === "monthly" ? "Gross monthly salary in Rand" : "Gross annual salary in Rand");
        calc();
      });
    });

    function payeOnTaxable(annual) {
      var tax = 0, prev = 0;
      for (var i = 0; i < T.brackets.length; i++) {
        var limit = T.brackets[i][0], rate = T.brackets[i][1];
        if (annual <= prev) break;
        tax += (Math.min(annual, limit) - prev) * rate;
        prev = limit;
      }
      return tax;
    }

    function calc() {
      var gross = parseFloat(grossEl.value) || 0;
      if (gross < 0) gross = 0;
      var grossAnnual = period === "monthly" ? gross * 12 : gross;
      var grossMonthly = period === "monthly" ? gross : gross / 12;

      var age = ageEl.value;
      var rebate = age === "65-74" ? T.rebate_secondary : age === "75+" ? T.rebate_tertiary : T.rebate_primary;

      var pensionPct = Math.min(27.5, Math.max(0, parseFloat(pensionEl.value) || 0));
      var pensionDed = Math.min(grossAnnual * pensionPct / 100, grossAnnual * T.pension_pct_cap, T.pension_rand_cap);

      var med = Math.max(0, Math.min(12, parseInt(medEl.value, 10) || 0));
      var mtcMonthly = 0;
      if (med >= 1) mtcMonthly += T.mtc_main;
      if (med >= 2) mtcMonthly += T.mtc_first_dep;
      if (med >= 3) mtcMonthly += (med - 2) * T.mtc_addl_dep;
      var mtcAnnual = mtcMonthly * 12;

      var taxable = Math.max(0, grossAnnual - pensionDed);
      var payeAnnual = Math.max(0, payeOnTaxable(taxable) - rebate - mtcAnnual);
      var uifMonthly = Math.min(grossMonthly * T.uif_rate, T.uif_cap);
      var uifAnnual = uifMonthly * 12;

      var netAnnual = grossAnnual - payeAnnual - uifAnnual;

      var marginal = "0%";
      var prev = 0;
      for (var i = 0; i < T.brackets.length; i++) {
        if (taxable > prev) marginal = Math.round(T.brackets[i][1] * 100) + "%";
        prev = T.brackets[i][0];
      }

      var eff = grossAnnual > 0 ? (payeAnnual + uifAnnual) / grossAnnual * 100 : 0;

      document.getElementById("r-net-monthly").textContent = fmtR2(netAnnual / 12);
      document.getElementById("r-paye").textContent = fmtR2(payeAnnual / 12) + " / mo";
      document.getElementById("r-uif").textContent = fmtR2(uifMonthly) + " / mo";
      document.getElementById("r-net-annual").textContent = fmtR2(netAnnual);
      document.getElementById("r-net-weekly").textContent = fmtR2(netAnnual / 52);
      document.getElementById("r-net-daily").textContent = fmtR2(netAnnual / 365);
      document.getElementById("r-effective").textContent = eff.toFixed(1) + "%";
      document.getElementById("r-marginal").textContent = marginal;
      document.getElementById("r-pension-note").textContent = pensionDed > 0 ? "Pension deduction applied: " + fmtR2(pensionDed) + " / yr" : "";
      document.getElementById("r-medical-note").textContent = mtcMonthly > 0 ? "Medical tax credit applied: " + fmtR2(mtcMonthly) + " / mo" : "";

      var gm = grossMonthly > 0 ? grossMonthly : 1;
      var pPaye = Math.min(100, payeAnnual / 12 / gm * 100),
          pUif = Math.min(100 - pPaye, uifMonthly / gm * 100),
          pNet = Math.max(0, 100 - pPaye - pUif);
      document.getElementById("bar-paye").style.width = pPaye + "%";
      document.getElementById("bar-uif").style.width = pUif + "%";
      document.getElementById("bar-net").style.width = pNet + "%";
      document.getElementById("bar-legend").innerHTML =
        '<span><span class="dot bar-paye"></span>PAYE ' + pPaye.toFixed(1) + '%</span>' +
        '<span><span class="dot bar-uif"></span>UIF ' + pUif.toFixed(1) + '%</span>' +
        '<span><span class="dot bar-net"></span>Take-home ' + pNet.toFixed(1) + '%</span>';
    }

    ["input", "change"].forEach(function (ev) {
      grossEl.addEventListener(ev, calc);
      ageEl.addEventListener(ev, calc);
      pensionEl.addEventListener(ev, calc);
      medEl.addEventListener(ev, calc);
    });
    calc();
  }

  // ---- UIF mini calculator ----
  var uifForm = document.getElementById("uifCalc");
  if (uifForm && typeof SAPC_TAX !== "undefined") {
    var T2 = SAPC_TAX;
    var sal = document.getElementById("uif-salary");
    function ucalc() {
      var s = Math.max(0, parseFloat(sal.value) || 0);
      var m = Math.min(s * T2.uif_rate, T2.uif_cap);
      document.getElementById("uif-out").innerHTML =
        "<strong>" + fmtR2(m) + "</strong> per month &nbsp;·&nbsp; " + fmtR2(m * 12) + " per year" +
        (s * T2.uif_rate > T2.uif_cap ? '<div class="hint">Capped: 1% of the R17,712 monthly ceiling applies.</div>' : "");
    }
    sal.addEventListener("input", ucalc);
    ucalc();
  }

  // ---- contact form client-side validation (server validates for real) ----
  var cf = document.getElementById("contactForm");
  if (cf) {
    cf.addEventListener("submit", function (e) {
      var name = document.getElementById("cf-name").value.trim(),
          email = document.getElementById("cf-email").value.trim(),
          msg = document.getElementById("cf-message").value.trim(),
          err = document.getElementById("cf-error");
      var ok = true, problems = [];
      if (name.length < 2) { ok = false; problems.push("your name"); }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) { ok = false; problems.push("a valid email"); }
      if (msg.length < 10) { ok = false; problems.push("a message (10+ characters)"); }
      if (!ok) {
        e.preventDefault();
        err.textContent = "Please add " + problems.join(", ") + ".";
        err.style.display = "block";
      }
    });
  }
})();
