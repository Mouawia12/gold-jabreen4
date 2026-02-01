<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Pricing;
use App\Models\TaxSettings;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Schema;

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

        TaxSettings::updateOrCreate(
            ['id' => 1],
            [
                'enabled' => 0,
                'value' => 0.00,
            ]
        );

        $this->seedPermissions();
        $this->grantAdminAllPermissions();
    }

    private function seedPermissions(): void
    {
        if (!Schema::hasTable('permissions')) {
            return;
        }

        if (Permission::query()->count() > 0) {
            return;
        }

        $sqlPath = base_path('gold-jabreen2.sql');
        if (!file_exists($sqlPath)) {
            return;
        }

        $sql = file_get_contents($sqlPath);
        if ($sql === false) {
            return;
        }

        if (!preg_match('/INSERT INTO `permissions` .*?;\\s*/s', $sql, $match)) {
            return;
        }

        $insertSql = $match[0];
        if (!preg_match('/VALUES\\s*(.+);/s', $insertSql, $valuesMatch)) {
            return;
        }

        $valuesBlob = trim($valuesMatch[1]);
        $valuesBlob = trim($valuesBlob);
        if ($valuesBlob === '') {
            return;
        }

        preg_match_all('/\\(([^)]+)\\)/s', $valuesBlob, $tuples);
        if (empty($tuples[1])) {
            return;
        }

        $rows = [];
        foreach ($tuples[1] as $tuple) {
            $fields = str_getcsv($tuple, ',', "'");
            if (count($fields) < 6) {
                continue;
            }
            $rows[] = [
                'name' => $fields[1],
                'guard_name' => 'admin-web',
                'created_at' => $fields[4],
                'updated_at' => $fields[5],
            ];
        }

        if (!empty($rows)) {
            DB::table('permissions')->insert($rows);
        }
    }

    private function grantAdminAllPermissions(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = 'admin-web';

        $role = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => $guard,
        ]);

        $permissions = Permission::query()->where('guard_name', $guard)->get();
        if ($permissions->isNotEmpty()) {
            $role->syncPermissions($permissions);
        }

        $user = User::where('email', 'info@admin.com')->first();
        if ($user) {
            $user->role_name = 'Admin';
            $user->save();
            $user->syncRoles([$role->name]);
        }
    }
}
