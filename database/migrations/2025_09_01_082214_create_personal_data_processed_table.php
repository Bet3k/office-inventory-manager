<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('personal_data_processed', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('name');
            $table->timestamps();
        });

        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::create(['name' => "$action-personal-data-processed"]);
        }
    }

    public function down(): void
    {
        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::query()->where('name', "$action-personal-data-processed")->delete();
        }

        Schema::dropIfExists('personal_data_processed');
    }
};
