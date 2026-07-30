<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportTicketResource\Pages;
use App\Models\SupportTicket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Home';
    protected static ?string $navigationLabel = 'Tickets';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('subject')->required()->maxLength(255),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable(),
            Forms\Components\Select::make('category')->options([
                'Follow-Up' => 'Follow-Up', 'Outstanding' => 'Outstanding',
                'Reminder' => 'Reminder', 'Escalation' => 'Escalation', 'General' => 'General',
            ])->default('General')->required(),
            Forms\Components\Select::make('priority')->options([
                'Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High', 'Critical' => 'Critical',
            ])->default('Medium')->required(),
            Forms\Components\Select::make('status')->options([
                'Open' => 'Open', 'InProgress' => 'In Progress', 'Resolved' => 'Resolved', 'Closed' => 'Closed',
            ])->default('Open')->required(),
            Forms\Components\RichEditor::make('description')->required()->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->label('FU-ID')->sortable(),
            Tables\Columns\TextColumn::make('subject')->searchable()->sortable()->weight('bold')->limit(40),
            Tables\Columns\TextColumn::make('customer.name')->searchable()->label('Related'),
            Tables\Columns\TextColumn::make('category')->badge()->color('gray'),
            Tables\Columns\TextColumn::make('priority')->badge()->color('gray'),
            Tables\Columns\TextColumn::make('status')->badge()->color('gray')->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable()->label('Age'),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
            Tables\Filters\SelectFilter::make('priority'),
        ])->actions([
            Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make(),
        ])->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
