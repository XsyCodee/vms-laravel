<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class SystemLogs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 50;
    protected static ?string $navigationLabel = 'System Logs';
    protected static ?string $title = 'System Logs';
    protected static string $view = 'filament.pages.system-logs';

    protected function getViewData(): array
    {
        $tab = request('tab', 'admin');
        $logs = match($tab) {
            'login' => DB::table('system_audit_logs')->where('action', 'like', '%LOGIN%')->orWhere('action', 'like', '%auth%')->orWhere('action', 'like', '%challenge%')->orderByDesc('created_at')->limit(100)->get(),
            'wablas' => DB::table('system_audit_logs')->where('action', 'like', '%WABLAS%')->orWhere('action', 'like', '%wa-notify%')->orWhere('action', 'like', '%whatsapp%')->orderByDesc('created_at')->limit(100)->get(),
            default => DB::table('system_audit_logs')->orderByDesc('created_at')->limit(100)->get(),
        };
        $tabCounts = [
            'admin' => DB::table('system_audit_logs')->count(),
            'login' => DB::table('system_audit_logs')->where('action', 'like', '%LOGIN%')->orWhere('action', 'like', '%auth%')->count(),
            'wablas' => DB::table('system_audit_logs')->where('action', 'like', '%WABLAS%')->orWhere('action', 'like', '%whatsapp%')->count(),
        ];
        return compact('logs', 'tab', 'tabCounts');
    }
}
