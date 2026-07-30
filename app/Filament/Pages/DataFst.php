<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class DataFst extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manage Device';
    protected static ?int $navigationSort = 25;
    protected static ?string $navigationLabel = 'Data FST';
    protected static string $view = 'filament.pages.placeholder';
    protected static ?string $title = 'Data FST (Form Serah Terima)';
}
