<?php

namespace App\Filament\Superadmin\Resources\SettingResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Filament\Superadmin\Resources\SettingResource;

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
}
