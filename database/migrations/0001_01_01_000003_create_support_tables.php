<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Support Tickets ──
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
            $table->foreignId('reporter_id')->constrained('users');
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('datacenter_id')->nullable()->constrained('datacenters')->cascadeOnDelete();
            $table->string('subject');
            $table->text('description');
            $table->string('priority')->default('Medium');
            $table->string('status')->default('Open');
            $table->string('category')->default('General');
            $table->integer('sla_downtime_mins')->default(0);
            $table->dateTime('resolved_at')->nullable();
            $table->timestamps();
        });

        // ── Ticket Comments ──
        Schema::create('ticket_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('support_tickets')->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users');
            $table->text('body');
            $table->boolean('is_internal')->default(false);
            $table->timestamps();
        });

        // ── Legacy Equipment Records ──
        Schema::create('legacy_equipment_records', function (Blueprint $table) {
            $table->id();
            $table->string('rack_name')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('qty')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimension')->nullable();
            $table->string('serial_number')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('arrival_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('rack_id')->nullable()->constrained('racks')->nullOnDelete();
            $table->timestamps();
        });

        // ── Vendor Maintenance ──
        Schema::create('vendor_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->integer('sla_downtime_mins')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // ── Pivot: maintenance_affected_racks ──
        Schema::create('maintenance_affected_racks', function (Blueprint $table) {
            $table->foreignId('maintenance_id')->constrained('vendor_maintenances')->cascadeOnDelete();
            $table->foreignId('rack_id')->constrained('racks')->cascadeOnDelete();
            $table->primary(['maintenance_id', 'rack_id']);
        });

        // ── Api Logs ──
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('endpoint');
            $table->string('method');
            $table->string('action');
            $table->integer('status');
            $table->timestamp('timestamp')->useCurrent();
        });

        // ── System Audit Logs ──
        Schema::create('system_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('resource')->nullable();
            $table->text('details')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // ── Datacenter Mail Configs ──
        Schema::create('datacenter_mail_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('datacenter_id')->unique()->constrained('datacenters')->cascadeOnDelete();
            $table->string('imap_host');
            $table->integer('imap_port')->default(993);
            $table->string('imap_user');
            $table->string('imap_pass');
            $table->string('smtp_host');
            $table->integer('smtp_port')->default(465);
            $table->string('smtp_user');
            $table->string('smtp_pass');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Inbox Messages ──
        Schema::create('inbox_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('datacenter_id')->constrained('datacenters')->cascadeOnDelete();
            $table->string('message_id')->unique();
            $table->string('thread_id')->nullable();
            $table->string('from');
            $table->string('to');
            $table->string('subject');
            $table->text('body_text');
            $table->text('html_content')->nullable();
            $table->boolean('is_read')->default(false);
            $table->dateTime('received_at')->useCurrent();
            $table->dateTime('replied_at')->nullable();
            $table->timestamps();
        });

        // ── Interconnection Providers ──
        Schema::create('interconnection_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->foreignId('datacenter_id')->nullable()->constrained('datacenters')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbox_messages');
        Schema::dropIfExists('datacenter_mail_configs');
        Schema::dropIfExists('system_audit_logs');
        Schema::dropIfExists('api_logs');
        Schema::dropIfExists('maintenance_affected_racks');
        Schema::dropIfExists('vendor_maintenances');
        Schema::dropIfExists('legacy_equipment_records');
        Schema::dropIfExists('ticket_comments');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('interconnection_providers');
    }
};
