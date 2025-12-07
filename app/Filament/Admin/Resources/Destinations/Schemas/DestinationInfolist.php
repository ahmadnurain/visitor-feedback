<?php

namespace App\Filament\Admin\Resources\Destinations\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DestinationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.name')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('address'),
                TextEntry::make('latitude')
                    ->numeric(),
                TextEntry::make('longitude')
                    ->numeric(),

                TextEntry::make('banner_path'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
