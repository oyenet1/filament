<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Model;

class EditInstitutionProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'School profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->unique(),
                TextInput::make('slug')
                    ->unique(),
                TextInput::make('domain')
                    ->nullable(),

            ]);
    }
}
