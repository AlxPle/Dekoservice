<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Seiten';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')
                ->label('Titel')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->hint(fn(?string $state): string => mb_strlen($state ?? '') . ' / 255')
                ->afterStateUpdated(function (Set $set, ?string $state) {
                    $set('slug', \Illuminate\Support\Str::slug($state));
                }),
            TextInput::make('slug')
                ->label('Slug (URL)')
                ->required()
                ->maxLength(255)
                ->unique(Page::class, 'slug', ignoreRecord: true)
                ->disabled(fn(?Page $record) => $record !== null)
                ->dehydrated(),
            TextInput::make('icon')
                ->label('Icon (Emoji)')
                ->maxLength(10)
                ->live(onBlur: true)
                ->hint(fn(?string $state): string => mb_strlen($state ?? '') . ' / 10'),
            Textarea::make('excerpt')
                ->label('Kurzbeschreibung (Karte auf Startseite)')
                ->maxLength(300)
                ->rows(3)
                ->live(onBlur: true)
                ->hint(fn(?string $state): string => mb_strlen($state ?? '') . ' / 300'),
            Textarea::make('meta_title')
                ->label('Meta-Titel (SEO)')
                ->maxLength(60)
                ->rows(2)
                ->live(onBlur: true)
                ->hint(fn(?string $state): string => mb_strlen($state ?? '') . ' / 60')
                ->hintColor(fn(?string $state): string => mb_strlen($state ?? '') > 55 ? 'warning' : 'gray'),
            Textarea::make('meta_description')
                ->label('Meta-Beschreibung (SEO)')
                ->maxLength(160)
                ->rows(3)
                ->live(onBlur: true)
                ->hint(fn(?string $state): string => mb_strlen($state ?? '') . ' / 160')
                ->hintColor(fn(?string $state): string => mb_strlen($state ?? '') > 150 ? 'warning' : 'gray'),
            KeyValue::make('content')
                ->label('Inhalt')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Geändert')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'edit'  => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
