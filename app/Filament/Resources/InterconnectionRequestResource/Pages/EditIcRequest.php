<?php
namespace App\Filament\Resources\InterconnectionRequestResource\Pages;
use App\Filament\Resources\InterconnectionRequestResource;
use Filament\Actions; use Filament\Resources\Pages\EditRecord;
class EditIcRequest extends EditRecord { protected static string $resource = InterconnectionRequestResource::class; protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; } }
