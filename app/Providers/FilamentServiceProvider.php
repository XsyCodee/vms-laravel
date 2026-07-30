<?php

namespace App\Providers;

use App\Filament\AdminPanelProvider;
use Filament\Panel;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function panel(Panel $panel): Panel
    {
        // This method is for legacy filament v2 support
        // For v3, we use AdminPanelProvider
        return $panel;
    }

    public function register(): void
    {
        // Register panel provider for Filament v3
        $this->app->register(AdminPanelProvider::class);
    }
}