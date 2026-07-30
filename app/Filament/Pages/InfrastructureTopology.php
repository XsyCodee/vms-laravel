<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class InfrastructureTopology extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Infrastructure';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Infrastructure Topology';
    protected static ?string $title = 'Infrastructure Topology';
    protected static string $view = 'filament.pages.topology';

    protected function getViewData(): array
    {
        return [
            'datacenters' => DB::table('datacenters')->with('region')->get(),
            'floors' => DB::table('floors')->with('datacenter')->get(),
            'halls' => DB::table('data_rooms')->with('floor.datacenter')->get(),
            'rows' => DB::table('rows')->with('dataHall.floor.datacenter')->get(),
        ];
    }
}
