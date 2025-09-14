<?php

use App\Models\JobListing;
use App\Models\User;
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
        Schema::create('reported_jobs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(JobListing::class);
            $table->text("message");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_jobs');
    }
};
