<?php

namespace App\Filament\Superadmin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\School;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Resources\Components\Tab;
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
    protected static ?string $modelLabel = 'Schools';

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
                    \Filament\Forms\Components\Section::make('Name')
                        ->schema([
                            TextInput::make('name')
                                ->debounce(2000)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->dehydrated()
                                ->readonly()
                                ->unique(School::class, 'slug', fn ($record) => $record),
                        ]),
                ]),
                \Filament\Forms\Components\Group::make([
                    \Filament\Forms\Components\Section::make('Contant Details')
                        ->schema([

                            TextInput::make('phone')
                                ->unique(),

                            TextInput::make('email')
                                ->unique()
                                ->required(),

                            TextInput::make('domain')
                                ->nullable()
                                ->unique(),
                        ]),
                    \Filament\Forms\Components\Section::make('Logo')
                        ->schema([
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
                ])->columns(2)

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
                    ->label("TELEPHONE"),
                Tables\Columns\TextColumn::make('email')
                    ->label("EMAIL"),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("DATE")
                    ->date(),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'active' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "active")),
            'inactive' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "inactive")),
            'expired' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "expired")),
            'disabled' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "disabled")),
        ];
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
