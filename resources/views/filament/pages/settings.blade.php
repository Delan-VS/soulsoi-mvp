<x-filament-panels::page>
    <style>
        .settings-card {
            background-color: #222222;
            border: 1px solid #2e2e2e;
            border-radius: 12px;
            padding: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #d1d1d6;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            background-color: #2a2a2a;
            border: 1px solid #3a3a3a;
            border-radius: 8px;
            color: #ffffff;
            padding: 10px 14px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s;
        }
        .form-input:focus {
            border-color: #eab308;
            box-shadow: 0 0 0 2px rgba(234, 179, 8, 0.2);
        }
        .save-btn {
            background-color: #eab308;
            color: #111111;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 8px;
            transition: background-color 0.2s;
            cursor: pointer;
        }
        .save-btn:hover {
            background-color: #ca8a04;
        }
    </style>

    <div class="settings-card max-w-2xl">
        <form wire:submit.prevent="save">
            <h3 class="text-white font-semibold text-lg mb-6 border-b border-zinc-800 pb-3">General Configuration</h3>

            <div class="form-group">
                <label class="form-label" for="site_name">Application Name</label>
                <input class="form-input" type="text" id="site_name" wire:model="site_name">
            </div>

            <div class="form-group">
                <label class="form-label" for="system_email">System Alert Email</label>
                <input class="form-input" type="email" id="system_email" wire:model="system_email">
            </div>

            <h3 class="text-white font-semibold text-lg mt-8 mb-6 border-b border-zinc-800 pb-3">Sensor Thresholds</h3>

            <div class="form-group">
                <label class="form-label" for="sensor_interval">Polling Interval (Minutes)</label>
                <input class="form-input" type="number" id="sensor_interval" wire:model="sensor_interval">
            </div>

            <div class="form-group">
                <label class="form-label" for="notify_threshold">Critical Moisture Alert Threshold (%)</label>
                <input class="form-input" type="number" step="0.1" id="notify_threshold" wire:model="notify_threshold">
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="save-btn">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
