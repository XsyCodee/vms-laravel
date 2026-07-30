<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportDataSeeder extends Seeder
{
    private array $customerMap = [];
    private array $rackCache = [];
    private array $rowIds = [];
    private int $saId, $custRoleId, $adminId;

    public function run(): void
    {
        $t = fn() => ['created_at' => now(), 'updated_at' => now()];

        $this->command->info('=== Importing all data from /sdc/data/ ===');

        $regionId = DB::table('regions')->insertGetId(['name' => 'Jakarta', 'code' => 'JKT', ...$t()]);
        $dcId = DB::table('datacenters')->insertGetId(['name' => 'ProDC Jakarta P1', 'code' => 'P1', 'region_id' => $regionId, ...$t()]);
        $f8 = DB::table('floors')->insertGetId(['name' => 'Lantai 8', 'datacenter_id' => $dcId, ...$t()]);
        $f9 = DB::table('floors')->insertGetId(['name' => 'Lantai 9', 'datacenter_id' => $dcId, ...$t()]);
        $da8 = DB::table('data_rooms')->insertGetId(['name' => 'Data Hall A', 'floor_id' => $f8, ...$t()]);
        $db8 = DB::table('data_rooms')->insertGetId(['name' => 'Data Hall B', 'floor_id' => $f8, ...$t()]);
        $da9 = DB::table('data_rooms')->insertGetId(['name' => 'Data Hall A', 'floor_id' => $f9, ...$t()]);
        $db9 = DB::table('data_rooms')->insertGetId(['name' => 'Data Hall B', 'floor_id' => $f9, ...$t()]);
        $this->rowIds = [
            'ct8' => DB::table('rows')->insertGetId(['name' => 'CT-1', 'room_id' => $da8, ...$t()]),
            'mmr8' => DB::table('rows')->insertGetId(['name' => 'MMR-1', 'room_id' => $da8, ...$t()]),
            'ct9' => DB::table('rows')->insertGetId(['name' => 'CT-1', 'room_id' => $da9, ...$t()]),
            'mmr9' => DB::table('rows')->insertGetId(['name' => 'MMR-1', 'room_id' => $da9, ...$t()]),
            'db8' => DB::table('rows')->insertGetId(['name' => 'CT-1', 'room_id' => $db8, ...$t()]),
            'db9' => DB::table('rows')->insertGetId(['name' => 'CT-1', 'room_id' => $db9, ...$t()]),
        ];

        $this->saId = DB::table('roles')->insertGetId(['name' => 'Superadmin', ...$t()]);
        DB::table('roles')->insertGetId(['name' => 'NOC Admin', ...$t()]);
        DB::table('roles')->insertGetId(['name' => 'NOC Staff', ...$t()]);
        $this->custRoleId = DB::table('roles')->insertGetId(['name' => 'Customer', ...$t()]);
        $this->adminId = DB::table('users')->insertGetId(['name' => 'SDC Admin', 'email' => 'admin@vms.local', 'password' => bcrypt('Tahun2026_!@#'), 'role_id' => $this->saId, ...$t()]);

        $xlsx = 'C:/laragon/www/sdc/data/daftar-perangkat.xlsx';
        $sheets = $this->readXlsx($xlsx);

        $this->parseCustomerSheet($sheets['RACK CUSTOMER LT. 8 (P1)'] ?? [], $this->rowIds['ct8'], 'P1 DA Close Rack', $t());
        $this->parseCustomerSheet($sheets['RACK CUSTOMER LT.9 (P2) DataHal'] ?? [], $this->rowIds['ct9'], 'P2 DA Close Rack', $t());
        $this->parseMmrSheet($sheets['MMR OPEN RACK LT. 8 (P1)'] ?? [], $this->rowIds['mmr8'], 'L8 MMR');
        $this->parseMmrSheet($sheets['MMR OPEN RACK LT.9 (P2)'] ?? [], $this->rowIds['mmr9'], 'L9 MMR');

        $this->importJson('C:/laragon/www/sdc/data/mmr_lt8_import.json', $this->rowIds['mmr8'], 'L8 MMR');
        $this->importJson('C:/laragon/www/sdc/data/mmr_lt8_devices.json', $this->rowIds['mmr8'], 'L8 MMR');

        DB::table('support_tickets')->insert(['reporter_id' => $this->adminId, 'subject' => 'Follow up: Cross-connect installation', 'description' => 'Menindaklanjuti permintaan koneksi fiber.', 'priority' => 'Medium', 'category' => 'Follow-Up', 'status' => 'Open', ...$t()]);

        $this->command->info("Done! Customers: " . DB::table('customers')->count() . " Racks: " . DB::table('racks')->count() . " Equipment: " . DB::table('rack_equipments')->count() . " Legacy: " . DB::table('legacy_equipment_records')->count());
    }

    private function readXlsx(string $path): array
    {
        $result = [];
        if (!file_exists($path)) return $result;
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) return $result;
        $ss = [];
        $xml = $zip->getFromName('xl/sharedStrings.xml');
        if ($xml) foreach (simplexml_load_string($xml)?->si ?? [] as $si) {
            $t = (string)($si->t ?? '');
            if (empty($t) && $si->r) foreach ($si->r as $r) $t .= (string)($r->t ?? '');
            $ss[] = $t;
        }
        $names = [];
        $wb = simplexml_load_string($zip->getFromName('xl/workbook.xml'));
        if ($wb?->sheets) foreach ($wb->sheets->sheet as $s) $names[] = (string)$s['name'];
        for ($i = 1; $i <= count($names); $i++) {
            $xml = $zip->getFromName("xl/worksheets/sheet{$i}.xml");
            if (!$xml) continue;
            $sheet = simplexml_load_string($xml);
            if (!$sheet?->sheetData) continue;
            $rows = [];
            foreach ($sheet->sheetData->row as $row) {
                $cells = [];
                foreach ($row->c as $c) {
                    $v = (string)($c->v ?? '');
                    if ((string)($c['t'] ?? '') === 's' && $v !== '') $v = $ss[(int)$v] ?? $v;
                    $cells[] = $v;
                }
                if ($cells) $rows[] = $cells;
            }
            $result[$names[$i - 1]] = $rows;
        }
        $zip->close();
        return $result;
    }

    private function parseCustomerSheet(array $rows, int $rowId, string $prefix, array $t): void
    {
        $rId = $cId = null;
        foreach ($rows as $cells) {
            $first = trim($cells[0] ?? '');
            if (preg_match('/^Rack\s+(\d+)\s+(.+)/i', $first, $m)) {
                $name = trim(preg_replace('/\s+/', ' ', $m[2]));
                $cId = $this->cust($name);
                $rId = $this->rack("{$prefix} {$m[1]}", $rowId, 'CLOSED', 'OCCUPIED', $cId);
                if (!DB::table('rack_tenants')->where('rack_id', $rId)->where('customer_id', $cId)->exists())
                    DB::table('rack_tenants')->insert(['rack_id' => $rId, 'customer_id' => $cId, 'u_size' => 42, 'status' => 'ACTIVE', ...$t]);
                continue;
            }
            if ($rId && isset($cells[1]) && !empty($cells[1]) && is_numeric($cells[0]))
                $this->eq($cells, $rId, $cId, $prefix);
        }
    }

    private function parseMmrSheet(array $rows, int $rowId, string $pfx): void
    {
        $rId = $rn = null;
        foreach ($rows as $cells) {
            $f = trim($cells[0] ?? '');
            if (preg_match('/^OPEN\s+RACK\s+(\d+)/i', $f, $m)) {
                $rn = "{$pfx} Open Rack {$m[1]}";
                $rId = $this->rack($rn, $rowId, 'OPEN', 'AVAILABLE');
                continue;
            }
            if ($rId && isset($cells[1]) && !empty($cells[1]) && is_numeric($cells[0]))
                $this->eq($cells, $rId, null, $rn);
        }
    }

    private function importJson(string $path, int $rowId, string $pfx): void
    {
        if (!file_exists($path)) return;
        $data = json_decode(file_get_contents($path), true) ?: [];
        if (isset($data[0]['items'])) $data = $data[0]['items'];
        foreach ($data as $it) {
            if (!isset($it['name'])) continue;
            $rn = $pfx . ' ' . ($it['rack_name'] ?? 'Open Rack');
            $rid = $this->rack($rn, $rowId, 'OPEN', 'AVAILABLE');
            DB::table('legacy_equipment_records')->insert([
                'rack_id' => $rid, 'rack_name' => $rn, 'item_name' => $it['name'],
                'qty' => (int)($it['qty'] ?? 1), 'weight' => $it['berat'] ?? null,
                'dimension' => $it['dimensi'] ?? null,
                'serial_number' => ($it['sn'] ?? null) ?: null,
                'notes' => $it['keterangan'] ?? null,
                'arrival_date' => $this->d($it['tanggal'] ?? null), 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    private function eq(array $c, int $rid, ?int $cid, string $rn): void
    {
        $n = trim((string)$c[1]);
        if (empty($n) || strtolower($n) === 'barang') return;
        $sn = ($c[5] ?? null);
        if ($sn !== null && $sn !== '-' && is_numeric($sn)) $sn = number_format((float)$sn, 0, '', '');
        $sn = ($sn && $sn !== '-' && trim((string)$sn) !== '') ? (string)$sn : null;
        if ($sn && strlen($sn) > 50) $sn = substr($sn, 0, 50);
        $w = ($c[3] ?? null); $w = (is_numeric($w) && (float)$w > 0) ? (string)$w : null;
        $dim = ($c[4] ?? null); $dim = ($dim && $dim !== '-' && trim((string)$dim) !== '') ? (string)$dim : null;
        $dt = $this->d($c[7] ?? null);
        DB::table('rack_equipments')->insert([
            'rack_id' => $rid, 'customer_id' => $cid, 'name' => $n, 'equipment_type' => 'Device',
            'u_start' => 1, 'u_end' => max(1, (int)$dim), 'status' => 'Active',
            'serial_number' => $sn, 'weight' => $w, 'arrival_date' => $dt,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('legacy_equipment_records')->insert([
            'rack_id' => $rid, 'rack_name' => $rn, 'item_name' => $n,
            'qty' => (int)($c[2] ?? 1), 'weight' => $w, 'dimension' => $dim,
            'serial_number' => $sn, 'notes' => $c[6] ?? null, 'arrival_date' => $dt,
            'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    private function cust(string $n): int
    {
        $n = trim(preg_replace('/\s+/', ' ', $n));
        if (isset($this->customerMap[$n])) return $this->customerMap[$n];
        $e = DB::table('customers')->where('name', $n)->first();
        if ($e) { $this->customerMap[$n] = $e->id; return $e->id; }
        // Insert without code first
        $id = DB::table('customers')->insertGetId(['name' => $n, 'created_at' => now(), 'updated_at' => now()]);
        // Set code after (based on id)
        $code = strtoupper(substr(preg_replace('/[^A-Z]/', '', strtoupper($n)), 0, 3)) ?: 'CT';
        if (DB::table('customers')->where('code', $code)->where('id', '!=', $id)->exists()) $code .= $id;
        DB::table('customers')->where('id', $id)->update(['code' => $code]);
        $this->customerMap[$n] = $id;
        $es = strtolower(preg_replace('/[^a-z0-9]/', '', substr($n, 0, 10)));
        if (empty($es)) $es = 'cust' . $id;
        $es .= '@vms.local';
        if (!DB::table('users')->where('email', $es)->exists())
            DB::table('users')->insert(['name' => $n, 'email' => $es, 'password' => bcrypt('Tahun2026_!@#'), 'role_id' => $this->custRoleId, 'customer_id' => $id, 'created_at' => now(), 'updated_at' => now()]);
        $this->command->info("  + {$n}");
        return $id;
    }

    private function rack(string $n, int $rid, string $t, string $s, ?int $cid = null): int
    {
        $k = $n . $rid;
        if (isset($this->rackCache[$k])) return $this->rackCache[$k];
        $e = DB::table('racks')->where('name', $n)->where('row_id', $rid)->first();
        if ($e) { $this->rackCache[$k] = $e->id; return $e->id; }
        $id = DB::table('racks')->insertGetId(['row_id' => $rid, 'customer_id' => $cid, 'name' => $n, 'type' => $t, 'status' => $s, 'u_capacity' => 42, 'created_at' => now(), 'updated_at' => now()]);
        $this->rackCache[$k] = $id;
        return $id;
    }

    private function d($v): ?string
    {
        if (empty($v)) return null;
        if ($v instanceof \DateTime) return $v->format('Y-m-d');
        $v = trim((string)$v);
        if (empty($v)) return null;
        foreach (['Y-m-d', 'd/m/Y', 'm/d/Y', 'Y-m-d H:i:s'] as $f) {
            $d = \DateTime::createFromFormat($f, $v);
            if ($d) {
                $year = (int)$d->format('Y');
                if ($year < 2000 || $year > 2030) return null;
                return $d->format('Y-m-d');
            }
        }
        if (is_numeric($v) && $v > 30000 && $v < 100000) {
            $d = new \DateTime('1899-12-30');
            $d->modify('+' . (int)$v . ' days');
            $year = (int)$d->format('Y');
            if ($year < 2000 || $year > 2030) return null;
            return $d->format('Y-m-d');
        }
        return null;
    }
}
