<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\FarmFinancialsService;
use App\Models\Farm;
use App\Models\Crop;
use App\Models\AuditLog;
use App\Http\Requests\StoreFarmRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FarmFinancialsServiceTest extends TestCase
{
    protected FarmFinancialsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FarmFinancialsService();
    }

    /**
     * Fix #2: Investor Funding Target = Total Budget - Farmer Stake.
     */
    public function test_investor_funding_target_equals_total_budget_minus_farmer_stake(): void
    {
        $result = $this->service->calculate([
            'total_budget' => 350000.00,
            'farmer_stake' => 50000.00,
            'expected_yield_kg' => 18000,
            'selling_price_per_kg' => 25,
            'crop_cycle_days' => 120,
        ]);

        $this->assertEquals(350000.00, $result['total_budget']);
        $this->assertEquals(50000.00, $result['farmer_stake']);
        $this->assertEquals(300000.00, $result['investor_funding_target']);
        $this->assertTrue($result['is_stake_valid']);
        $this->assertNull($result['stake_validation_error']);
    }

    /**
     * Fix #2: Validate that farmer stake is >= 0 and < total budget.
     */
    public function test_farmer_stake_validation_fails_when_stake_gte_total_budget(): void
    {
        // Case: Farmer stake equals total budget (no room for external investors)
        $result = $this->service->calculate([
            'total_budget' => 100000.00,
            'farmer_stake' => 100000.00,
            'expected_yield_kg' => 5000,
            'selling_price_per_kg' => 25,
        ]);

        $this->assertFalse($result['is_stake_valid']);
        $this->assertNotNull($result['stake_validation_error']);
        $this->assertStringContainsString('must be strictly less than the total project budget', $result['stake_validation_error']);

        // Case: Farmer stake exceeds total budget
        $resultExceeded = $this->service->calculate([
            'total_budget' => 100000.00,
            'farmer_stake' => 120000.00,
            'expected_yield_kg' => 5000,
            'selling_price_per_kg' => 25,
        ]);

        $this->assertFalse($resultExceeded['is_stake_valid']);
    }

    /**
     * Fix #3: Investor ROI = investor profit share / investor capital x 100.
     * Profit split between farmer and investors comes from configurable profit-share setting.
     */
    public function test_investor_roi_formula_and_configurable_profit_split(): void
    {
        // Set profit share config: 70% investor, 30% farmer
        config(['soulsoil.financials.investor_profit_share_percent' => 70.0]);
        config(['soulsoil.financials.farmer_profit_share_percent' => 30.0]);

        // Total Budget: 3,50,000, Farmer Stake: 50,000 => Investor Capital: 3,00,000
        // Expected Yield: 18,000 kg @ ₹25/kg => Gross Revenue: 4,50,000
        // Net Profit: 4,50,000 - 3,50,000 = 1,00,000
        // Investor Share: 70% of 1,00,000 = 70,000
        // Farmer Share: 30% of 1,00,000 = 30,000
        // Cycle ROI: (70,000 / 3,00,000) * 100 = 23.33% (~23.3%)
        $result = $this->service->calculate([
            'total_budget' => 350000.00,
            'farmer_stake' => 50000.00,
            'expected_yield_kg' => 18000.00,
            'selling_price_per_kg' => 25.00,
            'crop_cycle_days' => 120,
        ]);

        $this->assertEquals(450000.00, $result['gross_revenue']);
        $this->assertEquals(100000.00, $result['net_profit']);
        $this->assertEquals(70000.00, $result['investor_profit_share']);
        $this->assertEquals(30000.00, $result['farmer_profit_share']);
        $this->assertEquals(23.33, round($result['calculated_roi'], 2));

        // Test with different configurable profit split (e.g. 80% investor / 20% farmer)
        config(['soulsoil.financials.investor_profit_share_percent' => 80.0]);
        config(['soulsoil.financials.farmer_profit_share_percent' => 20.0]);

        $resultCustom = $this->service->calculate([
            'total_budget' => 350000.00,
            'farmer_stake' => 50000.00,
            'expected_yield_kg' => 18000.00,
            'selling_price_per_kg' => 25.00,
            'crop_cycle_days' => 120,
        ]);

        $this->assertEquals(80000.00, $resultCustom['investor_profit_share']);
        $this->assertEquals(20000.00, $resultCustom['farmer_profit_share']);
        $this->assertEquals(26.67, round($resultCustom['calculated_roi'], 2));
    }

    /**
     * Fix #3: Show annualized ROI using crop cycle days and label which is shown.
     */
    public function test_annualized_roi_with_crop_cycle_days(): void
    {
        config(['soulsoil.financials.investor_profit_share_percent' => 70.0]);
        config(['soulsoil.financials.days_in_year' => 365]);

        // Cycle ROI: 23.33%, Cycle Days: 120 days
        // Annualized ROI = 23.33 * (365 / 120) = 70.96%
        $result = $this->service->calculate([
            'total_budget' => 350000.00,
            'farmer_stake' => 50000.00,
            'expected_yield_kg' => 18000.00,
            'selling_price_per_kg' => 25.00,
            'crop_cycle_days' => 120,
        ]);

        $this->assertEquals(120, $result['cycle_days']);
        $this->assertEquals(70.96, round($result['annualized_roi'], 2));
    }

    /**
     * Fix #1: Formula note under Expected ROI must be built from live values, never static.
     */
    public function test_live_dynamic_formula_note_formatting(): void
    {
        config(['soulsoil.financials.investor_profit_share_percent' => 70.0]);

        $result = $this->service->calculate([
            'total_budget' => 350000.00,
            'farmer_stake' => 50000.00,
            'expected_yield_kg' => 18000.00,
            'selling_price_per_kg' => 25.00,
            'crop_cycle_days' => 120,
        ]);

        $note = $result['formula_note'];

        $this->assertStringContainsString('Formula:', $note);
        $this->assertStringContainsString('70,000', $note); // Investor Profit Share
        $this->assertStringContainsString('300,000', $note); // Investor Capital
        $this->assertStringContainsString('23.3%', $note); // Cycle ROI
        $this->assertStringContainsString('71.0%', $note); // Annualized ROI
        $this->assertStringContainsString('120-day', $note); // Duration
    }

    /**
     * Fix #5: Warn (not block) when yield per acre or price falls outside crop benchmarks.
     */
    public function test_crop_benchmark_warnings_when_outside_range(): void
    {
        $crop = Crop::firstOrCreate(
            ['name' => 'Paddy'],
            [
                'min_yield_per_acre' => 1800.00,
                'max_yield_per_acre' => 2800.00,
                'min_price_per_kg' => 20.00,
                'max_price_per_kg' => 35.00,
                'growth_duration_days' => 120,
            ]
        );

        // Case 1: Within normal benchmarks (2,000 kg/acre, ₹25/kg)
        $resultNormal = $this->service->calculate([
            'total_budget' => 200000.00,
            'farmer_stake' => 30000.00,
            'expected_yield_kg' => 20000.00, // 10 acres * 2,000 kg/acre
            'selling_price_per_kg' => 25.00,
            'total_acres' => 10.0,
            'crop_name' => 'Paddy',
        ]);

        $this->assertFalse($resultNormal['has_benchmark_warnings']);
        $this->assertEmpty($resultNormal['benchmark_warnings']);

        // Case 2: Yield too low (1,000 kg/acre < 1,800 min) & Price too high (₹50/kg > ₹35 max)
        $resultOutlier = $this->service->calculate([
            'total_budget' => 200000.00,
            'farmer_stake' => 30000.00,
            'expected_yield_kg' => 10000.00, // 10 acres * 1,000 kg/acre
            'selling_price_per_kg' => 50.00,
            'total_acres' => 10.0,
            'crop_name' => 'Paddy',
        ]);

        $this->assertTrue($resultOutlier['has_benchmark_warnings']);
        $this->assertCount(2, $resultOutlier['benchmark_warnings']);
        $this->assertStringContainsString('below standard benchmark', $resultOutlier['benchmark_warnings'][0]);
        $this->assertStringContainsString('exceeds typical wholesale benchmark', $resultOutlier['benchmark_warnings'][1]);
    }

    /**
     * Fix #5: Optional yield-shortfall scenario using configurable percentage.
     */
    public function test_yield_shortfall_stress_test_scenario(): void
    {
        config(['soulsoil.financials.default_yield_shortfall_percent' => 15.0]);
        config(['soulsoil.financials.investor_profit_share_percent' => 70.0]);

        $result = $this->service->calculate([
            'total_budget' => 350000.00,
            'farmer_stake' => 50000.00,
            'expected_yield_kg' => 18000.00,
            'selling_price_per_kg' => 25.00,
            'crop_cycle_days' => 120,
            'apply_shortfall' => true,
        ]);

        $shortfall = $result['shortfall_scenario'];

        // 18,000 kg - 15% = 15,300 kg
        $this->assertEquals(15300.00, $shortfall['stressed_yield_kg']);
        // 15,300 * 25 = 3,82,500
        $this->assertEquals(382500.00, $shortfall['stressed_revenue']);
        // 3,82,500 - 3,50,000 = 32,500
        $this->assertEquals(32500.00, $shortfall['stressed_net_profit']);
        // 70% of 32,500 = 22,750
        $this->assertEquals(22750.00, $shortfall['stressed_investor_profit_share']);
        // Stressed ROI: (22,750 / 300,000) * 100 = 7.58% (~7.6%)
        $this->assertEquals(7.58, round($shortfall['stressed_cycle_roi'], 2));
    }

    /**
     * Fix #6: Division by zero and empty input safety.
     */
    public function test_division_by_zero_and_empty_inputs_safety(): void
    {
        // All inputs 0 or empty
        $result = $this->service->calculate([]);

        $this->assertEquals(0.0, $result['total_budget']);
        $this->assertEquals(0.0, $result['farmer_stake']);
        $this->assertEquals(0.0, $result['investor_funding_target']);
        $this->assertEquals(0.0, $result['calculated_roi']);
        $this->assertEquals(0.0, $result['annualized_roi']);
        $this->assertIsString($result['formula_note']);

        // Total Budget 0, Capital 0
        $resultZeroCapital = $this->service->calculate([
            'total_budget' => 0,
            'farmer_stake' => 0,
            'expected_yield_kg' => 10000,
            'selling_price_per_kg' => 25,
            'crop_cycle_days' => 0,
        ]);

        $this->assertEquals(0.0, $resultZeroCapital['calculated_roi']);
        $this->assertEquals(0.0, $resultZeroCapital['annualized_roi']);
    }

    /**
     * Fix #2: Farm model funding progress and isFunded() checks against investor funding target.
     */
    public function test_farm_funding_progress_and_is_funded_checks(): void
    {
        $farm = new Farm([
            'name' => 'Test Plot Alpha',
            'total_budget' => 350000.00,
            'your_contribution' => 50000.00,
            'funding_target' => 300000.00, // Investor funding target
            'funding_raised' => 150000.00,
        ]);

        // Progress: 1,50,000 / 3,00,000 = 50%
        $this->assertEquals(50.0, $farm->fundingProgressPercent());
        $this->assertFalse($farm->isFunded());

        // Fully funded
        $farm->funding_raised = 300000.00;
        $this->assertEquals(100.0, $farm->fundingProgressPercent());
        $this->assertTrue($farm->isFunded());
    }

    /**
     * Fix #4: Form Request validates that override requires justification reason.
     */
    public function test_store_farm_request_requires_override_reason_when_overridden(): void
    {
        $dataWithOverrideNoReason = [
            'name' => 'Farm Beta',
            'total_acres' => 10,
            'primary_crop' => 'Paddy',
            'listing_category' => 'Cereals',
            'total_budget' => 350000,
            'funding_target' => 300000,
            'your_contribution' => 50000,
            'expected_yield_kg' => 18000,
            'selling_price_kg' => 25,
            'expected_roi' => 25.0,
            'is_roi_overridden' => '1',
            'roi_override_reason' => '', // Empty!
            'yielding_period' => 4,
            'expected_start_date' => '2026-12-01',
            'min_investment' => 1000,
            'max_investment' => 50000,
        ];

        $request = StoreFarmRequest::create('/admin/farms', 'POST', $dataWithOverrideNoReason);
        $validator = Validator::make($request->all(), $request->rules());
        $request->withValidator($validator);

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('roi_override_reason'));
    }
}
