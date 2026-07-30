<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class SecurityCenter extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Security';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Security Centers';
    protected static ?string $title = 'Security Centers';
    protected static string $view = 'filament.pages.security';

    protected function getViewData(): array
    {
        return [
            'activeVisitors' => DB::table('visit_permits')->whereIn('status', ['CheckIn', 'Approved'])->count(),
            'todayPermits' => DB::table('visit_permits')->whereDate('created_at', now())->count(),
            'recentLogs' => DB::table('system_audit_logs')->orderByDesc('created_at')->limit(15)->get(),
        ];
    }
}
