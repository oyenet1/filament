<?php

namespace App\Filament\Superadmin\Resources\SettingResource\Pages;

use App\Filament\Superadmin\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;


    protected function getSavedNotificationTitle(): ?string
    {
        return 'School Updated Successfuuly';
    }

    protected function getHeaderActions(): array
    {
        // filament.superadmin.resources.settings.index
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->hasRole('super-admin'))
            // ->successRedirectUrl(route('posts.list')),
        ];
    }
}
