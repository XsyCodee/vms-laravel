<?php
namespace App\Filament\Resources\VisitPermitResource\Pages;
use App\Filament\Resources\VisitPermitResource;
use Filament\Actions; use Filament\Resources\Pages\ListRecords;
class ListVisitPermits extends ListRecords { protected static string $resource = VisitPermitResource::class; protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; } }
