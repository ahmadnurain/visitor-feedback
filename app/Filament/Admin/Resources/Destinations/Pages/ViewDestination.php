<?php

namespace App\Filament\Admin\Resources\Destinations\Pages;

use App\Filament\Admin\Resources\Destinations\DestinationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDestination extends ViewRecord
{
    protected static string $resource = DestinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
