<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;

class ClientAccounts extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Client Management';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Client Accounts';
    protected static ?string $title = 'Client Accounts';
    protected static string $view = 'filament.pages.client-accounts';
}
