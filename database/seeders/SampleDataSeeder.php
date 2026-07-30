<?php

namespace Database\Seeders;

use App\Models\Rack;
use App\Models\Server;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample racks
        $racks = [
            ['name' => 'Rack A-01', 'location' => 'Zone A - Row 1', 'total_u' => 42, 'used_u' => 28, 'power_capacity' => 10.0, 'status' => 'active'],
            ['name' => 'Rack A-02', 'location' => 'Zone A - Row 1', 'total_u' => 42, 'used_u' => 35, 'power_capacity' => 10.0, 'status' => 'active'],
            ['name' => 'Rack B-01', 'location' => 'Zone B - Row 1', 'total_u' => 42, 'used_u' => 15, 'power_capacity' => 15.0, 'status' => 'active'],
            ['name' => 'Rack B-02', 'location' => 'Zone B - Row 1', 'total_u' => 42, 'used_u' => 0, 'power_capacity' => 15.0, 'status' => 'active'],
            ['name' => 'Rack C-01', 'location' => 'Zone C - Row 1', 'total_u' => 42, 'used_u' => 40, 'power_capacity' => 10.0, 'status' => 'maintenance'],
        ];

        foreach ($racks as $rackData) {
            Rack::create($rackData);
        }

        // Create sample servers
        $servers = [
            ['rack_id' => 1, 'name' => 'Web Server 01', 'hostname' => 'web01.vms.local', 'ip_address' => '192.168.1.10', 'u_position' => 1, 'model' => 'Dell PowerEdge R740', 'manufacturer' => 'Dell', 'status' => 'active', 'power_consumption' => 500],
            ['rack_id' => 1, 'name' => 'Web Server 02', 'hostname' => 'web02.vms.local', 'ip_address' => '192.168.1.11', 'u_position' => 3, 'model' => 'Dell PowerEdge R740', 'manufacturer' => 'Dell', 'status' => 'active', 'power_consumption' => 500],
            ['rack_id' => 1, 'name' => 'Database Server', 'hostname' => 'db01.vms.local', 'ip_address' => '192.168.1.20', 'u_position' => 5, 'model' => 'HP ProLiant DL380', 'manufacturer' => 'HP', 'status' => 'active', 'power_consumption' => 800],
            ['rack_id' => 2, 'name' => 'Application Server 01', 'hostname' => 'app01.vms.local', 'ip_address' => '192.168.1.30', 'u_position' => 1, 'model' => 'Dell PowerEdge R640', 'manufacturer' => 'Dell', 'status' => 'active', 'power_consumption' => 450],
            ['rack_id' => 2, 'name' => 'Application Server 02', 'hostname' => 'app02.vms.local', 'ip_address' => '192.168.1.31', 'u_position' => 3, 'model' => 'Dell PowerEdge R640', 'manufacturer' => 'Dell', 'status' => 'inactive', 'power_consumption' => 450],
            ['rack_id' => 3, 'name' => 'Storage Server', 'hostname' => 'storage01.vms.local', 'ip_address' => '192.168.1.40', 'u_position' => 10, 'model' => 'NetApp AFF A250', 'manufacturer' => 'NetApp', 'status' => 'active', 'power_consumption' => 350],
            ['rack_id' => 4, 'name' => 'Backup Server', 'hostname' => 'backup01.vms.local', 'ip_address' => '192.168.1.50', 'u_position' => 1, 'model' => 'Dell PowerEdge R740xd', 'manufacturer' => 'Dell', 'status' => 'maintenance', 'power_consumption' => 600],
        ];

        foreach ($servers as $serverData) {
            Server::create($serverData);
        }

        // Create sample tickets
        $admin = User::first();

        $tickets = [
            [
                'server_id' => 1,
                'created_by' => $admin->id,
                'assigned_to' => $admin->id,
                'title' => 'High CPU Usage on Web Server 01',
                'description' => 'Web Server 01 showing high CPU usage above 90% during peak hours. Need to investigate and optimize.',
                'priority' => 'high',
                'status' => 'open',
            ],
            [
                'server_id' => 6,
                'created_by' => $admin->id,
                'assigned_to' => $admin->id,
                'title' => 'Storage Server Disk Space Warning',
                'description' => 'Storage server disk space reaching 85% capacity. Schedule cleanup and consider expansion.',
                'priority' => 'medium',
                'status' => 'in_progress',
            ],
            [
                'server_id' => 7,
                'created_by' => $admin->id,
                'title' => 'Scheduled Maintenance for Backup Server',
                'description' => 'Backup server needs scheduled maintenance including firmware update and disk check.',
                'priority' => 'low',
                'status' => 'open',
            ],
        ];

        foreach ($tickets as $ticketData) {
            Ticket::create($ticketData);
        }

        $this->command->info('Sample data seeded successfully!');
    }
}