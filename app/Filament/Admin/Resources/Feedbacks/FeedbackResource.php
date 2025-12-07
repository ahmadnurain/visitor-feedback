<?php

namespace App\Filament\Admin\Resources\Feedbacks;

use App\Models\Feedback;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select as FormSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Filament\Admin\Resources\Feedbacks\Pages\ListFeedbacks;
use App\Filament\Admin\Resources\Feedbacks\Pages\EditFeedback;
use App\Filament\Admin\Resources\Feedbacks\Pages\ViewFeedback;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Feedback';
    protected static ?string $pluralModelLabel = 'Feedbacks';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Grid::make(2)->schema([
                TextInput::make('title')->disabled()->columnSpanFull(),
                Textarea::make('content')->rows(6)->disabled()->columnSpanFull(),

                TextInput::make('visitor_name')->disabled()->label('Visitor Name'),
                TextInput::make('channel')->disabled()->label('Channel'),

                FormSelect::make('feedback_category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->searchable()
                    ->preload(),

                TextInput::make('rating')->numeric()->minValue(1)->maxValue(5)->disabled(),

                FormSelect::make('status')->options([
                    'new' => 'Baru',
                    'processing' => 'Sedang Ditindaklanjuti',
                    'resolved' => 'Selesai',
                    'ignored' => 'Diabaikan',
                ])->required()->native(false),

                Textarea::make('action_taken')
                    ->label('Tindak Lanjut / Catatan')
                    ->columnSpanFull(),

                FormSelect::make('processed_by')
                    ->relationship('processor', 'name')
                    ->label('Processed By')
                    ->disabled(),
            ])->columnSpanFull(),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Infolists\Components\TextEntry::make('destination.name')->label('Destination'),
            \Filament\Infolists\Components\TextEntry::make('category.name')->label('Category')->badge(),
            \Filament\Infolists\Components\TextEntry::make('rating')->label('Rating'),
            \Filament\Infolists\Components\TextEntry::make('visitor_name')->label('Visitor'),
            \Filament\Infolists\Components\TextEntry::make('title')->label('Title')->columnSpanFull(),
            \Filament\Infolists\Components\TextEntry::make('content')->label('Content')->columnSpanFull(),
            \Filament\Infolists\Components\TextEntry::make('status')->badge(),
            \Filament\Infolists\Components\TextEntry::make('action_taken')->label('Action Taken')->columnSpanFull(),
            \Filament\Infolists\Components\TextEntry::make('submitted_at')->dateTime()->since(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('destination.name')->label('Destination')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Category')->badge()->color('info'),
                TextColumn::make('rating')->label('Rating')->sortable(),
                TextColumn::make('title')->limit(40)->searchable(),
                TextColumn::make('status')->badge()->color(fn($state) => match ($state) {
                    'new' => 'gray',
                    'processing' => 'warning',
                    'resolved' => 'success',
                    'ignored' => 'danger',
                    default => 'gray',
                })->sortable(),
                TextColumn::make('visitor_name')->label('Visitor')->searchable(),
                TextColumn::make('submitted_at')->label('Submitted')->dateTime()->since()->sortable(),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options([
                    'new' => 'Baru',
                    'processing' => 'Sedang Ditindaklanjuti',
                    'resolved' => 'Selesai',
                    'ignored' => 'Diabaikan',
                ]),
                SelectFilter::make('destination_id')->label('Destination')->relationship('destination', 'name'),
                SelectFilter::make('feedback_category_id')->label('Category')->relationship('category', 'name'),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make()->label('View')->modalWidth('3xl'),
                \Filament\Actions\EditAction::make()->label('Status'),

                \Filament\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                    ->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make()
                            ->withFilename('Feedback-' . date('Y-m-d'))
                            ->withColumns([
                                \pxlrbt\FilamentExcel\Columns\Column::make('submitted_at')
                                    ->heading('Tanggal')
                                    ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->format('d/m/Y H:i') : ''),
                                \pxlrbt\FilamentExcel\Columns\Column::make('visitor_name')
                                    ->heading('Nama Pengunjung'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('destination.name')
                                    ->heading('Destinasi'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('category.name')
                                    ->heading('Kategori'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('rating')
                                    ->heading('Rating'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('title')
                                    ->heading('Judul'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('content')
                                    ->heading('Isi Masukan'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('status')
                                    ->heading('Status')
                                    ->formatStateUsing(fn($state) => match ($state) {
                                        'new' => 'Baru',
                                        'processing' => 'Sedang Ditindaklanjuti',
                                        'resolved' => 'Selesai',
                                        'ignored' => 'Diabaikan',
                                        default => $state,
                                    }),
                                \pxlrbt\FilamentExcel\Columns\Column::make('action_taken')
                                    ->heading('Tindak Lanjut'),
                                \pxlrbt\FilamentExcel\Columns\Column::make('processor.name')
                                    ->heading('Diproses Oleh'),
                            ])
                    ])
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFeedbacks::route('/'),
            'view'  => ViewFeedback::route('/{record}'),
            'edit'  => EditFeedback::route('/{record}/edit'),
        ];
    }
}
