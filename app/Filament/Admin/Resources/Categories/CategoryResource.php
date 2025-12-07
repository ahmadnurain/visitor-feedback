<?php

namespace App\Filament\Admin\Resources\Categories;

use BackedEnum;
use App\Models\Category;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use App\Filament\Admin\Resources\Categories\Pages\EditCategory;
use App\Filament\Admin\Resources\Categories\Pages\ViewCategory;
use App\Filament\Admin\Resources\Categories\Pages\CreateCategory;
use App\Filament\Admin\Resources\Categories\Pages\ListCategories;
use App\Filament\Admin\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Admin\Resources\Categories\Tables\CategoriesTable;
use App\Filament\Admin\Resources\Categories\Schemas\CategoryInfolist;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|\UnitEnum|null $navigationGroup = 'Data Kategori';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Category Destinasi';
    protected static ?string $pluralModelLabel = 'Category Destinasi';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make()
                ->columns(1)
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->placeholder('Mis. Alam & Outdoor')
                        ->required()
                        ->maxLength(100)
                        ->live(onBlur: true)
                        ->dehydrateStateUsing(fn($state) => trim((string) $state))     // opsional: trim spasi
                        ->unique(ignoreRecord: true)                                    // <- CEGAH DUPLIKAT
                        ->validationMessages([
                            'unique' => 'Nama kategori sudah digunakan.',
                        ])
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Auto isi slug dari name
                            $set('slug', \Illuminate\Support\Str::slug($state ?? ''));
                        }),

                    TextInput::make('slug')
                        ->label('Slug')
                        ->placeholder('alam-outdoor')
                        ->required()
                        ->maxLength(120)
                        ->unique(ignoreRecord: true)
                        ->rules(['alpha_dash']),

                ])->columnSpanFull(),
        ]);
    }
    public static function infolist(Schema $schema): Schema
    {
        return CategoryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
