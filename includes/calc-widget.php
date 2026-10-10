<?php
// PAYE calculator widget — include once per page, after config.php.
// Renders the input form + live results card. Math runs in assets/js/app.js
// using the SAPC_TAX constants below, which mirror includes/config.php.
$__sapcTaxJson = json_encode([
    'brackets'         => $TAX_BRACKETS,
    'rebate_primary'   => $REBATE_PRIMARY,
    'rebate_secondary' => $REBATE_SECONDARY,
    'rebate_tertiary'  => $REBATE_TERTIARY,
    'pension_pct_cap'  => $PENSION_PCT_CAP,
    'pension_rand_cap' => $PENSION_RAND_CAP,
    'mtc_main'         => $MTC_MAIN_MEMBER,
    'mtc_first_dep'    => $MTC_FIRST_DEPENDANT,
    'mtc_addl_dep'     => $MTC_ADDL_DEPENDANT,
    'uif_rate'         => $UIF_RATE,
    'uif_cap'          => $UIF_CAP_MONTH,
    'tax_year'         => $TAX_YEAR_LABEL,
]);
?>
<script>var SAPC_TAX = <?php echo $__sapcTaxJson; ?>;</script>
<div class="calc-layout">
  <form class="card" id="payeCalc" onsubmit="return false;" aria-label="Take-home pay calculator">
    <div class="field">
      <label id="gross-label">Gross salary</label>
      <div class="seg" role="group" aria-labelledby="gross-label" style="margin-bottom:8px">
        <button type="button" data-period="monthly" class="active" aria-pressed="true">Monthly</button>
        <button type="button" data-period="annual" aria-pressed="false">Annual</button>
      </div>
      <input type="number" id="gross" value="35000" min="0" step="100" inputmode="decimal" aria-label="Gross salary in Rand">
    </div>
    <div class="field">
      <label for="age">Age group</label>
      <select id="age">
        <option value="u65" selected>Under 65</option>
        <option value="65-74">65 to 74</option>
        <option value="75+">75 and over</option>
      </select>
      <div class="hint">Over-65s get extra SARS rebates, so PAYE drops.</div>
    </div>
    <div class="field-row">
      <div class="field">
        <label for="pension">Pension / RA (%)</label>
        <input type="number" id="pension" value="0" min="0" max="27.5" step="0.5" inputmode="decimal">
        <div class="hint">% of salary, reduces taxable income.</div>
      </div>
      <div class="field">
        <label for="medical">Medical aid members</label>
        <input type="number" id="medical" value="0" min="0" max="12" step="1" inputmode="numeric">
        <div class="hint">People covered, incl. yourself.</div>
      </div>
    </div>
    <p class="disclaimer">Uses SARS <?php echo htmlspecialchars($TAX_YEAR_LABEL); ?> tables (1 Mar 2026 – 28 Feb 2027). Estimate only.</p>
  </form>
  <div class="result-card" aria-live="polite">
    <div class="lbl">Your take-home pay</div>
    <div class="big mono" id="r-net-monthly">R0.00</div>
    <div class="lbl">per month</div>
    <div class="bar-wrap">
      <div class="bar" aria-hidden="true"><span class="bar-paye" id="bar-paye"></span><span class="bar-uif" id="bar-uif"></span><span class="bar-net" id="bar-net"></span></div>
      <div class="bar-legend" id="bar-legend"></div>
    </div>
    <div class="result-rows">
      <div class="row"><span>PAYE (income tax)</span><strong class="mono" id="r-paye">–</strong></div>
      <div class="row"><span>UIF</span><strong class="mono" id="r-uif">–</strong></div>
      <div class="row"><span>Take-home per year</span><strong class="mono" id="r-net-annual">–</strong></div>
      <div class="row"><span>Take-home per week</span><strong class="mono" id="r-net-weekly">–</strong></div>
      <div class="row"><span>Take-home per day</span><strong class="mono" id="r-net-daily">–</strong></div>
      <div class="row"><span>Effective deduction rate</span><strong class="mono" id="r-effective">–</strong></div>
      <div class="row"><span>Marginal tax bracket</span><strong class="mono" id="r-marginal">–</strong></div>
    </div>
    <p class="hint" id="r-pension-note" style="color:#bfe0c9;margin-bottom:2px"></p>
    <p class="hint" id="r-medical-note" style="color:#bfe0c9;margin-top:0"></p>
  </div>
</div>
