<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class DataFst extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manage Device';
    protected static ?int $navigationSort = 25;
    protected static ?string $navigationLabel = 'Data FST';
    protected static ?string $title = 'Data FST (Form Serah Terima)';
    protected static string $view = 'filament.pages.fst';

    protected function getViewData(): array
    {
        return ['records' => DB::table('legacy_equipment_records')->orderByDesc('created_at')->limit(50)->get()];
    }
}
