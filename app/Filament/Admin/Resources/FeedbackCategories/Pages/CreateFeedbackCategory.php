<?php

namespace App\Filament\Admin\Resources\FeedbackCategories\Pages;

use App\Filament\Admin\Resources\FeedbackCategories\FeedbackCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFeedbackCategory extends CreateRecord
{
    protected static string $resource = FeedbackCategoryResource::class;
}
