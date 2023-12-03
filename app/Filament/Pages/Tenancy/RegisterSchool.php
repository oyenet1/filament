<?php



namespace App\Filament\Pages\Tenancy;

use App\Models\School;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterSchool extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Add new School';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Wizard::make([
                    \Filament\Forms\Components\Wizard\Step::make('Name')
                        ->schema([
                            TextInput::make('name')
                                ->debounce(2000)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->dehydrated()
                                ->readonly()
                                ->unique(School::class, 'slug', fn ($record) => $record),
                        ]),
                    \Filament\Forms\Components\Wizard\Step::make('Contants')
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
                    \Filament\Forms\Components\Wizard\Step::make('Logo')
                        ->schema([
                            FileUpload::make('avatar_url')
                                ->directory('school/logos')
                                ->nullable()
                                ->image()
                                ->imageEditor()
                                ->maxSize(2014),
                        ])
                ])->columnSpanFull()

            ]);
    }

    protected function handleRegistration(array $data): School
    {
        $school = School::create($data);

        $school->members()->attach(auth()->user());

        return $school;
    }
}
