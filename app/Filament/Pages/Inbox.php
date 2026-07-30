<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class Inbox extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Home';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Inbox';
    protected static string $view = 'filament.pages.placeholder';
    protected static ?string $title = 'Inbox';
}
