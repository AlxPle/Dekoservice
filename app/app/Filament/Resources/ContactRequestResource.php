<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactRequestResource\Pages;
use App\Models\ContactRequest;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ContactRequestResource extends Resource
{
    protected static ?string $model = ContactRequest::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Anfragen';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('first_name')
                ->label('Vorname')
                ->required()
                ->maxLength(255),
            TextInput::make('last_name')
                ->label('Nachname')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->label('E-Mail')
                ->email()
                ->required()
                ->maxLength(255),
            TextInput::make('phone')
                ->label('Telefon')
                ->tel()
                ->maxLength(50),
            Select::make('event_type')
                ->label('Veranstaltungsart')
                ->options([
                    'wedding'   => 'Hochzeit',
                    'birthday'  => 'Geburtstag',
                    'corporate' => 'Firmenevent',
                    'other'     => 'Sonstiges',
                ]),
            DatePicker::make('event_date')
                ->label('Veranstaltungsdatum'),
            Textarea::make('message')
                ->label('Nachricht')
                ->rows(5)
                ->columnSpanFull(),
            Toggle::make('is_processed')
                ->label('Bearbeitet'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-Mail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon'),
                Tables\Columns\BadgeColumn::make('event_type')
                    ->label('Art')
                    ->colors([
                        'success' => 'wedding',
                        'warning' => 'birthday',
                        'info'    => 'corporate',
                        'gray'    => 'other',
                    ]),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Datum')
                    ->date('d.m.Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_processed')
                    ->label('Bearbeitet')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Eingegangen')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_processed')
                    ->label('Bearbeitet'),
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
            'index'  => Pages\ListContactRequests::route('/'),
            'create' => Pages\CreateContactRequest::route('/create'),
            'edit'   => Pages\EditContactRequest::route('/{record}/edit'),
        ];
    }
}
