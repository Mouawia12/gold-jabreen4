<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaratSimplePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_karat_simple_page_and_create(): void
    {
        $this->seed();

        $user = User::where('email', 'info@admin.com')->first();
        $this->assertNotNull($user, 'Default admin user not seeded.');

        $this->actingAs($user, 'admin-web');

        $response = $this->get('/admin/karats/simple');
        $this->assertTrue(in_array($response->status(), [200, 302], true));

        $payload = [
            'id' => 0,
            'name_ar' => 'عيار اختبار ' . now()->timestamp,
            'name_en' => 'KTest' . now()->timestamp,
            'label' => 'KT' . now()->timestamp,
            'stamp_value' => 18,
            'transform_factor' => 0.8571,
        ];

        $post = $this->post('/admin/storeKarat', $payload);
        $post->assertStatus(302);
        $this->assertDatabaseHas('karats', [
            'label' => $payload['label'],
            'name_ar' => $payload['name_ar'],
            'name_en' => $payload['name_en'],
        ]);
    }
}
