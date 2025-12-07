<?php

namespace App\Filament\Admin\Resources\Destinations;


use App\Models\Destination;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

use Filament\Tables\Filters\SelectFilter;


use Filament\Tables\Table;                              // Tabel



use Filament\Forms\Components\Select;                  // Komponen form
use Filament\Schemas\Components\Grid;                  // ✅ Grid untuk Schema (v4)

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;

    // Kalau enum bikin linting rewel, boleh ganti ke string: 'heroicon-o-map-pin'
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Destination';
    protected static ?string $pluralModelLabel = 'Destinations';
    protected static ?string $recordTitleAttribute = 'name';

    /**
     * FORM — Schema v4
     */
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(150)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state ?? ''))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(170)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),

                TextInput::make('address')
                    ->label('Address')
                    ->columnSpanFull(),

                Grid::make(3)->schema([
                    TextInput::make('latitude')
                        ->label('Latitude')
                        ->numeric()
                        ->step('any')
                        ->rules(['nullable', 'numeric'])
                        ->helperText('Range: -90 s.d. 90'),

                    TextInput::make('longitude')
                        ->label('Longitude')
                        ->numeric()
                        ->rules(['nullable', 'numeric'])
                        ->helperText('Range: -180 s.d. 180'),
                ])->columnSpanFull(),

                FileUpload::make('banner_path')
                    ->label('Banner')
                    ->disk('public')
                    ->directory('destinations')
                    ->image()
                    ->imagePreviewHeight('200')
                    ->openable()
                    ->columnSpanFull(),
            ])->columnSpanFull(),
        ]);
    }

    /**
     * INFO LIST — dipakai ViewAction (modal)
     */
    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make()
                ->columns(2)
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('name')->label('Name'),
                    \Filament\Infolists\Components\TextEntry::make('category.name')->label('Category'),


                    \Filament\Infolists\Components\ImageEntry::make('banner_path')
                        ->label('Banner')
                        ->disk('public')          // sesuaikan jika kamu pakai disk lain
                        ->height(200)
                        ->columnSpanFull(),

                    \Filament\Infolists\Components\TextEntry::make('address')->label('Address')->columnSpanFull(),
                    \Filament\Infolists\Components\TextEntry::make('latitude')->label('Latitude'),
                    \Filament\Infolists\Components\TextEntry::make('longitude')->label('Longitude'),



                    \Filament\Infolists\Components\TextEntry::make('created_at')->label('Created')->dateTime()->since(),
                    \Filament\Infolists\Components\TextEntry::make('updated_at')->label('Updated')->dateTime()->since(),
                ])->columnSpanFull(),
        ]);
    }

    /**
     * TABLE — dengan ViewAction (modal)
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('category.name')->label('Category')->badge()->color('success'),

                TextColumn::make('created_at')->dateTime()->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()
                    ->label('View')
                    ->modalHeading(fn($record) => 'Detail: ' . $record->name)
                    ->modalWidth('3xl'),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),

            'view'   => Pages\ViewDestination::route('/{record}'),
            'edit'   => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
