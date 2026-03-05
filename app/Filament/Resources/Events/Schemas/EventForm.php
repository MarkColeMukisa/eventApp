<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Event Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                if (blank($state)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),
                        TextInput::make('location')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Section::make('Publication')
                    ->schema([
                        DateTimePicker::make('starts_at')
                            ->required()
                            ->seconds(false),
                        DateTimePicker::make('ends_at')
                            ->seconds(false),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(false)
                            ->required(),
                        FileUpload::make('cover_image')
                            ->image()
                            ->disk('public')
                            ->directory('events/covers')
                            ->visibility('public'),
                    ])
                    ->columns(2),
            ]);
    }
}
