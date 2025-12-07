<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\Feedbacks\FeedbackResource;
use App\Models\Feedback;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestFeedbacks extends BaseWidget
{
    // Samakan tipe dengan parent: int|string|array
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(FeedbackResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('submitted_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('destination.name')
                    ->label('Destination')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'new' => 'gray',
                        'processing' => 'warning',
                        'resolved' => 'success',
                        'ignored' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->since(),
            ])
            // Biar baris bisa diklik ke halaman edit/view tanpa pakai Actions
            ->recordUrl(
                fn(Feedback $record): string =>
                FeedbackResource::getUrl('edit', ['record' => $record])
            )
            // Matikan default record action (biar gak dobel)
            ->recordAction(null);
    }
}
