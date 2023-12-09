<?php

namespace App\Filament\Superadmin\Resources\SettingResource\Pages;

use Filament\Actions;
use App\Models\School;
use Filament\Resources\Components\Tab;
use Filament\Support\Enums\IconPosition;
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
            'all' => Tab::make()
                ->icon('heroicon-o-academic-cap')
                ->iconPosition(IconPosition::After),
            'active' => Tab::make()
                ->badge(fn () => School::where('status', "active")->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "active"))
                ->badgeColor('success'),
            'inactive' => Tab::make()
                ->badge(fn () => School::where('status', "inactive")->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "inactive"))
                ->badgeColor('warning'),
            'expired' => Tab::make()
                ->badge(fn () => School::where('status', "expired")->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "expired"))
                ->badgeColor('secondary'),
            'disabled' => Tab::make()
                ->badge(fn () => School::where('status', "disabled")->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', "disabled"))
                ->badgeColor('danger'),
        ];
    }
}
