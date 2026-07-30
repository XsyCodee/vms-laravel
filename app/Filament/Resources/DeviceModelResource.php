<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceModelResource\Pages;
use App\Models\DeviceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeviceModelResource extends Resource
{
    protected static ?string $model = DeviceModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'Manage Device';
    protected static ?string $navigationLabel = 'Master Devices';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('brand')->required()->maxLength(255),
            Forms\Components\TextInput::make('model_name')->required()->unique(ignoreRecord: true)->maxLength(255),
            Forms\Components\Select::make('equipment_type')->options([
                'Server' => 'Server', 'Switch/Router' => 'Switch/Router', 'Storage' => 'Storage',
                'Firewall' => 'Firewall', 'Patch Panel' => 'Patch Panel', 'UPS' => 'UPS', 'Other' => 'Other',
            ])->required(),
            Forms\Components\TextInput::make('u_size')->numeric()->default(1)->required(),
            Forms\Components\TextInput::make('port_count')->numeric()->default(0),
            Forms\Components\Toggle::make('requires_serial_number')->default(true),
            Forms\Components\TextInput::make('power_draw_w')->numeric()->label('Power Draw (W)'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('brand')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('model_name')->searchable()->sortable()->weight('bold'),
            Tables\Columns\TextColumn::make('equipment_type')->badge()->sortable(),
            Tables\Columns\TextColumn::make('u_size')->label('U')->sortable(),
            Tables\Columns\TextColumn::make('port_count')->label('Ports')->sortable(),
            Tables\Columns\TextColumn::make('equipments_count')->counts('equipments')->label('Usage'),
        ])->filters([
            Tables\Filters\SelectFilter::make('equipment_type'),
            Tables\Filters\SelectFilter::make('brand'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeviceModels::route('/'),
            'create' => Pages\CreateDeviceModel::route('/create'),
            'edit' => Pages\EditDeviceModel::route('/{record}/edit'),
        ];
    }
}
