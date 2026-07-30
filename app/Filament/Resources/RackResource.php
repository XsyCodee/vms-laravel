<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RackResource\Pages;
use App\Models\Rack;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RackResource extends Resource
{
    protected static ?string $model = Rack::class;
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';
    protected static ?string $navigationGroup = 'Infrastructure';
    protected static ?string $navigationLabel = 'Data Rack';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('row_id')->relationship('row', 'name')
                ->searchable()->preload()->required()->label('Containment'),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable()->preload()->label('Assigned Client'),
            Forms\Components\TextInput::make('name')->required()->maxLength(255)->label('Rack Name'),
            Forms\Components\TextInput::make('u_capacity')->numeric()->default(42)->required()->label('U Capacity'),
            Forms\Components\Select::make('type')->options(['OPEN' => 'Open Rack', 'CLOSED' => 'Closed Rack', 'MMR' => 'MMR'])->default('OPEN')->required(),
            Forms\Components\Select::make('status')->options(['AVAILABLE' => 'Available', 'OCCUPIED' => 'Occupied', 'MAINTENANCE' => 'Maintenance', 'RESERVED' => 'Reserved'])->default('AVAILABLE')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
            Tables\Columns\TextColumn::make('row.name')->label('Containment')->searchable(),
            Tables\Columns\TextColumn::make('row.dataHall.name')->label('Data Hall'),
            Tables\Columns\TextColumn::make('row.dataHall.floor.datacenter.name')->label('Datacenter'),
            Tables\Columns\TextColumn::make('customer.name')->label('Client')->searchable()->placeholder('Unassigned'),
            Tables\Columns\TextColumn::make('type')->badge()->color('gray'),
            Tables\Columns\TextColumn::make('status')->badge()->color('gray'),
            Tables\Columns\TextColumn::make('u_capacity')->label('U')->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('type'),
            Tables\Filters\SelectFilter::make('status'),
            Tables\Filters\SelectFilter::make('customer')->relationship('customer', 'name'),
        ])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRacks::route('/'),
            'create' => Pages\CreateRack::route('/create'),
            'edit' => Pages\EditRack::route('/{record}/edit'),
        ];
    }
}
