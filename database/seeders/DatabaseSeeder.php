<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Pricing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $branch = Branch::first();
        if (!$branch) {
            $branch = Branch::create([
                'branch_name' => 'Main Branch',
                'branch_phone' => null,
                'branch_address' => null,
                'status' => 1,
            ]);
        }

        User::updateOrCreate(
            ['email' => 'info@admin.com'],
            [
                'name' => 'Default Admin',
                'password' => Hash::make('Rr$123#'),
                'branch_id' => $branch->id,
                'phone_number' => '0000000000',
                'profile_pic' => '',
                'role_name' => 'Admin',
                'status' => 1,
            ]
        );

        $user = User::where('email', 'info@admin.com')->first();
        if ($user) {
            Pricing::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'last_Update' => now(),
                    'price' => 0.00,
                    'price_21' => 0.00,
                    'price_22' => 0.00,
                    'price_24' => 0.00,
                    'price_18' => 0.00,
                    'price_14' => 0.00,
                    'currency' => 'SAR',
                ]
            );
        }
    }
}
