<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Regions ──
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->timestamps();
        });

        // ── Datacenters ──
        Schema::create('datacenters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('noc_email')->nullable();
            $table->timestamps();
        });

        // ── Floors ──
        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('datacenter_id')->constrained('datacenters')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        // ── Data Rooms (Data Halls) ──
        Schema::create('data_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained('floors')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        // ── Rows (Containments) ──
        Schema::create('rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('data_rooms')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        // ── Roles ──
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // ── Permissions ──
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('group')->default('other');
            $table->timestamps();
        });

        // ── Customers ──
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->nullable()->unique();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->timestamps();
        });

        // ── Users ──
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('password')->default('Tahun2026_!@#');
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('datacenter_id')->nullable()->constrained('datacenters')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });

        // ── Pivot: role_permission ──
        Schema::create('role_permission', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->primary(['role_id', 'permission_id']);
        });

        // ── Pivot: user_permission ──
        Schema::create('user_permission', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->primary(['user_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_permission');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('users');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('rows');
        Schema::dropIfExists('data_rooms');
        Schema::dropIfExists('floors');
        Schema::dropIfExists('datacenters');
        Schema::dropIfExists('regions');
    }
};
