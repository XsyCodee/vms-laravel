<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class SettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 40;
    protected static ?string $navigationLabel = 'Settings';
    protected static ?string $title = 'Settings';
    protected static string $view = 'filament.pages.settings';

    protected function getViewData(): array
    {
        return [
            'totalUsers' => DB::table('users')->count(),
            'totalCustomers' => DB::table('customers')->count(),
            'totalRacks' => DB::table('racks')->count(),
            'totalEquipments' => DB::table('rack_equipments')->count(),
        ];
    }
}
