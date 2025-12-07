<?php

namespace App\Filament\Admin\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    // Nonaktif bila dipakai oleh destinasi
                    ->disabled(fn(Category $record) => $record->destinations()->exists())
                    ->tooltip(fn(Category $record) => $record->destinations()->exists()
                        ? 'Tidak bisa dihapus: kategori ini sudah dipakai oleh ' . $record->destinations()->count() . ' destinasi.'
                        : null),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Bulk delete yang melewati record yang dipakai
                    DeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            /** @var \Illuminate\Support\Collection<int, Category> $blocked */
                            $blocked = $records->filter(fn(Category $c) => $c->destinations()->exists());
                            $allowed = $records->diff($blocked);

                            // Hanya hapus yang tidak dipakai
                            $allowed->each->delete();

                            if ($blocked->isNotEmpty()) {
                                Notification::make()
                                    ->title('Sebagian tidak dihapus')
                                    ->body($blocked->count() . ' kategori dilewati karena sedang dipakai oleh destinasi.')
                                    ->danger()
                                    ->send();
                            }
                        }),
                ]),
            ]);
    }
}
