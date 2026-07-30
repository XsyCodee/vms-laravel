<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class DataInterkoneksi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationGroup = 'Interkoneksi';
    protected static ?int $navigationSort = 10;
    protected static ?string $navigationLabel = 'Data Interkoneksi';
    protected static ?string $title = 'Data Interkoneksi';
    protected static string $view = 'filament.pages.interkoneksi';

    protected function getViewData(): array
    {
        $records = DB::table('interconnection_records')->orderByDesc('created_at')->limit(50)->get();
        return ['records' => $records];
    }
}
