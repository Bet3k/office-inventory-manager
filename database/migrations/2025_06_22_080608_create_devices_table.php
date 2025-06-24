<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('brand');
            $table->string('type');
            $table->string('serial_number')->unique();
            $table->string('status');
            $table->string('service_status');
            $table->timestamps();
        });

        foreach (['view', 'viewAny', 'create', 'update', 'delete', 'assign'] as $action) {
            Permission::create(['name' => "$action-devices"]);
        }
    }

    public function down(): void
    {
        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::query()->where('name', "$action-devices")->delete();
        }

        Schema::dropIfExists('devices');
    }
};
