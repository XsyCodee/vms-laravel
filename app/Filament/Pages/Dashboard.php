<?php
namespace App\Filament\Pages;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as Base;
class Dashboard extends Base
{
    protected static ?string $title = 'Regional Overview';
    public function getColumns(): int|string|array { return 12; }
    public function getWidgets(): array { return [StatsOverview::class]; }
}
