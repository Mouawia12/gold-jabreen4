<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateCompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_company_succeeds(): void
    {
        $this->seed();

        $user = User::where('email', 'info@admin.com')->first();
        $this->assertNotNull($user, 'Default admin user not seeded.');

        $payload = [
            'id' => 0,
            'type' => 3,
            'company' => 'عميل اختبار',
            'opening_balance' => 0,
            'credit_amount' => 0,
        ];

        $response = $this->actingAs($user, 'admin-web')
            ->post('/admin/storeCompany', $payload);

        $response->assertStatus(302);
        $this->assertDatabaseHas('companies', [
            'company' => 'عميل اختبار',
            'group_id' => 3,
        ]);
    }
}
