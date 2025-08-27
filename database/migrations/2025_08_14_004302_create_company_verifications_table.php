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
        Schema::create('company_verifications', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("size");
            $table->string("type");
            $table->enum("status", ["waiting","under-review", "approved", "rejected"])->default("waiting");
            $table->text("rejected_reason")->nullable();
            $table->string("document_path");
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_verifications');
    }
};
