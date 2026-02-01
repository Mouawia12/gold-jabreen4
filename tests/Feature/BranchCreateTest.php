<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_branch_create_succeeds(): void
    {
        $this->seed();

        $user = User::where('email', 'info@admin.com')->first();
        $this->assertNotNull($user, 'Default admin user not seeded.');

        $this->actingAs($user, 'admin-web');

        $payload = [
            'branch_name' => 'فرع اختبار ' . now()->timestamp,
            'branch_phone' => '0550000000',
            'branch_address' => 'Test Address',
            'commercial_record' => '0',
            'license_number' => '0',
            'status' => 1,
        ];

        $response = $this->post('/admin/branches', $payload);
        $this->assertTrue(in_array($response->status(), [200, 302], true));
        $error = $response->getSession()->get('error');
        $this->assertNull($error, $error ?? '');
    }
}
