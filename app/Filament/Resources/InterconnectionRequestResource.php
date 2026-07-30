<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterconnectionRequestResource\Pages;
use App\Models\InterconnectionRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InterconnectionRequestResource extends Resource
{
    protected static ?string $model = InterconnectionRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'Interkoneksi';
    protected static ?string $navigationLabel = 'Request Interkoneksi';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('ticket_number')->required()->unique(ignoreRecord: true),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable(),
            Forms\Components\Select::make('service_type')->options(['LAYANAN' => 'Layanan','SEWA_CORE_APJII' => 'Sewa Core APJII','SEWA_CORE_MMR' => 'Sewa Core MMR'])->required(),
            Forms\Components\Select::make('interconnect_type')->options(['CROSS_CONNECT' => 'Cross Connect','INTERNAL_BUILDING' => 'Internal Building','ANTAR_RACK' => 'Antar Rack'])->required(),
            Forms\Components\Section::make('Source (Side A)')->schema([
                Forms\Components\TextInput::make('source_device')->required(),
                Forms\Components\TextInput::make('source_port')->required(),
                Forms\Components\TextInput::make('source_rack'),
                Forms\Components\TextInput::make('source_tenant'),
            ])->columns(2),
            Forms\Components\Section::make('Destination (Side Z)')->schema([
                Forms\Components\TextInput::make('dest_device')->required(),
                Forms\Components\TextInput::make('dest_port')->required(),
                Forms\Components\TextInput::make('dest_rack'),
                Forms\Components\TextInput::make('dest_tenant'),
            ])->columns(2),
            Forms\Components\Select::make('status')->options([
                'PENDING' => 'Pending', 'WAITING_DEST_APPROVAL' => 'Waiting Dest Approval',
                'AWAITING_PAYMENT' => 'Awaiting Payment', 'NOC_DC_PROCESSING' => 'NOC DC Processing',
                'COMPLETED' => 'Completed', 'REJECTED' => 'Rejected',
            ])->default('PENDING')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('ticket_number')->searchable()->sortable()->weight('bold'),
            Tables\Columns\TextColumn::make('customer.name')->searchable()->label('Client'),
            Tables\Columns\TextColumn::make('service_type')->badge(),
            Tables\Columns\TextColumn::make('source_device')->label('Source')->limit(20),
            Tables\Columns\TextColumn::make('dest_device')->label('Dest')->limit(20),
Tables\Columns\TextColumn::make('status')->badge()->color('gray')->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
            Tables\Filters\SelectFilter::make('service_type'),
        ])->actions([
            Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make(),
        ])->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIcRequests::route('/'),
            'create' => Pages\CreateIcRequest::route('/create'),
            'edit' => Pages\EditIcRequest::route('/{record}/edit'),
        ];
    }
}
