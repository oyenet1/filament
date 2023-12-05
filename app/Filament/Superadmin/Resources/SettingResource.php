<?php

namespace App\Filament\Superadmin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\School;
use App\Models\Setting;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\State;
use Filament\Resources\Resource;
use Nnjeim\World\Models\Country;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Resources\Components\Tab;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Superadmin\Resources\SettingResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Superadmin\Resources\SettingResource\RelationManagers;

class SettingResource extends Resource
{
    protected static ?string $model = School::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Configuration';
    protected static ?string $navigationLabel = 'School Settings';
    protected static ?string $modelLabel = 'School';

    protected static bool $isScopedToTenant = false; //tenancy not applied


    // show navigation based on permissions
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('create school settings');
    }


    public static function form(Form $form): Form
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
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

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
                                            ->nullable(),
                                        TextInput::make('parent_prefix')
                                            ->nullable(),
                                        TextInput::make('student_prefix')
                                            ->nullable(),

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
                            FileUpload::make('avatar_url')
                                ->label('LOGO')
                                ->nullable()
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('logo-'),
                                )
                                ->directory('school/logos')
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')->label('LOGO'),
                Tables\Columns\TextColumn::make('code')
                    ->label("CODE")->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label("NAME")->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label("TELEPHONE")->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label("EMAIL")->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('city.country.name')
                    ->label("Location")
                    ->searchable()
                    ->default(function (Set $set) {
                        return  $set('city.country.name');
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("COMMENCE ON")
                    ->date(),

                Tables\Columns\TextColumn::make('status')
                    ->label("STATUS"),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'expired' => 'Expired',
                        'disabled' => 'Disabled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    "Restored Back" => Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
