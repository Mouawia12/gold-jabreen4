<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\HomeController; 
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\AdminController; 
use App\Http\Controllers\Admin\TestController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\KaratController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\StorehouseController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\EnterWorkController;
use App\Http\Controllers\Admin\TaxSettingsController;
use App\Http\Controllers\Admin\CompanyInfoController;
use App\Http\Controllers\Admin\ExitWorkController;
use App\Http\Controllers\Admin\ExitWorkTaxController;
use App\Http\Controllers\Admin\EnterOldController;
use App\Http\Controllers\Admin\EnterMoneyController;
use App\Http\Controllers\Admin\ExitMoneyController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\PosTaxController;
use App\Http\Controllers\Admin\GoldConvertController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\ExpenseTypeController;
use App\Http\Controllers\Admin\CatchReciptController;
use App\Http\Controllers\Admin\AccountsTreeController;
use App\Http\Controllers\Admin\AccountSettingController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ExitOldController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ItemCollectibleController;
use App\Http\Controllers\Admin\PurchaseCollectibleController;
use App\Http\Controllers\Admin\SimplifiedTaxInvoicePrintController;
use App\Http\Controllers\Admin\SaleCollectibleController; 
use App\Http\Controllers\Admin\AccountingClosingController;
use App\Http\Controllers\Admin\ZataControlle;
use App\Http\Controllers\Admin\SimplifiedDebitController;
use App\Http\Controllers\Admin\StandardDebitController;
use App\Http\Controllers\Admin\CatchGoldReciptController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\ExchangeRateController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::get('/', function () {
        return view('admin.auth.login');
    })->name('index');

// Public Routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('index');
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// *********  admin Routes ******** //
Route::group(
    [
        'namespace' => 'Admin'
    ], function () {
    Auth::routes(
        [
            'verify' => false,
            'register' => false,
        ]
    );

    Route::get( 'admin/login', [LoginController::class, 'showLoginForm' ] )->name('admin.login');
	Route::post( 'admin/login', [LoginController::class, 'login' ] );

});

Route::group(
    ['middleware' => ['auth:admin-web'],
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ], function () {

    Route::get('/',[LoginController::class, 'showLoginForm' ] );
    Route::get('/home',  [HomeController::class, 'index' ])->name('admin.home');
    Route::get('/lock-screen', [HomeController::class, 'lock_screen' ] )->name('admin.lock.screen');
    Route::post('admin/logout', [LoginController::class, 'logout' ] )->name('admin.logout'); 

    Route::get('simplified-tax-invoice', [ZataControlle::class, 'Simplified_Tax_Invoice' ] )->name('admin.zata.simplified.invoice');
    Route::get('/sales/simplified-tax/{invoice}/print', [SimplifiedTaxInvoicePrintController::class, 'print'])
        ->name('admin.sales.simplified_tax.print');
    
    
    // admins Routes
    Route::resource('admins', AdminController::class)->names([
        'index' => 'admin.admins.index',
        'create' => 'admin.admins.create',
        'update' => 'admin.admins.update',
        'destroy' => 'admin.admins.destroy', 
        'edit' => 'admin.admins.edit',
        'store' => 'admin.admins.store',
        'show' => 'admin.admins.show'
    ]); 

 
    Route::post( '/user/delete', [ AdminController::class, 'delete' ] )->name( 'admin.users.delete' );
   
    // admins simplified_debit
    Route::resource('simplified_debit', SimplifiedDebitController::class)->names([
        'index' => 'admin.simplified_debit.index',
        'create' => 'admin.simplified_debit.create',
        'update' => 'admin.simplified_debit.update',
        'destroy' => 'admin.simplified_debit.destroy',
        'edit' => 'admin.simplified_debit.edit',
        'store' => 'admin.simplified_debit.store',
        'show' => 'admin.simplified_debit.show'
    ]); 

    Route::get('/get-simplified-sales/{id}', [SimplifiedDebitController::class, 'get_sales'])->name('get.simplified.sales');
    Route::get('/simplified-dept/{id}', [SimplifiedDebitController::class, 'add_simplified_dept'])->name('add.simplified.dept');
    Route::post('/simplified-dept/{id}', [SimplifiedDebitController::class, 'store_simplified_dept'])->name('store.simplified.dept'); 
    Route::get('/get-simplified-dept-number/{type}/{id}', [SimplifiedDebitController::class, 'get_simplified_debit_no'])->name('get.simplified.debit.no');
    Route::get('/simplified-dept-print/{id}', [SimplifiedDebitController::class, 'print'])->name('simplified.dept.print'); 


     // admins standard_debit
     Route::resource('standard_debit', StandardDebitController::class)->names([
         'index' => 'admin.standard_debit.index',
         'create' => 'admin.standard_debit.create',
         'update' => 'admin.standard_debit.update',
         'destroy' => 'admin.standard_debit.destroy',
         'edit' => 'admin.standard_debit.edit',
         'store' => 'admin.standard_debit.store',
         'show' => 'admin.standard_debit.show'
     ]); 

     Route::get('/get-standard-sales/{id}', [StandardDebitController::class, 'get_sales'])->name('get.standard.sales');
     Route::get('/standard-dept/{id}', [StandardDebitController::class, 'add_standard_dept'])->name('add.standard.dept');
     Route::post('/standard-dept/{id}', [StandardDebitController::class, 'store_standard_dept'])->name('store.standard.dept'); 
     Route::get('/get-standard-dept-number/{type}/{id}', [StandardDebitController::class, 'get_standard_debit_no'])->name('get.standard.debit.no');
     Route::get('/standard-dept-print/{id}', [StandardDebitController::class, 'print'])->name('standard.dept.print'); 
    
    Route::post('/remove-selected-admins', [AdminController::class, 'remove_selected' ] )->name('remove.selected.admins');
    Route::get('/print-selected-admins', [AdminController::class, 'print_selected' ] )->name('print.selected.admins');
    Route::post('/export-admins-excel', [AdminController::class, 'export_members_excel' ])->name('export.admins.excel');

    // adminProfile Routes
    Route::get('profile/edit/{id}',  [AdminController::class, 'edit_profile' ] )->name('admin.profile.edit');
    Route::patch('profile/update/{id}', [AdminController::class, 'update_profile' ] )->name('admin.profile.update');

 
   // Inventory Routes
    Route::resource('inventory', InventoryController::class)->names([
        'index' => 'admin.inventory.index',
        'create' => 'admin.inventory.create',
        'edit' => 'admin.inventory.edit',
        'destroy' => 'admin.inventory.destroy', 
    ]); 

    Route::get('/inventory/state/{id}',  [InventoryController::class, 'inventory_state' ] )->name('inventory.state');
    Route::get('/private_inventory',  [InventoryController2::class, 'insert_private_inventory' ] )->name('private_inventory');
    
    Route::post('/updateProduct', [InventoryController::class, 'update_weight_item' ] )->name('admin.inventory.update');
    Route::post('/add-item', [InventoryController::class, 'inventory_weight_item' ] )->name('admin.inventory.add');
    Route::get('/getItemInventory/{branch_id}/{code}', [InventoryController::class, 'getProduct'])->name('getItems');

    // Roles Routes
    Route::resource('roles', RoleController::class)->names([
        'index' => 'admin.roles.index',
        'create' => 'admin.roles.create',
        'update' => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
        'edit' => 'admin.roles.edit',
        'store' => 'admin.roles.store',
    ]);

    // branches Routes
    Route::resource('branches', BranchController::class)->names([
        'index' => 'admin.branches.index',
        'create' => 'admin.branches.create',
        'update' => 'admin.branches.update',
        'destroy' => 'admin.branches.destroy',
        'edit' => 'admin.branches.edit',
        'store' => 'admin.branches.store', 
        'show' => 'admin.branches.show'
    ]);

    // companyInfo Routes
    Route::resource('companyInfo', CompanyInfoController::class)->names([
        'index' => 'admin.companyInfo.index',
        'create' => 'admin.companyInfo.create',
        'update' => 'admin.companyInfo.update',
        'destroy' => 'admin.companyInfo.destroy',
        'edit' => 'admin.companyInfo.edit',
        'store' => 'admin.companyInfo.store', 
        'show' => 'admin.companyInfo.show'
    ]);

    // admins Catch Gold Recipts
    Route::resource('CatchGoldRecipts', CatchGoldReciptController::class)->names([
        'index' => 'admin.CatchGoldRecipts.index',
        'create' => 'admin.CatchGoldRecipts.create',
        'update' => 'admin.CatchGoldRecipts.update',
        'destroy' => 'admin.CatchGoldRecipts.destroy',
        'edit' => 'admin.CatchGoldRecipts.edit',
        'store' => 'admin.CatchGoldRecipts.store',
        'show' => 'admin.CatchGoldRecipts.show'
    ]); 

    Route::get('/get-gold-recipts-no/{branch_id}', [CatchGoldReciptController::class, 'get_gold_recipts_no' ] )->name('get.gold.recipts.no');

    // backup Routes
    Route::resource('backup', BackupController::class)->names([
        'index' => 'admin.backup.index',
        'create' => 'admin.backup.create',
        'update' => 'admin.backup.update',
        'destroy' => 'admin.backup.destroy',
        'edit' => 'admin.backup.edit',
        'store' => 'admin.backup.store', 
        'show' => 'admin.backup.show'
    ]);

    
    // exchange Routes
    Route::resource('exchange', ExchangeRateController::class)->names([
        'index' => 'admin.exchange.index',
        'create' => 'admin.exchange.create',
        'update' => 'admin.exchange.update',
        'destroy' => 'admin.exchange.destroy',
        'edit' => 'admin.exchange.edit',
        'store' => 'admin.exchange.store', 
        'show' => 'admin.exchange.show'
    ]);

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/storeCategory', [CategoryController::class, 'store'])->name('storeCategory');
    Route::get('/deleteCategory/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');
    Route::get('/getCategory/{id}', [CategoryController::class, 'show'])->name('getCategory');

    Route::get('/karats', [KaratController::class, 'index'])->name('karats');
    Route::post('/storeKarat', [KaratController::class, 'store'])->name('storeKarat');
    Route::get('/deleteKarat/{id}', [KaratController::class, 'destroy'])->name('deleteKarat');
    Route::get('/getKarat/{id}', [KaratController::class, 'show'])->name('getKarat');
    Route::get('/getKaratWithOld/{id}', [KaratController::class, 'show_old'])->name('getKaratWithOld');
    Route::get('/getKaratWithPure/{id}', [KaratController::class, 'show_pure'])->name('getKaratWithPure');

    Route::get('/prices', [PricingController::class, 'index'])->name('prices');
    Route::get('/gold-stock-market-prices', [PricingController::class, 'get_gold_stock_market_prices'])->name('gold.stock.market.prices');
    Route::get('/updatePrices', [PricingController::class, 'edit'])->name('updatePrices');
    Route::post('/updatePricesManual', [PricingController::class, 'update'])->name('updatePricesManual'); 
    Route::get('/gold-price-api', [PricingController::class, 'Gold_Price_Api'])->name('gold.price.api');
    Route::get('/exchange_rates_all', [PricingController::class, 'exchange_rates_all'])->name('exchange_rates_all');
    Route::get('/exchange_rates_api/{currency}', [PricingController::class, 'exchange_rates_api'])->name('exchange_rates_api');
    
    Route::get('/items', [ItemController::class, 'index'])->name('items'); 
    Route::get('/item-create', [ItemController::class, 'create'])->name('items.create'); 
    Route::get('/item-edit/{id}', [ItemController::class, 'edit'])->name('items.edit'); 
    Route::post('/storeItem', [ItemController::class, 'store'])->name('storeItem');
    Route::get('/deleteItem/{id}', [ItemController::class, 'destroy'])->name('deleteItem');
    Route::get('/deleteItemCollectibles/{id}', [ItemCollectibleController::class, 'destroy'])->name('deleteItemCollectibles');
    Route::get('/getItem/{id}', [ItemController::class, 'show'])->name('getItem');
    Route::post('/compineItem', [ItemController::class, 'compineItem'])->name('compineItem');
    Route::get('/getParentItem/{id}', [ItemController::class, 'getParentItem'])->name('getParentItem');
    Route::get('/print_barcode', [ItemController::class, 'print_barcode'])->name('print_barcode');
    Route::get('/print_qrcode', [ItemController::class, 'print_qrcode'])->name('print_qrcode');
    Route::post('print_barcode', [ItemController::class, 'do_print_barcode'])->name('preview_barcode');
    Route::post('print_qrcode', [ItemController::class, 'do_print_qr'])->name('preview_qr');
    Route::get('/getItemCode/{type}', [ItemController::class, 'getItemCode'])->name('getItemCode'); 

    Route::get('/printBarcode/{id}', [ItemController::class, 'printBarcode'])->name('printBarcode');
    Route::get('/deleteItemMaterial/{id}', [ItemController::class, 'deleteItemMaterial'])->name('deleteItemMaterial');
    Route::get('/deletePosItemMaterial/{id}', [ItemController::class, 'deletePosItemMaterial'])->name('deletePosItemMaterial');
    
    Route::get('/lost_barcode', [ItemController::class, 'lost_barcode'])->name('lost_barcode');
    Route::get('/lost_barcode_search/{weight}', [ItemController::class, 'lost_barcode_search'])->name('lost_barcode_search');
    Route::get('get-item-table', [ItemController::class, 'get_item_table'])->name('get.item.table');
    
    #items_collectibles
    Route::get('/items-collectibles', [ItemCollectibleController::class, 'index'])->name('items.collectibles');
    Route::post('/storeItem-collectibles', [ItemCollectibleController::class, 'store'])->name('storeItem.collectibles');
    Route::get('/deleteItem-collectibles/{id}', [ItemCollectibleController::class, 'destroy'])->name('deleteItem.collectibles');
    Route::get('/getItem-collectibles/{id}', [ItemCollectibleController::class, 'show'])->name('getItem.collectibles');
    Route::post('/compineItem-collectibles', [ItemCollectibleController::class, 'compineItem'])->name('compineItem.collectibles');
    Route::get('/getParentItem-collectibles/{id}', [ItemCollectibleController::class, 'getParentItem'])->name('getParentItem.collectibles');
    Route::get('/print_barcode-collectibles', [ItemCollectibleController::class, 'print_barcode'])->name('print_barcode.collectibles');
    Route::get('/print_qrcode-collectibles', [ItemCollectibleController::class, 'print_qrcode'])->name('print_qrcode.collectibles');
    Route::post('print_barcode-collectibles', [ItemCollectibleController::class, 'do_print_barcode'])->name('preview_barcode.collectibles');
    Route::post('print_qrcode-collectibles', [ItemCollectibleController::class, 'do_print_qr'])->name('preview_qr.collectibles');
    Route::get('/getItemCode-collectibles', [ItemCollectibleController::class, 'getItemCode'])->name('getItemCode.collectibles');

    Route::get('/printBarcode-collectibles/{id}', [ItemCollectibleController::class, 'printBarcode'])->name('printBarcode.collectibles');
    Route::get('/deleteItemMaterial-collectibles/{id}', [ItemCollectibleController::class, 'deleteItemMaterial'])->name('deleteItemMaterial.collectibles');
    Route::get('/deletePosItemMaterial-collectibles/{id}', [ItemCollectibleController::class, 'deletePosItemMaterial'])->name('deletePosItemMaterial.collectibles');
    
    Route::get('/lost_barcode-collectibles', [ItemCollectibleController::class, 'lost_barcode'])->name('lost_barcode.collectibles');
    Route::get('/lost_barcode_search-collectibles/{weight}', [ItemCollectibleController::class, 'lost_barcode_search'])->name('lost_barcode_search.collectibles');
    Route::get('/getProductCollectible/{code}/{branch_id}', [ItemCollectibleController::class, 'getProduct'])->name('getProductCollectible');

    Route::get('/gold_stock', [WarehouseController::class, 'gold_stock'])->name('gold_stock');

    Route::get('/clients/{type}', [CompanyController::class, 'index'])->name('clients');
    Route::post('storeCompany', [CompanyController::class, 'store'])->name('storeCompany');
    Route::get('/deleteCompany/{id}', [CompanyController::class, 'destroy'])->name('deleteCompany');
    Route::get('/getCompany/{id}', [CompanyController::class, 'edit'])->name('getCompany');
    Route::get('/clientAccount/{id}', [CompanyController::class, 'clientAccount'])->name('clientAccount');

    Route::get('/workEntryAll', [EnterWorkController::class, 'index'])->name('workEntryAll'); 
    Route::get('/workEntryCreate', [EnterWorkController::class, 'create'])->name('workEntryCreate');
    Route::post('storeWorkEntry', [EnterWorkController::class, 'store'])->name('storeWorkEntry');
    Route::get('/get_work_entry_no/{type}/{branch_id}', [EnterWorkController::class, 'get_work_entry_no'])->name('get_work_entry_no');
    Route::get('/workEntryPreview/{id}', [EnterWorkController::class, 'show'])->name('workEntryPreview');
    Route::get('/workEntryDelete/{id}', [EnterWorkController::class, 'destroy'])->name('workEntryDelete');
    Route::get('/workEnterPrint/{id}', [EnterWorkController::class, 'print'])->name('workEnterPrint');
    Route::get('/getSupplierItem/{supplier}/{id}', [EnterWorkController::class, 'getSupplierItem'])->name('getSupplierItem');
    Route::get('/getSupplierKarat/{id}', [EnterWorkController::class, 'getSupplierKarat'])->name('getSupplierKarat');
    Route::get('/getClientSupplierKarat/{supplier}/{bill}/{karat}/{category}', [EnterWorkController::class, 'getClientSupplierKarat'])->name('getClientSupplierKarat');
    Route::get('/getSupplierBill/{id}/{bill}', [EnterWorkController::class, 'getSupplierBill'])->name('getSupplierBill');
    Route::get('/purchase/return', [EnterWorkController::class, 'purchase_return'])->name('purchase.return');
    Route::get('/return-purchase/{id}', [EnterWorkController::class, 'edit'])->name('create.return.purchase');
    Route::post('/return-purchase/{id}', [EnterWorkController::class, 'update'])->name('return.purchase.store');
    Route::get('/get-return-purchase-number/{type}/{id}', [EnterWorkController::class, 'get_return_purchases_no'])->name('get.return.purchase.number');
    

    Route::get('/PurchaseEntryAll', [PurchaseCollectibleController::class, 'index'])->name('Purchase.Entry.All');
    Route::get('/PurchaseEntryCreate', [PurchaseCollectibleController::class, 'create'])->name('Purchase.Entry.Create');
    Route::post('storePurchaseEntry', [PurchaseCollectibleController::class, 'store'])->name('store.Purchase.Entry');
    Route::get('/get-purchase-entry-no/{branch_id}', [PurchaseCollectibleController::class, 'get_work_purchase_no'])->name('get.purchase.entry.no');
    Route::get('/PurchaseEntryPreview/{id}', [PurchaseCollectibleController::class, 'show'])->name('Purchase.Entry.Preview');
    Route::get('/PurchaseEntryDelete/{id}', [PurchaseCollectibleController::class, 'destroy'])->name('Purchase.Entry.Delete');
    Route::get('/PurchaseEnterPrint/{id}', [PurchaseCollectibleController::class, 'print'])->name('Purchase.Enter.Print');

    Route::get('/oldEntryAll', [EnterOldController::class, 'index'])->name('oldEntryAll');
    Route::get('/oldEntryCreate', [EnterOldController::class, 'create'])->name('oldEntryCreate');
    Route::post('storeOldEntry', [EnterOldController::class, 'store'])->name('storeOldEntry');
    Route::get('/get_old_entry_no/{type}/{branch_id}', [EnterOldController::class, 'get_old_entry_no'])->name('get.old.entry.no');
    Route::get('/oldEntryPreview/{id}', [EnterOldController::class, 'show'])->name('oldEntryPreview');
    Route::get('/oldEntryDelete/{id}', [EnterOldController::class, 'destroy'])->name('oldEntryDelete');
    Route::get('/oldEnterPrint/{id}', [EnterOldController::class, 'print'])->name('oldEnterPrint');
    Route::get('/purchase-old/return', [EnterOldController::class, 'purchase_return'])->name('purchase.old.return');
    Route::get('/return-purchase-old/{id}', [EnterOldController::class, 'edit'])->name('create.return.purchase.old');
    Route::post('/return-purchase-old/{id}', [EnterOldController::class, 'update'])->name('return.purchase.old.store');
    Route::get('/get-return-purchase-old-number/{type}/{id}', [EnterOldController::class, 'get_return_purchases_no'])->name('get.return.purchase.old.number');
    

    Route::get('/oldExitAll', [ExitOldController::class, 'index'])->name('oldExitAll');
    Route::get('/oldExitCreate', [ExitOldController::class, 'create'])->name('oldExitCreate');
    Route::post('storeOldExit', [ExitOldController::class, 'store'])->name('storeOldExit');
    Route::get('/get_old_exit_no', [ExitOldController::class, 'get_old_exit_no'])->name('get_old_exit_no');
    Route::get('/oldExitPreview/{id}', [ExitOldController::class, 'print'])->name('oldExitPreview');
    Route::get('/oldExitTaxPreview/{id}', [ExitOldController::class, 'print_tax'])->name('oldExitTaxPreview');
    Route::get('/oldExitDelete/{id}', [ExitOldController::class, 'destroy'])->name('oldExitDelete');
    Route::get('/oldExitPrint/{id}', [ExitOldController::class, 'print'])->name('oldExitPrint');

    Route::get('/workExitAll', [ ExitWorkController::class, 'index'])->name('workExitAll');
    Route::get('/workExitCreate', [ExitWorkController::class, 'create'])->name('workExitCreate');
    Route::post('storeWorkExit', [ExitWorkController::class, 'store'])->name('storeWorkExit');
    Route::get('/get_work_exit_no', [ExitWorkController::class, 'get_work_exit_no'])->name('get_work_exit_no');
    Route::get('/getProduct/{code}/{branch_id}', [ItemController::class, 'getProduct'])->name('getProduct');
    Route::get('/getKaratPrice/{id}', [ExitWorkController::class, 'getKaratPrice'])->name('getKaratPrice');
    

    Route::get('/workExitPrint/{id}', [ExitWorkController::class, 'print'])->name('workExitPrint');
    Route::get('/workQrcode/{id}', [ExitWorkController::class, 'Qrcode'])->name('workQrcode');
    
   
    Route::get('/money_entry_list', [EnterMoneyController::class, 'index'])->name('money_entry_list');
    Route::get('/money_entry_create', [EnterMoneyController::class, 'create'])->name('money_entry_create');
    Route::post('storeMoneyEnter', [EnterMoneyController::class, 'store'])->name('storeMoneyEnter');
    Route::get('/getClientExitWorks/{id}/{branch_id}', [EnterMoneyController::class, 'getClientExitWorks'])->name('getClientExitWorks');
    Route::get('/enterMoneyPreview/{id}', [EnterMoneyController::class, 'show'])->name('enterMoneyPreview');
    Route::get('/enterMoneyDestroy/{id}', [EnterMoneyController::class, 'destroy'])->name('enterMoneyDestroy');
    Route::get('/get-enter-mony-no/{type}/{branch_id}', [EnterMoneyController::class, 'getBillNo'])->name('get.enter.mony.no');
    

    Route::get('/money_exit_list', [ExitMoneyController::class, 'index'])->name('money_exit_list');
    Route::get('/money_exit_create', [ExitMoneyController::class, 'create'])->name('money_exit_create');
    Route::post('storeMoneyExit', [ExitMoneyController::class, 'store'])->name('storeMoneyExit');
    Route::get('/exitMoneyPreview/{id}/{type}', [ExitMoneyController::class, 'show'])->name('exitMoneyPreview');
    Route::get('/exitMoneyDestroy/{id}', [ExitMoneyController::class, 'destroy'])->name('exitMoneyDestroy');
    Route::get('/getClientSupplier/{type}', [ExitMoneyController::class, 'getClientSupplier'])->name('getClientSupplier');
    Route::get('/getClientSupplierWorks/{id}/{type}/{branch_id}', [ExitMoneyController::class, 'getClientSupplierWorks'])->name('getClientSupplierWorks');
    Route::get('/getClientDocumentdata/{id}/{type}', [ExitMoneyController::class, 'getClientDocumentdata'])->name('getClientDocumentdata');
    Route::get('/get-exit-mony-no/{type}/{branch_id}', [ExitMoneyController::class, 'getBillNo'])->name('get.exit.mony.no');

    Route::get('/warehouses', [StorehouseController::class, 'index'])->name('warehouses');
    Route::post('/storeWarehouse', [StorehouseController::class, 'store'])->name('storeWarehouse');
    Route::get('/deleteWarehouse/{id}', [StorehouseController::class, 'destroy'])->name('deleteWarehouse');
    Route::get('/getWarehouse/{id}', [StorehouseController::class, 'show'])->name('getWarehouse');

    Route::get('/pos', [PosController::class, 'create'])->name('pos');
    Route::post('/store_pos', [PosController::class, 'store'])->name('store_pos');
 
    Route::post('/posPayment', [PosController::class, 'posPayment'])->name('posPayment');
    Route::get('/pos_payment_show/{id}/{type}', [PosController::class, 'pos_payment_show'])->name('pos_payment_show');
    Route::get('/pos_sales', [PosController::class, 'index'])->name('pos_sales');
    Route::get('/pos_purchase', [PosController::class, 'pos_purchase'])->name('pos_purchase');
    Route::get('/return_work/{id}', [PosController::class, 'return_work'])->name('return_work');
    Route::post('/return_work_post', [PosController::class, 'return_work_post'])->name('return_work_post');
    Route::get('/return_sales', [PosController::class, 'return_sales'])->name('return_sales');
    Route::get('/workReturnPreview/{id}', [PosController::class, 'workReturnPreview'])->name('workReturnPreview');
    Route::get('/workReturnPrint/{id}', [PosController::class, 'workReturnPrint'])->name('workReturnPrint');
    Route::get('/workExitPreview/{id}', [PosController::class, 'print'])->name('workExitPreview');
    Route::get('/send-invoice-whatsapp/{id}', [PosController::class, 'send_invoice_whatsapp'])->name('send.invoice.whatsapp');
    Route::get('/return_old/{id}', [PosController::class, 'return_old'])->name('return_old');
    Route::post('/return_old_post', [PosController::class, 'return_old_post'])->name('return_old_post');
    Route::get('/oldReturnPreview/{id}', [PosController::class, 'oldReturnPreview'])->name('oldReturnPreview');
    Route::get('/oldReturnPrint/{id}', [PosController::class, 'oldReturnPrint'])->name('oldReturnPrint'); 
    Route::get('/get_sales_pos_no/{type}/{invoice}/{branch_id}', [PosController::class, 'get_sales_pos_no'])->name('get_sales_pos_no');
    
    #postax  
    Route::get('/pos-tax-create', [PosTaxController::class, 'pos_create'])->name('pos_tax_create');
    Route::get('/pos-tax-create-gold-recipts/{id}', [PosTaxController::class, 'pos_create_gold_recipts'])->name('pos.create.gold.recipts');
    Route::post('/store_pos_tax', [PosTaxController::class, 'store_pos'])->name('store_pos_tax');
    Route::get('/get_sales_pos_tax_no/{type}/{invoic}/{branch_id}', [PosTaxController::class, 'get_sales_pos_no'])->name('get_sales_pos_tax_no');

    Route::post('/posPayment-tax', [PosTaxController::class, 'posPayment'])->name('posPaymentTax');
    Route::get('/pos_tax_payment_show/{id}/{type}', [PosTaxController::class, 'pos_payment_show'])->name('pos_tax_payment_show');
    Route::get('/pos-tax-payment-catch-show/{id}/{type}/{amount}', [PosTaxController::class, 'pos_payment_catch_gold_show'])->name('pos.payment.catch.gold');
    Route::get('/pos_tax_sales', [PosTaxController::class, 'pos_sales'])->name('pos_tax_sales');
    Route::get('/pos_tax_purchase', [PosTaxController::class, 'pos_purchase'])->name('pos_tax_purchase');
    Route::get('/return_work_tax/{id}', [PosTaxController::class, 'return_work'])->name('return_work_tax');
    Route::post('/return_work_post_tax', [PosTaxController::class, 'return_work_post'])->name('return_work_post_tax');
    Route::get('/return_sales_tax', [PosTaxController::class, 'return_sales'])->name('return_sales_tax');
    Route::get('/workReturnPreviewTax/{id}', [PosTaxController::class, 'workReturnPreview'])->name('workReturnPreviewTax');
    Route::get('/workReturnPrintTax/{id}', [PosTaxController::class, 'workReturnPrint'])->name('workReturnPrintTax');
    Route::get('/return_old_tax/{id}', [PosTaxController::class, 'return_old'])->name('return_old_tax');
    Route::post('/return_old_post_tax', [PosTaxController::class, 'return_old_post'])->name('return_old_post_tax');
    Route::get('/oldReturnPreviewTax/{id}', [PosTaxController::class, 'oldReturnPreview'])->name('oldReturnPreviewTax');
    Route::get('/oldReturnPrintTax/{id}', [PosTaxController::class, 'oldReturnPrint'])->name('oldReturnPrintTax');
    Route::get('/workExitPreviewTax/{id}', [PosTaxController::class, 'print'])->name('workExitPreviewTax');
    
    #sale collectible  
    Route::get('/pos-collectible', [SaleCollectibleController::class, 'index'])->name('pos.collectible');
    Route::get('/pos-collectible-create', [SaleCollectibleController::class, 'pos_create'])->name('pos.collectible.create');
    Route::post('/store_pos_collectible', [SaleCollectibleController::class, 'store_pos'])->name('store.pos.collectible');
 
    Route::post('/posPayment-collectible', [SaleCollectibleController::class, 'posPayment'])->name('posPaymentCollectible');
    Route::get('/pos_collectible_payment_show/{id}/{type}', [SaleCollectibleController::class, 'pos_payment_show'])->name('pos_Collectible_payment_show');
    Route::get('/return-pos-collectible/{id}', [SaleCollectibleController::class, 'return_pos'])->name('return.pos.Collectible');
    Route::post('/return-sale-post-collectible', [SaleCollectibleController::class, 'return_sale_post'])->name('return.sale.post.Collectible');
    Route::get('/return-sales-collectible', [SaleCollectibleController::class, 'return_sales'])->name('return.sales.Collectible');
    Route::get('/saleReturnPreviewCollectible/{id}', [SaleCollectibleController::class, 'sale_return_print'])->name('sale.Return.Preview.Collectible');
    Route::get('/workReturnPrintCollectible/{id}', [SaleCollectibleController::class, 'workReturnPrint'])->name('workReturnPrinCollectible');
    Route::get('/return_old_Collectible/{id}', [SaleCollectibleController::class, 'return_old'])->name('return_old_Collectible');
    Route::post('/return_old_post_Collectible', [SaleCollectibleController::class, 'return_old_post'])->name('return_old_post_Collectible');
    Route::get('/oldReturnPreviewCollectible/{id}', [SaleCollectibleController::class, 'oldReturnPreview'])->name('oldReturnPreviewCollectible');
    Route::get('/oldReturnPrintCollectible/{id}', [SaleCollectibleController::class, 'oldReturnPrint'])->name('oldReturnPrintCollectible');
    Route::post('/store_pos_Collectible_purchase', [SaleCollectibleController::class, 'store_pos_purchase'])->name('store_pos_collectible_purchase');
    Route::get('/test_print_Collectible', [SaleCollectibleController::class, 'test_print'])->name('test_print_collectible');
    Route::get('/SalePreview/{id}', [SaleCollectibleController::class, 'print'])->name('Sale.Preview');
    Route::get('/get_sales_pos_collectible_no/{type}/{branch_id}', [SaleCollectibleController::class, 'get_sale_collectible_no'])->name('get_sales_pos_collectible_no');
    Route::get('/get_purchase_pos_no', [EnterWorkController::class, 'get_purchase_pos_no'])->name('get_purchase_pos_no');
   
    Route::get('/item_list_report', [ReportController::class, 'item_list_report'])->name('item_list_report');
    Route::post('/item_list_report', [ReportController::class, 'item_list_report_search'])->name('item_list_report_search');
    Route::get('/item_list_report', [ReportController::class, 'item_list_report'])->name('item_list_report');

    Route::get('/sold_items_report', [ReportController::class, 'sold_items_report'])->name('sold_items_report');
    Route::post('/sold_items_report', [ReportController::class, 'sold_items_report_search'])->name('sold_items_report_search');
    Route::get('/sales_report', [ReportController::class, 'sales_report'])->name('sales_report');
    Route::post('/sales_report', [ReportController::class, 'sales_report_search'])->name('sales_report_search');
    Route::get('/sales-collectible-report', [ReportController::class, 'sales_collectible_report'])->name('sales.collectible.report');
    Route::post('/sales-collectible-report', [ReportController::class, 'sales_collectible_report_search'])->name('sales.collectible.report.search');
    Route::get('/purchase_report', [ReportController::class, 'purchase_report'])->name('purchase_report');
    Route::post('/purchase_report', [ReportController::class, 'purchase_report_search'])->name('purchase_report_search');
    Route::get('/purchase-collectible-report', [ReportController::class, 'purchase_collectible_report'])->name('purchase.collectible.report');
    Route::post('/purchase-collectible-report', [ReportController::class, 'purchase_collectible_report_search'])->name('purchase.collectible.report.search');
    Route::get('/vendor_account', [ReportController::class, 'vendor_account'])->name('vendor_account');
    Route::post('/vendor_account', [ReportController::class, 'vendor_account_search'])->name('vendor_account_search');
    Route::get('/gold_stock_report', [ReportController::class, 'gold_stock_report'])->name('gold_stock_report');
    Route::post('/gold_stock_report', [ReportController::class, 'gold_stock_search'])->name('gold_stock_search');
    Route::get('/daily_all_movements', [ReportController::class, 'daily_all_movements'])->name('daily_all_movements');
    Route::post('/daily_all_movements', [ReportController::class, 'daily_all_movements_search'])->name('daily_all_movements_search');
    Route::get('/box_movement_report', [ReportController::class, 'box_movement_report'])->name('box_movement_report');
    Route::post('/box_movement_report', [ReportController::class, 'box_movement_report_search'])->name('box_movement_report_search');
    Route::get('/bank_movement_report', [ReportController::class, 'bank_movement_report'])->name('bank_movement_report');
    Route::post('/bank_movement_report', [ReportController::class, 'bank_movement_report_search'])->name('bank_movement_report_search');
    Route::get('/sales_total_report', [ReportController::class, 'sales_total_report'])->name('sales_total_report');
    Route::post('/sales_total_report', [ReportController::class, 'sales_total_report_search'])->name('sales_total_report_search');
    Route::get('/sales-collectible-total-report', [ReportController::class, 'sales_collectible_total_report'])->name('sales.collectible.total.report');
    Route::post('/sales-collectible-total-report', [ReportController::class, 'sales_collectible_total_report_search'])->name('sales.collectible.total.report.search');
    Route::get('/purchase_total_report', [ReportController::class, 'purchase_total_report'])->name('purchase_total_report');
    Route::post('/purchase_total_report', [ReportController::class, 'purchase_total_report_search'])->name('purchase_total_report_search');
    Route::get('/purchase-collectible-total-report', [ReportController::class, 'purchase_collectible_total_report'])->name('purchase.collectible.total.report');
    Route::post('/purchase-collectible-total-report', [ReportController::class, 'purchase_collectible_total_report_search'])->name('purchase.collectible.total.report.search');
    Route::get('/purchase_sales_total_report', [ReportController::class, 'purchase_sales_total_report'])->name('purchase_sales_total_report');
    Route::post('/purchase_sales_total_report', [ReportController::class, 'purchase_sales_total_report_search'])->name('purchase_sales_total_report_search');
    Route::get('/movement_report', [ReportController::class, 'movement_report'])->name('movement_report');
    Route::post('/movement_report', [ReportController::class, 'movement_report_search'])->name('movement_report_search');

    Route::get('/account_movement_report', [ReportController::class, 'account_movement_report'])->name('account_movement_report');
    Route::post('/account_movement_report', [ReportController::class, 'account_movement_report_search'])->name('account_movement_report_search');
    Route::get('/account_company_report_search/{id}', [ReportController::class, 'account_company_report_search'])->name('account.company.report.search');
    Route::get('/account-companies-details-public/{id}', [ReportController::class, 'account_companies_details_public'])->name('account.companies.details.public');
    
    Route::get('/account_companies_details_report', [ReportController::class, 'account_companies_details_report'])->name('account_companies_details_report');
    Route::post('/account_companies_details_report', [ReportController::class, 'account_companies_details_search'])->name('account_companies_details_search');
    
    Route::get('/reports/account_balance', [ReportController::class, 'account_balance'])->name('account_balance');
    Route::post('/reports/account_balance', [ReportController::class, 'account_balance_search'])->name('search_account_balance');
    
    Route::get('/reports/tax-declaration', [ReportController::class, 'tax_declaration'])->name('tax.declaration');
    Route::post('/reports/tax-declaration-result', [ReportController::class, 'tax_declaration_report_search'])->name('tax.declaration.result');

    Route::get('/reports/inventory/{id}', [ReportController::class, 'inventory_report'])->name('inventory.report');

    Route::get('/purchase-return-report', [ReportController::class, 'purchaseReturnReport'])->name('purchase.return.report');
    Route::post('/purchase-return-report', [ReportController::class, 'purchaseReturnReportSearch'])->name('purchase.return.search.report');
    
    Route::get('/sales-return-report', [ReportController::class, 'salesReturnReport'])->name('sales.return.report');
    Route::post('/sales-return-report', [ReportController::class, 'salesReturnReportSearch'])->name('sales.return.search.report');
    
    Route::get('/accounts', [AccountsTreeController::class, 'index'])->name('accounts_list');
    Route::get('/accounts_tree', [AccountsTreeController::class, 'index2'])->name('accounts_tree');

    Route::get('/accounts/create', [AccountsTreeController::class, 'create'])->name('create_account');
    Route::post('/accounts/create', [AccountsTreeController::class, 'store'])->name('store_account');
    Route::get('/accounts/get_level/{parent}', [AccountsTreeController::class, 'getLevel'])->name('get_account_level');
    Route::get('/accounts/edit/{id}', [AccountsTreeController::class, 'edit'])->name('edit_account');
    Route::post('/accounts/edit/{id}', [AccountsTreeController::class, 'update'])->name('update_account');
    Route::get('/accounts/delete/{id}', [AccountsTreeController::class, 'destroy'])->name('delete_account');
    Route::get('/accounts/journals/{type}', [AccountsTreeController::class, 'journals'])->name('journals');
    Route::get('/accounts/journals/preview/{id}', [AccountsTreeController::class, 'previewJournal'])->name('preview_journal');
    Route::post('/accounts/journals_search', [AccountsTreeController::class, 'journals_search'])->name('journals_search');
    Route::get('/accounts/movements/preview/{id}', [AccountsTreeController::class, 'previewMovements'])->name('preview.movements');
    Route::get('/accounts/journals-manual', [AccountsTreeController::class, 'journals_manual'])->name('journals.manual');
    Route::get('/accounts/journals-movment', [AccountsTreeController::class, 'journals_movment'])->name('journals.movment');
    
    Route::get('/account_settings', [AccountSettingController::class, 'index'])->name('account_settings_list');
    Route::get('/account_settings/create', [AccountSettingController::class, 'create'])->name('create_account_settings');
    Route::post('/account_settings/create', [AccountSettingController::class, 'store'])->name('store_account_settings');
    Route::get('/account_settings/edit/{id}', [AccountSettingController::class, 'edit'])->name('edit_account_settings');
    Route::post('/account_settings/edit/{id}', [AccountSettingController::class, 'update'])->name('update_account_settings');
    Route::get('/account_settings/delete/{id}', [AccountSettingController::class, 'destroy'])->name('delete_account_settings');
    Route::get('/accounts/journals/{type}', [AccountsTreeController::class, 'journals'])->name('journals');
    Route::get('/accounts/journals/preview/{id}', [AccountsTreeController::class, 'previewJournal'])->name('preview_journal');
    Route::post('/accounts/journals_search', [AccountsTreeController::class, 'journals_search'])->name('journals_search');

    Route::get('/accounts/manual', [JournalController::class, 'create'])->name('manual_journal');
    Route::post('/accounts/manual', [JournalController::class, 'store'])->name('store_manual');
    Route::get('/getAccounts/{code}', [AccountsTreeController::class, 'getAccount'])->name('getAccounts');
    Route::get('/journals/delete/{id}', [JournalController::class, 'delete'])->name('delete_journal');
    Route::get('manual_number', [JournalController::class, 'manual_number'])->name('manual_number');
    Route::get('/accounts/manual-basic/create', [JournalController::class, 'create_basic'])->name('manual.journal.basic');
    Route::post('/accounts/manual-basic/store', [JournalController::class, 'store_basic'])->name('store.manual.basic');

    Route::get('/incoming_list', [JournalController::class, 'incoming_list'])->name('incoming_list');
    Route::post('/search_incoming_list', [JournalController::class, 'search_incoming_list'])->name('search_incoming_list');
    
	Route::get('/incoming_list_new', [JournalController::class, 'incoming_list_new'])->name('incoming_list_new');
    Route::post('/search_incoming_list_new', [JournalController::class, 'search_incoming_list_new'])->name('search_incoming_list_new');

    Route::get('/balance_sheet', [JournalController::class, 'balance_sheet'])->name('balance_sheet');
    Route::post('/search_balance_sheet', [JournalController::class, 'search_balance_sheet'])->name('search_balance_sheet');

    Route::get('/tax_settings', [TaxSettingsController::class, 'index'])->name('tax_settings');
    Route::post('/storeTax', [TaxSettingsController::class, 'store'])->name('storeTax');

    Route::get('/fixItems', [ItemController::class, 'fixItems'])->name('fixItems');
 
    Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses'); 
    Route::post('/storeExpense', [ExpensesController::class, 'store'])->name('storeExpense');
    Route::get('/getExpense/{id}', [ExpensesController::class, 'show'])->name('getExpense');
    Route::get('/printExpense/{id}', [ExpensesController::class, 'print'])->name('printExpense');
    Route::get('/get-expenses-no/{branch_id}', [ExpensesController::class, 'get_expense_no'])->name('get.expenses.no');

    Route::get('/catches', [CatchReciptController::class, 'index'])->name('catches'); 
    Route::post('/storeCatch', [CatchReciptController::class, 'store'])->name('storeCatch');
    Route::get('/getCatch/{id}', [CatchReciptController::class, 'show'])->name('getCatch');
    Route::get('/getSupplierAccount/{id}', [CatchReciptController::class, 'getSupplierAccount'])->name('getSupplierAccount');
    Route::get('/catche_destroy/{id}', [CatchReciptController::class, 'destroy'])->name('catche_destroy');
    Route::get('/printCatch/{id}', [CatchReciptController::class, 'print'])->name('printCatch');
    Route::get('/get-catch-recipt-no/{branch_id}', [CatchReciptController::class, 'get_Catch_no'])->name('get.catch.recipt.no');

    Route::get('/expenses_type/{id}', [ExpenseTypeController::class, 'index'])->name('expenses_type');
    Route::post('/storeExpensType', [ExpenseTypeController::class, 'store'])->name('storeExpensType');
    Route::get('/expenses_type_destroy/{id}', [ExpenseTypeController::class, 'destroy'])->name('expenses_type_destroy');
    Route::get('/getExpenseType/{id}', [ExpenseTypeController::class, 'show'])->name('getExpenseType');

    Route::get('/insert_enter_work', [EnterWorkController2::class, 'insert_enter_work_privet']);
    Route::get('/insert_enter_old', [EnterOldController2::class, 'insert_old_work_privet']);
    Route::get('/insert_exit_work', [PosController2::class, 'insert_exit_work_privet']);
    Route::get('/insert_Exit_Money_privet', [ExitMoneyController2::class, 'insert_Exit_Money_privet']);
    Route::get('/insert_enter_Money_privet', [EnterMoneyController2::class, 'insert_enter_Money_privet']);
    Route::get('/insert_enter_movment_Money_privet', [EnterMoneyController2::class, 'insert_enter_movment_Money_privet']);
    
    Route::get( '/add-permission', 'PermissionController@add');
    Route::post( '/create-permission', 'PermissionController@create')->name('permission.create');
    Route::get('/test', [TestController::class, 'test']);
    Route::get('/pdf', [TestController::class, 'generatePdf']);
    Route::get('/test-pdf', [TestController::class, 'TestPdf']);

    //ClosingYear
    Route::get('/year-closing', [AccountingClosingController::class, 'ClosingYear'])->name('Closing.Year');
    
    Route::get('/fix-enter-journal', [TestController::class, 'fixEnterJournal']);
    Route::get('/fix-old-journal', [TestController::class, 'fixOldJournal']);
});
});
