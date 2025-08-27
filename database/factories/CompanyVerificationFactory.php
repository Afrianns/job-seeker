<?php

namespace Database\Factories;

use App\Models\CompanyVerification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyVerification>
 */
class CompanyVerificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = CompanyVerification::class;
    
    public function definition(): array
    {
        $enum = ["waiting","under-review", "approved", "rejected"];
        return [
            "name" => "Result-kepribadian (1).pdf",
            "size" => fake()->randomDigitNotNull(),
            "type" => "application/pdf",
            "status" => $enum[rand(0, 3)],
            "document_path" => "companies-verification-doc/XLXPeU6HIQyVNYgLoka9uZMp0U88r40VJfJes7Hl.pdf",
        ];
    }
}
