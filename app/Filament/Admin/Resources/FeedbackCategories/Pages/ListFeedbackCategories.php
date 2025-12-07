<?php

namespace App\Filament\Admin\Resources\FeedbackCategories\Pages;

use App\Filament\Admin\Resources\FeedbackCategories\FeedbackCategoryResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListFeedbackCategories extends ListRecords
{
    protected static string $resource = FeedbackCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
