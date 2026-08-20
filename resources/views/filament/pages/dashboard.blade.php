<x-filament-panels::page>
    <!-- Custom styling to ensure the page mimics the screenshot perfectly -->
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
        }
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        .lists-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 32px;
        }
        @media (max-width: 768px) {
            .lists-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }

        .custom-dashboard-card {
            background-color: #222222;
            border: 1px solid #2e2e2e;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.2s ease-in-out;
        }
        .custom-dashboard-card:hover {
            border-color: #444444;
            transform: translateY(-2px);
        }
        .list-panel {
            background-color: #222222;
            border: 1px solid #2e2e2e;
            border-radius: 16px;
            overflow: hidden;
        }
        .list-header {
            padding: 16px 20px;
            border-bottom: 1px solid #2e2e2e;
            font-size: 1.1rem;
            font-weight: 600;
            color: #ffffff;
        }
        .list-row {
            padding: 16px 20px;
            border-bottom: 1px solid #2e2e2e;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        .list-row:last-child {
            border-bottom: none;
        }
        .list-row:hover {
            background-color: #282828;
        }
        .review-button {
            border: 1px solid #444444;
            color: #d1d1d6;
            background-color: transparent;
            padding: 6px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .review-button:hover {
            background-color: #333333;
            border-color: #666666;
            color: #ffffff;
        }
        .stat-value-amber {
            color: #eab308;
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1;
            margin-top: 12px;
        }
        .stat-value-white {
            color: #ffffff;
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1;
            margin-top: 12px;
        }
    </style>

    <div class="space-y-8" style="margin-top: 12px;">
        <!-- 4 Stats Cards Grid -->
        <div class="stats-grid">
            <div class="custom-dashboard-card">
                <div class="text-zinc-400 text-sm font-medium">Pending farmers</div>
                <div class="stat-value-amber">{{ $pendingFarmersCount }}</div>
            </div>
            <div class="custom-dashboard-card">
                <div class="text-zinc-400 text-sm font-medium">Pending farms</div>
                <div class="stat-value-amber">{{ $pendingFarmsCount }}</div>
            </div>
            <div class="custom-dashboard-card">
                <div class="text-zinc-400 text-sm font-medium">Approved farmers</div>
                <div class="stat-value-white">{{ $approvedFarmersCount }}</div>
            </div>
            <div class="custom-dashboard-card">
                <div class="text-zinc-400 text-sm font-medium">Active farms</div>
                <div class="stat-value-white">{{ $activeFarmsCount }}</div>
            </div>
        </div>

        <!-- Lists Grid -->
        <div class="lists-grid">
            <!-- Recent Farmers Panel -->
            <div class="list-panel">
                <div class="list-header">
                    Recent farmers (pending)
                </div>
                <div class="divide-y divide-zinc-800">
                    @forelse($recentFarmers as $farmer)
                        <div class="list-row">
                            <div>
                                <div class="text-white font-semibold text-base">{{ $farmer->full_name }}</div>
                                <div class="text-zinc-400 text-sm mt-0.5">{{ $farmer->district }}, {{ $farmer->state }}</div>
                            </div>
                            <div>
                                <a href="{{ route('filament.admin.resources.farmers.edit', ['record' => $farmer->id]) }}" class="review-button inline-block">
                                    Review
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-zinc-500 text-sm">
                            No pending farmers.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Farms Panel -->
            <div class="list-panel">
                <div class="list-header">
                    Recent farms (pending)
                </div>
                <div class="divide-y divide-zinc-800">
                    @forelse($recentFarms as $farm)
                        <div class="list-row">
                            <div>
                                <div class="text-white font-semibold text-base">{{ $farm->name }}</div>
                                <div class="text-zinc-400 text-sm mt-0.5">
                                    {{ $farm->primary_crop }} · {{ $farm->total_acres }} acres
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.farms.edit', ['farm' => $farm->id]) }}" class="review-button inline-block">
                                    <x-heroicon-o-eye class="w-4 h-4 mr-1 inline"/> Review
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-zinc-500 text-sm">
                            No pending farms.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
