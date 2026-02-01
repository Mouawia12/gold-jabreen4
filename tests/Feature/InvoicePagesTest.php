<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoicePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_create_pages_load(): void
    {
        $this->seed();

        $user = User::where('email', 'info@admin.com')->first();
        $this->assertNotNull($user, 'Default admin user not seeded.');

        $this->actingAs($user, 'admin-web');

        $paths = [
            '/admin/pos',
            '/admin/pos-tax-create',
            '/admin/workEntryCreate',
            '/admin/oldEntryCreate',
            '/admin/workExitCreate',
            '/admin/pos-collectible-create',
        ];

        foreach ($paths as $path) {
            $response = $this->get($path);
            $this->assertTrue(
                in_array($response->status(), [200, 302], true),
                "Unexpected status for {$path}: {$response->status()}"
            );

            if ($response->status() === 302) {
                $location = $response->headers->get('Location') ?? '';
                $this->assertFalse(
                    str_contains($location, '/login'),
                    "Redirected to login for {$path}"
                );
            } else {
                $response->assertStatus(200, "Failed loading {$path}");
            }
        }
    }
}
