<?php



namespace App\Filament\Pages\Tenancy;

use App\Models\Institution;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;

class RegisterSchool extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register School';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique(),
                TextInput::make('slug')
                    ->unique(),
                TextInput::make('phone')
                    ->unique(),
                TextInput::make('logo')
                    ->required(),
                TextInput::make('email')
                    ->unique()
                    ->required(),
                TextInput::make('domain')
                    ->nullable()
                    ->unique(),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Institution
    {
        $institution = Institution::create($data);

        $institution->members()->attach(auth()->user());

        return $institution;
    }
}
