<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegacyEquipmentResource\Pages;
use App\Models\LegacyEquipmentRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LegacyEquipmentResource extends Resource
{
    protected static ?string $model = LegacyEquipmentRecord::class;
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationGroup = 'Manage Device';
    protected static ?string $navigationLabel = 'Data Perangkat';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('rack_id')->relationship('rack', 'name')->searchable(),
            Forms\Components\TextInput::make('rack_name')->maxLength(255),
            Forms\Components\TextInput::make('item_name')->required()->maxLength(255),
            Forms\Components\TextInput::make('qty')->numeric(),
            Forms\Components\TextInput::make('weight')->maxLength(100),
            Forms\Components\TextInput::make('dimension')->maxLength(100),
            Forms\Components\TextInput::make('serial_number')->maxLength(255),
            Forms\Components\Textarea::make('notes'),
            Forms\Components\DateTimePicker::make('arrival_date'),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('item_name')->searchable()->sortable()->weight('bold'),
            Tables\Columns\TextColumn::make('rack.name')->label('Rack')->searchable(),
            Tables\Columns\TextColumn::make('rack_name')->label('Rack Name')->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('serial_number')->searchable()->label('SN'),
            Tables\Columns\TextColumn::make('dimension')->label('Size'),
            Tables\Columns\TextColumn::make('qty')->label('Qty'),
            Tables\Columns\TextColumn::make('is_active')->label('Active')->badge()->color('gray'),
            Tables\Columns\TextColumn::make('arrival_date')->dateTime('d M Y')->sortable(),
        ])->filters([])->actions([
            Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make(),
        ])->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLegacyEquipment::route('/'),
            'create' => Pages\CreateLegacyEquipment::route('/create'),
            'edit' => Pages\EditLegacyEquipment::route('/{record}/edit'),
        ];
    }
}
