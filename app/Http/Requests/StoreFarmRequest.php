<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreFarmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->is_admin || auth()->user()->farmer !== null);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Step 1: Basic Plot Details
            'name' => 'required|string|max:255',
            'total_acres' => 'required|numeric|min:0.01',
            'primary_crop' => 'required|string|max:255',
            'secondary_crop' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'listing_category' => 'required|string|max:100',

            // Step 2: Investment & Budget Breakdown
            'budget_breakdown' => 'nullable|string', // JSON string from hidden input
            'total_budget' => 'nullable|numeric|min:0',
            'funding_target' => 'required|numeric|min:1', // Investor funding target
            'your_contribution' => 'required|numeric|min:0', // Farmer stake
            'expected_yield_kg' => 'required|numeric|min:1',
            'selling_price_kg' => 'required|numeric|min:0.01',
            'calculated_roi' => 'nullable|numeric',
            'annualized_roi' => 'nullable|numeric',
            'expected_roi' => 'required|numeric|min:0',
            'is_roi_overridden' => 'nullable',
            'roi_override_reason' => 'nullable|string|max:1000',
            'crop_cycle_days' => 'nullable|integer|min:1',
            'yield_shortfall_percent' => 'nullable|numeric|min:0|max:100',

            // Step 3: Media Uploads
            'farm_photo' => 'nullable|image|max:5120',
            'farm_photos.*' => 'nullable|image|max:5120',
            'farm_documents.*' => 'nullable|mimes:pdf|max:10240',

            // Step 4: Yield & Timeline
            'yielding_period' => 'required|integer|min:1',
            'expected_start_date' => 'required|date',
            'farming_timeline' => 'nullable|string',

            // Step 5: Terms & Investment Limits
            'min_investment' => 'required|numeric|min:1|lte:max_investment|lte:funding_target',
            'max_investment' => 'required|numeric|gte:min_investment|lte:funding_target',
        ];
    }

    /**
     * Configure the validator instance.
     * Enforce: Farmer Stake >= 0 and Farmer Stake < Total Budget.
     * Enforce: Reason required if ROI is overridden.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $totalBudget = (float) ($this->input('total_budget') ?? 0.0);
            $farmerStake = (float) ($this->input('your_contribution') ?? 0.0);
            $isOverridden = filter_var($this->input('is_roi_overridden'), FILTER_VALIDATE_BOOLEAN)
                || $this->input('is_roi_overridden') === '1'
                || $this->input('is_roi_overridden') === 1;
            $reason = trim((string) $this->input('roi_override_reason', ''));

            // Fix #2: Validate that the stake is >= 0 and < the total budget
            if ($totalBudget > 0.0 && $farmerStake >= $totalBudget) {
                $validator->errors()->add(
                    'your_contribution',
                    sprintf(
                        'Farmer stake (₹%s) must be strictly less than the total budget (₹%s). Investor crowdfunding requires an open capital ask.',
                        number_format($farmerStake, 2),
                        number_format($totalBudget, 2)
                    )
                );
            }

            // Fix #4: An override needs a reason
            if ($isOverridden && empty($reason)) {
                $validator->errors()->add(
                    'roi_override_reason',
                    'An audit reason is required whenever the admin overrides the algorithmic calculated ROI.'
                );
            }
        });
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'your_contribution.min' => 'Farmer stake contribution must be at least ₹0.',
            'expected_yield_kg.required' => 'Expected harvest yield in kg is required for automatic financial calculations.',
            'selling_price_kg.required' => 'Expected selling price (₹/kg) is required for revenue projections.',
            'roi_override_reason.required_if' => 'Please provide a clear justification note for overriding the calculated investor ROI.',
        ];
    }
}
