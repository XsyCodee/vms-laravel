<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class ClientDevices extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-server';
    protected static ?string $navigationGroup = 'Client Management';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Client Devices';
    protected static ?string $title = 'Client Devices';
    protected static string $view = 'filament.pages.client-devices';
}
