<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('department');
            $table->timestamps();
        });

        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::create(['name' => "$action-department"]);
        }
    }

    public function down(): void
    {
        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::query()->where('name', "$action-department")->delete();
        }

        Schema::dropIfExists('departments');
    }
};
