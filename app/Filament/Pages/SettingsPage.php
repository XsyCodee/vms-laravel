<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class SettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 40;
    protected static ?string $navigationLabel = 'Settings';
    protected static string $view = 'filament.pages.placeholder';
    protected static ?string $title = 'Settings';
}
