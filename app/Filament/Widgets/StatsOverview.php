<?php
namespace App\Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $p = DB::table('visit_permits')->selectRaw("COUNT(*) as t, SUM(CASE WHEN status IN ('CheckIn','Approved') THEN 1 ELSE 0 END) as a, SUM(CASE WHEN status='Pending' THEN 1 ELSE 0 END) as pg")->first();
        $r = DB::table('racks')->selectRaw("COUNT(*) as t, SUM(CASE WHEN customer_id IS NOT NULL THEN 1 ELSE 0 END) as o")->first();
        $ic = DB::table('interconnection_records')->where('is_active', 1)->count();
        $tickets = DB::table('support_tickets')->whereIn('status', ['Open', 'InProgress'])->count();
        return [
            Stat::make('Active Permits', $p->a ?? 0)->description("{$p->pg} pending")->color('warning')->icon('heroicon-o-users'),
            Stat::make('Racks', ($r->o ?? 0) . '/' . ($r->t ?? 0))->description('Occupied/Total')->color('success')->icon('heroicon-o-server-stack'),
            Stat::make('Interconnections', $ic)->description('Active')->color('primary')->icon('heroicon-o-arrows-right-left'),
            Stat::make('Open Tickets', $tickets)->description('Follow-ups')->color('info')->icon('heroicon-o-ticket'),
        ];
    }
    protected function getColumns(): int { return 4; }
}
