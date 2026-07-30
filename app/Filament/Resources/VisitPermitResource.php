<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitPermitResource\Pages;
use App\Models\VisitPermit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VisitPermitResource extends Resource
{
    protected static ?string $model = VisitPermit::class;
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Security';
    protected static ?string $navigationLabel = 'Visitor Permits';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('datacenter_id')->relationship('datacenter', 'name')->required(),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable(),
            Forms\Components\TextInput::make('company_name')->maxLength(255),
            Forms\Components\TextInput::make('visitor_names')->required()->label('Visitor Names'),
            Forms\Components\Textarea::make('activity')->required(),
            Forms\Components\DateTimePicker::make('scheduled_at')->required(),
            Forms\Components\Select::make('status')->options([
                'Pending' => 'Pending', 'Approved' => 'Approved', 'NDASigned' => 'NDA Signed',
                'CheckIn' => 'Checked In', 'Done' => 'Done', 'Closed' => 'Closed', 'Rejected' => 'Rejected',
            ])->default('Pending')->required(),
            Forms\Components\Textarea::make('zone_access')->label('Rack Access Zone'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->label('PRM-ID')->sortable(),
            Tables\Columns\TextColumn::make('customer.name')->searchable()->label('Client'),
            Tables\Columns\TextColumn::make('visitor_names')->searchable()->limit(30)->label('Visitors'),
            Tables\Columns\TextColumn::make('scheduled_at')->dateTime('d M Y H:i')->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->color('gray')->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
        ])->actions([
            Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make(),
        ])->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array { return []; }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisitPermits::route('/'),
            'create' => Pages\CreateVisitPermit::route('/create'),
            'edit' => Pages\EditVisitPermit::route('/{record}/edit'),
        ];
    }
}
