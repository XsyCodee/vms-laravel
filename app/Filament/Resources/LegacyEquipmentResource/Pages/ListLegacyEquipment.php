<?php
namespace App\Filament\Resources\LegacyEquipmentResource\Pages;
use App\Filament\Resources\LegacyEquipmentResource;
use Filament\Actions; use Filament\Resources\Pages\ListRecords;
class ListLegacyEquipment extends ListRecords { protected static string $resource = LegacyEquipmentResource::class; protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; } }
