<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_succeeds_with_valid_credentials(): void
    {
        $branch = Branch::create([
            'branch_name' => 'Main Branch',
            'branch_phone' => null,
            'branch_address' => null,
            'status' => 1,
        ]);

        $user = User::create([
            'name' => 'Default Admin',
            'email' => 'info@admin.com',
            'password' => Hash::make('Rr$123#'),
            'branch_id' => $branch->id,
            'phone_number' => '0000000000',
            'profile_pic' => '',
            'role_name' => 'Admin',
            'status' => 1,
        ]);

        $token = 'test-token';
        $response = $this->withSession(['_token' => $token])
            ->post('/admin/login', [
                '_token' => $token,
                'email' => 'info@admin.com',
                'password' => 'Rr$123#',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/home');
        $this->assertAuthenticatedAs($user, 'admin-web');
    }

    public function test_admin_login_fails_with_invalid_credentials(): void
    {
        $branch = Branch::create([
            'branch_name' => 'Main Branch',
            'branch_phone' => null,
            'branch_address' => null,
            'status' => 1,
        ]);

        User::create([
            'name' => 'Default Admin',
            'email' => 'info@admin.com',
            'password' => Hash::make('Rr$123#'),
            'branch_id' => $branch->id,
            'phone_number' => '0000000000',
            'profile_pic' => '',
            'role_name' => 'Admin',
            'status' => 1,
        ]);

        $token = 'test-token';
        $response = $this->withSession(['_token' => $token])
            ->from('/admin/login')
            ->post('/admin/login', [
                '_token' => $token,
                'email' => 'info@admin.com',
                'password' => 'wrong-password',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin-web');
    }
}
