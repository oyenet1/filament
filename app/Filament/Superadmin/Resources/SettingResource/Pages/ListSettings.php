<?php

namespace App\Filament\Superadmin\Resources\SettingResource\Pages;

use App\Filament\Superadmin\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->can('create school settings'), 403);
    }
}
