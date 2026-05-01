<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Models\GalleryImage;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galerie';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('filename')
                ->label('Bild')
                ->image()
                ->directory('gallery')
                ->required(),
            TextInput::make('alt_text')
                ->label('Bildbeschreibung (Alt-Text)')
                ->maxLength(255),
            Select::make('category')
                ->label('Kategorie')
                ->options([
                    'wedding'   => 'Hochzeit',
                    'birthday'  => 'Geburtstag',
                    'corporate' => 'Firmenevent',
                    'other'     => 'Sonstiges',
                ])
                ->required(),
            TextInput::make('sort_order')
                ->label('Reihenfolge')
                ->numeric()
                ->default(0),
            Toggle::make('is_active')
                ->label('Aktiv')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('filename')
                    ->label('Bild')
                    ->disk('public')
                    ->directory('gallery'),
                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Beschreibung')
                    ->limit(40),
                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategorie')
                    ->colors([
                        'success' => 'wedding',
                        'warning' => 'birthday',
                        'info'    => 'corporate',
                        'gray'    => 'other',
                    ]),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Reihenfolge')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktiv')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'wedding'   => 'Hochzeit',
                        'birthday'  => 'Geburtstag',
                        'corporate' => 'Firmenevent',
                        'other'     => 'Sonstiges',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'),
            'edit'   => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }
}
