/**
 * SoulSoil Farm Financials & Real-time ROI Engine
 * 
 * Shared calculation logic between form preview and server verification.
 * Adheres to:
 * 1. Live dynamic formula note generation (never static).
 * 2. Investor Funding Target = Total Budget - Farmer Stake (with 0 <= stake < total budget validation).
 * 3. Investor ROI = Investor Profit Share / Investor Capital x 100 (configurable split, cycle & annualized).
 * 4. Storing Calculated ROI separately from Admin Override with reason audit.
 * 5. Non-blocking crop benchmark range warnings & optional yield-shortfall simulation.
 * 6. Division-by-zero protection and decimal precision.
 */

(function (window, document) {
    'use strict';

    const SoulSoilFinancials = {
        config: {
            investor_profit_share_percent: 70.0,
            farmer_profit_share_percent: 30.0,
            default_yield_shortfall_percent: 15.0,
            days_in_year: 365,
            default_crop_cycle_days: 120,
            currency_symbol: '₹',
            labels: {
                cycle_roi: 'Cycle ROI',
                annualized_roi: 'Annualized ROI',
                formula_prefix: 'Formula'
            }
        },

        crops: [],

        init: function (customConfig, cropsData) {
            if (customConfig && typeof customConfig === 'object') {
                this.config = Object.assign({}, this.config, customConfig);
            }
            if (Array.isArray(cropsData)) {
                this.crops = cropsData;
            }

            this.bindEvents();
            this.recalculateAll();
        },

        bindEvents: function () {
            const self = this;

            // Recalculate on any financial input change
            const watchedInputIds = [
                'wiz_acres',
                'wiz_primary_crop',
                'wiz_your_contribution',
                'wiz_expected_yield_kg',
                'wiz_expected_price_kg',
                'wiz_yielding_period',
                'wiz_crop_cycle_days',
                'wiz_toggle_shortfall',
                'wiz_is_roi_overridden',
                'wiz_roi',
                'wiz_override_reason'
            ];

            watchedInputIds.forEach(function (id) {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', function () {
                        self.recalculateAll();
                    });
                    el.addEventListener('change', function () {
                        self.recalculateAll();
                    });
                }
            });

            // Override toggle listener
            const overrideToggle = document.getElementById('wiz_is_roi_overridden');
            if (overrideToggle) {
                overrideToggle.addEventListener('change', function () {
                    self.toggleOverrideUi(this.checked);
                    self.recalculateAll();
                });
            }
        },

        toggleOverrideUi: function (isOverridden) {
            const roiInput = document.getElementById('wiz_roi');
            const reasonCard = document.getElementById('override_reason_container');
            const reasonInput = document.getElementById('wiz_override_reason');
            const overrideBadge = document.getElementById('calc_override_status_badge');

            if (isOverridden) {
                if (roiInput) {
                    roiInput.removeAttribute('readonly');
                    roiInput.classList.remove('bg-light');
                    roiInput.classList.add('border-warning');
                    roiInput.focus();
                }
                if (reasonCard) reasonCard.style.display = 'block';
                if (reasonInput) reasonInput.setAttribute('required', 'required');
                if (overrideBadge) {
                    overrideBadge.textContent = 'Admin Override Active';
                    overrideBadge.className = 'badge bg-warning text-dark px-2.5 py-1 fw-bold';
                }
            } else {
                if (roiInput) {
                    roiInput.setAttribute('readonly', 'readonly');
                    roiInput.classList.add('bg-light');
                    roiInput.classList.remove('border-warning');
                }
                if (reasonCard) reasonCard.style.display = 'none';
                if (reasonInput) {
                    reasonInput.removeAttribute('required');
                    reasonInput.value = '';
                }
                if (overrideBadge) {
                    overrideBadge.textContent = 'Calculated (Pure Engine)';
                    overrideBadge.className = 'badge bg-success bg-opacity-10 text-success px-2.5 py-1 fw-bold';
                }
            }
        },

        formatMoney: function (amount) {
            return Number(Math.round(amount)).toLocaleString('en-IN');
        },

        findCrop: function (cropName) {
            if (!cropName || !this.crops || !this.crops.length) return null;
            const needle = cropName.trim().toLowerCase();
            return this.crops.find(function (c) {
                return c.name.toLowerCase() === needle || needle.includes(c.name.toLowerCase()) || c.name.toLowerCase().includes(needle);
            }) || null;
        },

        calculateFinancials: function () {
            // 1. Sum up table budget items
            let totalBudget = 0;
            const items = [];
            document.querySelectorAll('#budget_table_body tr').forEach(function (tr) {
                const purpose = tr.querySelector('.b-purpose')?.value || '';
                const qty = parseFloat(tr.querySelector('.b-qty')?.value) || 0;
                const unit = tr.querySelector('.b-unit')?.value || 'kg';
                const rate = parseFloat(tr.querySelector('.b-rate')?.value) || 0;
                let amount = parseFloat(tr.querySelector('.b-amount')?.value) || 0;

                if (qty > 0 && rate > 0 && amount <= 0) {
                    amount = Math.round(qty * rate);
                    const amtInput = tr.querySelector('.b-amount');
                    if (amtInput) amtInput.value = amount;
                }

                if (purpose && amount > 0) {
                    items.push({
                        purpose: purpose,
                        item: purpose,
                        quantity: qty,
                        qty: qty,
                        unit: unit,
                        rate: rate,
                        cost: amount,
                        amount: amount
                    });
                    totalBudget += amount;
                }
            });

            // Update budget total display & hidden fields
            const budgetTotalDisplay = document.getElementById('budget_total_display');
            if (budgetTotalDisplay) budgetTotalDisplay.textContent = this.config.currency_symbol + this.formatMoney(totalBudget);

            const jsonEl = document.getElementById('budget_breakdown_json');
            if (jsonEl) jsonEl.value = JSON.stringify(items);

            const totalBudgetHidden = document.getElementById('wiz_total_budget');
            if (totalBudgetHidden) totalBudgetHidden.value = totalBudget;

            const totalBudgetDisplay = document.getElementById('wiz_total_budget_display');
            if (totalBudgetDisplay) totalBudgetDisplay.textContent = this.config.currency_symbol + this.formatMoney(totalBudget);

            // 2. Read Farmer Stake & Validate (Fix #2)
            const farmerStakeInput = document.getElementById('wiz_your_contribution');
            const farmerStake = Math.max(0, parseFloat(farmerStakeInput?.value) || 0);

            // Validation: Stake >= 0 and Stake < Total Budget
            const stakeErrorEl = document.getElementById('wiz_stake_validation_error');
            const isStakeInvalid = totalBudget > 0 && farmerStake >= totalBudget;

            if (isStakeInvalid) {
                if (farmerStakeInput) farmerStakeInput.classList.add('is-invalid');
                if (stakeErrorEl) {
                    stakeErrorEl.textContent = `Farmer stake (${this.config.currency_symbol}${this.formatMoney(farmerStake)}) must be strictly less than the total project budget (${this.config.currency_symbol}${this.formatMoney(totalBudget)}).`;
                    stakeErrorEl.style.display = 'block';
                }
            } else {
                if (farmerStakeInput) farmerStakeInput.classList.remove('is-invalid');
                if (stakeErrorEl) {
                    stakeErrorEl.textContent = '';
                    stakeErrorEl.style.display = 'none';
                }
            }

            // 3. Investor Funding Target = Total Budget - Farmer Stake (Fix #2)
            const investorFundingTarget = Math.max(0, totalBudget - farmerStake);
            const fundingTargetInput = document.getElementById('wiz_funding_target');
            if (fundingTargetInput) {
                fundingTargetInput.value = investorFundingTarget;
                fundingTargetInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            const fundingTargetDisplay = document.getElementById('wiz_funding_target_display');
            if (fundingTargetDisplay) fundingTargetDisplay.textContent = this.config.currency_symbol + this.formatMoney(investorFundingTarget);

            // 4. Read Production Parameters
            const yieldKgInput = document.getElementById('wiz_expected_yield_kg');
            const expectedYieldKg = Math.max(0, parseFloat(yieldKgInput?.value) || 0);

            const priceKgInput = document.getElementById('wiz_expected_price_kg');
            const sellingPricePerKg = Math.max(0, parseFloat(priceKgInput?.value) || 0);

            const acresInput = document.getElementById('wiz_acres');
            const totalAcres = Math.max(0.01, parseFloat(acresInput?.value) || 1.0);

            const cropNameInput = document.getElementById('wiz_primary_crop');
            const cropName = cropNameInput ? cropNameInput.value.trim() : '';

            const crop = this.findCrop(cropName);

            // Cycle Duration (Days)
            const periodMonths = parseInt(document.getElementById('wiz_yielding_period')?.value, 10) || 4;
            const cycleDays = crop && crop.growth_duration_days ? crop.growth_duration_days : (periodMonths * 30 || this.config.default_crop_cycle_days);
            const cycleDaysHidden = document.getElementById('wiz_crop_cycle_days');
            if (cycleDaysHidden) cycleDaysHidden.value = cycleDays;

            // Unit helper displays
            const yieldTonsEl = document.getElementById('wiz_yield_tons_display');
            if (yieldTonsEl) yieldTonsEl.textContent = `≈ ${(expectedYieldKg / 1000).toFixed(2)} Tons`;

            const priceTonEl = document.getElementById('wiz_price_ton_display');
            if (priceTonEl) priceTonEl.textContent = `${this.config.currency_symbol}${this.formatMoney(sellingPricePerKg * 1000)} / Ton`;

            // 5. Financial Formulas
            const grossRevenue = Math.round(expectedYieldKg * sellingPricePerKg);
            const netProfit = grossRevenue - totalBudget;

            const investorSharePct = this.config.investor_profit_share_percent;
            const farmerSharePct = this.config.farmer_profit_share_percent;

            let investorProfitShare = 0;
            let farmerProfitShare = 0;
            if (netProfit > 0) {
                investorProfitShare = Math.round(netProfit * (investorSharePct / 100.0));
                farmerProfitShare = Math.round(netProfit * (farmerSharePct / 100.0));
            }

            // Cycle ROI = (Investor Profit Share / Investor Capital) * 100
            let calculatedRoi = 0.0;
            if (investorFundingTarget > 0 && investorProfitShare > 0) {
                calculatedRoi = parseFloat(((investorProfitShare / investorFundingTarget) * 100.0).toFixed(1));
            }

            // Annualized ROI = Cycle ROI * (365 / Cycle Days)
            let annualizedRoi = 0.0;
            if (cycleDays > 0 && calculatedRoi > 0) {
                annualizedRoi = parseFloat((calculatedRoi * (this.config.days_in_year / cycleDays)).toFixed(1));
            }

            // 6. Update Summary Metrics in UI
            const revEl = document.getElementById('calc_projected_revenue');
            if (revEl) revEl.textContent = this.config.currency_symbol + this.formatMoney(grossRevenue);

            const deductEl = document.getElementById('calc_budget_deduct');
            if (deductEl) deductEl.textContent = '- ' + this.config.currency_symbol + this.formatMoney(totalBudget);

            const profitEl = document.getElementById('calc_projected_profit');
            if (profitEl) {
                profitEl.textContent = (netProfit >= 0 ? this.config.currency_symbol : '-' + this.config.currency_symbol) + this.formatMoney(Math.abs(netProfit));
                profitEl.className = netProfit >= 0 ? 'text-success fw-bold fs-5' : 'text-danger fw-bold fs-5';
            }

            // Hidden server sync inputs
            const calcRoiHidden = document.getElementById('wiz_calculated_roi');
            if (calcRoiHidden) calcRoiHidden.value = calculatedRoi;

            const annRoiHidden = document.getElementById('wiz_annualized_roi');
            if (annRoiHidden) annRoiHidden.value = annualizedRoi;

            // Badges in UI
            const cycleRoiBadge = document.getElementById('calc_cycle_roi_badge');
            if (cycleRoiBadge) cycleRoiBadge.textContent = `${calculatedRoi}% Cycle ROI`;

            const annRoiBadge = document.getElementById('calc_annualized_roi_badge');
            if (annRoiBadge) annRoiBadge.textContent = `${annualizedRoi}% Annualized (${cycleDays}d)`;

            // 7. Admin Override Handling (Fix #4)
            const overrideCheckbox = document.getElementById('wiz_is_roi_overridden');
            const isOverridden = overrideCheckbox && overrideCheckbox.checked;
            const roiInput = document.getElementById('wiz_roi');

            if (!isOverridden && roiInput) {
                roiInput.value = calculatedRoi;
            }

            // 8. Fix #1: Live Dynamic Formula Note
            const formulaNoteEl = document.getElementById('formula_note_live');
            if (formulaNoteEl) {
                if (investorFundingTarget <= 0) {
                    formulaNoteEl.innerHTML = `<i class="fas fa-info-circle text-muted me-1"></i><strong>${this.config.labels.formula_prefix}:</strong> Set total budget exceeding farmer stake to compute investor returns.`;
                } else if (investorProfitShare <= 0) {
                    formulaNoteEl.innerHTML = `<i class="fas fa-exclamation-triangle text-warning me-1"></i><strong>${this.config.labels.formula_prefix}:</strong> Revenue (${this.config.currency_symbol}${this.formatMoney(grossRevenue)}) does not exceed total budget (${this.config.currency_symbol}${this.formatMoney(totalBudget)}). Net profit is ${this.config.currency_symbol}0; ROI is 0.0%.`;
                } else {
                    formulaNoteEl.innerHTML = `<i class="fas fa-calculator text-success me-1"></i><strong>${this.config.labels.formula_prefix}:</strong> (${investorSharePct}% Investor Share ${this.config.currency_symbol}${this.formatMoney(investorProfitShare)} ÷ Capital ${this.config.currency_symbol}${this.formatMoney(investorFundingTarget)}) × 100 = <span class="text-success fw-bold">${calculatedRoi}% Cycle ROI</span> | <span class="text-primary fw-bold">${annualizedRoi}% Annualized</span> (${cycleDays}d cycle).`;
                }
            }

            // 9. Fix #5: Benchmark Range Warnings (Non-blocking)
            this.updateBenchmarkWarnings(crop, expectedYieldKg, sellingPricePerKg, totalAcres);

            // 10. Fix #5: Yield Shortfall Simulation
            this.updateShortfallSimulation(expectedYieldKg, sellingPricePerKg, totalBudget, investorFundingTarget, cycleDays);

            return {
                totalBudget,
                farmerStake,
                investorFundingTarget,
                grossRevenue,
                netProfit,
                investorProfitShare,
                farmerProfitShare,
                calculatedRoi,
                annualizedRoi,
                cycleDays
            };
        },

        updateBenchmarkWarnings: function (crop, expectedYieldKg, sellingPricePerKg, totalAcres) {
            const warningBox = document.getElementById('crop_benchmark_warnings_box');
            const warningText = document.getElementById('crop_benchmark_warning_text');
            const hintBox = document.getElementById('crop_benchmark_hint');

            if (!warningBox || !warningText) return;

            const yieldPerAcre = totalAcres > 0 ? (expectedYieldKg / totalAcres) : 0;
            const warnings = [];

            if (crop) {
                if (hintBox) {
                    hintBox.innerHTML = `<i class="fas fa-seedling text-success me-1"></i><strong>${crop.name} standard benchmark:</strong> ${crop.min_yield_per_acre} - ${crop.max_yield_per_acre} kg/acre | ${this.config.currency_symbol}${crop.min_price_per_kg} - ${this.config.currency_symbol}${crop.max_price_per_kg}/kg | ${crop.growth_duration_days} days.`;
                    hintBox.style.display = 'block';
                }

                if (crop.min_yield_per_acre && yieldPerAcre > 0 && yieldPerAcre < parseFloat(crop.min_yield_per_acre)) {
                    warnings.push(`Projected yield (${yieldPerAcre.toFixed(0)} kg/acre) is below standard benchmark (${crop.min_yield_per_acre} - ${crop.max_yield_per_acre} kg/acre) for ${crop.name}.`);
                } else if (crop.max_yield_per_acre && yieldPerAcre > parseFloat(crop.max_yield_per_acre)) {
                    warnings.push(`Projected yield (${yieldPerAcre.toFixed(0)} kg/acre) is higher than typical maximum (${crop.min_yield_per_acre} - ${crop.max_yield_per_acre} kg/acre) for ${crop.name}.`);
                }

                if (crop.min_price_per_kg && sellingPricePerKg > 0 && sellingPricePerKg < parseFloat(crop.min_price_per_kg)) {
                    warnings.push(`Selling price (${this.config.currency_symbol}${sellingPricePerKg}/kg) is lower than benchmark wholesale minimum (${this.config.currency_symbol}${crop.min_price_per_kg}/kg) for ${crop.name}.`);
                } else if (crop.max_price_per_kg && sellingPricePerKg > parseFloat(crop.max_price_per_kg)) {
                    warnings.push(`Selling price (${this.config.currency_symbol}${sellingPricePerKg}/kg) exceeds typical benchmark wholesale range (${this.config.currency_symbol}${crop.max_price_per_kg}/kg) for ${crop.name}.`);
                }
            } else {
                if (hintBox) hintBox.style.display = 'none';
            }

            if (warnings.length > 0) {
                warningText.innerHTML = warnings.map(w => `<li>${w}</li>`).join('');
                warningBox.style.display = 'block';
            } else {
                warningBox.style.display = 'none';
            }
        },

        updateShortfallSimulation: function (yieldKg, priceKg, totalBudget, capital, cycleDays) {
            const toggle = document.getElementById('wiz_toggle_shortfall');
            const card = document.getElementById('shortfall_simulation_card');
            if (!card) return;

            if (!toggle || !toggle.checked) {
                card.style.display = 'none';
                return;
            }

            card.style.display = 'block';

            const shortfallPct = this.config.default_yield_shortfall_percent;
            const stressedYield = Math.round(yieldKg * (1 - (shortfallPct / 100.0)));
            const stressedRevenue = Math.round(stressedYield * priceKg);
            const stressedNetProfit = stressedRevenue - totalBudget;

            let stressedInvestorShare = 0;
            if (stressedNetProfit > 0) {
                stressedInvestorShare = Math.round(stressedNetProfit * (this.config.investor_profit_share_percent / 100.0));
            }

            let stressedRoi = 0.0;
            if (capital > 0 && stressedInvestorShare > 0) {
                stressedRoi = parseFloat(((stressedInvestorShare / capital) * 100.0).toFixed(1));
            }

            let stressedAnnualized = 0.0;
            if (cycleDays > 0 && stressedRoi > 0) {
                stressedAnnualized = parseFloat((stressedRoi * (this.config.days_in_year / cycleDays)).toFixed(1));
            }

            const stressedYieldEl = document.getElementById('stress_yield_display');
            if (stressedYieldEl) stressedYieldEl.textContent = `${this.formatMoney(stressedYield)} kg (≈ ${(stressedYield / 1000).toFixed(2)} T)`;

            const stressedRevEl = document.getElementById('stress_rev_display');
            if (stressedRevEl) stressedRevEl.textContent = this.config.currency_symbol + this.formatMoney(stressedRevenue);

            const stressedProfitEl = document.getElementById('stress_profit_display');
            if (stressedProfitEl) {
                stressedProfitEl.textContent = (stressedNetProfit >= 0 ? this.config.currency_symbol : '-' + this.config.currency_symbol) + this.formatMoney(Math.abs(stressedNetProfit));
                stressedProfitEl.className = stressedNetProfit >= 0 ? 'fw-bold text-success' : 'fw-bold text-danger';
            }

            const stressedRoiBadge = document.getElementById('stress_roi_badge');
            if (stressedRoiBadge) {
                stressedRoiBadge.textContent = `${stressedRoi}% Cycle ROI | ${stressedAnnualized}% Annualized`;
                stressedRoiBadge.className = stressedRoi > 0 ? 'badge bg-warning text-dark px-2 py-1 fw-bold' : 'badge bg-danger text-white px-2 py-1 fw-bold';
            }
        },

        recalculateAll: function () {
            return this.calculateFinancials();
        }
    };

    window.SoulSoilFinancials = SoulSoilFinancials;

    // Helper functions for inline onclick handlers in table
    window.recalcRowBudget = function (input) {
        const tr = input.closest('tr');
        const qty = parseFloat(tr.querySelector('.b-qty')?.value) || 0;
        const rate = parseFloat(tr.querySelector('.b-rate')?.value) || 0;
        const amtInput = tr.querySelector('.b-amount');
        if (qty > 0 && rate > 0 && amtInput) {
            amtInput.value = Math.round(qty * rate);
        }
        SoulSoilFinancials.recalculateAll();
    };

    window.calculateBudgetTotal = function () {
        SoulSoilFinancials.recalculateAll();
    };

    window.removeBudgetRow = function (btn) {
        btn.closest('tr').remove();
        SoulSoilFinancials.recalculateAll();
    };

    window.addBudgetItem = function (purpose, qty = 1, unit = 'kg', rate = 0, amount = 0) {
        const tbody = document.getElementById('budget_table_body');
        if (!tbody) return;
        const row = document.createElement('tr');
        const initialAmount = amount > 0 ? amount : Math.round(qty * rate);
        row.innerHTML = `
            <td class="py-2.5 ps-3"><input type="text" class="form-control form-control-sm rounded-3 py-1.5 b-purpose" value="${purpose}" placeholder="Item purpose"></td>
            <td class="py-2.5"><input type="number" step="0.1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-qty" value="${qty}" oninput="recalcRowBudget(this)" placeholder="Qty"></td>
            <td class="py-2.5">
                <select class="form-select form-select-sm rounded-3 py-1.5 b-unit" onchange="calculateBudgetTotal()">
                    <option value="kg" ${unit === 'kg' ? 'selected' : ''}>kg</option>
                    <option value="quintal" ${unit === 'quintal' ? 'selected' : ''}>quintal</option>
                    <option value="bags" ${unit === 'bags' ? 'selected' : ''}>bags</option>
                    <option value="days" ${unit === 'days' ? 'selected' : ''}>days</option>
                    <option value="plot" ${unit === 'plot' ? 'selected' : ''}>plot</option>
                    <option value="units" ${unit === 'units' ? 'selected' : ''}>units</option>
                </select>
            </td>
            <td class="py-2.5"><input type="number" step="1" min="0" class="form-control form-control-sm rounded-3 py-1.5 b-rate" value="${rate}" oninput="recalcRowBudget(this)" placeholder="₹/unit"></td>
            <td class="py-2.5"><input type="number" class="form-control form-control-sm rounded-3 py-1.5 b-amount fw-bold text-success bg-light" value="${initialAmount}" oninput="calculateBudgetTotal()"></td>
            <td class="py-2.5 text-center"><button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeBudgetRow(this)"><i class="fas fa-trash-alt"></i></button></td>
        `;
        tbody.appendChild(row);
        SoulSoilFinancials.recalculateAll();
    };

    window.updateAutoRoi = function () {
        SoulSoilFinancials.recalculateAll();
    };

})(window, document);
