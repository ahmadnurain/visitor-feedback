<?php

namespace App\Filament\Admin\Resources\FeedbackCategories\Pages;

use App\Filament\Admin\Resources\FeedbackCategories\FeedbackCategoryResource;
use Filament\Resources\Pages\EditRecord;

class EditFeedbackCategory extends EditRecord
{
    protected static string $resource = FeedbackCategoryResource::class;
}
