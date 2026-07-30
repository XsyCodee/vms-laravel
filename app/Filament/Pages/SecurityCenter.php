<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class SecurityCenter extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Security';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Security Centers';
    protected static string $view = 'filament.pages.placeholder';
    protected static ?string $title = 'Security Centers';
}
