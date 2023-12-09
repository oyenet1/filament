<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\State;
use Nnjeim\World\Models\Country;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Tenancy\EditTenantProfile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditSchoolProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'School Profile Settings';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'School Updated Successfuuly';
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Group::make([
                    Forms\Components\Wizard::make([
                        Forms\Components\Wizard\Step::make('School Details')
                            ->schema([
                                Fieldset::make('School Bio')
                                    ->schema([
                                        TextInput::make('name')
                                            ->debounce()
                                            ->required()
                                            ->readonly(fn () => !auth()->user()->hasRole('super-admin')),

                                        TextInput::make('slug')
                                            ->dehydrated()
                                            ->hidden()
                                            ->readonly()
                                            ->unique(School::class, 'slug', fn ($record) => $record),
                                        TextInput::make('phone')
                                            ->required()
                                            ->unique(ignoreRecord: true),

                                        TextInput::make('email')
                                            ->unique(ignoreRecord: true)
                                            ->required()
                                            ->email(),

                                        TextInput::make('domain')
                                            ->nullable()
                                            ->unique(ignoreRecord: true),
                                    ])->columns(4),
                                Fieldset::make('School Code Prefix')
                                    ->relationship('setting')
                                    ->schema([
                                        TextInput::make('staff_prefix')
                                            ->nullable()
                                            ->readonly(),
                                        TextInput::make('parent_prefix')
                                            ->nullable()
                                            ->readonly(),
                                        TextInput::make('student_prefix')
                                            ->nullable()
                                            ->readonly(),

                                    ])->columns(4),

                            ])->columns(4),
                        Forms\Components\Wizard\Step::make('Address')->schema([
                            Select::make('country_id')
                                ->label('Country')
                                ->preload()
                                ->options(Country::all()->pluck('name', 'id'))
                                ->searchable()
                                ->placeholder('Nigeria')
                                ->nullable()
                                ->live()
                                ->native(false)
                                ->afterStateUpdated(function (Set $set) {
                                    $set('state_id', null);
                                    $set('city_id', null);
                                }),
                            Select::make('state_id')
                                ->label('State')
                                ->relationship(name: 'state', titleAttribute: 'name')
                                ->options(fn (Get $get): Collection
                                => State::query()
                                    ->where('country_id', $get('country_id'))
                                    ->pluck('name', 'id', 'country_id'))
                                ->searchable(['name'])
                                ->nullable()
                                ->preload()
                                ->native(false)
                                ->live()
                                ->afterStateUpdated(fn (Set $set) => $set('city_id', null)),
                            Select::make('city_id')
                                ->label('City/Town')
                                ->relationship(name: 'city', titleAttribute: 'name')
                                ->options(fn (Get $get): Collection
                                => City::query()
                                    ->where('country_id', $get('country_id'))
                                    ->where('state_id', $get('state_id'))
                                    ->pluck('name', 'id', 'state_id'))
                                ->searchable(['name'])
                                ->nullable()
                                ->helperText("if you can'\t find your town/city, select the nearest city. Also contact us via email,phone and chat")
                                ->preload()
                                ->live()
                                ->native(false),

                            TextInput::make('address')
                                ->nullable(),
                        ]),
                        Forms\Components\Wizard\Step::make('Logo')->schema([
                            FileUpload::make('logo')
                                ->label('LOGO')
                                ->nullable()
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('logo-'),
                                )
                                ->directory('/school/logos')
                                ->image()
                                ->imageEditor()
                                ->imageEditorAspectRatios([
                                    null,
                                    '1:1',
                                ])
                                ->maxSize(2014)
                                ->circleCropper()
                                ->imageResizeMode('cover'),
                        ])
                    ])->columns(4)
                ])->columnSpanFull(),

            ]);
    }
}
