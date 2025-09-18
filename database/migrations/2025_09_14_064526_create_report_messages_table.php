<?php

use App\Models\JobListing;
use App\Models\Report;
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
        Schema::create('report_messages', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Report::class)->constrained()->cascadeOnDelete();
            $table->text("message");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_messages');
    }
};
