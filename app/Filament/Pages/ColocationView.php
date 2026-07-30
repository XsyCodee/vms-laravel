<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class ColocationView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationGroup = 'Infrastructure';
    protected static ?int $navigationSort = 40;
    protected static ?string $navigationLabel = 'Colocation View';
    protected static ?string $title = 'Colocation View';
    protected static string $view = 'filament.pages.colocation';

    protected function getViewData(): array
    {
        return ['racks' => DB::table('racks')->whereNotNull('customer_id')->with('customer')->with('row.dataHall.floor.datacenter')->get()];
    }
}
