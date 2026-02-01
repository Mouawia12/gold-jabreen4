<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_create_succeeds(): void
    {
        $defaultConnection = config('database.default');
        config(['database.connections.mysql2' => config("database.connections.{$defaultConnection}")]);

        $this->seed();

        if (!Branch::query()->exists()) {
            Branch::create([
                'branch_name' => 'Default Branch',
                'branch_phone' => '000',
                'branch_address' => 'N/A',
                'commercial_record' => '000',
                'license_number' => '000',
                'status' => 1,
            ]);
        }

        $user = User::where('email', 'info@admin.com')->first();
        $this->assertNotNull($user, 'Default admin user not seeded.');

        $this->actingAs($user, 'admin-web');

        $payload = [
            'id' => 0,
            'name_ar' => 'مجموعة اختبار ' . now()->timestamp,
            'name_en' => 'Test Category ' . now()->timestamp,
            'description' => 'Test',
        ];

        $response = $this->post('/admin/storeCategory', $payload);
        $this->assertTrue(in_array($response->status(), [200, 302], true));
        $error = $response->getSession()->get('error');
        $this->assertNull($error, $error ?? '');
    }
}
