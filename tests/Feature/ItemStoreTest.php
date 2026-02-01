<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Karat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_store_succeeds(): void
    {
        $this->seed();

        $user = User::where('email', 'info@admin.com')->first();
        $this->assertNotNull($user, 'Default admin user not seeded.');

        $this->actingAs($user, 'admin-web');

        $branch = Branch::query()->first();
        $this->assertNotNull($branch, 'Default branch not seeded.');

        $category = Category::create([
            'name' => 'Category ' . now()->timestamp,
            'name_ar' => 'مجموعة ' . now()->timestamp,
            'name_en' => 'Category ' . now()->timestamp,
            'description' => '',
            'image_url' => '',
            'parent_id' => 0,
            'branch_id' => $branch->id,
            'status' => 1,
            'user_id' => $user->id,
        ]);

        $karat = Karat::create([
            'name_ar' => 'عيار اختبار ' . now()->timestamp,
            'name_en' => 'KTest' . now()->timestamp,
            'label' => 'KT' . now()->timestamp,
            'stamp_value' => 15.00,
            'transform_factor' => 1.0000,
        ]);

        $payload = [
            'id' => 0,
            'name_ar' => 'صنف اختبار ' . now()->timestamp,
            'name_en' => 'Item Test ' . now()->timestamp,
            'category_id' => $category->id,
            'karat_id' => $karat->id,
            'branch_id' => $branch->id,
            'item_type' => 1,
            'tax' => 15,
            'state' => 1,
            'weight' => 0,
            'no_metal' => 0,
            'no_metal_type' => 1,
            'made_Value' => 0,
            'price' => 0,
            'cost' => 0,
            'multi' => 1,
        ];

        $response = $this->post('/admin/storeItem', $payload);
        $this->assertTrue(in_array($response->status(), [200, 302], true));
        $error = $response->getSession()->get('error');
        $this->assertNull($error, $error ?? '');
    }
}
