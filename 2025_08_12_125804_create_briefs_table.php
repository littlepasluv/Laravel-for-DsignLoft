<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('briefs', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description")->nullable();
            $table->json("brand_style")->nullable();
            $table->json("colors")->nullable();
            $table->foreignId("package_id")->constrained("packages");
            $table->string("status")->default("pending");
            $table->foreignId("created_by")->constrained("users");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('briefs');
    }
};
