<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('personal_data_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('data_type')->unique();
            $table->timestamps();
        });

        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::create(['name' => "$action-personal-data-type"]);
        }
    }

    public function down(): void
    {
        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::query()->where('name', "$action-personal-data-type")->delete();
        }

        Schema::dropIfExists('personal_data_types');
    }
};
