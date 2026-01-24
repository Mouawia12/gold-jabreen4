 <!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <style type="text/css">
        ::-webkit-scrollbar {width: 7px !important;}
        ::-webkit-scrollbar-track {background: #eee !important;}
        ::-webkit-scrollbar-thumb {background: #949eb7 !important;}
	    ::-webkit-scrollbar {width: 7px !important;}
        ::-webkit-scrollbar-track {background: #eee !important;}
        ::-webkit-scrollbar-thumb {background: #949eb7 !important;}
	    .main-sidemenu{margin-top:10px !important; height:98% !important;}
	    .app-sidebar{width:260px;}
	    .app-sidebar__user{padding-bottom:20px;}
	    .side-menu__label{color:#666;font-size:13px;font-weight:600;padding-top:5%;}
        .main-header {height: 50px !important;}
        .main-profile-menu.show .dropdown-menu {top: 50px !important;}
        .app-sidebar__user .user-pro-body img{
            width:150px !important;
            height:auto !important;
        }
    </style>
    
    <div class="main-sidemenu" style="overflow: auto!important;" id="right">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <a href="{{route('admin.home')}}">
                    <div class="">
                        <img alt="user-img" class="avatar avatar-xl brround ht-300"
                             src="{{URL::asset('assets/img/logo.png')}}">  
                    </div>  
                </a> 
            </div>
        </div> 
        <ul class="side-menu" style="padding-bottom: 50px !important;" id="main-menu-navigation"
            data-menu="menu-navigation">
            <li class="slide {{ Request::is('home*') ? 'active' : '' }}">
                <a class="side-menu__item" href="{{ url('/admin/' . $page='home') }}"> 
                    <i class="fa fa-home side-menu__icon"></i>
                    <span class="side-menu__label"> الرئيسية </span>
                </a>
            </li>       
           
            @can('عرض فاتورة ضريبية')                
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-newspaper side-menu__icon"></i>
                        <span class="side-menu__label">
                            {{__('المبيعات الضريبية المبسطة')}}
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                    @can('اضافة فاتورة ضريبية')    
                        <li>
                            <a class="slide-item" href="{{route('pos')}}">
                            {{__('فاتورة جديدة')}}
                            </a>
                        </li> 
                    @endcan  
                    @can('عرض فاتورة ضريبية')  
                        <li>
                            <a class="slide-item" href="{{route('pos_sales')}}">
                            {{__(' قائمة المبيعات')}}
                            </a>
                        </li> 
                    @endcan   

                    @can(['اضافة مرتجع فاتورة مبيعات','عرض مرتجع فاتورة مبيعات'])                           
                        <li>
                            <a class="slide-item" href="{{route('return_sales')}}">
                            {{__('main.return_sales')}}
                            </a>
                        </li> 
                    @endcan                                                     
                    </ul>
                </li> 
            @endcan  
            @can('عرض فاتورة ضريبية')                
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-newspaper side-menu__icon"></i>
                        <span class="side-menu__label">
                       المبيعات الضريبية الشركات
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                    @can('اضافة فاتورة ضريبية')    
                        <li>
                            <a class="slide-item" href="{{route('pos_tax_create')}}">
                               اضافة فاتورة    
                            </a>
                        </li> 
                    @endcan  
                    @can('عرض فاتورة ضريبية')  
                        <li>
                            <a class="slide-item" href="{{route('pos_tax_sales')}}">
                                المبيعات الضريبية للشركات
                            </a>
                        </li> 
                    @endcan  
                    @can(['اضافة مرتجع فاتورة مبيعات','عرض مرتجع فاتورة مبيعات'])                           
                        <li>
                            <a class="slide-item" href="{{route('return_sales_tax')}}">
                              مردود مبيعات شركات 
                            </a>
                        </li> 
                    @endcan                                                     
                    </ul>
                </li> 
            @endcan    
            @can('عرض فاتورة ضريبية')                
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-newspaper side-menu__icon"></i>
                        <span class="side-menu__label">
                      مبيعات - المقتنيات الثمينة
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                    @can('اضافة فاتورة ضريبية')    
                        <li>
                            <a class="slide-item" href="{{route('pos.collectible.create')}}">
                               اضافة فاتورة    
                            </a>
                        </li> 
                    @endcan  
                    @can('عرض فاتورة ضريبية')  
                        <li>
                            <a class="slide-item" href="{{route('pos.collectible')}}">
                                مبيعات المقتنيات الثمينة
                            </a>
                        </li> 
                    @endcan  
                    @can(['اضافة مرتجع فاتورة مبيعات','عرض مرتجع فاتورة مبيعات'])                           
                        <li>
                            <a class="slide-item" href="{{route('return.sales.Collectible')}}">
                              مردود مبيعات مقتنيات ثمينة
                            </a>
                        </li> 
                    @endcan                                                     
                    </ul>
                </li> 
            @endcan    
            @can('عرض فاتورة مشتريات')           
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-fw fa-folder-open side-menu__icon"></i>
                        <span class="side-menu__label">
                            المشتريات
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('workEntryAll')}}">
                             مشتريات الذهب المشغول 
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('oldEntryAll')}}">
                            {{__('مشتريات الكسر / الصافي ')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('Purchase.Entry.All')}}">
                             مشتريات - مقتنيات ثمينة
                            </a>
                        </li>    
                    </ul>
                </li> 
            @endcan   
            @can('عرض مردود مشتريات')                 
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-fw fa-folder-open side-menu__icon"></i>
                        <span class="side-menu__label">
                            مردود المشتريات
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('purchase.return')}}">
                             مردود مشتريات الذهب المشغول 
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('purchase.old.return')}}">
                            {{__('مردود مشتريات الكسر / الصافي ')}}
                            </a>
                        </li>   
                    </ul>
                </li> 
            @endcan   
            @can('عرض صنف')
                 <!-- Nav Item - Pages Collapse Menu -->
                 <li class="slide">

                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa fa-barcode side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('main.items')}}
                        </span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        @can('اضافة صنف')
                        <li>
                            <a class="slide-item" href="{{route('items.create')}}">
                            {{__('اضافة صنف جديد')}}
                            </a>
                        </li> 
                        @endcan
                        <li>
                            <a class="slide-item" href="{{route('items')}}">
                            {{__('main.item_list')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('categories')}}">
                            {{__('مجموعات الاصناف')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('items.collectibles')}}">
                            اصناف المقتنيات الثمينة
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('lost_barcode')}}">
                            {{__('main.lost_barcode')}}
                            </a>
                        </li>  
                    </ul>
                </li> 
            @endcan  
            @can('عرض المخزون') 
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-pie-chart side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('رصيد الذهب')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('gold_stock')}}">
                            {{__('ميزان ارصدة الذهب')}}
                            </a>
                        </li>  
                    </ul>
                </li> 
            @endcan  
            @can(['اضافة اسعار الذهب','عرض اسعار الذهب'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-gem side-menu__icon"></i>  
                        <span class="side-menu__label">
                        {{__('اسعار الذهب')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu"> 
                        <li>
                            <a class="slide-item" href="{{route('prices')}}">
                            {{__('main.prices')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('gold.stock.market.prices')}}">
                            {{__('اسعار بورصة الذهب')}}
                            </a>
                        </li> 
                    </ul> 
                </li> 
            @endcan   
            @can(['عرض اشعار مدين مبسطة','عرض اشعار مدين ضريبية'])  
       
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-credit-card side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('اشعارات الفواتير')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li> 
                            <a class="slide-item" href="{{ route('admin.simplified_debit.show',0) }}">
                            {{__('اشعار مدين لفاتورة مبسطة')}}
                            </a>
                        </li>  
                        <li> 
                            <a class="slide-item" href="{{ route('admin.standard_debit.show',0) }}">
                            {{__(' اشعار مدين لفاتورة ضريبية')}}
                            </a>
                        </li>   
                                               
                    </ul>
                </li>  
          
            @endcan    
            @can('عرض مورد') 
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-user-plus side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('الموردين')}}
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('clients' , 4)}}">
                            {{__('main.suppliers')}}
                            </a>
                        </li>  
                    </ul>
                </li>
            @endcan  
            @can('عرض عميل')                  
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-user side-menu__icon"></i>
                        <span class="side-menu__label">
                            {{__('main.clients')}} 
                        </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('clients' , 3)}}">
                            {{__('main.clients')}}
                            </a>
                        </li>  
                    </ul>
                </li>  
            @endcan  

            @can(['عرض دفتر خروج النقدية','عرض دفتر دخول النقدية'])        
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-money-bill side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('النقدية')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('money_exit_list')}}">
                            {{__('main.money_exit_list')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('money_entry_list')}}">
                            {{__('main.money_entry_list')}}
                            </a>
                        </li>                             
                    </ul>
                </li>  
            @endcan 
            @can(['اضافة سند صرف','عرض سند صرف'])  
                            
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-credit-card side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('main.expenses')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('expenses')}}">
                            {{__('main.expenses_list')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('expenses_type' , 0)}}">
                            {{__('main.expenses_type')}}
                            </a>
                        </li>   
                                               
                    </ul>
                </li>  
            @endcan  
            @can(['اضافة سند قبض','عرض سند قبض'])     
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-credit-card side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('main.catches')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('catches')}}">
                            {{__('main.catches_list')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('admin.CatchGoldRecipts.index')}}">
                            {{__('سند قبض نقد وذهب')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('expenses_type' , 1)}}">
                            {{__('main.catches_type')}}
                            </a>
                        </li>   
                                               
                    </ul>
                </li> 
            @endcan   
            @can(['اضافة نسخة احتياطية','عرض نسخة احتياطية'])     
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-database side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('النسخ الاحتياطية')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('admin.backup.index')}}">
                            {{__('النسخ الاحتياطية')}}
                            </a>
                        </li>   
                                               
                    </ul>
                </li> 
            @endcan  
            @can('عرض جرد')               
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-newspaper side-menu__icon"></i>
                        <span class="side-menu__label">
                           قائمة الجرد
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">    
                    @can('اضافة جرد')  
                        <li>
                            <a class="slide-item" href="{{route('admin.inventory.create')}}">
                                جرد جديد
                            </a>
                        </li>  
                    @endcan   
                        <li>
                            <a class="slide-item" href="{{route('admin.inventory.index')}}">
                               محاضر الجرد
                            </a>
                        </li>                                          
                    </ul>
                </li> 
            @endcan  
            @can(['اضافة حسابات','عرض حسابات','تعديل حسابات','حذف الحسابات'])                 
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-usd side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('main.accounting')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('accounts_list')}}">
                             {{__('main.accounts')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('account_settings_list')}}">
                            {{__('main.account_settings')}}
                            </a>
                        </li>   
                        <li>
                            <a class="slide-item" href="{{route('journals' , 1)}}">
                            {{__('main.journals')}}
                            </a>
                        </li>   
                        <li>
                            <a class="slide-item" href="{{route('journals' , 0)}}">
                            {{__('main.manual_journals')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('manual_journal')}}">
                            {{__('main.manual_journal')}}
                            </a>
                        </li>                                                  
                    </ul>
                </li> 
            @endcan   
            @can('التقارير المخزون')                  
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-copy side-menu__icon"></i>
                        <span class="side-menu__label">
                         تقارير المخزون
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('item_list_report')}}">
                            {{__('main.item_list_report')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('sold_items_report')}}">
                            {{__('main.sold_items_report')}}
                            </a>
                        </li>     
                        <li>
                            <a class="slide-item" href="{{route('sales_report')}}">
                            {{__('main.sales_report')}}
                            </a>
                        </li>   
                        <li>
                            <a class="slide-item" href="{{route('sales.collectible.report')}}">
                                  ت مبيعات مقتنيات تفصيلي
                            </a>
                        </li>    
                        <li>
                            <a class="slide-item" href="{{route('sales_total_report')}}">
                            {{__('main.sales_total_report')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('sales.collectible.total.report')}}">
                                  ت مبيعات مقتنيات اجمالي
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('purchase_report')}}">
                            {{__('main.purchase_report')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('purchase.collectible.report')}}">
                                ت مشتريات ثمينة تفصيلي
                            </a>
                        </li>      
                        <li>
                            <a class="slide-item" href="{{route('purchase_total_report')}}">
                            {{__('main.purchase_total_report')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('purchase.collectible.total.report')}}">
                               ت مشتريات ثمينة اجمالي
                            </a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{route('sales.return.report')}}">
                               مرتجع مبيعات
                            </a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{route('purchase.return.report')}}">
                               مردود المشتريات
                            </a>
                        </li>
                        <li>
                            <a class="slide-item" href="{{route('gold_stock_report')}}">
                            {{__('main.gold_stock_report')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('daily_all_movements')}}">
                            {{__('main.daily_all_movements')}}
                            </a>
                        </li>    
                        <li>
                            <a class="slide-item" href="{{route('box_movement_report')}}">
                            {{__('main.box_movement_report')}}
                            </a>
                        </li>   
                        <li>
                            <a class="slide-item" href="{{route('bank_movement_report')}}">
                            {{__('main.bank_movement_report')}}
                            </a>
                        </li>    
                        <li>
                            <a class="slide-item" href="{{route('vendor_account')}}">
                            {{__('main.vendor_account')}}
                            </a>
                        </li>                     
                    </ul>
                </li>     
            @endcan  
            @can('التقارير المحاسبية')                  
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-copy side-menu__icon"></i>
                        <span class="side-menu__label">
                        التقارير المحاسبية
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">   
                        <li>
                            <a class="slide-item" href="{{route('account_balance')}}">
                            {{__('main.balance_report')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('incoming_list')}}">
                            {{__('main.incoming_list')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('balance_sheet')}}">
                            {{__('main.balance_sheet')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('account_movement_report')}}">
                            {{__('main.account_movement_report')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('account_companies_details_report')}}">
                               تقرير حركة تفصيلي مورد
                            </a>
                        </li>      
                        <li>
                            <a class="slide-item" href="{{route('tax.declaration')}}">
                                الاقرار الضريبي
                            </a>
                        </li>                        
                    </ul>
                </li>     
            @endcan  
            @can(['اضافة الاعدادات','عرض الاعدادات','تعديل الاعدادات','حذف الاعدات'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fas fa-fw fa-cog side-menu__icon"></i>
                        <span class="side-menu__label">
                        {{__('main.basic_data')}}
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a> 
                    <ul class="slide-menu">  
                        <li>
                            <a class="slide-item" href="{{route('warehouses')}}">
                            {{__('main.warehouses')}}
                            </a>
                        </li> 
                        <li>
                            <a class="slide-item" href="{{route('tax_settings')}}">
                            {{__('main.additional_tax')}}
                            </a>
                        </li>  
                        <li>
                            <a class="slide-item" href="{{route('admin.companyInfo.index')}}">
                            {{__('main.companyInfo')}}
                            </a>
                        </li>  
                    </ul> 
                </li> 
            @endcan   
            @can('عرض فرع')   
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-code-branch side-menu__icon"></i>
                        <span class="side-menu__label">
                        الفروع
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        @can('اضافة فرع')
                            <li>
                                <a class="slide-item" href="{{ route('admin.branches.create') }}">
                                    اضافة فرع جديد
                                </a>
                            </li>
                        @endcan
                        @can('عرض فرع')
                            <li>
                                <a class="slide-item" href="{{ route('admin.branches.index') }}">
                                    قائمة الفروع
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan                                                                                  
            @can('عرض صلاحية')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#">
                        <i class="fa fa-users side-menu__icon"></i>
                        <span class="side-menu__label">
                         الصلاحيات والمستخدمين
                    </span><i class="angle fe fe-chevron-down"></i>
                    </a>
                    <ul class="slide-menu">
                        @can('اضافة صلاحية')
                            <li>
                                <a class="slide-item" href="{{ route('admin.roles.create') }}">
                                    اضافة صلاحية جديد
                                </a>
                            </li>
                        @endcan
                        @can('عرض صلاحية')
                            <li>
                                <a class="slide-item" href="{{ route('admin.roles.index') }}">
                                    قائمة صلاحيات المستخدمين
                                </a>
                            </li>
                        @endcan
                        @can('اضافة مستخدم')
                            <li>
                                <a class="slide-item" href="{{ route('admin.admins.create') }}">
                                    اضافة مستخدم جديد
                                </a>
                            </li>
                        @endcan
                        @can('عرض مستخدم')
                            <li>
                                <a class="slide-item" href="{{ route('admin.admins.index') }}">
                                    قائمة المستخدمين
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan
        </ul>
    </div>
</aside>
<!-- main-sidebar -->
