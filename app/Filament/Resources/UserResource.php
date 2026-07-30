<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Users';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('password')->password()
                ->required(),
            Forms\Components\Select::make('role_id')->relationship('role', 'name')->required(),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable()->label('Assign to Tenant'),
            Forms\Components\Select::make('datacenter_id')->relationship('datacenter', 'name')->label('Datacenter'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
            Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('role.name')->badge()->sortable(),
            Tables\Columns\TextColumn::make('customer.name')->label('Tenant')->searchable()->placeholder('Internal'),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('role')->relationship('role', 'name'),
            Tables\Filters\SelectFilter::make('customer')->relationship('customer', 'name'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
