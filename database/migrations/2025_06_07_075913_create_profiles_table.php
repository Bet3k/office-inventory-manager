<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->timestamps();
        });

        foreach (['create', 'view', 'viewAny', 'update', 'delete'] as $action) {
            Permission::create(['name' => "$action-user"]);
        }
    }

    public function down(): void
    {
        foreach (['view', 'viewAny', 'create', 'update', 'delete'] as $action) {
            Permission::query()->where('name', "$action-user")->delete();
        }

        Schema::dropIfExists('profiles');
    }
};
