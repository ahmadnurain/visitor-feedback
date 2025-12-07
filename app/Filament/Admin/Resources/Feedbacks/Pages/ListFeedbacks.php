<?php

namespace App\Filament\Admin\Resources\Feedbacks\Pages;

use App\Filament\Admin\Resources\Feedbacks\FeedbackResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;

class ListFeedbacks extends ListRecords
{
    protected static string $resource = FeedbackResource::class;
}
