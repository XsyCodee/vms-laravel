<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class DataColoClient extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Infrastructure';
    protected static ?int $navigationSort = 30;
    protected static ?string $navigationLabel = 'Data Colo Client';
    protected static ?string $title = 'Data Colo Client';
    protected static string $view = 'filament.pages.colo-clients';
}
