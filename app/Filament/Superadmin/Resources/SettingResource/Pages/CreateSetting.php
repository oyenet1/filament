<?php

namespace App\Filament\Superadmin\Resources\SettingResource\Pages;

use App\Filament\Superadmin\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;
    protected static ?string $modelLabel = 'Add new School';

    public function mount(): void
    {
        abort_unless(auth()->user()->can('create school settings'), 403);
    }
}
