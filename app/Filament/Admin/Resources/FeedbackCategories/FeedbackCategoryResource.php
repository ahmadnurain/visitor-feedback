<?php

namespace App\Filament\Admin\Resources\FeedbackCategories;

use App\Filament\Admin\Resources\FeedbackCategories\Pages\CreateFeedbackCategory;
use App\Filament\Admin\Resources\FeedbackCategories\Pages\EditFeedbackCategory;
use App\Filament\Admin\Resources\FeedbackCategories\Pages\ListFeedbackCategories;
use App\Models\FeedbackCategory;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class FeedbackCategoryResource extends Resource
{
    protected static ?string $model = FeedbackCategory::class;

    // Ikuti tipe bawaan Filament
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static UnitEnum|string|null $navigationGroup = 'Data Kategori';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make()
                ->columns(1)
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, callable $set): void {
                            if ($operation === 'create' && filled($state)) {
                                $set('slug', Str::slug($state));
                            }
                        }),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),

                    Textarea::make('description')
                        ->columnSpanFull(),

                    Toggle::make('is_active')
                        ->required()
                        ->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFeedbackCategories::route('/'),
            'create' => CreateFeedbackCategory::route('/create'),
            'edit' => EditFeedbackCategory::route('/{record}/edit'),
        ];
    }
}
