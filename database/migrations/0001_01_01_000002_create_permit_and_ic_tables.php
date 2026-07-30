<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Visit Permits ──
        Schema::create('visit_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('datacenter_id')->constrained('datacenters')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->string('company_name')->nullable();
            $table->string('visitor_names');
            $table->text('visitor_photo')->nullable();
            $table->string('activity');
            $table->dateTime('scheduled_at');
            $table->dateTime('check_in_at')->nullable();
            $table->dateTime('check_out_at')->nullable();
            $table->string('status')->default('Pending');
            $table->foreignId('approved_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('nda_signed_at')->nullable();
            $table->string('qr_code_token')->nullable()->unique();
            $table->boolean('requires_escort')->default(false);
            $table->text('zone_access')->nullable();
            $table->string('collateral_type')->nullable();
            $table->string('collateral_name')->nullable();
            $table->string('collateral_id')->nullable();
            $table->timestamps();
        });

        // ── Access Cards ──
        Schema::create('access_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_number')->unique();
            $table->string('status')->default('Available');
            $table->foreignId('current_permit_id')->nullable()->unique()->constrained('visit_permits')->nullOnDelete();
            $table->timestamps();
        });

        // ── Permit Event Logs ──
        Schema::create('permit_event_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id')->constrained('visit_permits')->cascadeOnDelete();
            $table->string('status');
            $table->text('message')->nullable();
            $table->timestamp('timestamp')->useCurrent();
        });

        // ── Logic Switches ──
        Schema::create('logic_switches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('switch_type'); // METRO | IPT | ILIX | HSPIX
            $table->integer('total_ports')->default(48);
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Switch Ports ──
        Schema::create('switch_ports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('switch_id')->constrained('logic_switches')->cascadeOnDelete();
            $table->string('port_name'); // e.g. Gi0/1
            $table->string('status')->default('AVAILABLE');
            $table->string('allocated_to')->nullable();
            $table->text('notes')->nullable();
            $table->unique(['switch_id', 'port_name']);
            $table->timestamps();
        });

        // ── Interconnection Requests ──
        Schema::create('interconnection_requests', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('requester_id')->constrained('users');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            // Type
            $table->string('service_type'); // LAYANAN | SEWA_CORE_APJII | SEWA_CORE_MMR
            $table->string('service_sub_type')->nullable();
            $table->string('interconnect_type'); // CROSS_CONNECT | INTERNAL_BUILDING | ANTAR_RACK
            // Source
            $table->string('source_device');
            $table->string('source_port');
            $table->string('source_rack')->nullable();
            $table->string('source_tenant')->nullable();
            // Destination
            $table->string('dest_device');
            $table->string('dest_port');
            $table->string('dest_rack')->nullable();
            $table->string('dest_tenant')->nullable();
            // Cable specs
            $table->string('connector_type')->nullable();
            $table->string('cable_label')->nullable();
            $table->string('cable_spec')->nullable();
            $table->string('media_type')->nullable();
            // NOC Logic
            $table->foreignId('allocated_switch_id')->nullable()->constrained('logic_switches')->nullOnDelete();
            $table->string('allocated_port_name')->nullable();
            $table->text('logic_config')->nullable();
            $table->text('installation_notes')->nullable();
            // Finance
            $table->string('payment_status')->nullable();
            $table->text('payment_notes')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('ewo_code_hsp')->nullable();
            $table->string('ewo_code_prodc')->nullable();
            $table->string('cid')->nullable();
            // Status
            $table->string('status')->default('PENDING');
            $table->text('reject_reason')->nullable();
            // Handler IDs
            $table->foreignId('noc_logic_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('finance_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('noc_dc_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('logic_setup_by_id')->nullable()->constrained('users')->nullOnDelete();
            // Timestamps
            $table->dateTime('noc_logic_at')->nullable();
            $table->dateTime('payment_at')->nullable();
            $table->dateTime('noc_dc_start_at')->nullable();
            $table->dateTime('installed_at')->nullable();
            $table->dateTime('logic_setup_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });

        // ── Request Timelines ──
        Schema::create('request_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained('interconnection_requests')->cascadeOnDelete();
            $table->string('status');
            $table->text('message')->nullable();
            $table->string('handled_by')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('timestamp')->useCurrent();
        });

        // ── Interconnection Records (legacy import) ──
        Schema::create('interconnection_records', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->dateTime('date')->nullable();
            $table->string('ticket_id')->nullable();
            $table->string('interconnect_id')->nullable();
            $table->string('kode_apjii')->nullable();
            $table->string('label_apjii')->nullable();
            $table->string('cable_id')->nullable();
            $table->string('media_type')->nullable();
            $table->string('rack_a')->nullable();
            $table->string('device_a')->nullable();
            $table->string('port_a')->nullable();
            $table->string('rack_b')->nullable();
            $table->string('device_b')->nullable();
            $table->string('port_b')->nullable();
            $table->string('status_text')->nullable();
            $table->string('pic')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('request_timelines');
        Schema::dropIfExists('interconnection_requests');
        Schema::dropIfExists('interconnection_records');
        Schema::dropIfExists('switch_ports');
        Schema::dropIfExists('logic_switches');
        Schema::dropIfExists('permit_event_logs');
        Schema::dropIfExists('access_cards');
        Schema::dropIfExists('visit_permits');
    }
};
