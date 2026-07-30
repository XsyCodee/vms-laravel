<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class ColocationView extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-view-columns';
    protected static ?string $navigationGroup = 'Infrastructure';
    protected static ?int $navigationSort = 40;
    protected static ?string $navigationLabel = 'Colocation View';
    protected static string $view = 'filament.pages.placeholder';
    protected static ?string $title = 'Colocation View';
}
