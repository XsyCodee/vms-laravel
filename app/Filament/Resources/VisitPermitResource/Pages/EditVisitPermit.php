<?php
namespace App\Filament\Resources\VisitPermitResource\Pages;
use App\Filament\Resources\VisitPermitResource;
use Filament\Actions; use Filament\Resources\Pages\EditRecord;
class EditVisitPermit extends EditRecord { protected static string $resource = VisitPermitResource::class; protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; } }
