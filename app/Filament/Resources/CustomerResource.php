<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->unique(ignoreRecord: true)->maxLength(255),
            Forms\Components\TextInput::make('code')->unique(ignoreRecord: true)->maxLength(50)->label('Client Code'),
            Forms\Components\TextInput::make('contact_email')->email()->maxLength(255),
            Forms\Components\TextInput::make('contact_phone')->tel()->maxLength(50),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
            Tables\Columns\TextColumn::make('code')->searchable()->label('Code'),
            Tables\Columns\TextColumn::make('contact_email')->label('Email'),
            Tables\Columns\TextColumn::make('contact_phone')->label('Phone'),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
        ])
        ->filters([])
        ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
