<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('member_of_staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('first_name');
            $table->string('last_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_of_staff');
    }
};
