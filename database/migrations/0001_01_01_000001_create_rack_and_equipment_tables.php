<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Racks ──
        Schema::create('racks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('row_id')->constrained('rows')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('name');
            $table->integer('u_capacity')->default(42);
            $table->string('type')->default('OPEN');
            $table->string('status')->default('AVAILABLE');
            $table->timestamps();
        });

        // ── Rack Tenants ──
        Schema::create('rack_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rack_id')->constrained('racks')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->integer('u_size')->nullable()->default(42);
            $table->string('status')->default('ACTIVE');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['rack_id', 'customer_id']);
        });

        // ── Device Models ──
        Schema::create('device_models', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model_name')->unique();
            $table->string('equipment_type');
            $table->integer('u_size')->default(1);
            $table->integer('port_count')->default(0);
            $table->boolean('requires_serial_number')->default(true);
            $table->integer('power_draw_w')->nullable();
            $table->timestamps();
        });

        // ── Rack Equipments ──
        Schema::create('rack_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rack_id')->constrained('racks')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('name');
            $table->string('equipment_type');
            $table->integer('u_start');
            $table->integer('u_end');
            $table->string('orientation')->default('FRONT');
            $table->string('status')->default('Active');
            $table->dateTime('arrival_date')->nullable();
            $table->dateTime('departure_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('asset_tag')->nullable()->unique();
            $table->string('weight')->nullable();
            $table->foreignId('device_model_id')->nullable()->constrained('device_models')->nullOnDelete();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // ── Equipment Ports ──
        Schema::create('equipment_ports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('rack_equipments')->cascadeOnDelete();
            $table->string('port_name');
            $table->timestamps();
        });

        // ── Infrastructure Audit Logs ──
        Schema::create('infrastructure_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('rack_equipments')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->text('previous_state')->nullable();
            $table->text('new_state')->nullable();
            $table->timestamp('timestamp')->useCurrent();
        });

        // ── Cross Connects ──
        Schema::create('cross_connects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('datacenter_id')->constrained('datacenters')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->string('media_type')->default('Singlemode Fiber');
            $table->foreignId('side_a_port_id')->constrained('equipment_ports')->cascadeOnDelete();
            $table->foreignId('side_z_port_id')->nullable()->constrained('equipment_ports')->cascadeOnDelete();
            $table->string('target_type')->nullable();
            $table->string('target_provider')->nullable();
            $table->string('status')->default('Requested');
            $table->string('apjii_code')->nullable();
            $table->string('ewo_code')->nullable();
            $table->string('label_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('side_a_company')->nullable();
            $table->string('side_z_company')->nullable();
            $table->foreignId('mmr_side_a_port_id')->nullable()->constrained('equipment_ports')->nullOnDelete();
            $table->foreignId('mmr_side_z_port_id')->nullable()->constrained('equipment_ports')->nullOnDelete();
            $table->timestamps();
        });

        // ── Goods Items ──
        Schema::create('goods_items', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->unique();
            $table->foreignId('datacenter_id')->constrained('datacenters')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status');
            $table->dateTime('scanned_at')->nullable();
            $table->dateTime('arrival_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('weight')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cross_connects');
        Schema::dropIfExists('infrastructure_audit_logs');
        Schema::dropIfExists('equipment_ports');
        Schema::dropIfExists('rack_equipments');
        Schema::dropIfExists('device_models');
        Schema::dropIfExists('rack_tenants');
        Schema::dropIfExists('racks');
        Schema::dropIfExists('goods_items');
    }
};
