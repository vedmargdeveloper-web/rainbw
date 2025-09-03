<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\MetaController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\GstController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\SourceController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\OccasionController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\PitchController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BookingCalendarController;
use App\Http\Controllers\Admin\AllocationController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\VehicleHeadController;
use App\Http\Controllers\Admin\ChallanController;
use App\Http\Controllers\Admin\VechicleGenrationController;
use App\Http\Controllers\Admin\LogisticsController;
use App\Http\Controllers\Admin\TransportController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\ChallanTypeMasterController;
use Illuminate\Http\Request;




Route::get('/optimize', function () {
    // Clear route cache
    Artisan::call('route:clear');

    // Clear configuration cache
    Artisan::call('config:clear');

    // Clear application cache
    Artisan::call('cache:clear');

    // Clear compiled views cache
    Artisan::call('view:clear');

    // Clear optimized class loader cache
    Artisan::call('optimize:clear');

    return "Cache is cleared";
});



Route::get('login', function() {
		return redirect()->route('admin');
})->name('login');
Route::get('/searchPincode', [AdminController::class, 'searchPincode'])->name('searchPincode');

Route::get('/',[App\Http\Controllers\HomeController::class, 'index']);


Route::get('admin',[App\Http\Controllers\Admin\AdminController::class,'index'])->name('admin');

Route::post('admin/login',[App\Http\Controllers\Admin\AdminController::class,'login'])->name('admin.login');

Route::middleware([Admin::class])->prefix('admin')->group(function () {
	 	
	    Route::get('home',[AdminController::class,'home'])->name('admin.home');
		Route::get('dashboard/filter-chart', [AdminController::class, 'filterChart'])->name('dashboard.filter-chart');

	    Route::get('logout',[AdminController::class,'logout'])->name('admin.logout');
	    
	    Route::resource('item', ItemController::class);
	    Route::resource('gst', GstController::class);
	    
	    Route::get('ajax-fetch/items',[ItemController::class,'fetch_item_ajax'])->name('ajax.customers.details');
	    Route::get('ajax-fetch/gst',[GstController::class,'fetch_gst_ajax'])->name('ajax.gst.details');
	    Route::get('ajax-fetch/user',[MasterController::class,'fetch_user_ajax'])->name('ajax.user.fetch');
	    
	    Route::get('master/password',[MasterController::class,'master_password'])->name('ajax.user.password');
	    
	    Route::get('fetch/city',[MasterController::class,'city'])->name('ajax.fetch.city');

	    //Route::get('fetch/city',[MasterController::class,'city'])->name('ajax.fetch.state');
	    
	    Route::post('master/update-password',[MasterController::class,'update_password'])->name('master.update.password');
	    
	    //Route::get('ajax/master/',[ UserController::class,'permissions'])->name('user.permissions.create');

	    Route::resource('customers', CustomerController::class);
	    Route::resource('state', StateController::class);
	    Route::resource('city', CityController::class);
	    Route::resource('address', AddressController::class);
	    Route::get('user/permission/{uid}',[ UserController::class,'permissions'])->name('user.permissions.create');
	    Route::post('user/permission/store',[ UserController::class,'permissions_store'])->name('user.permissions.store');
	    Route::get('fetch/customers/{type}/{compition}',[ CustomerController::class,'ajax_customers_limit'])->name('ajax.customers.limit');
	    Route::resource('users', UserController::class);  
	    Route::resource('meta', MetaController::class);
	    Route::resource('invoice', InvoiceController::class);
	    Route::resource('quotation', QuotationController::class);
	    Route::resource('booking', BookingController::class);
	    Route::resource('inquiry', InquiryController::class);
	    Route::resource('lead', LeadController::class);
	    Route::resource('source', SourceController::class);
	    Route::resource('occasion', OccasionController::class);
	    Route::resource('pitch', PitchController::class);
	    Route::resource('allocation', AllocationController::class);
	    Route::resource('color', ColorController::class);
	    Route::resource('heads', VehicleHeadController::class);
	    Route::resource('transport', TransportController::class);
	    Route::resource('vehicle-id-genration', VechicleGenrationController::class);


		//  Route::resource('challan-type', ChallanTypeMasterController::class);
		Route::get('/challan-type', [ChallanTypeMasterController::class, 'index'])->name('challan-type.index');
		Route::post('/challan-type/store', [ChallanTypeMasterController::class, 'store'])->name('challan-type.store');
	Route::get('/challan-type/edit/{id}', [ChallanTypeMasterController::class, 'edit'])->name('challan-type.edit');
Route::patch('/challan-type/update/{id}', [ChallanTypeMasterController::class, 'update'])->name('challan-type.update');
		Route::delete('/challan-type/delete/{id}', [ChallanTypeMasterController::class, 'destroy'])->name('challan-type.destroy');

	    Route::post('minor-heads', [VehicleHeadController::class,'minor_store'])->name('minorstore.store');
	    Route::get('minor-fetch-heads', [VehicleHeadController::class,'minor_fetch'])->name('minorstore.fetch.store');
	    
	    // Route::get('store/allocation',[ InvoiceController::class,'print'])->name('invoice.print');
	    
	    Route::post('allocation-table-fetch',[ AllocationController::class,'ajax_table_location'])->name('allocation.table.fetch');
	    Route::post('allocation-vendor-table-fetch',[ AllocationController::class,'allocation_vendor_table_fetch'])->name('allocation.vendor.table.fetch');
	    
	    Route::get('logistics/create',[LogisticsController::class,'create'])->name('logistics.create');
	    Route::get('logistics/ajax-challan-create',[LogisticsController::class,'challan'])->name('logistics.challan');
	    Route::get('logistics/challan-print',[LogisticsController::class,'challan_print'])->name('logistics.challan.print');
	    Route::post('logistics/challan-store',[LogisticsController::class,'challan_store'])->name('logistics.challan.store');

	    Route::post('logistics/ajax-store-data',[LogisticsController::class,'ajax_store_data'])->name('logistics.store.data');

	    Route::get('challan', [InvoiceController::class, 'challan'])->name('invoice.challan');
	    Route::get('invoice/create', [InvoiceController::class, 'invoicetype'])->name('invoice.create');

	    Route::get('invoice/print/{id}',[ InvoiceController::class,'print'])->name('invoice.print');

	    Route::get('invoice/email/{id}',[ InvoiceController::class,'email'])->name('invoice.email');

		//+++++++++++++++++++++++Challan Controller +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


		// Route::get('/challan-types', [ChallanTypeMasterController::class, 'index'])->name('challan.index');
		// Route::post('/challan-types/store', [ChallanTypeMasterController::class, 'store'])->name('challan.store');
		// Route::get('/challan-types/fetch', [ChallanTypeMasterController::class, 'fetch'])->name('challan.fetch');
		// Route::post('/challan-types/update/{id}', [ChallanTypeMasterController::class, 'update'])->name('challan.update');
		// Route::delete('/challan-types/delete/{id}', [ChallanTypeMasterController::class, 'destroy'])->name('challan.delete');
	     
		Route::get('challans',[ ChallanController::class,'index'])->name('challan.index');
		Route::get('challan/create',[ ChallanController::class,'create'])->name('challan.create');
		Route::post('challan/store',[ ChallanController::class,'store'])->name('challan.store');
		Route::get('challan/edit/{id}',[ ChallanController::class,'edit'])->name('challan.edit');
		Route::post('challan/update/{id}',[ ChallanController::class,'update'])->name('challan.update');
		Route::get('challan/print',[ ChallanController::class,'print'])->name('challan.print');
		// Route::get('return-challan/print/{id}',[ ChallanController::class,'printReturnChallan'])->name('return.challan.print');
	    Route::get('challan/email/{id}',[ ChallanController::class,'email'])->name('challan.email');

		Route::get('return-challan/print/{id}',[ ChallanController::class,'returnChallan'])->name('return.challan');
		Route::post('return-challan/print/{id}',[ ChallanController::class,'returnChallanStore'])->name('return.challan.store');


        Route::get('challan/create/{id}',[ ChallanController::class,'createQuotationChallan'])->name('quotation.challan.create');


	    Route::get('pitch/print/{id}',[ PitchController::class,'print'])->name('pitch.print');

	    Route::get('quotation/print/{id}',[ QuotationController::class,'print'])->name('quotation.print');
	    Route::get('quotation/email/{id}',[ QuotationController::class,'email'])->name('quotation.email');

        Route::get('quotation/challan/print/{id}',[ QuotationController::class,'printChallanOne'])->name('challanOne.print');
		Route::get('quotation/return-challan/print/{id}',[ QuotationController::class,'printReturnChallan'])->name('returnchallan.print');


	    Route::get('quotation/check-view/{id}',[ QuotationController::class,'check_view'])->name('quotation.check.view');
	    Route::get('booking/check-view/{id}',[ BookingController::class,'check_view'])->name('booking.check.view');
	    Route::get('pitch/check-view/{id}',[ PitchController::class,'check_view'])->name('pitch.check.view');

	    Route::get('booking/print/{id}',[ BookingController::class,'print'])->name('booking.print');
	    
	    Route::get('booking/email/{id}',[ BookingController::class,'email'])->name('booking.email');

	    Route::get('ajax/fetchstatus',[ QuotationController::class,'fetch_ajax_status'])->name('booking.email');
	    
	    Route::get('ajax/fetch-inquiry',[InquiryController::class,'fetch_ajax_inquiry_history'])->name('ajax.inquiry.history');
	    //Route::get('ajax/filter-inquiry',[InquiryController::class,'inquiry_filter'])->name('ajax.filter.inquiry');
	    
	    Route::get('last-enquiries',[QuotationController::class,'last_enquiries'])->name('ajax.last.enquries');
	    Route::get('last-quotation',[BookingController::class,'fresh_quotations'])->name('ajax.last.booking');
	    
	    Route::resource('master', MasterController::class);
	    Route::get('fetch/customer/details/{type}',[CustomerController::class,'ajax_customers_details'])->name('ajax.customer.details');
	    Route::get('fetch/delivery/details/{type}',[AddressController::class,'ajax_delivery_details'])->name('ajax_delivery_details');
	    
	    Route::get('fetch/product/details/{type}',[ItemController::class,'ajax_fetch_item'])->name('ajax_fetch_item');

		// Route::get('/booking-calendar', [BookingCalendarController::class, 'index']);
		// Route::get('/booking-calendar/events', [BookingCalendarController::class, 'events']); // GET for fetching
		// Route::post('/booking-calendar/events', [BookingCalendarController::class, 'ajax']);   // POST for add/update/delete

 Route::get('/booking-calendar', [BookingCalendarController::class, 'index'])->name('admin.booking-calendar');
    Route::get('/booking-calendar/events', [BookingCalendarController::class, 'events'])->name('admin.booking-calendar.events');
    Route::post('/booking-calendar/events', [BookingCalendarController::class, 'ajax'])->name('admin.booking-calendar.ajax');
    Route::get('/booking-calendar/events/{id}', [BookingCalendarController::class, 'show'])->name('admin.booking-calendar.show');


});
