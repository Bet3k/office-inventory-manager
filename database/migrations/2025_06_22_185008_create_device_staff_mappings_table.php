<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('device_staff_mappings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('member_of_staff_id')->constrained('member_of_staff');
            $table->foreignUuid('device_id')->constrained('devices');
            $table->timestamps();
        });

        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::create(['name' => "$action-device_staff_mappings"]);
        }
    }

    public function down(): void
    {
        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::query()->where('name', "$action-device_staff_mappings")->delete();
        }

        Schema::dropIfExists('device_staff_mappings');
    }
};
