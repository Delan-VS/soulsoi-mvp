<?php

namespace App\Services;

use App\Models\Crop;

class FarmFinancialsService
{
    /**
     * Compute comprehensive farm financials, investor returns, profit splits,
     * stress test scenario, and benchmark warnings.
     *
     * @param array $inputs
     * @return array
     */
    public function calculate(array $inputs): array
    {
        $totalBudget = max(0.0, (float) ($inputs['total_budget'] ?? 0.0));
        $farmerStake = max(0.0, (float) ($inputs['farmer_stake'] ?? $inputs['your_contribution'] ?? 0.0));
        $expectedYieldKg = max(0.0, (float) ($inputs['expected_yield_kg'] ?? 0.0));
        $sellingPricePerKg = max(0.0, (float) ($inputs['selling_price_per_kg'] ?? $inputs['selling_price_kg'] ?? 0.0));
        $totalAcres = max(0.0, (float) ($inputs['total_acres'] ?? 1.0));

        // Configurable profit share percentages
        $investorSharePercent = (float) config('soulsoil.financials.investor_profit_share_percent', 70.0);
        $farmerSharePercent = (float) config('soulsoil.financials.farmer_profit_share_percent', 30.0);
        $shortfallPercent = (float) ($inputs['yield_shortfall_percent'] ?? config('soulsoil.financials.default_yield_shortfall_percent', 15.0));
        $daysInYear = (int) config('soulsoil.financials.days_in_year', 365);

        // Fetch crop benchmarks from database if crop specified
        $cropName = $inputs['crop_name'] ?? $inputs['primary_crop'] ?? null;
        $crop = null;
        if (!empty($cropName)) {
            $crop = Crop::where('name', $cropName)->first();
            if (!$crop) {
                // Try fuzzy/partial match if exact match not found
                $crop = Crop::where('name', 'LIKE', '%' . $cropName . '%')->first();
            }
        }

        // Cycle duration in days
        $defaultDays = (int) config('soulsoil.financials.default_crop_cycle_days', 120);
        $cycleDays = (int) ($inputs['crop_cycle_days'] ?? $crop?->growth_duration_days ?? $defaultDays);
        if ($cycleDays <= 0) {
            $cycleDays = $defaultDays;
        }

        // 1. Investor Funding Target = Total Budget - Farmer Stake
        $investorFundingTarget = max(0.0, round($totalBudget - $farmerStake, 2));

        // Validate stake condition: stake >= 0 and stake < total_budget
        $isStakeValid = ($farmerStake >= 0.0) && ($totalBudget <= 0.0 || $farmerStake < $totalBudget);
        $stakeValidationError = null;
        if ($totalBudget > 0.0 && $farmerStake >= $totalBudget) {
            $stakeValidationError = sprintf(
                'Farmer stake (₹%s) must be strictly less than the total project budget (₹%s) to allow investor crowdfunding.',
                number_format($farmerStake, 2),
                number_format($totalBudget, 2)
            );
        }

        // 2. Gross Harvest Revenue & Net Profit
        $grossRevenue = round($expectedYieldKg * $sellingPricePerKg, 2);
        $netProfit = round($grossRevenue - $totalBudget, 2);

        // 3. Profit Allocation
        $investorProfitShare = 0.0;
        $farmerProfitShare = 0.0;
        if ($netProfit > 0.0) {
            $investorProfitShare = round($netProfit * ($investorSharePercent / 100.0), 2);
            $farmerProfitShare = round($netProfit * ($farmerSharePercent / 100.0), 2);
        }

        // 4. Investor Cycle ROI (%) = (Investor Profit Share / Investor Capital) * 100
        $calculatedRoi = 0.0;
        if ($investorFundingTarget > 0.0 && $investorProfitShare > 0.0) {
            $calculatedRoi = round(($investorProfitShare / $investorFundingTarget) * 100.0, 2);
        }

        // 5. Annualized ROI (%) = Cycle ROI * (365 / Cycle Days)
        $annualizedRoi = 0.0;
        if ($cycleDays > 0 && $calculatedRoi > 0.0) {
            $annualizedRoi = round($calculatedRoi * ($daysInYear / $cycleDays), 2);
        }

        // 6. Dynamic Live Formula Note
        $formulaNote = $this->buildFormulaNote(
            $investorProfitShare,
            $investorFundingTarget,
            $calculatedRoi,
            $annualizedRoi,
            $cycleDays,
            $investorSharePercent
        );

        // 7. Optional Yield Shortfall Stress Test Scenario
        $applyShortfall = (bool) ($inputs['apply_shortfall'] ?? false);
        $shortfallScenario = $this->calculateShortfallScenario(
            $expectedYieldKg,
            $sellingPricePerKg,
            $totalBudget,
            $investorFundingTarget,
            $shortfallPercent,
            $investorSharePercent,
            $cycleDays,
            $daysInYear
        );

        // 8. Benchmark Range Checks & Non-blocking Warnings
        $yieldPerAcre = $totalAcres > 0.0 ? round($expectedYieldKg / $totalAcres, 2) : 0.0;
        $benchmarkWarnings = [];
        $cropBenchmark = null;

        if ($crop) {
            $cropBenchmark = [
                'crop_name' => $crop->name,
                'min_yield_per_acre' => (float) $crop->min_yield_per_acre,
                'max_yield_per_acre' => (float) $crop->max_yield_per_acre,
                'min_price_per_kg' => (float) $crop->min_price_per_kg,
                'max_price_per_kg' => (float) $crop->max_price_per_kg,
                'growth_duration_days' => (int) $crop->growth_duration_days,
            ];
            $benchmarkWarnings = $crop->checkBenchmarkWarnings($yieldPerAcre, $sellingPricePerKg);
        }

        return [
            'total_budget' => $totalBudget,
            'farmer_stake' => $farmerStake,
            'investor_funding_target' => $investorFundingTarget,
            'is_stake_valid' => $isStakeValid,
            'stake_validation_error' => $stakeValidationError,
            'expected_yield_kg' => $expectedYieldKg,
            'selling_price_per_kg' => $sellingPricePerKg,
            'total_acres' => $totalAcres,
            'yield_per_acre' => $yieldPerAcre,
            'gross_revenue' => $grossRevenue,
            'net_profit' => $netProfit,
            'investor_share_percent' => $investorSharePercent,
            'farmer_share_percent' => $farmerSharePercent,
            'investor_profit_share' => $investorProfitShare,
            'farmer_profit_share' => $farmerProfitShare,
            'calculated_roi' => $calculatedRoi,
            'annualized_roi' => $annualizedRoi,
            'cycle_days' => $cycleDays,
            'days_in_year' => $daysInYear,
            'formula_note' => $formulaNote,
            'shortfall_percent' => $shortfallPercent,
            'apply_shortfall' => $applyShortfall,
            'shortfall_scenario' => $shortfallScenario,
            'crop_benchmark' => $cropBenchmark,
            'benchmark_warnings' => $benchmarkWarnings,
            'has_benchmark_warnings' => !empty($benchmarkWarnings),
        ];
    }

    /**
     * Build dynamic formula note formatted strictly from live values.
     *
     * @param float $investorProfitShare
     * @param float $investorCapital
     * @param float $cycleRoi
     * @param float $annualizedRoi
     * @param int $cycleDays
     * @param float $sharePercent
     * @return string
     */
    public function buildFormulaNote(
        float $investorProfitShare,
        float $investorCapital,
        float $cycleRoi,
        float $annualizedRoi,
        int $cycleDays,
        float $sharePercent
    ): string {
        $prefix = config('soulsoil.financials.labels.formula_prefix', 'Formula');
        $currency = config('soulsoil.financials.currency_symbol', '₹');

        if ($investorCapital <= 0.0) {
            return sprintf(
                '%s: Investor capital required is %s0.00. Enter a total budget exceeding farmer stake to compute investor returns.',
                $prefix,
                $currency
            );
        }

        if ($investorProfitShare <= 0.0) {
            return sprintf(
                '%s: Gross harvest revenue does not exceed total budget. No positive net profit to distribute (%s0.00 investor share). ROI is 0.0%%.',
                $prefix,
                $currency
            );
        }

        return sprintf(
            '%s: (%s%.0f%% Investor Profit Share %s%s ÷ Investor Capital %s%s) × 100 = %.1f%% Cycle ROI | %.1f%% Annualized ROI (over %d-day crop cycle)',
            $prefix,
            $sharePercent,
            '%',
            $currency,
            number_format($investorProfitShare),
            $currency,
            number_format($investorCapital),
            $cycleRoi,
            $annualizedRoi,
            $cycleDays
        );
    }

    /**
     * Calculate stressed downside scenario with reduced crop yield.
     *
     * @param float $yieldKg
     * @param float $priceKg
     * @param float $budget
     * @param float $capital
     * @param float $shortfallPct
     * @param float $sharePct
     * @param int $cycleDays
     * @param int $daysInYear
     * @return array
     */
    public function calculateShortfallScenario(
        float $yieldKg,
        float $priceKg,
        float $budget,
        float $capital,
        float $shortfallPct,
        float $sharePct,
        int $cycleDays,
        int $daysInYear
    ): array {
        $stressedYieldKg = round($yieldKg * (1.0 - ($shortfallPct / 100.0)), 2);
        $stressedRevenue = round($stressedYieldKg * $priceKg, 2);
        $stressedNetProfit = round($stressedRevenue - $budget, 2);

        $stressedInvestorShare = 0.0;
        if ($stressedNetProfit > 0.0) {
            $stressedInvestorShare = round($stressedNetProfit * ($sharePct / 100.0), 2);
        }

        $stressedRoi = 0.0;
        if ($capital > 0.0 && $stressedInvestorShare > 0.0) {
            $stressedRoi = round(($stressedInvestorShare / $capital) * 100.0, 2);
        }

        $stressedAnnualizedRoi = 0.0;
        if ($cycleDays > 0 && $stressedRoi > 0.0) {
            $stressedAnnualizedRoi = round($stressedRoi * ($daysInYear / $cycleDays), 2);
        }

        return [
            'shortfall_percent' => $shortfallPct,
            'stressed_yield_kg' => $stressedYieldKg,
            'stressed_revenue' => $stressedRevenue,
            'stressed_net_profit' => $stressedNetProfit,
            'stressed_investor_profit_share' => $stressedInvestorShare,
            'stressed_cycle_roi' => $stressedRoi,
            'stressed_annualized_roi' => $stressedAnnualizedRoi,
            'is_profitable' => $stressedNetProfit > 0.0,
        ];
    }
}
