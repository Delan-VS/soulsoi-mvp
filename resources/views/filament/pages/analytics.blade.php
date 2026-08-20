<x-filament-panels::page>
    <style>
        .premium-card {
            background-color: #222222;
            border: 1px solid #2e2e2e;
            border-radius: 12px;
            padding: 24px;
        }
        .chart-bar {
            height: 160px;
            background-color: #2a2a2a;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            padding: 10px;
        }
        .bar {
            width: 24px;
            background: linear-gradient(180deg, #5cc42c 0%, #5cc42c 100%);
            border-radius: 4px;
            transition: height 1s ease-in-out;
        }
        .bar-amber {
            background: linear-gradient(180deg, #f59e0b 0%, #b45309 100%);
        }
        .bar-emerald {
            background: linear-gradient(180deg, #10b981 0%, #047857 100%);
        }
    </style>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="premium-card">
                <div class="text-zinc-400 text-sm font-medium">Active Sensors</div>
                <div class="text-3xl font-bold text-white mt-2">{{ $activeSensorsCount }} / {{ $sensorsCount }}</div>
                <div class="text-emerald-500 text-xs mt-1">● Online and transmitting</div>
            </div>
            <div class="premium-card">
                <div class="text-zinc-400 text-sm font-medium">Soil Reports Analysed</div>
                <div class="text-3xl font-bold text-white mt-2">{{ $soilReportsCount }}</div>
                <div class="text-zinc-500 text-xs mt-1">Across all active sectors</div>
            </div>
            <div class="premium-card">
                <div class="text-zinc-400 text-sm font-medium">Average pH Level</div>
                <div class="text-3xl font-bold text-amber-500 mt-2">{{ $avgPh }} pH</div>
                <div class="text-zinc-500 text-xs mt-1">Optimal target: 6.0 - 7.0</div>
            </div>
            <div class="premium-card">
                <div class="text-zinc-400 text-sm font-medium">Average Soil Moisture</div>
                <div class="text-3xl font-bold text-[#5cc42c] mt-2">{{ $avgMoisture }}%</div>
                <div class="text-zinc-500 text-xs mt-1">Healthy moisture range</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Soil Moisture Chart -->
            <div class="premium-card space-y-4">
                <h3 class="text-white font-semibold text-lg">Soil Moisture Readings (Daily Avg)</h3>
                <div class="chart-bar">
                    <div class="bar" style="height: 60%" title="Monday: 60%"></div>
                    <div class="bar" style="height: 75%" title="Tuesday: 75%"></div>
                    <div class="bar" style="height: 45%" title="Wednesday: 45%"></div>
                    <div class="bar" style="height: 80%" title="Thursday: 80%"></div>
                    <div class="bar" style="height: 90%" title="Friday: 90%"></div>
                    <div class="bar" style="height: 70%" title="Saturday: 70%"></div>
                    <div class="bar" style="height: 55%" title="Sunday: 55%"></div>
                </div>
                <div class="flex justify-between text-zinc-400 text-xs px-2">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>

            <!-- Crop Diversity Chart -->
            <div class="premium-card space-y-4">
                <h3 class="text-white font-semibold text-lg">Sensor Status Distribution</h3>
                <div class="chart-bar">
                    <div class="bar bar-emerald" style="height: 85%" title="Active: 85%"></div>
                    <div class="bar bar-amber" style="style" style="height: 10%" title="Maintenance: 10%"></div>
                    <div class="bar" style="background-color: #ef4444; height: 5%" title="Inactive: 5%"></div>
                </div>
                <div class="flex justify-around text-zinc-400 text-xs">
                    <span>Active</span><span>Maintenance</span><span>Inactive</span>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
