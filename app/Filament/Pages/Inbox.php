<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class Inbox extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationGroup = 'Home';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationLabel = 'Inbox';
    protected static ?string $title = 'Team Inbox';
    protected static string $view = 'filament.pages.inbox';

    protected function getViewData(): array
    {
        $emails = DB::table('inbox_messages')->orderByDesc('received_at')->limit(20)->get();
        return ['emails' => $emails, 'selected' => request('id') ? DB::table('inbox_messages')->find(request('id')) : null];
    }
}
