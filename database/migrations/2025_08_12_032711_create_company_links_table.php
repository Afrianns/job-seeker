<?php

use App\Models\Company;
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
        Schema::create('company_links', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("facebook_link")->nullable();
            $table->string("instagram_link")->nullable();
            $table->string("twitter_link")->nullable();
            $table->string("website_link")->nullable();
            $table->foreignIdFor(Company::class)->unique()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_links');
    }
};
