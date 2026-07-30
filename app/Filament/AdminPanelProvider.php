<?php
namespace App\Filament;

use App\Filament\Pages\Login;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Inbox;
use App\Filament\Pages\InfrastructureTopology;
use App\Filament\Pages\DataColoClient;
use App\Filament\Pages\ColocationView;
use App\Filament\Pages\DataInterkoneksi;
use App\Filament\Pages\SecurityCenter;
use App\Filament\Pages\ClientDevices;
use App\Filament\Pages\ClientAccounts;
use App\Filament\Pages\DataFst;
use App\Filament\Pages\SettingsPage;
use App\Filament\Pages\SystemLogs;
use App\Filament\Resources\RackResource;
use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\VisitPermitResource;
use App\Filament\Resources\InterconnectionRequestResource;
use App\Filament\Resources\LegacyEquipmentResource;
use App\Filament\Resources\DeviceModelResource;
use App\Filament\Resources\SupportTicketResource;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\StatsOverview;
use Filament\Panel;
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()->id('admin')->path('admin')
            ->login(Login::class)
            ->colors(['primary' => '#7C3AED'])
            ->brandName('ProDC VMS')
            ->sidebarCollapsibleOnDesktop()
            ->resources([
                RackResource::class, CustomerResource::class, VisitPermitResource::class,
                InterconnectionRequestResource::class, LegacyEquipmentResource::class,
                DeviceModelResource::class, SupportTicketResource::class, UserResource::class,
            ])
            ->pages([
                Dashboard::class, Inbox::class, InfrastructureTopology::class,
                DataColoClient::class, ColocationView::class, DataInterkoneksi::class,
                SecurityCenter::class, ClientDevices::class, ClientAccounts::class,
                DataFst::class, SettingsPage::class, SystemLogs::class,
            ])
            ->widgets([StatsOverview::class]);
    }
}
