<?php

use App\Models\JobListing;
use App\Models\Report;
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
        Schema::create('message_to_recruiters', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->enum("type", ["warning","info"])->default("info");
            $table->text("message");
            $table->foreignIdFor(Report::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_to_recruiters');
    }
};
