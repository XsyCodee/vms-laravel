<?php
namespace App\Filament\Resources\InterconnectionRequestResource\Pages;
use App\Filament\Resources\InterconnectionRequestResource;
use Filament\Actions; use Filament\Resources\Pages\ListRecords;
class ListIcRequests extends ListRecords { protected static string $resource = InterconnectionRequestResource::class; protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; } }
