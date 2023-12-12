<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use Tables\Actions\SaveAction;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AcademicYearResource\Pages;
use App\Filament\Resources\AcademicYearResource\RelationManagers;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Academics';
    protected static ?string $navigationLabel = 'Academic Year';
    protected static ?string $modelLabel = 'Academic Year';

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $getGlobalSearchResultsLimit = 20;


    // show navigation based on permissions
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->can('create academic year');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('start')
                    ->required()
                    ->native(false),
                Forms\Components\DatePicker::make('end')
                    ->native(false),
                Forms\Components\Toggle::make('is_current')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('terms_count')
                    ->label('Terms')
                    ->counts('terms')
                    ->extraAttributes(['class' => 'text-center'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('start')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_current')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->successNotificationTitle('Acacdemic Year updated successfully'),
                    Tables\Actions\RestoreAction::make()
                        ->successNotificationTitle('Academic Year has been restored'),
                    Tables\Actions\DeleteAction::make()
                        ->successNotificationTitle('Academic archived and will be deleted after 30 days'),
                    Tables\Actions\ForceDeleteAction::make()
                        ->label('Erase Permanently')
                        ->successNotificationTitle('Academic Year permanently deleted')
                ])->button()
                    ->label('Actions')
                    ->size(ActionSize::Small)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->successNotificationTitle('Records archived and will be deleted after 30 days')
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label('Erase Permanently')
                        ->successNotificationTitle('Academic Year records permanently deleted')
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\RestoreBulkAction::make()
                        ->successNotificationTitle('Academic Year records has been restored')
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAcademicYears::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Academic Year' => $record->name,
            'Term(s)' => $record->terms->count(),
            'Current' => $record->is_current ? 'Yes' : 'No'
        ];
    }
}
