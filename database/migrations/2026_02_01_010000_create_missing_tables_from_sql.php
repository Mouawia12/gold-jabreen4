<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        $currentSqlMode = DB::selectOne('SELECT @@SESSION.sql_mode AS sql_mode');
        DB::statement("SET SESSION sql_mode='NO_ENGINE_SUBSTITUTION'");

        DB::unprepared(<<<'SQL'
CREATE TABLE IF NOT EXISTS `catch_gold_recipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `docNumber` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `payment_type` int(11) NOT NULL,
  `from_account` int(11) NOT NULL,
  `to_account` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `gold21` decimal(10,2) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `catch_gold_recipts_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `weight` decimal(10,2) NOT NULL,
  `weight21` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `catch_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `company_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `company_id` int(11) NOT NULL,
  `paid_money` double NOT NULL,
  `debit_money` double NOT NULL,
  `credit_money` double NOT NULL,
  `paid_gold` double NOT NULL,
  `debit_gold` decimal(10,2) NOT NULL,
  `credit_gold` decimal(10,2) NOT NULL,
  `date` varchar(191) NOT NULL,
  `invoice_type` varchar(191) NOT NULL,
  `bill_id` double NOT NULL,
  `bill_number` varchar(191) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enter_money` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `doc_number` varchar(191) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `based_on` int(11) NOT NULL,
  `based_on_bill_number` varchar(191) DEFAULT '',
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enter_olds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `bill_type` smallint(6) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(12,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(12,2) NOT NULL,
  `remain_money` decimal(12,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(12,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT NULL,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enter_old_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(12,2) NOT NULL,
  `weight21` decimal(12,2) NOT NULL,
  `gram_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `made_money` decimal(12,2) NOT NULL,
  `net_weight` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL,
  `net_money` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enter_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `bill_type` smallint(6) NOT NULL,
  `supplier_bill_number` varchar(191) DEFAULT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(12,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(12,2) NOT NULL,
  `remain_money` decimal(12,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `made_total` decimal(12,0) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(12,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `enter_work_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `weight21` decimal(8,2) NOT NULL,
  `made_money` decimal(12,2) NOT NULL,
  `made_value` decimal(12,0) NOT NULL,
  `net_weight` decimal(12,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `net_money` decimal(12,2) NOT NULL,
  `returned_weight` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exchange_rates` (
  `id` int(11) NOT NULL,
  `conversion_rates` double(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS `exit_money` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `doc_number` varchar(191) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `based_on` int(11) NOT NULL,
  `based_on_bill_number` varchar(191) DEFAULT '',
  `type` int(11) DEFAULT NULL,
  `price_gram` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_olds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `bill_type` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) NOT NULL DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_olds_tax` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `bill_type` smallint(6) NOT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `client_tax_number` varchar(100) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) NOT NULL DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_old_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(10,2) DEFAULT 0.00,
  `weight21` decimal(8,2) NOT NULL,
  `made_money` decimal(8,2) NOT NULL,
  `net_weight` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(10,2) DEFAULT 0.00,
  `gram_tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_old_tax_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(10,2) DEFAULT 0.00,
  `weight21` decimal(8,2) NOT NULL,
  `made_money` decimal(8,2) NOT NULL,
  `net_weight` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(10,2) DEFAULT 0.00,
  `gram_tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_phone` varchar(50) DEFAULT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `qr` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_works_tax` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `type` int(11) DEFAULT 0,
  `client_id` int(11) NOT NULL,
  `client_tax_number` varchar(100) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `total21_gold` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text DEFAULT NULL,
  `qr` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_work_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(8,2) NOT NULL,
  `gram_tax` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `exit_work_tax_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(8,2) NOT NULL,
  `gram_tax` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `account_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `gold_converts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `doc_number` varchar(191) NOT NULL,
  `total21weight` decimal(8,2) NOT NULL,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `gold_convert_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `docId` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `weight21` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `isroles` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(100) NOT NULL,
  `name_en` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `category_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `no_metal` decimal(8,2) NOT NULL DEFAULT 0.00,
  `no_metal_type` int(11) NOT NULL,
  `made_Value` decimal(8,2) DEFAULT 0.00,
  `item_type` int(11) NOT NULL,
  `tax` decimal(8,2) DEFAULT 0.00,
  `price` decimal(20,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(20,2) NOT NULL DEFAULT 0.00,
  `multi` tinyint(4) DEFAULT 0,
  `supplier_id` smallint(6) DEFAULT NULL,
  `supplier_bill_number` varchar(100) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT 1,
  `img` varchar(191) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `items_collectibles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `category_id` int(11) NOT NULL,
  `karat_id` int(11) DEFAULT 0,
  `weight` decimal(8,2) DEFAULT 0.00,
  `no_metal` decimal(8,2) DEFAULT 0.00,
  `no_metal_type` int(11) DEFAULT 0,
  `made_Value` decimal(8,2) DEFAULT 0.00,
  `item_type` int(11) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `stone_type` varchar(255) DEFAULT NULL,
  `stone_purity` varchar(100) DEFAULT NULL,
  `stone_color` varchar(100) DEFAULT NULL,
  `stone_size` varchar(50) DEFAULT NULL,
  `metal_weight` decimal(8,2) DEFAULT NULL,
  `other_properties1` varchar(100) DEFAULT NULL,
  `other_properties2` varchar(100) DEFAULT NULL,
  `other_properties3` varchar(100) DEFAULT NULL,
  `tax` decimal(8,2) DEFAULT 0.00,
  `price` decimal(20,2) DEFAULT 0.00,
  `cost` decimal(20,2) DEFAULT 0.00,
  `state` int(11) NOT NULL DEFAULT -1,
  `img` varchar(191) DEFAULT NULL,
  `att_file` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `item_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `karats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(255) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `stamp_value` decimal(8,2) DEFAULT 0.00,
  `transform_factor` decimal(8,4) NOT NULL DEFAULT 0.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `notification_wahtsapp` (
  `id` int(11) NOT NULL,
  `bill_number` varchar(50) NOT NULL,
  `client_phone` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `program_settings` (
  `id` int(11) NOT NULL,
  `branche` int(11) NOT NULL,
  `users` int(11) NOT NULL,
  `items` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `purchases_collectibles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(50) NOT NULL,
  `supplier_bill_number` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `purchase_collectible_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `made_money` decimal(8,2) NOT NULL,
  `net_weight` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `return_works` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `role_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `view_id` int(11) NOT NULL,
  `all_auth` int(11) NOT NULL DEFAULT 0,
  `save_auth` int(11) NOT NULL DEFAULT 0,
  `edit_auth` int(11) NOT NULL DEFAULT 0,
  `delete_auth` int(11) NOT NULL DEFAULT 0,
  `preview_auth` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sale_collectibles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `bill_number` varchar(191) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_tax_number` varchar(50) DEFAULT NULL,
  `total_money` decimal(8,2) NOT NULL,
  `paid_money` decimal(8,2) NOT NULL,
  `remain_money` decimal(8,2) NOT NULL,
  `paid_gold` decimal(8,2) NOT NULL,
  `remain_gold` decimal(8,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `net_money` decimal(10,2) NOT NULL DEFAULT 0.00,
  `returned_bill_id` int(11) DEFAULT 0,
  `bill_client_name` varchar(191) DEFAULT '',
  `pos` int(11) DEFAULT 0,
  `notes` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sale_collectibles_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_id` int(11) NOT NULL,
  `karat_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `weight` decimal(8,2) NOT NULL,
  `gram_price` decimal(8,2) NOT NULL,
  `gram_manufacture` decimal(8,2) NOT NULL,
  `gram_tax` decimal(8,2) NOT NULL,
  `net_money` decimal(8,2) NOT NULL,
  `returned` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `simplified_debit` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `total21_gold` decimal(10,2) NOT NULL,
  `paid_money` decimal(10,2) NOT NULL,
  `remain_money` decimal(10,2) NOT NULL,
  `paid_gold` decimal(10,2) NOT NULL,
  `remain_gold` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `qr` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS `simplified_debit_details` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `simplified_detail_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `gram_price` decimal(10,2) NOT NULL,
  `gram_manufacture` decimal(10,2) NOT NULL,
  `gram_tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS `standard_debit` (
  `id` int(11) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `bill_number` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `total21_gold` decimal(10,2) NOT NULL,
  `paid_money` decimal(10,2) NOT NULL,
  `remain_money` decimal(10,2) NOT NULL,
  `paid_gold` decimal(10,2) NOT NULL,
  `remain_gold` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `qr` text DEFAULT NULL,
  `invoice_hash` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS `standard_debit_details` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `standard_detail_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `karat_id` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `gram_price` decimal(10,2) NOT NULL,
  `gram_manufacture` decimal(10,2) NOT NULL,
  `gram_tax` decimal(10,2) NOT NULL,
  `net_money` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS `storehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `code` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `tax_number` varchar(200) DEFAULT '',
  `commercial_registration` varchar(200) DEFAULT '',
  `serial_prefix` varchar(200) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sync_states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tax_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enabled` int(11) NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_stone_type` (
  `id` int(11) NOT NULL,
  `stone_ar` varchar(150) NOT NULL,
  `stone_en` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `route` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `warehouses_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `type` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `enter` decimal(8,2) NOT NULL,
  `out` decimal(8,2) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL
        );

        if ($currentSqlMode && isset($currentSqlMode->sql_mode)) {
            DB::statement("SET SESSION sql_mode='" . $currentSqlMode->sql_mode . "'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::dropIfExists('warehouses_items');
        Schema::dropIfExists('views');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('tbl_stone_type');
        Schema::dropIfExists('tax_settings');
        Schema::dropIfExists('sync_states');
        Schema::dropIfExists('storehouses');
        Schema::dropIfExists('standard_debit_details');
        Schema::dropIfExists('standard_debit');
        Schema::dropIfExists('simplified_debit_details');
        Schema::dropIfExists('simplified_debit');
        Schema::dropIfExists('sale_collectibles_details');
        Schema::dropIfExists('sale_collectibles');
        Schema::dropIfExists('role_views');
        Schema::dropIfExists('role_has_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('return_works');
        Schema::dropIfExists('purchase_collectible_details');
        Schema::dropIfExists('purchases_collectibles');
        Schema::dropIfExists('program_settings');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('notification_wahtsapp');
        Schema::dropIfExists('model_has_roles');
        Schema::dropIfExists('model_has_permissions');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('karats');
        Schema::dropIfExists('item_materials');
        Schema::dropIfExists('items_collectibles');
        Schema::dropIfExists('items');
        Schema::dropIfExists('isroles');
        Schema::dropIfExists('infos');
        Schema::dropIfExists('gold_convert_items');
        Schema::dropIfExists('gold_converts');
        Schema::dropIfExists('expense_types');
        Schema::dropIfExists('exit_work_tax_details');
        Schema::dropIfExists('exit_work_details');
        Schema::dropIfExists('exit_works_tax');
        Schema::dropIfExists('exit_works');
        Schema::dropIfExists('exit_old_tax_details');
        Schema::dropIfExists('exit_old_details');
        Schema::dropIfExists('exit_olds_tax');
        Schema::dropIfExists('exit_olds');
        Schema::dropIfExists('exit_money');
        Schema::dropIfExists('exchange_rates');
        Schema::dropIfExists('enter_work_details');
        Schema::dropIfExists('enter_works');
        Schema::dropIfExists('enter_old_details');
        Schema::dropIfExists('enter_olds');
        Schema::dropIfExists('enter_money');
        Schema::dropIfExists('company_movements');
        Schema::dropIfExists('catch_types');
        Schema::dropIfExists('catch_gold_recipts_details');
        Schema::dropIfExists('catch_gold_recipts');
    }
};
