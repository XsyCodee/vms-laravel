<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Region;
use App\Models\Datacenter;
use App\Models\Floor;
use App\Models\DataRoom;
use App\Models\Row;
use App\Models\Customer;
use App\Models\User;
use App\Models\Rack;
use App\Models\SupportTicket;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles ──
        $superadmin = Role::create(['name' => 'Superadmin']);
        $nocAdmin = Role::create(['name' => 'NOC Admin']);
        $nocStaff = Role::create(['name' => 'NOC Staff']);
        $customer = Role::create(['name' => 'Customer']);

        // ── Permissions ──
        $perms = [
            ['key' => 'dashboard:view', 'label' => 'View Dashboard', 'group' => 'Dashboard'],
            ['key' => 'permits:view', 'label' => 'View Permits', 'group' => 'Security'],
            ['key' => 'permits:manage', 'label' => 'Manage Permits', 'group' => 'Security'],
            ['key' => 'racks:view', 'label' => 'View Racks', 'group' => 'Infrastructure'],
            ['key' => 'racks:manage', 'label' => 'Manage Racks', 'group' => 'Infrastructure'],
            ['key' => 'infrastructure:view', 'label' => 'View Infrastructure', 'group' => 'Infrastructure'],
            ['key' => 'infrastructure:manage', 'label' => 'Manage Infrastructure', 'group' => 'Infrastructure'],
            ['key' => 'settings:manage', 'label' => 'Manage Settings', 'group' => 'Settings'],
            ['key' => 'users:manage', 'label' => 'Manage Users', 'group' => 'Settings'],
            ['key' => 'tickets:view', 'label' => 'View Tickets', 'group' => 'Support'],
            ['key' => 'tickets:manage', 'label' => 'Manage Tickets', 'group' => 'Support'],
        ];
        foreach ($perms as $p) {
            $perm = Permission::create($p);
            $superadmin->permissions()->attach($perm->id);
            if (in_array($p['group'], ['Dashboard', 'Security', 'Infrastructure', 'Support'])) {
                $nocAdmin->permissions()->attach($perm->id);
                $nocStaff->permissions()->attach($perm->id);
            }
        }

        // ── Region + Datacenter ──
        $region = Region::create(['name' => 'Jakarta', 'code' => 'JKT']);
        $dc = Datacenter::create(['region_id' => $region->id, 'code' => 'P1', 'name' => 'ProDC Jakarta P1']);

        // ── Floors + Data Halls + Rows ──
        foreach (['Lantai 8' => ['DA' => 'Data Hall A', 'DB' => 'Data Hall B'], 'Lantai 9' => ['DA' => 'Data Hall A', 'DB' => 'Data Hall B']] as $fName => $halls) {
            $floor = Floor::create(['datacenter_id' => $dc->id, 'name' => $fName]);
            foreach ($halls as $hCode => $hName) {
                $hall = DataRoom::create(['floor_id' => $floor->id, 'name' => $hName]);
                foreach (['MMR-1', 'CT-1'] as $rn) {
                    Row::create(['room_id' => $hall->id, 'name' => $rn]);
                }
            }
        }

        // ── Customers ──
        $c1 = Customer::create(['name' => 'PT Lintas Network Solusi', 'code' => 'LNS', 'contact_email' => 'ops@lintas.net.id']);
        $c2 = Customer::create(['name' => 'PT Data Teknologi Nusantara', 'code' => 'DTN', 'contact_email' => 'info@dtn.co.id']);

        // ── Users ──
        User::create(['name' => 'SDC Admin', 'email' => 'admin@vms.local', 'password' => Hash::make('Tahun2026_!@#'), 'role_id' => $superadmin->id]);
        User::create(['name' => 'Lintas Admin', 'email' => 'lintasnetworksolusi@vms.local', 'password' => Hash::make('Tahun2026_!@#'), 'role_id' => $customer->id, 'customer_id' => $c1->id]);

        // ── Racks ──
        $names = ['RACK 01', 'RACK 02', 'RACK 03', 'Open Rack 1', 'Open Rack 2'];
        foreach ($names as $i => $name) {
            $row = Row::inRandomOrder()->first();
            Rack::create(['row_id' => $row->id, 'name' => $name, 'u_capacity' => 42, 'type' => $i >= 3 ? 'OPEN' : 'CLOSED', 'status' => 'AVAILABLE', 'customer_id' => $i < 2 ? $c1->id : ($i < 4 ? $c2->id : null)]);
        }

        // ── Sample Ticket ──
        SupportTicket::create(['reporter_id' => 1, 'customer_id' => $c1->id, 'subject' => 'Follow up cross-connect Rack 01', 'description' => 'Menindaklanjuti permintaan koneksi ke Data Hall A.', 'priority' => 'Medium', 'category' => 'Follow-Up', 'status' => 'Open']);
    }
}
