<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class InfrastructureTopology extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Infrastructure';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Infrastructure Topology';
    protected static string $view = 'filament.pages.placeholder';
    protected static ?string $title = 'Infrastructure Topology';
}
