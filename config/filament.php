<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Path
    |--------------------------------------------------------------------------
    |
    | This is the path where Filament will be accessible from. You can change
    | this to anything you like, just make sure it's a valid path and doesn't
    | conflict with any existing routes.
    |
    */

    'path' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Filament Domain
    |--------------------------------------------------------------------------
    |
    | This is the domain where Filament will be accessible from. You can change
    | this to anything you like. If you set this to null, Filament will use
    | the domain from your APP_URL configuration.
    |
    */

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Default Panel Provider
    |--------------------------------------------------------------------------
    |
    | This is the panel provider class that Filament will use as the default
    | panel provider for all applications. You can change this to any class
    | that extends the `Filament\PanelProvider` class.
    |
    */

    'default_panel_provider' => null,

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    |
    | These are the settings for the authentication that's used by Filament.
    |
    */

    'auth' => [
        'guard' => 'web',
        'pages' => [
            'login' => \App\Filament\Pages\Login::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    |
    | These are the settings for the branding that's used by Filament.
    |
    */

    'branding' => [
        'accent_color' => '#2563EB',
    ],

];