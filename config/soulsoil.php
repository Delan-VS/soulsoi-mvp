<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SoulSoil Agricultural & Financial Settings
    |--------------------------------------------------------------------------
    |
    | Central configuration for farm capital structuring, profit-sharing ratios,
    | return-on-investment calculations, stress testing scenarios, and display.
    |
    */
    'financials' => [
        // Percentage of net crop profit allocated to external investors
        'investor_profit_share_percent' => 70.0,

        // Percentage of net crop profit retained by the farmer
        'farmer_profit_share_percent' => 30.0,

        // Configurable yield shortfall stress test percentage (e.g. 15.0% crop deficit)
        'default_yield_shortfall_percent' => 15.0,

        // Days in a standard calendar year for annualized return computations
        'days_in_year' => 365,

        // Default crop cycle duration (in days) when not specified by the crop benchmark
        'default_crop_cycle_days' => 120,

        // Currency formatting
        'currency_symbol' => '₹',
        'currency_code' => 'INR',

        // Standard labels
        'labels' => [
            'cycle_roi' => 'Cycle ROI',
            'annualized_roi' => 'Annualized ROI',
            'investor_share' => 'Investor Profit Share',
            'farmer_share' => 'Farmer Retained Profit',
            'formula_prefix' => 'Formula',
        ],
    ],
];
