<?php
		// Cron Job Routing
		Route::get('cronjob', 'CronController@index');
        Route::get('transactions','BankController@getsalttransactions');
        Route::post('transactions','BankController@postsalttransactions');

        /*Page Counter for Blog*/
		Route::get('pagecounter', 'HomeController@pagecounter');
		Route::get('subscribetoblog', 'HomeController@blogsubscribe');
		Route::get('subscribetoraletta', 'HomeController@ralettasubscribe');
		Route::get('uae', 'HomeController@uaesection');
		Route::get('ralettapayments', 'HomeController@ralettapayments');
        /*End*/

		/*Invite User*/
		Route::get('invitation/accept/{id}','HomeController@inviteaccept');
		Route::get('invitation/reject/{id}','HomeController@invitereject');

		/*Start Api*/
		Route::get('api', 'ApiController@index');
		Route::get('api/success', 'ApiController@success');
		Route::get('api/failed', 'ApiController@failed');
		Route::get('api/destroy', 'ApiController@destroy');
		Route::get('api/loginorsignup', 'ApiController@loginorsignup');
		Route::get('api/countries', 'ApiController@getCountries');
		Route::get('api/gettoken', 'ApiController@gettoken');
		Route::get('api/login/{email}/{password}', 'ApiController@login');
		Route::get('api/autologin/{email}/{password}', 'ApiController@autologin');
		Route::get('api/signup', 'ApiController@signup');
        /*End Api*/
        
        /* Start E-way Bill Leanding Page*/
        Route::get('e-waybill','HomeController@ewaybillleandingpage');
        /* End E-way Bill leanding page*/

        /*Start view invoice,so,po,bill without login*/
        Route::get('printinv/{invoice_id}','InvoiceController@viewInvoiceWithoutLogin');
        Route::get('printsorder/{so_id}','SalesOrderController@viewSOrderWithoutLogin');
        Route::get('printbill/{bill_id}','PurchaseController@viewBillWithoutLogin');
        Route::get('printporder/{po_id}','PurchaseOrderController@viewPOrderWithoutLogin');
		/*End view invoice without login*/

        /* Start Static Pages*/
        Route::get('aboutus', 'HomeController@aboutus');
        Route::get('privacy-policy', 'HomeController@privacy_policy');
        Route::get('termscondition', 'HomeController@termscondition');
        Route::get('security', 'HomeController@security');
        Route::get('gdpr', 'HomeController@gdpr');
        Route::get('contactus', 'HomeController@contactUs');
        /* End Static Pages */

        /*Start Send mail for raletta*/
        Route::get('submitenquiry', 'HomeController@sendEnquiryEmail');
        Route::get('submitralettacontact', 'HomeController@sendRalettaContactEmail');
        Route::get('submitcoworkingcontact', 'HomeController@sendCoWorkingContactEmail');
        Route::get('submitcoworkingadwords', 'HomeController@sendCoWorkingAdwordsEmail');

        Route::get('submitpalmindoreadwords', 'HomeController@sendPalmIndoreAdwordsEmail');
        Route::get('submitlakeviewadwords', 'HomeController@sendLakeViewAdwordsEmail');

        Route::get('submitralettaseo', 'HomeController@sendRalettaSeoEmail');
		Route::get('submitralettadigital', 'HomeController@sendRalettaDigitalEmail');
		Route::get('submitralettamobileapp', 'HomeController@sendRalettaMobileAppEmail');
		Route::get('submitralettawebdev', 'HomeController@sendRalettaWebDevEmail');
		Route::get('submitralettadigitalmarketing', 'HomeController@sendRalettaDigitalMarketingEmail');
		Route::get('submit-raletta-digital-marketing-contact', 'HomeController@sendRalettaDigitalMarketingContact');
        Route::get('submitmerrchantadwords', 'HomeController@sendMerrchantAdwordsEmail');
        Route::get('submitmtechsolutionsads', 'HomeController@sendMtechsolutionsAdwordsEmail');
        Route::get('submitbitcoinmlmads', 'HomeController@sendBitcoinmlmAdwordsEmail');
        /*End*/
		/* Admin part routing */
		Route::get('/', 'HomeController@frontpage');
		Route::get('/adwords', 'HomeController@adwords');
		Route::get('/subscription', 'HomeController@subscription');
		Route::get('/register', 'RegisterController@register');
		Route::post('/register', 'RegisterController@doregister');
		Route::get('register/activate/{code}', 'RegisterController@activate');
		Route::get('register/activated', 'RegisterController@activated');
		Route::get('/login', 'LoginController@login');
		Route::get('invitelogin/{invitetype}/{inviteid}', 'HomeController@invitelogin');
		Route::post('/authenticate', 'LoginController@authenticate');
		Route::get('/logout', 'LoginController@logout');
		Route::get('features', 'HomeController@features');
		Route::get('/demo', 'LoginController@demologin');
		// Password Reset Routes...
		Route::get('password/resets/{token?}', 'LoginController@showResetForm');
		Route::post('password/resets/{token?}', 'LoginController@setPassword');
		Route::post('password/email', 'LoginController@sendResetLinkEmail');
		Route::get('password/reset', 'LoginController@reset');

		//HRMS and CRM Leanding Page Routing
		Route::get('crm','CRMController@leandingpage');
		Route::get('hrms', 'HRMSController@leandingpage');

		// Customer Login Route 
		Route::get('customer', 'CustomerAuth\AuthController@showLoginForm');
		Route::post('customer/authenticate', 'CustomerAuth\AuthController@login');
		Route::get('customer/logout', 'CustomerAuth\AuthController@logout');

		Route::get('customer/dashboard', 'CustomerPanelController@index');
		Route::get('customer/profile', 'CustomerPanelController@profile');
		Route::post('customer/profile', 'CustomerPanelController@updateProfile');
		Route::post('customer/getcustomerinfo', 'CustomerController@getcustomerinfo');

		Route::get('customer-panel/order/{id}','CustomerPanelController@salesOrder');
		Route::get('customer-panel/view-order-details/{id}','CustomerPanelController@viewOrderDetails');
		Route::get('customer-panel/orderPdf/{order_id}','CustomerPanelController@orderPdf');
		Route::get('customer-panel/orderPrint/{order_id}','CustomerPanelController@orderPrint');

		Route::get('customer-panel/invoice/{id}','CustomerPanelController@invoice');
		Route::get('customer-panel/view-detail-invoice/{order_id}/{invoice_id}','CustomerPanelController@viewInvoiceDetails');
		Route::get('customer-panel/invoice-pdf/{order_id}/{invoice_id}','CustomerPanelController@invoicePdf');
		Route::get('customer-panel/invoice-print/{order_id}/{invoice_id}','CustomerPanelController@invoicePrint');

		Route::get('customer-panel/payment/{id}','CustomerPanelController@payment');
		Route::get('customer-panel/view-receipt/{id}','CustomerPanelController@viewReceipt');
		
		Route::get('customer-panel/shipment/{id}','CustomerPanelController@shipment');
		Route::get('customer-panel/view-shipment-details/{order_id}/{shipment_id}','CustomerPanelController@shipmentDetails');

		Route::get('customer-panel/branch/{id}','CustomerPanelController@branch');
		Route::get('customer-panel/branch/edit/{id}','CustomerPanelController@branchEdit');
		Route::post('customer-panel/branch/update/{id}','CustomerPanelController@branchUpdate');

		// Customer payment start
        Route::post('customer/pay','CustomerPayController@payNow');
        Route::get('customer_payments/success','CustomerPayController@paymentSuccess');
        Route::get('customer_payments/cancel','CustomerPayController@paymentCancel');
        Route::get('customer_payments/fail','CustomerPayController@paymentFail');
        Route::post('customer_payments/bank-payment','CustomerPayController@bankPayment');

		Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
		Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

        // Customer payment end
	Route::group(['middleware' => ['web']], function () {
	    Route::get('admin', 'AdminAuth\AuthController@adminLogin');
	    Route::post('admin-login', ['as'=>'admin-login','uses'=>'AdminAuth\AuthController@adminLoginPost']);
	    Route::get('admin/dashboard', 'AdminPanelController@index');
	    Route::get('admin/activeusers', 'AdminPanelController@activeusers');
	    Route::get('admin/dailyactiveusers', 'AdminPanelController@dailyactiveusers');
	    Route::get('admin/logout', 'AdminAuth\AuthController@logout');
	    Route::get('admin/blogsubscriber', 'AdminPanelController@blogsubscriber');
	    Route::get('admin/ralettasubscriber', 'AdminPanelController@ralettasubscriber');
	    Route::get('admin/dailyblogview', 'AdminPanelController@dailyblogcounterlist');
	    Route::get('admin/vouchers', 'AdminPanelController@voucherslist');
	    Route::post('admin/savevoucher', 'AdminPanelController@savevoucher');
	    Route::post('admin/sendvoucer', 'AdminPanelController@sendvoucer');
	    Route::post('admin/setleadremindar', 'AdminPanelController@setleadremindar');
	    Route::get('admin/removeleadremindar/{leadid}/{leadtype}/{leadstatus}', 'AdminPanelController@removeleadremindar');
	    Route::get('admin/removeleadremindar/{leadid}', 'AdminPanelController@removeremindar');
		Route::get('admin/demovisitors', 'AdminPanelController@demovisitors');
	    Route::get('admin/deleteorganisation', 'AdminPanelController@deleteorganisationRequest');
	    Route::get('admin/raletta_adwords/{leadtype}/{leadstatus}', 'AdminPanelController@ralettaadwordslist');
	    Route::post('admin/raletta_adwords/clearremindar', 'AdminPanelController@clearremindar');
	    Route::post('admin/updatelead', 'AdminPanelController@updatelead');
	    Route::post('admin/storelead', 'AdminPanelController@storelead');
	    Route::get('admin/manageadmin', 'AdminPanelController@manageadmin');
	    Route::post('admin/saveadmin', 'AdminPanelController@saveadmin');
	    Route::post('admin/deleteadmin', 'AdminPanelController@deleteadmin');
		Route::get('admin/auth/{provider}', 'AdminAuth\AuthController@redirectToProvider');
		Route::get('admin/auth/{provider}/callback', 'AdminAuth\AuthController@handleProviderCallback');
		Route::get('admin/reminderlist', 'AdminPanelController@reminderlist');
	});

	Route::group(['middleware' => ['auth','locale'] ], function() {
		/* User Actions */
		Route::get('/gstchallan', 'HomeController@gstchallan');
		Route::get('home','DashboardController@home');
		Route::get('dashboard/mailcheck','DashboardController@mailcheck');
		Route::get('dashboard','DashboardController@index');
		Route::post('change-lang','DashboardController@switchLanguage');
		Route::get('users','UserController@index')->middleware(['permission:manage_team_member']);
		Route::get('create-user','UserController@create')->middleware(['permission:add_team_member']);
		Route::post('save-user','UserController@store');
		Route::get('edit-user/{id}','UserController@edit')->middleware(['permission:add_team_member']);
		Route::post('update-user','UserController@update');
		Route::post('delete-user','UserController@destroy')->middleware(['permission:delete_team_member']);
		Route::post('email-valid','UserController@validEmail');
		Route::get('profile','UserController@profile');
		Route::get('change-password','UserController@changePassword');
		Route::post('change-password','UserController@updatePassword');
		Route::post('feedback','OrganisationController@feedbacksubmit');
		Route::get('feedback/success','OrganisationController@feedbacksuccess');
		// Details 
		Route::get('user/purchase-list/{id}','UserController@userPurchaseOrderList');
		Route::get('user/sales-order-list/{id}','UserController@userSalesOrderList');
		Route::get('user/sales-invoice-list/{id}','UserController@userSalesInvoiceList');
		Route::get('user/user-transfer-list/{id}','UserController@userTransferList');
		Route::get('user/user-payment-list/{id}','UserController@userPaymentList');
		Route::get('pointofsale','PointofsaleController@index');
		Route::post('pointofsale/store','PointofsaleController@store');
		// user Role
		
		Route::get('role/list','RoleController@index');
		Route::get('role/create','RoleController@create');
		Route::post('role/save','RoleController@store');
		Route::get('role/edit/{id}','RoleController@edit');
		Route::post('role/update','RoleController@update');
		Route::post('role/delete','RoleController@destroy');

		// item category
		Route::get('item-category','CategoryController@index');//->middleware(['permission:manage_item_category']);
		Route::get('create-category','CategoryController@create')->middleware(['permission:add_item_category']);
		Route::post('save-category','CategoryController@store');
		Route::post('edit-category','CategoryController@edit')->middleware(['permission:edit_item_category']);
		Route::post('update-category','CategoryController@update');
		Route::post('delete-category/{id}','CategoryController@destroy')->middleware(['permission:delete_item_category']);
		Route::get('categorydownloadExcel/{type}', 'CategoryController@downloadCsv');
		Route::get('categoryimport', 'CategoryController@import');
		Route::post('categoryimportcsv', 'CategoryController@importCsv');

		// item Unit
		Route::get('unit','UnitController@index')->middleware(['permission:manage_unit']);
		Route::get('create-unit','UnitController@create')->middleware(['permission:add_unit']);
		Route::post('save-unit','UnitController@store');
		Route::post('edit-unit','UnitController@edit')->middleware(['permission:edit_unit']);
		Route::post('update-unit','UnitController@update');
		Route::post('delete-unit/{id}','UnitController@destroy')->middleware(['permission:delete_unit']);
		
		// Location
		Route::get('location','LocationController@index')->middleware(['permission:manage_location']);
		Route::get('create-location','LocationController@create')->middleware(['permission:add_location']);
		Route::post('save-location','LocationController@store');
		Route::get('edit-location/{id}','LocationController@edit')->middleware(['permission:edit_location']);
		Route::post('update-location/{id}','LocationController@update');
		Route::post('delete-location/{id}','LocationController@destroy')->middleware(['permission:delete_location']);
		Route::get('loc_code-valid','LocationController@validLocCode');

		// Item
		Route::get('item','ItemController@index')->middleware(['permission:manage_item']);
		Route::get('create-item/{tab}','ItemController@create')->middleware(['permission:add_item']);
		Route::get('getitemdetail/{id}','ItemController@getitemdetail')->middleware(['permission:add_item']);
		Route::post('save-item','ItemController@store');
		Route::post('items/additembyajax','ItemController@additembyajax');
		Route::get('edit-item/{tab}/{id}','ItemController@edit')->middleware(['permission:edit_item']);
		Route::get('copy-item/{id}','ItemController@copy');
		Route::get('show-item/{id}','ItemController@show');
		Route::post('update-item/{id}','ItemController@update');
		Route::post('item/delete/{id}','ItemController@destroy')->middleware(['permission:delete_item']);
		Route::post('save-sale-price','ItemController@storeSalePrice');
		Route::post('save-purchase-price','ItemController@storePurchasePrice');
		Route::post('update-item-info','ItemController@updateItemInfo');
		Route::post('add-sale-price','ItemController@addSalePrice');
		Route::post('edit-sale-price','ItemController@editSalePrice');
		Route::post('update-sale-price','ItemController@updateSalePrice');
		Route::post('delete-sale-price/{id}/{item_id}','ItemController@deleteSalePrice');
		Route::post('update-purchase-price','ItemController@updatePurchasePrice');

		Route::post('add-stock','ItemController@addStock');
		Route::post('remove-stock','ItemController@removeStock');
		Route::post('move-stock','ItemController@moveStock');
		Route::post('stock-valid','ItemController@stockValidChk');
		Route::post('qty-valid','ItemController@qtyValidAjax');
		Route::get('trans-details/{id}','ItemController@showFullDetails');

		Route::get('itemdownloadcsv/{type}', 'ItemController@downloadCsv');
		Route::get('itemimport', 'ItemController@import');
		Route::post('itemimportcsv', 'ItemController@importCsv');

		// Company 
		Route::get('company','CompanyController@index');
		Route::get('create-company','CompanyController@create');
		Route::post('save-company','CompanyController@store');
		Route::get('edit-company/{id}','CompanyController@edit');
		Route::post('update-company/{id}','CompanyController@update');
		Route::post('delete-company/{id}','CompanyController@destroy');

		// create direct sale / invoive
		Route::get('sales/list','SalesController@index')->middleware(['permission:manage_invoice']);
		Route::get('sales/add','SalesController@create')->middleware(['permission:add_invoice']);
		Route::post('sales/save','SalesController@store');
		Route::get('sales/edit/{id}','SalesController@edit')->middleware(['permission:edit_invoice']);
		Route::post('sales/update','SalesController@update');
		Route::post('sales/delete/{id}','SalesController@destroy')->middleware(['permission:delete_invoice']);
		Route::post('sales/reference-validation','SalesController@referenceValidation');
		Route::post('sales/get-branches','SalesController@customerBranches');
		
		Route::post('sales/search','SalesController@search');
		Route::post('sales/quantity-validation','SalesController@quantityValidation');
		Route::post('sales/check-item-qty','SalesController@checkItemQty');
		Route::get('sales/preview/{id}','SalesController@pdfview');
        Route::post('sales/quantity-validation-with-localtion','SalesController@quantityValidationWithLocaltion');
		Route::post('sales/quantity-validation-edit-invoice','SalesController@quantityValidationEditInvoice');
		Route::get('sales/filtering','SalesController@salesFiltering');
		Route::get('sales/addrowdata','SalesController@getrowdata');

		// invoice for 2 number business
		Route::get('playarena','PlayarenainvController@index')->middleware(['permission:manage_invoice']);
		Route::get('playarena/addinvoice','PlayarenainvController@createInvoice')->middleware(['permission:manage_invoice']);
		Route::post('playarena/saveinvoice','PlayarenainvController@storeInvoice')->middleware(['permission:manage_invoice']);
		Route::get('playarena/editinvoice/{id}','PlayarenainvController@editinvoice')->middleware(['permission:edit_invoice']);
		Route::post('playarena/updateinvoice','PlayarenainvController@updateInvoice')->middleware(['permission:manage_invoice']);
		Route::get('playarena/view-detail-invoice/{invoiceno}','PlayarenainvController@viewInvoiceDetails')->middleware(['permission:manage_invoice']);
		Route::post('playarena/deleteinv/{id}','PlayarenainvController@destroy');
		Route::get('playarena/invoice/pdf/{invoice_id}','PlayarenainvController@invoicePdf');
		Route::get('playarena/invoice/print/{invoice_id}','PlayarenainvController@invoicePrint');
		Route::post('playarena/invoicepayment','PlayarenainvController@saveinvpayment');

		// Bills for 2 number business
		Route::get('playarena/addbill','PlayarenabillController@createBill')->middleware(['permission:manage_invoice']);
		Route::post('playarena/savebill','PlayarenabillController@storeBill')->middleware(['permission:manage_invoice']);
		Route::get('playarena/editbill/{id}','PlayarenabillController@editBill')->middleware(['permission:edit_invoice']);
		Route::post('playarena/updatebill','PlayarenabillController@updateBill')->middleware(['permission:manage_invoice']);
		Route::get('playarena/view-detail-bill/{billno}','PlayarenabillController@viewBillDetails')->middleware(['permission:manage_invoice']);
		Route::post('playarena/deletebill/{id}','PlayarenabillController@destroy');
		Route::post('playarena/billpayment','PlayarenabillController@savebillpayment');
		Route::get('playarena/billpdf/{invoice_id}','PlayarenabillController@invoicePdf');
		Route::get('playarena/billprint/{invoice_id}','PlayarenabillController@invoicePrint');

		//Tools routes
		Route::get('tools','UtilityController@toolshome');

		// create sales order
		Route::get('order/list','SalesOrderController@index')->middleware(['permission:manage_quotation']);
		Route::get('order/add','SalesOrderController@create')->middleware(['permission:add_quotation']);
		Route::post('order/save','SalesOrderController@store');
		Route::get('order/edit/{id}','SalesOrderController@edit')->middleware(['permission:edit_quotation']);
		Route::post('order/update','SalesOrderController@update');
		Route::post('order/delete/{id}','SalesOrderController@destroy')->middleware(['permission:delete_quotation']);
		Route::get('order/view-order/{id}','SalesOrderController@viewOrder');
		Route::post('order/convert-order','SalesOrderController@convertOrder');

		Route::post('order/search','SalesOrderController@search');
		Route::post('order/quantity-validation','SalesOrderController@quantityValidation');

		Route::get('order/view-order-details/{id}','SalesOrderController@viewOrderDetails');

		Route::get('order/auto-invoice-create/{id}','SalesOrderController@autoInvoiceCreate');
		Route::post('order/check-quantity-after-invoice','SalesOrderController@checkQuantityAfterInvoice');
		Route::get('order/pdf/{order_id}','SalesOrderController@orderPdf');
		Route::get('order/print/{order_id}','SalesOrderController@orderPrint');
		Route::post('order/email-order-info','SalesOrderController@sendOrderInformationByEmail');
		Route::get('order/filtering','SalesOrderController@orderFiltering');

		// Invoice Routing
		Route::get('invoice/view-detail-invoice/{orderId}/{invoiceId}','InvoiceController@viewInvoiceDetails');
		Route::post('invoice/email-invoice-info','InvoiceController@sendInvoiceInformationByEmail');
		Route::get('invoice/pdf/{order_id}/{invoice_id}','InvoiceController@invoicePdf');
		Route::get('invoice/print/{order_id}/{invoice_id}','InvoiceController@invoicePrint');
		Route::post('invoice/delete/{id}','InvoiceController@destroy');
		Route::get('invoice/delete-invoice/{id}','InvoiceController@destroy');

		//E-way Bill
		Route::get('ewaybill/list','UtilityController@index')->middleware(['permission:manage_invoice']);
		Route::post('generate_ewaybill','UtilityController@generate_ewaybill')->middleware(['permission:manage_invoice']);
		Route::post('update_ewaybill','UtilityController@update_ewaybill')->middleware(['permission:manage_invoice']);
		Route::get('ewaybill/history','UtilityController@history')->middleware(['permission:manage_invoice']);
		Route::post('ewaybill/viewmessage','UtilityController@viewewaymessage')->middleware(['permission:manage_invoice']);
		Route::get('ewaybill/instructions','UtilityController@instructions')->middleware(['permission:manage_invoice']);
		Route::get('ewaybill/dashboard','UtilityController@dashboard')->middleware(['permission:manage_invoice']);
		Route::post('ewaybill/cancel','UtilityController@cancelewaybill')->middleware(['permission:manage_invoice']);
		Route::post('ewaybill/update_ewaybill_number','UtilityController@update_ewaybill_number')->middleware(['permission:manage_invoice']);
		//New get return Routing
		Route::get('gst-return','GstReturnController@index');
		Route::get('gstinvoice/{taxname}','GstReturnController@getGstInvoices');
		Route::get('gstbills/{taxname}','GstReturnController@gstGstBills');
        Route::get('gst-return-csv/{taxname}','GstReturnController@gstReturnCsv');
        Route::post('gst-return/record-a-payment','GstReturnController@recordapayment');
        Route::get('gst-return/gettaxtransaction/{taxname}','GstReturnController@getTaxTransaction');
        // Manage Contacts
        Route::get('contacts','ContactsController@index');
        Route::get('contacts/{contacttype}','ContactsController@ContactByType');
        Route::get('getcontactdetails/{id}/{contacttype}','ContactsController@getContactDetails');

		// Customer 
		Route::get('customer/list','CustomerController@index')->middleware(['permission:manage_customer']);
		Route::get('create-customer','CustomerController@create')->middleware(['permission:add_customer']);
		Route::post('save-customer','CustomerController@store');
		Route::post('customer/addcustomerajax','CustomerController@addcustomerajax');
		Route::get('customer/edit/{id}','CustomerController@edit')->middleware(['permission:edit_customer']);
		Route::get('customer/order/{id}','CustomerController@salesOrder');
		Route::get('customer/invoice/{id}','CustomerController@invoice');
		Route::get('customer/payment/{id}','CustomerController@payment');
		Route::get('customer/shipment/{id}','CustomerController@shipment');
		Route::post('update-customer/{id}','CustomerController@update');
		Route::post('customer/update-password','CustomerController@updatePassword');
		Route::post('delete-customer/{id}','CustomerController@destroy')->middleware(['permission:delete_customer']);
        Route::get('customer/get_state_for_country','CustomerController@getStateForCountry');
		Route::get('customerdownloadCsv/{type}', 'CustomerController@downloadCsv');
		Route::get('customerimport', 'CustomerController@import');
		Route::post('customerimportcsv', 'CustomerController@importCsv');
		Route::post('customer/delete-sales-info', 'CustomerController@deleteSalesInfo');
		//Route::post('customerimportcsv', 'CustomerController@importCsv');

		// Customer Branch
		Route::get('branch','CustomerController@index');
		Route::get('create-branch','CustomerController@create');
		Route::post('save-branch','CustomerController@storeBranch');
		Route::post('edit-branch','CustomerController@editBranch');
		Route::post('update-branch','CustomerController@updateBranch');
		Route::post('delete-branch/{id}','CustomerController@destroyBranch');

		// supplier 
		Route::get('supplier','SupplierController@index')->middleware(['permission:manage_supplier']);
		Route::post('supplier/addsupplierajax','SupplierController@addsupplierajax');
		Route::get('create-supplier','SupplierController@create')->middleware(['permission:add_supplier']);
		Route::post('save-supplier','SupplierController@store');
		Route::get('edit-supplier/{id}','SupplierController@edit')->middleware(['permission:edit_supplier']);
		Route::post('update-supplier/{id}','SupplierController@update');
		Route::post('delete-supplier/{id}','SupplierController@destroy')->middleware(['permission:delete_supplier']);
        Route::get('supplier/orders/{id}','SupplierController@orderList');
		Route::get('supplier/bill/{id}','SupplierController@billList');
		Route::get('supplier/payment/{id}','SupplierController@billPayments');
		Route::get('supplierdownloadCsv/{type}', 'SupplierController@downloadCsv');
		Route::get('supplierimport', 'SupplierController@import');
		Route::post('supplierimportcsv', 'SupplierController@importCsv');
		Route::post('supplier/getsupplierinfo', 'SupplierController@getsupplierinfo');
		
		// tagging on customer, supplier and employee
		Route::post('customer-to-supplier', 'CustomerController@customertosupplier');
		Route::post('customer-to-employee', 'CustomerController@customertoemployee');
		Route::post('supplier-to-customer', 'SupplierController@suppliertocustomer');
		Route::post('supplier-to-employee', 'SupplierController@suppliertoemployee');
		Route::post('employee-to-customer', 'EmpController@employeetocustomer');
		Route::post('employee-to-supplier', 'EmpController@employeetosupplier');

		// check-in Purchese Order
		Route::get('purchaseorder/list','PurchaseOrderController@index')->middleware(['permission:manage_purchase']);
		Route::get('purchaseorder/add','PurchaseOrderController@create')->middleware(['permission:add_purchase']);
		Route::post('purchaseorder/save','PurchaseOrderController@store');
		Route::get('purchaseorder/edit/{id}','PurchaseOrderController@edit')->middleware(['permission:edit_purchase']);
		Route::post('purchaseorder/update','PurchaseOrderController@update');
		Route::post('purchaseorder/delete/{id}','PurchaseOrderController@destroy')->middleware(['permission:delete_purchase']);
		Route::get('purchaseorder/auto-bill-create/{id}','PurchaseOrderController@autoBillCreate');
		Route::post('purchaseorder/item-search','PurchaseOrderController@searchItem');
		Route::get('purchaseorder/view-purchase-details/{id}','PurchaseOrderController@viewPurchaseInvoiceDetail');
	
		Route::get('purchaseorder/pdf/{order_id}','PurchaseOrderController@invoicePdf');
		Route::get('purchaseorder/print/{order_id}','PurchaseOrderController@invoicePrint');
		Route::post('purchaseorder/reference-validation','PurchaseOrderController@referenceValidation');
		
		Route::get('purchaseorder/filtering','PurchaseOrderController@Filtering');

		// check-in Purchese Bill
		Route::get('purchase/list','PurchaseController@index')->middleware(['permission:manage_purchase']);
		Route::get('purchase/add','PurchaseController@create')->middleware(['permission:add_purchase']);
		Route::post('purchase/save','PurchaseController@store');
		Route::get('purchase/edit/{id}','PurchaseController@edit')->middleware(['permission:edit_purchase']);
		Route::post('purchase/update','PurchaseController@update');
		Route::post('purchase/delete/{id}','PurchaseController@destroy')->middleware(['permission:delete_purchase']);
		
		Route::post('purchase/item-search','PurchaseController@searchItem');
		Route::get('purchase/view-purchase-details/{id}','PurchaseController@viewPurchaseInvoiceDetail');
	
		Route::get('purchase/pdf/{order_id}','PurchaseController@invoicePdf');
		Route::get('purchase/print/{order_id}','PurchaseController@invoicePrint');
		Route::post('purchase/reference-validation','PurchaseController@referenceValidation');
		
		Route::get('purchase/filtering','PurchaseController@Filtering');

		// Payment Routing
		Route::post('payment/save','PaymentController@createPayment');
        Route::post('payment/paybill','BillPaymentController@createBillPayment');

		// item Tax
		Route::get('tax','TaxController@index');//->middleware(['permission:manage_tax']);
		Route::get('gettaxjson','TaxController@getTaxdataInDropdown');//->middleware(['permission:manage_tax']);
		Route::get('getitemtaxjson/{taxid}','TaxController@getItemTaxdataInDropdown');//->middleware(['permission:manage_tax']);
		Route::get('create-tax','TaxController@create')->middleware(['permission:add_tax']);
		Route::post('save-tax','TaxController@store');
		Route::post('save-tax-ajax','TaxController@savetaxajax');
		Route::post('edit-tax','TaxController@edit')->middleware(['permission:edit_tax']);
		Route::post('update-tax','TaxController@update');
		Route::post('update_gst_tax','TaxController@update_gst_tax');
		Route::post('delete-tax/{id}','TaxController@destroy')->middleware(['permission:delete_tax']);
		
		// item Sales Type
		Route::get('sales-type','SalesTypeController@index');

		Route::post('save-sales-type','SalesTypeController@store');
		Route::post('edit-sales-type','SalesTypeController@edit');
		Route::post('update-sales-type','SalesTypeController@update');
		Route::post('delete-sales-type/{id}','SalesTypeController@destroy');

		// Settings
		Route::get('setting-general','SettingController@index');
		Route::get('setting-email-template','SettingController@mailTemp');
		Route::get('setting-preference','SettingController@preference');
		Route::get('setting-finance','SettingController@finance');
		Route::get('setting-company','SettingController@company');
		Route::post('save-preference','SettingController@savePreference');
		Route::get('currency','SettingController@currency')->middleware(['permission:manage_currency']);
		Route::post('save-currency','SettingController@store');
		Route::post('save-currency-ajax','SettingController@savecurrencyajax');
		Route::post('edit-currency','SettingController@edit')->middleware(['permission:add_currency']);
		Route::post('update-currency','SettingController@update');
		Route::post('delete-currency/{id}','SettingController@destroy')->middleware(['permission:delete_currency']);
		Route::get('backup/list','SettingController@backupList')->middleware(['permission:manage_db_backup']);
		Route::get('back-up','SettingController@backupDB');
		Route::get('email/setup','SettingController@emailSetup');
		Route::post('save-email-config','SettingController@emailSaveConfig');
		Route::post('test-email','SettingController@testEmailConfig');
		Route::get('customer/setting', 'SettingController@customersettings');

		Route::post('backup/delete/{id}','SettingController@destroyBackup')->middleware(['permission:delete_db_backup']);

		
		//Payment route
		Route::get('payment/terms','SettingController@paymentTerm')->middleware(['permission:manage_payment_term']);
		Route::post('payment/terms/add','SettingController@addPaymentTerms')->middleware(['permission:add_payment_term']);
		Route::post('payment/terms/edit','SettingController@editPaymentTerms')->middleware(['permission:edit_payment_term']);
		Route::post('payment/terms/update','SettingController@updatePaymentTerms');
		Route::post('payment/terms/delete/{id}','SettingController@deletePaymentTerm')->middleware(['permission:delete_payment_term']);
		Route::get('payment/method','SettingController@paymentMethod')->middleware(['permission:manage_payment_method']);
		Route::post('payment/method/add','SettingController@addPaymentMethod')->middleware(['permission:add_payment_method']);
		Route::post('payment/method/edit','SettingController@editPaymentMethod')->middleware(['permission:edit_payment_method']);
		Route::post('payment/method/update','SettingController@updatePaymentMethod');
		Route::post('payment/method/delete/{id}','SettingController@deletePaymentMethod')->middleware(['permission:delete_payment_method']);
		Route::get('company/setting','SettingController@companySetting');
		Route::post('company/setting/save','SettingController@companySettingSave');

		//Route::get('payment/gateway','SettingController@PaymentGateway');
		Route::match(['get', 'post'], 'payment/gateway', 'SettingController@PaymentGateway');
		
		//mail template
		Route::get('mail-temp','MailTemplateController@index');
		Route::get('customer-invoice-temp/{id}','MailTemplateController@customerInvTemp');
		Route::post('customer-invoice-temp/{id}','MailTemplateController@update');

		// Payment Routing
		Route::get('payment/list','PaymentController@index')->middleware(['permission:manage_payment']);
		Route::post('payment/delete','PaymentController@delete')->middleware(['permission:delete_payment']);
		Route::get('payment/view-receipt/{id}','PaymentController@viewReceipt');
		Route::get('payment/create-receipt/{id}','PaymentController@createReceiptPdf');
		Route::get('payment/print-receipt/{id}','PaymentController@printReceipt');
		Route::post('payment/email-payment-info','PaymentController@sendPaymentInformationByEmail');
		Route::get('payment/pay-all/{orderid}','PaymentController@payAllAmount');

		Route::get('payment/filtering','PaymentController@paymentFiltering');
		
		Route::post('payment/edit-payment','PaymentController@editPayment')->middleware(['permission:edit_payment']);
		Route::post('payment/update-payment','PaymentController@updatePayment');

		// Bill Payment Routing
		Route::get('billpayment/list','BillPaymentController@index')->middleware(['permission:manage_payment']);
		Route::post('billpayment/delete','BillPaymentController@delete')->middleware(['permission:delete_payment']);
		Route::get('billpayment/view-receipt/{id}','BillPaymentController@viewReceipt');
		Route::get('billpayment/create-receipt/{id}','BillPaymentController@createReceiptPdf');
		Route::get('billpayment/print-receipt/{id}','BillPaymentController@printReceipt');
		Route::post('billpayment/email-payment-info','BillPaymentController@sendPaymentInformationByEmail');
		Route::get('billpayment/pay-all/{orderid}','BillPaymentController@payAllAmount');
		Route::get('billpayment/filtering','BillPaymentController@paymentFiltering');		
		Route::post('billpayment/edit-payment','BillPaymentController@editPayment')->middleware(['permission:edit_payment']);
		Route::post('billpayment/update-payment','BillPaymentController@updatePayment');
		
		// Shipment Routing
		Route::get('shipment/add/{id}','ShipmentController@createShipment');
		Route::post('shipment/store','ShipmentController@storeShipment');
		Route::get('shipment/create-auto-shipment/{id}','ShipmentController@storeAutoShipment');
		Route::get('shipment/list','ShipmentController@index');
		Route::post('shipment/status-change','ShipmentController@StatusChange');
		Route::post('shipment/delete/{id}','ShipmentController@destroy');
		Route::get('shipment/view-details/{order_id}/{shipment_id}','ShipmentController@shipmentDetails');
		Route::get('shipment/pdf/{order_id}/{shipment_id}','ShipmentController@pdfMake');
		Route::get('shipment/print/{order_id}/{shipment_id}','ShipmentController@shipmentPrint');
		Route::get('shipment/edit/{id}','ShipmentController@edit');
		Route::post('shipment/quantity-validation','ShipmentController@shipmentQuantityValidation');
		Route::post('shipment/update','ShipmentController@update');
		Route::post('shipment/email-shipment-info','ShipmentController@sendShipmentInformationByEmail');
		Route::get('shipment/delivery/{oid}/{sid}','ShipmentController@makeDelivery');

		Route::get('shipment/filtering','ShipmentController@shipmentFiltering');

		// Report Routing
		Route::get('report/inventory-stock-on-hand','ReportController@inventoryStockOnHand')->middleware(['permission:manage_stock_on_hand']);
		
		Route::get('report/inventory-stock-on-hand-pdf','ReportController@inventoryStockOnHandPdf');
		Route::get('report/inventory-stock-on-hand-csv','ReportController@inventoryStockOnHandCsv');
		Route::get('report/sales-report','ReportController@salesReport')->middleware(['permission:manage_sale_report']);
		Route::get('report/sales-report-pdf','ReportController@salesReportPdf');
		Route::get('report/sales-report-csv','ReportController@salesReportCsv');
		Route::get('report/sales-report-by-date/{date}','ReportController@salesReportByDate');
		Route::get('report/sales-report-by-month/{month}','ReportController@salesReportByMonth');
		Route::get('report/sales-report-by-debtor/{debtor}','ReportController@salesReportByDebtor');
		Route::get('report/sales-report-by-date-pdf/{date}','ReportController@salesReportByDatePdf');
		Route::get('report/sales-report-by-date-csv/{date}','ReportController@salesReportByDateCsv');
	
		Route::get('report/sales-estimate-report','ReportController@salesEstimateReport')->middleware(['permission:manage_sale_history_report']);
		Route::get('report/sales-estimate-report-pdf','ReportController@salesEstimateReportPdf');
		Route::get('report/sales-estimate-report-csv','ReportController@salesEstimateReportCsv');
		Route::get('report/aged-payables','ReportController@agedpayables')->middleware(['permission:manage_sale_report']);
		Route::get('report/aged-receivables','ReportController@agedreceivables')->middleware(['permission:manage_sale_report']);
		Route::get('report/balance-sheet','ReportController@balancesheet')->middleware(['permission:manage_sale_report']);
		// Purchase Report
        Route::get('report/purchase-report','ReportController@purchaseReport')->middleware(['permission:manage_purchase_report']);
        Route::get('report/purchase-report-pdf','ReportController@purchaseReportPdf');
        Route::get('report/purchase-report-csv','ReportController@purchaseReportCsv');
        Route::get('report/purchase_report_datewise/{time}','ReportController@purchaseReportDateWise');
		Route::get('report/purchase_report_monthwise/{date}','ReportController@purchaseReportMonthWise');
        Route::get('report/purchase_report_supplierwise/{supp_id}','ReportController@purchaseReportSupplierWise');
        Route::get('report/purchase-year-list','ReportController@purchaseYearList');

        Route::get('report/member-report','UserController@memberReport')->middleware(['permission:manage_team_report']);

		Route::get('reports','ReportController@dashboard')->middleware(['permission:manage_team_report']);

        // Bank Account
        Route::get('bank/list','BankController@index')->middleware(['permission:manage_bank_account']);
        Route::get('bank/add-account','BankController@addAccount')->middleware(['permission:add_bank_account']);
        Route::post('bank/save-account','BankController@storeAccount');
        Route::get('bank/edit-account/{tab}/{id}','BankController@editAccount')->middleware(['permission:edit_bank_account']);
        Route::post('bank/update-account','BankController@updateAccount');
        Route::get('bank/balances','BankController@bankBalance');
        Route::post('bank/delete/{id}','BankController@destroy');
        Route::get('bank/autogenerateaccount','BankController@autocreatebyorg')->middleware(['permission:manage_bank_account']);

        /*Start Connect a Bank Account*/
        Route::get('bank/connectbank','BankController@connect_bank_account')->middleware(['permission:manage_bank_account']);
        /*End Connect a Bank Account*/
        
        // Income expense category
        Route::get('income-expense-category/list','IncomeExpenseCategoryController@index')->middleware(['permission:manage_income_expense_category']);
        Route::get('income-expense-category/list/{id}','IncomeExpenseCategoryController@getCategoriesById')->middleware(['permission:manage_income_expense_category']);
        Route::post('income-expense-category/save','IncomeExpenseCategoryController@store');
        Route::get('income-expense-category/addchartsofaccount','IncomeExpenseCategoryController@addchartsofaccount');
        Route::post('income-expense-category/edit','IncomeExpenseCategoryController@edit')->middleware(['permission:edit_income_expense_category']);
        Route::post('income-expense-category/update','IncomeExpenseCategoryController@update');
        Route::post('income-expense-category/delete/{id}','IncomeExpenseCategoryController@destroy')->middleware(['permission:delete_income_expense_category']);

        //Deposit
        Route::get('deposit/list','DepositController@index')->middleware(['permission:manage_deposit']);
        Route::get('deposit/add-deposit','DepositController@addDeposit')->middleware(['permission:add_deposit']);
        Route::post('deposit/save','DepositController@store');
        Route::get('deposit/edit-deposit/{id}','DepositController@editDeposit')->middleware(['permission:edit_deposit']);
        Route::post('deposit/update','DepositController@updateDeposit');
        Route::post('deposit/delete/{id}','DepositController@destroy')->middleware(['permission:delete_deposit']);

        //Expense
        Route::get('expense/list','ExpenseController@index')->middleware(['permission:manage_expense']);
        Route::get('expense/add-expense','ExpenseController@addExpense')->middleware(['permission:add_expense']);
        Route::post('expense/save','ExpenseController@store');
        Route::get('expense/edit-expense/{id}','ExpenseController@editExpense')->middleware(['permission:edit_expense']);
        Route::post('expense/update','ExpenseController@updateExpense');
        Route::post('expense/delete/{id}','ExpenseController@destroy')->middleware(['permission:delete_expense']);
		
		// Balance Transfer Routing
		Route::get('transfer/list','BalanceTransferController@index')->middleware(['permission:manage_balance_transfer']);
		Route::get('transfer/create','BalanceTransferController@addTransfer')->middleware(['permission:add_balance_transfer']);
		Route::get('transfer/addfund/{accountid}','BalanceTransferController@addTransferById')->middleware(['permission:add_balance_transfer']);
		Route::post('transfer/save','BalanceTransferController@store');
		Route::post('transfer/check-balance','BalanceTransferController@checkBalance');
		Route::post('transfer/delete/{id}','BalanceTransferController@destroy')->middleware(['permission:delete_balance_transfer']);
		Route::get('transfer/edit-transfer/{id}','BalanceTransferController@editTransfer')->middleware(['permission:edit_balance_transfer']);
		Route::post('transfer/update','BalanceTransferController@updateTransfer');

		// Transaction Routing
		Route::get('transaction/list','TransactionController@index')->middleware(['permission:manage_transaction']);
		Route::get('transaction/expense-report','TransactionController@expenseReport');
		Route::post('transaction/delete/{id}','TransactionController@destroy');
		Route::get('transaction/edit/{id}','TransactionController@edit');
		Route::get('transaction/update','TransactionController@update');
		Route::get('transaction/income-report','TransactionController@incomeReport')->middleware(['permission:manage_income_report']);
		Route::get('transaction/income-vs-expense','TransactionController@incomeVsExpense')->middleware(['permission:manage_income_vs_expense']);

		// Barcode Generation
		Route::match(['get','post'],'barcode/create',  'BarcodeController@index')->middleware(['permission:manage_barcode']);
		Route::post('barcode/search','BarcodeController@search');

        //Organisation
        Route::get('organisations','OrganisationController@index');
        Route::get('organisations/get_json_orgnisations','OrganisationController@getorgnisations');
        Route::get('organisation/add-organisation','OrganisationController@addOrganisation');
        Route::post('organisation/save','OrganisationController@store');
        Route::get('organisation/edit-organisation/{id}','OrganisationController@editOrganisation');
        Route::post('organisation/update','OrganisationController@updateOrganisation');
        Route::post('organisation/delete/{id}','OrganisationController@destroy');
        Route::get('organisation/organisationlogin/{id}','OrganisationController@organisationLogin');
        Route::get('organisation/subscription','OrganisationController@subscription');
        Route::get('organisation/subscriptions/{org_id}','OrganisationController@subscriptions');
        Route::get('organisation/subscriptionplan/{plan_id}/{org_id}','OrganisationController@subscriptionplan');
        Route::post('organisation/updatesubscription','OrganisationController@updatesubscription');
        Route::get('organisation/subscription/success','OrganisationController@subscriptionsuccess');
        Route::get('organisation/subscription/failed','OrganisationController@subscriptionfailed');
        Route::get('organisation/subscription/aborted','OrganisationController@subscriptionaborted');
        Route::post('organisation/delete','OrganisationController@deleteorganisation');
        Route::post('organisation/activate','OrganisationController@activatebykey');

		/*Start Bank Spend and Receive Mody*/
		Route::get('bank/transactions/{bid}','BankTransactionController@index')->middleware(['permission:manage_bank_account']);
		Route::get('bank/transactions/add/{bid}','BankTransactionController@create')->middleware(['permission:manage_bank_account']);
		Route::post('bank/transactions/save','BankTransactionController@store')->middleware(['permission:manage_bank_account']);
		Route::get('bank/transactions/edit/{bid}/{id}','BankTransactionController@edit')->middleware(['permission:manage_bank_account']);
		Route::post('bank/transactions/update','BankTransactionController@update')->middleware(['permission:manage_bank_account']);
		Route::get('bank/import/{acid}','BankTransactionController@import')->middleware(['permission:manage_bank_account']);
		Route::post('bank/importcsv','BankTransactionController@importCsv')->middleware(['permission:manage_bank_account']);
		Route::get('bank/transdownload','BankTransactionController@downloadcsv')->middleware(['permission:manage_bank_account']);
		Route::get('bank/reconcile/{account_id}','BankTransactionController@banktransactions')->middleware(['permission:manage_bank_account']);
		/*End Bank Spend and Receive Mody*/

		/*Bank Reconcile*/
		Route::post('bank/reconcile/searchinvoice','BankTransactionController@searchinvoice')->middleware(['permission:manage_bank_account']);
		Route::post('bank/reconcile/save','BankTransactionController@reconcilesave')->middleware(['permission:manage_bank_account']);
		Route::post('bank/reconcile/create','BankTransactionController@reconcileadd')->middleware(['permission:manage_bank_account']);
		Route::post('bank/reconcile/discuss','BankTransactionController@reconcilediscuss')->middleware(['permission:manage_bank_account']);
		Route::post('bank/reconcile/transfer','BankTransactionController@reconciletransfer')->middleware(['permission:manage_bank_account']);
		/*End Bank Spend and Receive Mody*/

		// Data import/export
		Route::get('import','ImportController@index');
		Route::post('import/importbank','ImportController@importBank');
		Route::post('import/importcustomer','ImportController@importCustomer');
		Route::post('import/importsupplier','ImportController@importSupplier');
		Route::post('import/importitems','ImportController@importItems');
		Route::post('import/importinvoice','ImportController@importInvoice');
		Route::post('import/importbill','ImportController@importBill');

		Route::get('import/importbank','ImportController@importBankform');
		Route::get('import/importcustomer','ImportController@importCustomerform');
		Route::get('import/importsupplier','ImportController@importSupplierform');
		Route::get('import/importitems','ImportController@importItemsform');
		Route::get('import/importinvoice','ImportController@importInvoiceform');
		Route::get('import/importbill','ImportController@importBillform');

		Route::get('journal','JournalController@index');
		Route::get('journal/create','JournalController@addJournal');

		Route::get('crm/dashboard','CRMController@index');
		Route::get('crm/getleaddetails/{id}','CrmLeadController@getleaddetails');
		Route::get('crm/leads','CrmLeadController@leadlist');
		Route::post('crm/leads/store','CrmLeadController@leadstore');
		Route::post('crm/leads/update','CrmLeadController@leadupdate');
		Route::post('crm/lead/timeline','CrmLeadController@saveleadtimeline');
		Route::get('crm/leadpoints','CrmLeadController@leadpointslist');
		Route::post('crm/leadpoints/add','CrmLeadController@addleadpoint');
		Route::post('crm/deletelead/{id}','CrmLeadController@destroy');
		Route::post('crm/leads/statusupdate','CrmLeadController@statusupdate');
		Route::get('crm/tasks','CrmTaskController@tasklist');
		Route::get('crm/tasks/{lead_id}','CrmTaskController@filtertasks');
		Route::get('crm/gettaskdetails/{id}','CrmTaskController@gettaskdetails');
		Route::post('crm/tasks/store','CrmTaskController@taskstore');
		Route::post('crm/tasks/update','CrmTaskController@taskupdate');
		Route::post('crm/deletetask/{id}','CrmTaskController@destroy');

		Route::get('hrms/employees','HRMSController@employees');
		Route::get('hrms/addemployee','HRMSController@addemployee');

		/*activity-log*/
		Route::get('activity-log', 'ActivityLogController@index');

		/*HRMS Routings*/
	    Route::get('hrms/home', 'HomeController@index');
		Route::get('hrms/logout', 'AuthController@doLogout');

	    Route::get('hrms/change-password', 'AuthController@changePassword');

	    Route::post('hrms/change-password', 'AuthController@processPasswordChange');

	    Route::get('hrms/welcome', 'AuthController@welcome');

	    Route::get('hrms/not-found', 'AuthController@notFound');

	    Route::get('hrms/dashboard', ['as' => 'dashboard', 'uses' => 'AuthController@dashboard']);

	    Route::get('hrms/profile', 'ProfileController@show');

	    //Routes for add-employees

	    Route::get('hrms/add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@addEmployee']);

	    Route::post('hrms/add-employee', ['as' => 'add-employee', 'uses' => 'EmpController@processEmployee']);

	    Route::get('hrms/employee-manager', ['as' => 'employee-manager', 'uses' => 'EmpController@showEmployee']);

	    Route::post('hrms/employee-manager', 'EmpController@searchEmployee');

	    Route::get('hrms/upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@importFile']);

	    Route::post('hrms/upload-emp', ['as' => 'upload-emp', 'uses' => 'EmpController@uploadFile']);

	    Route::get('hrms/edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@showEdit']);

	    Route::post('hrms/edit-emp/{id}', ['as' => 'edit-emp', 'uses' => 'EmpController@doEdit']);

	    Route::get('hrms/delete-emp/{id}', ['as' => 'delete-emp', 'uses' => 'EmpController@doDelete']);

	    //Routes for Bank Account details

	    Route::get('hrms/bank-account-details', ['uses' => 'EmpController@showDetails']);

	    Route::post('hrms/update-account-details', ['uses' => 'EmpController@updateAccountDetail']);

	    //Routes for Team.

	    Route::get('hrms/add-team', ['as' => 'add-team', 'uses' => 'TeamController@addTeam']);

	    Route::post('hrms/add-team', ['as' => 'add-team', 'uses' => 'TeamController@processTeam']);

	    Route::get('hrms/team-listing', ['as' => 'team-listing', 'uses' => 'TeamController@showTeam']);

	    Route::get('hrms/edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@showEdit']);

	    Route::post('hrms/edit-team/{id}', ['as' => 'edit-team', 'uses' => 'TeamController@doEdit']);

	    Route::get('hrms/delete-team/{id}', ['as' => 'delete-team', 'uses' => 'TeamController@doDelete']);

	    //Routes for Role.

	    Route::get('hrms/add-role', ['as' => 'add-role', 'uses' => 'RoleController@addRole']);

	    Route::post('hrms/add-role', ['as' => 'add-role', 'uses' => 'RoleController@processRole']);

	    Route::get('hrms/role-list', ['as' => 'role-list', 'uses' => 'RoleController@showRole']);

	    Route::get('hrms/edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@showEdit']);

	    Route::post('hrms/edit-role/{id}', ['as' => 'edit-role', 'uses' => 'RoleController@doEdit']);

	    Route::get('hrms/delete-role/{id}', ['as' => 'delete-role', 'uses' => 'RoleController@doDelete']);

	    //Routes for Expense.

	    Route::get('hrms/add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@addExpense']);

	    Route::post('hrms/add-expense', ['as' => 'add-expense', 'uses' => 'ExpenseController@processExpense']);

	    Route::get('hrms/expense-list', ['as' => 'expense-list', 'uses' => 'ExpenseController@showExpense']);

	    Route::get('hrms/edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@showEdit']);

	    Route::post('hrms/edit-expense/{id}', ['as' => 'edit-expense', 'uses' => 'ExpenseController@doEdit']);

	    Route::get('hrms/delete-expense/{id}', ['as' => 'delete-expense', 'uses' => 'ExpenseController@doDelete']);

	    //Routes for Leave.

	    Route::get('hrms/add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@addLeaveType']);

	    Route::post('hrms/add-leave-type', ['as' => 'add-leave-type', 'uses' => 'LeaveController@processLeaveType']);

	    Route::get('hrms/leave-type-listing', ['as' => 'leave-type-listing', 'uses' => 'LeaveController@showLeaveType']);

	    Route::get('hrms/edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@showEdit']);

	    Route::post('hrms/edit-leave-type/{id}', ['as' => 'edit-leave-type', 'uses' => 'LeaveController@doEdit']);

	    Route::get('hrms/delete-leave-type/{id}', ['as' => 'delete-leave-type', 'uses' => 'LeaveController@doDelete']);

	    Route::get('hrms/apply-leave', ['as' => 'apply-leave', 'uses' => 'LeaveController@doApply']);

	    Route::post('hrms/apply-leave', ['as' => 'apply-leave', 'uses' => 'LeaveController@processApply']);

	    Route::get('hrms/my-leave-list', ['as' => 'my-leave-list', 'uses' => 'LeaveController@showMyLeave']);

	    Route::get('hrms/total-leave-list', ['as' => 'total-leave-list', 'uses' => 'LeaveController@showAllLeave']);

	    Route::post('hrms/total-leave-list', 'LeaveController@searchLeave');

	    Route::get('hrms/leave-drafting', ['as' => 'leave-drafting', 'uses' => 'LeaveController@showLeaveDraft']);

	    Route::post('hrms/leave-drafting', ['as' => 'leave-drafting', 'uses' => 'LeaveController@createLeaveDraft']);

	    //Routes for Attendance.
		Route::get('hrms/attendance','AttendanceController@attendance');
		Route::post('hrms/saveattendance','AttendanceController@saveattendance');
	    Route::get('hrms/attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@importAttendanceFile']);

	    Route::post('hrms/attendance-upload', ['as' => 'attendance-upload', 'uses' => 'AttendanceController@uploadFile']);

	    Route::get('hrms/attendance-manager', ['as' => 'attendance-manager', 'uses' => 'AttendanceController@showSheetDetails']);

	    Route::post('hrms/attendance-manager', ['as' => 'attendance-manager', 'uses' => 'AttendanceController@searchAttendance']);

	    Route::get('hrms/delete-file/{id}', ['as' => 'delete-file', 'uses' => 'AttendanceController@doDelete']);

	    //Routes for Assets.

	    Route::get('hrms/add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@addAsset']);

	    Route::post('hrms/add-asset', ['as' => 'add-asset', 'uses' => 'AssetController@processAsset']);

	    Route::get('hrms/asset-listing', ['as' => 'asset-listing', 'uses' => 'AssetController@showAsset']);

	    Route::get('hrms/edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@showEdit']);

	    Route::post('hrms/edit-asset/{id}', ['as' => 'edit-asset', 'uses' => 'AssetController@doEdit']);

	    Route::get('hrms/delete-asset/{id}', ['as' => 'delete-asset', 'uses' => 'AssetController@doDelete']);

	    Route::get('hrms/assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@doAssign']);

	    Route::post('hrms/assign-asset', ['as' => 'assign-asset', 'uses' => 'AssetController@processAssign']);

	    Route::get('hrms/assignment-listing', ['as' => 'assignment-listing', 'uses' => 'AssetController@showAssignment']);

	    Route::get('hrms/edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@showEditAssign']);

	    Route::post('hrms/edit-asset-assignment/{id}', ['as' => 'edit-asset-assignment', 'uses' => 'AssetController@doEditAssign']);

	    Route::get('hrms/delete-asset-assignment/{id}', ['as' => 'delete-asset-assignment', 'uses' => 'AssetController@doDeleteAssign']);

	    Route::get('hrms/hr-policy', ['as' => 'hr-policy', 'uses' => 'IndexController@showPolicy']);

	    Route::get('hrms/download-forms', ['as' => 'download-forms', 'uses' => 'IndexController@showForms']);

	    Route::get('hrms/download/{name}', 'DownloadController@downloadForms');

	    Route::get('hrms/calendar', 'AuthController@calendar');

	    //Routes for Leave and Holiday.

	    Route::post('hrms/get-leave-count', 'LeaveController@getLeaveCount');

	    Route::post('hrms/approve-leave', 'LeaveController@approveLeave');

	    Route::post('hrms/disapprove-leave', 'LeaveController@disapproveLeave');

	    Route::get('hrms/add-holidays', 'LeaveController@showHolidays');

	    Route::post('hrms/add-holidays', 'LeaveController@processHolidays');

	    Route::get('hrms/holiday-listing', 'LeaveController@showHoliday');

	    Route::get('hrms/edit-holiday/{id}', 'LeaveController@showEditHoliday');

	    Route::post('hrms/edit-holiday/{id}', 'LeaveController@doEditHoliday');

	    Route::get('hrms/delete-holiday/{id}', 'LeaveController@deleteHoliday');

	    //Routes for Event.

	    Route::get('hrms/create-event', ['as'=>'create-event','uses'=>'EventController@index']);

	    Route::post('hrms/create-event', 'EventController@createEvent');

	    Route::get('hrms/create-meeting', 'EventController@meeting');

	    Route::post('hrms/create-meeting', 'EventController@createMeeting');

	    //Routes for Award.

	    Route::get('hrms/add-award', ['uses'=>'AwardController@addAward']);

	    Route::post('hrms/add-award', ['uses'=>'AwardController@processAward']);

	    Route::get('hrms/award-listing', ['uses'=>'AwardController@showAward']);

	    Route::get('hrms/edit-award/{id}', ['uses'=>'AwardController@showAwardEdit']);

	    Route::post('hrms/edit-award/{id}', ['uses'=>'AwardController@doAwardEdit']);

	    Route::get('hrms/delete-award/{id}', ['uses'=>'AwardController@doAwardDelete']);

	    Route::get('hrms/assign-award', ['uses'=>'AwardController@assignAward']);

	    Route::post('hrms/assign-award', ['uses'=>'AwardController@processAssign']);

	    Route::get('hrms/awardees-listing', ['uses'=>'AwardController@showAwardAssign']);

	    Route::get('hrms/edit-award-assignment/{id}', ['uses'=>'AwardController@showAssignEdit']);

	    Route::post('hrms/edit-award-assignment/{id}', ['uses'=>'AwardController@doAssignEdit']);

	    Route::get('hrms/delete-award-assignment/{id}', ['uses'=>'AwardController@doAssignDelete']);

	    //Routes for Prmotion.

	    Route::get('hrms/promotion', ['uses'=>'EmpController@doPromotion']);

	    Route::post('hrms/promotion', ['uses'=>'EmpController@processPromotion']);

	    Route::get('hrms/show-promotion', ['uses'=>'EmpController@showPromotion']);

	    Route::post('hrms/get-promotion-data', ['uses' => 'EmpController@getPromotionData']);

	    //Routes for Training.

	    Route::get('hrms/add-training-program', ['uses'=>'TrainingController@addTrainingProgram']);

	    Route::post('hrms/add-training-program', ['uses'=>'TrainingController@processTrainingProgram']);

	    Route::get('hrms/show-training-program', ['uses'=>'TrainingController@showTrainingProgram']);

	    Route::get('hrms/edit-training-program/{id}', ['uses'=>'TrainingController@doEditTrainingProgram']);

	    Route::post('hrms/edit-training-program/{id}', ['uses'=>'TrainingController@processEditTrainingProgram']);

	    Route::get('hrms/delete-training-program/{id}',['uses'=>'TrainingController@deleteTrainingProgram']);

	    Route::get('hrms/add-training-invite', ['uses'=>'TrainingController@addTrainingInvite']);

	    Route::post('hrms/add-training-invite', ['uses'=>'TrainingController@processTrainingInvite']);

	    Route::get('hrms/show-training-invite', ['uses'=>'TrainingController@showTrainingInvite']);

	    Route::get('hrms/edit-training-invite/{id}', ['uses'=>'TrainingController@doEditTrainingInvite']);

	    Route::post('hrms/edit-training-invite/{id}', ['uses'=>'TrainingController@processEditTrainingInvite']);

	    Route::get('hrms/delete-training-invite/{id}',['uses'=>'TrainingController@deleteTrainingInvite']);

	    Route::post('hrms/status-update', 'UpdateController@index');

	    Route::post('hrms/post-reply', 'UpdateController@reply');

	    Route::get('hrms/post/{id}', 'UpdateController@post');

	    /** Routes for clients **/
	    Route::get('hrms/add-client', 'ClientController@addClient')->name('add-client');

	    Route::post('hrms/add-client', 'ClientController@saveClient');

	    Route::get('hrms/list-client', 'ClientController@listClients')->name('list-client');

	    Route::get('hrms/edit-client/{clientId}', 'ClientController@showEdit')->name('edit-client');

	    Route::post('hrms/edit-client/{clientId}', 'ClientController@saveClientEdit');


	    Route::get('hrms/delete-list/{clientId}', 'ClientController@doDelete');


	    /** Routes for projects **/
	    Route::get('hrms/validate-code/{code}', 'ClientController@validateCode');

	    Route::get('hrms/add-project', 'ProjectController@addProject')->name('add-project');

	    Route::post('hrms/add-project', 'ProjectController@saveProject');

	    Route::get('hrms/edit-project/{projectId}', 'ProjectController@showEdit')->name('edit-project');

	//    Route::post('edit-project/{projectId}', 'ProjectController@saveProjectEdit');

	    Route::get('hrms/list-project', 'ProjectController@listProject')->name('list-project');

	    Route::get('hrms/edit-project/{id}', ['as' => 'edit-project', 'uses' => 'ProjectController@showEdit']);

	    Route::post('hrms/edit-project/{id}', ['as' => 'edit-project', 'uses' => 'ProjectController@doEdit']);

	    Route::get('hrms/delete-project/{id}', ['as' => 'delete-project', 'uses' => 'ProjectController@doDelete']);

	    Route::get('hrms/assign-project', ['as' => 'assign-project', 'uses' => 'ProjectController@doAssign']);

	    Route::post('hrms/assign-project', ['as' => 'assign-project', 'uses' => 'ProjectController@processAssign']);

	    Route::get('hrms/project-assignment-listing', ['as' => 'project-assignment-listing', 'uses' => 'ProjectController@showProjectAssignment']);

	    Route::get('hrms/edit-project-assignment/{id}', ['as' => 'edit-project-assignment', 'uses' => 'ProjectController@showEditAssign']);

	    Route::post('hrms/edit-project-assignment/{id}', ['as' => 'edit-project-assignment', 'uses' => 'ProjectController@doEditAssign']);

	    Route::get('hrms/delete-project-assignment/{id}', ['as' => 'delete-project-assignment', 'uses' => 'ProjectController@doDeleteAssign']);

	    //Route::get('assign-project', 'ProjectController@assignProject')->name('assign-project');
	});