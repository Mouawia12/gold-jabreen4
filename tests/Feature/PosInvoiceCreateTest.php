<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class PosInvoiceCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_pos_invoice_create_succeeds(): void
    {
        $this->seed();

        putenv('AUTO_ACCOUNTING=0');
        $_ENV['AUTO_ACCOUNTING'] = '0';

        $user = User::where('email', 'info@admin.com')->first();
        $this->assertNotNull($user, 'Default admin user not seeded.');

        $branchId = Branch::query()->value('id') ?? 1;

        $categoryId = DB::table('categories')->insertGetId([
            'name' => 'Category 1',
            'code' => 'CAT-1',
            'slug' => 'cat-1',
            'description' => null,
            'image_url' => null,
            'parent_id' => 0,
            'tax_excise' => 0,
            'branch_id' => $branchId,
            'user_id' => $user->id,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $karatId = DB::table('karats')->where('label', 'K21')->value('id');
        if (!$karatId) {
            $karatId = DB::table('karats')->insertGetId([
                'name_ar' => 'عيار 21',
                'name_en' => 'K21',
                'label' => 'K21',
                'stamp_value' => 21,
                'transform_factor' => 1.0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $itemId = DB::table('items')->insertGetId([
            'code' => 'ITM-1',
            'name_ar' => 'صنف 1',
            'name_en' => 'Item 1',
            'branch_id' => $branchId,
            'category_id' => $categoryId,
            'karat_id' => $karatId,
            'weight' => 1.00,
            'no_metal' => 0,
            'no_metal_type' => 0,
            'made_Value' => 0,
            'item_type' => 1,
            'tax' => 0,
            'price' => 100,
            'cost' => 80,
            'multi' => 0,
            'supplier_id' => null,
            'supplier_bill_number' => null,
            'state' => 1,
            'img' => null,
            'quantity' => 10,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $customerId = 1;
        DB::table('companies')->insert([
            'id' => $customerId,
            'group_id' => 3,
            'group_name' => '',
            'customer_group_id' => 0,
            'customer_group_name' => '',
            'name' => 'عميل اختبار',
            'company' => 'عميل اختبار',
            'vat_no' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'postal_code' => '',
            'country' => '',
            'email' => '',
            'phone' => '',
            'invoice_footer' => '',
            'logo' => '',
            'award_points' => 0,
            'deposit_amount' => 0,
            'deposit_gold' => 0,
            'credit_gold' => 0,
            'opening_balance' => 0,
            'credit_amount' => 0,
            'stop_sale' => 0,
            'account_id' => 0,
            'representative_id_' => 0,
            'user_id' => $user->id,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $payload = [
            'document_type' => 1,
            'uuid' => (string) Str::uuid(),
            'bill_date' => now()->toDateTimeString(),
            'customer_id' => $customerId,
            'branch_id' => $branchId,
            'net_after_discount' => 100,
            'item_id' => [$itemId],
            'karat_id' => [$karatId],
            'count' => [1],
            'weight' => [1.00],
            'gram_price' => [100],
            'item_tax' => [0],
            'net_money' => [100],
            'total_weight21' => 1.00,
            'paid' => 0,
            'discount' => 0,
            'tax' => 0,
            'bill_client_phone' => '',
            'bill_client_name' => '',
            'notes' => '',
            'cash' => 0,
            'visa' => 0,
        ];

        $response = $this->actingAs($user, 'admin-web')
            ->post('/admin/store_pos', $payload);

        $response->assertStatus(302);
        $this->assertDatabaseCount('exit_works', 1);
        $this->assertDatabaseCount('exit_work_details', 1);
    }
}
