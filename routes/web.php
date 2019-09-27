<?php

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
// Route::group(['middleware' => ['auth','maintenancepage','itpage','hrpage','assetpage','itmanager','mngrpage','hrmanager']], function () {
// messages controller
Route::get('fetch_messages', 'ChatsController@fetchMessages');
Route::get('seen_message', 'ChatsController@seenMessages');
Route::get('update_seen', 'ChatsController@seenClickMessages');
Route::post('messages', 'ChatsController@sendMessage');
Route::post('search_user', 'ChatsController@searchuser');

Route::get('online_user', 'ChatsController@getOnlineUsers');
Route::get('my_session', 'ChatsController@getMySession');
Route::post('chatuploadfile', 'ChatsController@uploadFile');
Route::get('getchatfiles', 'ChatsController@fetchFiles');
Route::get('downloadchatfile/{id}/now', 'ChatsController@downloadFile');
Route::post('chatfilesearch', 'ChatsController@fileSearch');
//
// group message controller
// Route::get('/', 'GroupChatsController@index');
Route::get('seengroupmessage', 'GroupChatsController@seengroupmessage');
Route::post('groupadd', 'GroupChatsController@groupadd');
Route::get('showgroups', 'GroupChatsController@showgroups');
Route::get('getgroupmessage', 'GroupChatsController@getgroupmessage');
Route::post('sendgroupmessage', 'GroupChatsController@sendgroupmessage');
Route::get('getgroupmembers', 'GroupChatsController@getgroupmembers');
Route::get('removegroupmember', 'GroupChatsController@removegroupmember');
Route::post('addgroupmembers', 'GroupChatsController@addgroupmembers');
Route::post('search_group', 'GroupChatsController@groupsearch');
Route::post('uploadfile', 'GroupChatsController@sendFile');
Route::get('getgroupfiles', 'GroupChatsController@fetchFiles');
Route::get('downloadgroupfile/{id}/now', 'GroupChatsController@downloadFile');
Route::post('filesearch', 'GroupChatsController@fileSearch');
Route::get('getnonmembers', 'GroupChatsController@getnonmembers');
Route::post('searchnonmember', 'GroupChatsController@searchnonmember');
Route::post('searchmember', 'GroupChatsController@searchmember');
//vue dashboard route
Route::get('hrdashboard', 'DashboardController@hrdash');
Route::get('itdashboard', 'DashboardController@itdash');
Route::get('asdashboard', 'DashboardController@asdash');
Route::get('mtdashboard', 'DashboardController@mtdash');
//admin routes
Route::get('assetexpire', 'AssetTrackingController@trackexpired');
// my dashboard
Route::get('mydashboard', 'DashboardController@mydashboard');

// });
// files
Route::get('files', ['as' => 'files.index', 'uses' => 'FileDownloaderController@index']);
Route::post('files/download', ['as' => 'files.download', 'uses' => 'FileDownloaderController@download']);

Route::get('try', function () {
    print_r(\Hash::make('password'));
    die;
});

Auth::routes();

Route::group(['middleware' => 'guest'], function () {
 
    Route::get('/', 'Auth\AuthController@getLogin');
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
});

Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/change_profile_picture', ['as' => 'users.change_profile_picture_index', 'uses' => 'UserController@change_profile_picture_index']);
    Route::post('/change_profile_picture/update', ['as' => 'users.change_profile_picture', 'uses' => 'UserController@change_profile_picture']);


    //errors
    Route::get('restricted_page', function () {
        return view('errors.503');
    });
    //dashboard
    Route::resource('dashboard', 'DashboardController');
    Route::post('module/{id}/add', ['as' => 'dashboard.addModule', 'uses' => 'DashboardController@addModule']);

    Route::get('user/{reset}/password.php', ['as' => 'users.reset_password_user', 'uses' => 'UserController@user_reset_pass']);
    Route::post('user/reset_password/update.php', ['as' => 'users.reset_password_update_user', 'uses' => 'UserController@reset_password_update_user']);

    Route::group(['middleware' => 'chasepage'], function () {
        //modules
        Route::get('modules', ['as' => 'modules.index', 'uses' => 'ModuleController@index']);
        Route::get('modules/{id}/details', ['as' => 'modules.details', 'uses' => 'ModuleController@details']);
        Route::post('modules/edit', ['as' => 'modules.edit', 'uses' => 'ModuleController@edit']);
    });

    Route::group(['middleware' => 'itmodulepage'], function () {
        Route::get('modules/list', ['as' => 'modules.list', 'uses' => 'ModuleController@list']);
        Route::get('module/{id}/details', ['as' => 'module.details', 'uses' => 'ModuleController@show']);
        Route::post('module/edit', ['as' => 'module.edit', 'uses' => 'ModuleController@update']);
    });

    Route::group(['middleware' => 'itemcategmpage'], function () {
        //item categories
        Route::get('item_categories/list', ['as' => 'item_categories.list', 'uses' => 'AssetTrackingController@category_list']);
        Route::get('item_categories/create', ['as' => 'item_categories.create', 'uses' => 'AssetTrackingController@category_show_create']);
        Route::post('item_categories/add', ['as' => 'item_categories.add', 'uses' => 'AssetTrackingController@category_list_store']);
        Route::get('item_categories/{id}/details', ['as' => 'item_categories.details', 'uses' => 'AssetTrackingController@category_list_details']);
        Route::post('item_categories/update', ['as' => 'item_categories.update', 'uses' => 'AssetTrackingController@category_list_update']);
    });

    Route::group(['middleware' => 'reqmodulepage'], function () {
        Route::get('requisition_maintenance', ['as' => 'requisition_maintenance.index', 'uses' => 'RequisitionMaintenanceController@index']);
        Route::post('requisition_maintenance/add', ['as' => 'requisition_maintenance.create', 'uses' => 'RequisitionMaintenanceController@create']);
    });

    Route::group(['middleware' => 'filemaintenancepage'], function () {
        //files
        Route::get('maintenance/files', ['as' => 'files.itindex', 'uses' => 'FileDownloaderController@itindex']);
        Route::post('maintenance/upload', ['as' => 'files.itupload', 'uses' => 'FileDownloaderController@itupload']);
        Route::post('maintenance/delete', ['as' => 'files.delete', 'uses' => 'FileDownloaderController@delete']);
    });

    Route::group(['middleware' => 'rolepage'], function () {
        //role
        Route::resource('roles', 'RoleController');
        Route::post('getRoleDetails', 'RoleController@roleDetails');
        Route::post('roles/updates', ['as' => 'roles.updates', 'uses' => 'RoleController@roleUpdates']);
    });

    Route::group(['middleware' => 'departmentpage'], function () {
        //department
        Route::resource('departments', 'DepartmentController');
        Route::post('getDeptDetails', 'DepartmentController@departDetails');
        Route::post('department/updates', ['as' => 'departments.updates', 'uses' => 'DepartmentController@departUpdates']);
    });

    Route::group(['middleware' => 'supsappage'], function () {
        // SAP Manager
        Route::get('sap_manager', ['as' => 'sap_manager.list', 'uses' => 'ITRequestListController@sapmanagerindex']);
        Route::get('sap_manager/{id}/details', ['as' => 'sap_manager.details', 'uses' => 'ITRequestListController@sapmanagerdetails']);
        Route::post('sap_manager/remark', ['as' => 'sap_manager.remarks', 'uses' => 'ITRequestListController@sapmanagerremarks']);
    });

    Route::group(['middleware' => 'locationpage'], function () {
        //location
        Route::resource('locations', 'LocationController');
        Route::post('getLocDetails', 'LocationController@locationDetails');
        Route::post('locations/updates', ['as' => 'locations.updates', 'uses' => 'LocationController@locationUpdates']);
    });

    Route::group(['middleware' => 'usermaintenancepage'], function () {
        //users
        Route::resource('users', 'UserController');
        Route::get('users/{reset}/password', ['as' => 'users.reset_password', 'uses' => 'UserController@reset_password']);
        Route::post('users/reset_password/update', ['as' => 'users.reset_password_update', 'uses' => 'UserController@reset_password_update']);
        Route::get('users/{id}/activate', ['as' => 'users.activate', 'uses' => 'UserController@activate']);
        Route::get('users/C%Nc$wx%MoY%l1{id}%Nc$/access_control', ['as' => 'users.access_control', 'uses' => 'UserController@access_control']);
        Route::post('users/access_control/store', ['as' => 'users.access_control_store', 'uses' => 'UserController@access_control_store']);
        Route::post('users/import', ['as' => 'users.importnow', 'uses' => 'UserController@import']);
    });

    Route::group(['middleware' => 'museraccesspage'], function () {
        //user access maintenance
        Route::resource('user_access_request', 'UserAccessRequestController');
        Route::get('user_access_request/create/sub', ['as' => 'user_access_request.create_sub', 'uses' => 'UserAccessRequestController@create_sub']);
        Route::get('user_access_request/create/error', ['as' => 'user_access_request.create_error', 'uses' => 'UserAccessRequestController@create_error']);
        Route::post('user_access_request/store/sub', ['as' => 'user_access_request.store_sub', 'uses' => 'UserAccessRequestController@store_sub']);
        Route::post('user_access_request/store/error', ['as' => 'user_access_request.store_error', 'uses' => 'UserAccessRequestController@store_error']);
        Route::get('user_access_request/{id}/edit/sub', ['as' => 'user_access_request.edit_sub', 'uses' => 'UserAccessRequestController@edit_sub']);
        Route::get('user_access_request/{id}/edit/error', ['as' => 'user_access_request.edit_error', 'uses' => 'UserAccessRequestController@edit_error']);
        Route::put('user_access_request/{id}/update/sub', ['as' => 'user_access_request.update_sub', 'uses' => 'UserAccessRequestController@update_sub']);
        Route::put('user_access_request/{id}/update/error', ['as' => 'user_access_request.update_error', 'uses' => 'UserAccessRequestController@update_error']);
    });

    Route::group(['middleware' => 'msuppliespage'], function () {
        //supplies
        Route::resource('supplies', 'SuppliesController');
        Route::post('getSupplyDetails', 'SuppliesController@getDetails');
        Route::post('supplies/updates', ['as' => 'supplies.updates', 'uses' => 'SuppliesController@updates']);
        Route::get('supplies_import', ['as' => 'supplies.import', 'uses' => 'SuppliesController@import']);
        Route::post('supplies/upload', ['as' => 'supplies.upload', 'uses' => 'SuppliesController@upload']);

        //Job Order
        Route::resource('job_order_m', 'JobOrderMaintenanceController');
    });

    Route::group(['middleware' => 'mservicepage'], function () {
        //service request
        Route::resource('service_request', 'ServiceRequestController');
        Route::get('service_request/create/sub', ['as' => 'service_request.create_sub', 'uses' => 'ServiceRequestController@create_sub']);
        Route::get('service_request/create/error', ['as' => 'service_request.create_error', 'uses' => 'ServiceRequestController@create_error']);
        Route::post('service_request/store/sub', ['as' => 'service_request.store_sub', 'uses' => 'ServiceRequestController@store_sub']);
        Route::post('service_request/store/error', ['as' => 'service_request.store_error', 'uses' => 'ServiceRequestController@store_error']);
        Route::get('service_request/{id}/edit/sub', ['as' => 'service_request.edit_sub', 'uses' => 'ServiceRequestController@edit_sub']);
        Route::get('service_request/{id}/edit/error', ['as' => 'service_request.edit_error', 'uses' => 'ServiceRequestController@edit_error']);
        Route::put('service_request/{id}/update/sub', ['as' => 'service_request.update_sub', 'uses' => 'ServiceRequestController@update_sub']);
        Route::put('service_request/{id}/update/error', ['as' => 'service_request.update_error', 'uses' => 'ServiceRequestController@update_error']);
    });

    Route::group(['middleware' => 'itrepspage'], function () {
        //reports
        Route::resource('reports', 'ReportController');
        Route::get('reports/it/department', ['as' => 'reports.it', 'uses' => 'ReportController@itdept']);
    });

    Route::group(['middleware' => 'itpage'], function () {
        //list of requests for IT people
        Route::resource('it_request_list', 'ITRequestListController');
        Route::get('it_request_list/{id}/details', ['as' => 'it_request_list.details', 'uses' => 'ITRequestListController@details']);
    });
    Route::post('it_request_list/add_remarks', ['as' => 'it_request_list.add_remarks', 'uses' => 'ITRequestListController@add_remarks']);

    Route::group(['middleware' => 'manageruseraccpage'], function () {
        // It list for dept manager
        Route::get('user_access_list', ['as' => 'user_access.index', 'uses' => 'ITRequestListController@uaindex']);
        Route::get('user_access/{id}/details', ['as' => 'user_access.details', 'uses' => 'ITRequestListController@uadetails']);
        Route::post('user_access/remarks', ['as' => 'user_access.remarks', 'uses' => 'ITRequestListController@add_remarks']);
    });

    Route::group(['middleware' => 'itmanager'], function () {
        //IT manager pending user access request
        Route::resource('it_manager', 'ITManagerController');

        Route::get('it_manager/{id}/mng_details', ['as' => 'it_request_list.manager_details', 'uses' => 'ITRequestListController@manager_details']);
    });

    Route::group(['middleware' => 'empreqlistpage'], function () {
        // hr employee requisition approver
        Route::get('hrd_emp_req', ['as' => 'hrd_emp_req.list', 'uses' => 'EmployeeRequisitionController@list']);
        Route::get('hrd_emp_req/{id}/details', ['as' => 'hrd_emp_req.details', 'uses' => 'EmployeeRequisitionController@hrdetails']);
        Route::post('hrd_emp_req/remarks', ['as' => 'hrd_emp_req.remarks', 'uses' => 'EmployeeRequisitionController@remarks']);
        Route::post('hrd_emp_req/download', ['as' => 'hrd_emp_req.download_remark', 'uses' => 'EmployeeRequisitionController@download_remark']);
        Route::get('hrd_emp_req/{id}/editDate', ['as' => 'hrd_emp_req.editDate', 'uses' => 'EmployeeRequisitionController@editDate']);
        Route::get('hrd_emp_req/{id}/cancel_hr', ['as' => 'hrd_emp_req.cancel_hr', 'uses' => 'EmployeeRequisitionController@cancel_hr']);
    });

    Route::group(['middleware' => 'empreqhrview'], function () {
        // hr viewing
        Route::get('hrd_emp_req/viewlist', ['as' => 'hrd_emp_req.view_list', 'uses' => 'EmployeeRequisitionController@hrlist']);
        Route::get('hrd_emp_req/{id}/viewdetails', ['as' => 'hrd_emp_req.view', 'uses' => 'EmployeeRequisitionController@hrview']);
    });

    Route::group(['middleware' => 'obplistpage'], function () {
        // hr obp
        Route::get('hrd_obp', ['as' => 'hrd_obp.hr_obp_list', 'uses' => 'OBPController@hr_obp_list']);
        Route::get('hrd_obp/{id}/details', ['as' => 'hrd_obp.details', 'uses' => 'OBPController@hrd_details']);
        Route::get('hrd_obp/{id}/editDate', ['as' => 'hrd_obp.editDate', 'uses' => 'OBPController@editDate']);
        Route::get('hrd_obp/{id}/cancel', ['as' => 'hrd_obp.cancel', 'uses' => 'OBPController@cancel']);
    });

    Route::group(['middleware' => 'requisitionlistpage'], function () {
        // hr requisition
        Route::get('hrd_requisition', ['as' => 'hrd_requisition.hr_requisition_list', 'uses' => 'RequisitionController@hr_requisition_list']);
        Route::get('hrd_requisition/{id}/details', ['as' => 'hrd_requisition.details', 'uses' => 'RequisitionController@hrd_details']);
        Route::post('hrd_requisition/manager_approve', ['as' => 'hrd_requisition.manager_approve', 'uses' => 'RequisitionController@manager_approve']);
    });

    Route::group(['middleware' => 'undertimelistpage'], function () {
        // hr undertime
        Route::get('hrd_undertime', ['as' => 'hrd_undertime.hr_undertime_list', 'uses' => 'UndertimeController@hr_undertime_list']);
        Route::get('hrd_undertime/{id}/details', ['as' => 'hrd_undertime.details', 'uses' => 'UndertimeController@hrd_details']);
        Route::get('hrd_undertime/{id}/cancel', ['as' => 'hrd_undertime.cancel', 'uses' => 'UndertimeController@cancel']);
        Route::get('hrd_undertime/{id}/editDate', ['as' => 'hrd_undertime.editDate', 'uses' => 'UndertimeController@editDate']);
    });

    Route::group(['middleware' => 'workauthlistpage'], function () {
        // hr work auth
        Route::get('hrd_work_authorization', ['as' => 'hrd_work_authorization.hr_work_authorization_list', 'uses' => 'WorkAuthorizationController@hr_work_authorization_list']);
        Route::get('hrd_work_authorization/{id}/details', ['as' => 'hrd_work_authorization.details', 'uses' => 'WorkAuthorizationController@hrd_details']);
        Route::get('hrd_work_authorization/{id}/cancel', ['as' => 'hrd_work_authorization.cancel', 'uses' => 'WorkAuthorizationController@cancel']);
        Route::get('hrd_work_authorization/{id}/editDate', ['as' => 'hrd_work_authorization.editDate', 'uses' => 'WorkAuthorizationController@editDate']);
    });

    Route::group(['middleware' => 'exitpasslistpage'], function () {
        // hr exit pass
        Route::get('hrd_exit_list', ['as' => 'hrd_exit_list.hrd_list', 'uses' => 'EmployeeExitPassController@hrd_list']);
        Route::get('hrd_exit_list/{id}/details', ['as' => 'hrd_exit_list.details', 'uses' => 'EmployeeExitPassController@hrd_details']);
        Route::post('hrd_exit_list/remarks', ['as' => 'hrd_exit.remarks', 'uses' => 'EmployeeExitPassController@remarks']);
    });

    Route::group(['middleware' => 'hrreppage'], function () {
        // hr reports
        Route::get('hrd_reports', ['as' => 'hrd_reports.index', 'uses' => 'HRManagerController@hrd_reports_index']);
        Route::get('work_auth_report', ['as' => 'work_auth.report', 'uses' => 'HRManagerController@work_auth_reports']);
        Route::post('work_auth_report/generate', ['as' => 'work_auth.generate', 'uses' => 'HRManagerController@work_auth_generate']);
        Route::get('obp_request_report', ['as' => 'obp_request.report', 'uses' => 'HRManagerController@obp_request_reports']);
        Route::post('obp_request_report/generate', ['as' => 'obp_request.generate', 'uses' => 'HRManagerController@obp_request_generate']);
        Route::get('requisition_report', ['as' => 'requisition.report', 'uses' => 'HRManagerController@requisition_reports']);
        Route::post('requisition/generate', ['as' => 'requisition.generate', 'uses' => 'HRManagerController@requisition_generate']);
        Route::get('undertime_report', ['as' => 'undertime.report', 'uses' => 'HRManagerController@undertime_reports']);
        Route::post('undertime/generate', ['as' => 'undertime.generate', 'uses' => 'HRManagerController@undertime_generate']);
    });

    Route::group(['middleware' => 'assetreqlistpage'], function () {
        // assets
        Route::get('asset_request_list', ['as' => 'asset_request.lists', 'uses' => 'AssetRequestController@asset_req_list']);
        Route::get('asset_request/{id}/details', ['as' => 'asset_request.details', 'uses' => 'AssetRequestController@details']);
        Route::post('asset_request/remarks', ['as' => 'asset_request.remarks', 'uses' => 'AssetRequestController@remarks']);
        Route::get('asset_request/{id}/release', ['as' => 'asset_request.showrelease', 'uses' => 'AssetRequestController@showrelease']);
        // asset
        Route::get('asset_request/{id}/itemrelease', ['as' => 'asset_request.itemrelease', 'uses' => 'AssetRequestController@itemrelease']);
        Route::post('asset_request/reject', ['as' => 'asset_request.reject', 'uses' => 'AssetRequestController@reject']);
        Route::post('asset_request/releasing', ['as' => 'asset_request.releasing', 'uses' => 'AssetRequestController@release']);
        // non asset
        Route::get('asset_request/{id}/nonassetrelease', ['as' => 'asset_request.nonassetrelease', 'uses' => 'AssetRequestController@nonassetrelease']);
        Route::post('asset_request/nonassetreleasing', ['as' => 'asset_request.nonassetreleasing', 'uses' => 'AssetRequestController@nonassetreleasing']);
        // returning
        Route::post('asset_request/returning', ['as' => 'asset_request.returning', 'uses' => 'AssetRequestController@return']);
    });
    Route::get('asset_request/{id}/removeItem', ['as' => 'asset_request.removeItem', 'uses' => 'AssetRequestController@removeItem']);
    Route::get('asset_request/{id}/editquantity', ['as' => 'asset_request.editquantity', 'uses' => 'AssetRequestController@editquantity']);

    Route::group(['middleware' => 'assetreleasedlistpage'], function () {
        // released assets
        Route::get('released_assets/list', ['as' => 'released_assets.list', 'uses' => 'AssetTrackingController@released_index']);
        Route::post('returned_assets/returning', ['as' => 'returned_assets.returning', 'uses' => 'AssetRequestController@return']);
        Route::post('returned_nonassets/returning', ['as' => 'returned_nonassets.returning', 'uses' => 'AssetRequestController@return_na']);
    });

    Route::group(['middleware' => 'assetreturnedlistpage'], function () {
        //returned assets
        Route::get('returned_assets/list', ['as' => 'returned_assets.list', 'uses' => 'AssetTrackingController@returned_index']);
        // Route::post('returned_assets/returning',['as'=>'returned_assets.returning','uses'=>'AssetTrackingController@returning']);
    });

    Route::group(['middleware' => 'jolistpage'], function () {
        //job order
        Route::get('job_order_request_list', ['as' => 'job_order.list', 'uses' => 'JobOrderRequestController@list']);
        Route::get('job_order_request/{id}/details', ['as' => 'job_order.details', 'uses' => 'JobOrderRequestController@details']);
        Route::post('job_order/admin_remarks', ['as' => 'job_order.admin_remarks', 'uses' => 'JobOrderRequestController@admin_remarks']);
        Route::post('job_order/add_details', ['as' => 'job_order.add_details', 'uses' => 'JobOrderRequestController@add_details']);
    });

    Route::group(['middleware' => 'adminrepspage'], function () {
        // admin reports
        Route::get('admin_reports', ['as' => 'admin_reports.index', 'uses' => 'AdminManagerController@index']);
        Route::post('admin_reports/borrowed/generate', ['as' => 'admin_reports.bgenerate', 'uses' => 'AdminManagerController@bgenerate']);
        Route::post('admin_reports/overdue/generate', ['as' => 'admin_reports.ogenerate', 'uses' => 'AdminManagerController@ogenerate']);
        Route::post('admin_reports/materials/generate', ['as' => 'admin_reports.mgenerate', 'uses' => 'AdminManagerController@mgenerate']);
        Route::post('admin_reports/joborder/generate', ['as' => 'admin_reports.jogenerate', 'uses' => 'AdminManagerController@jogenerate']);
        Route::post('admin_reports/gatepass/generate', ['as' => 'admin_reports.gpgenerate', 'uses' => 'AdminManagerController@gpgenerate']);
    });

    Route::group(['middleware' => 'managerworkauthpage'], function () {
        // work auth dept manager
        Route::get('mng_work_authorization', ['as' => 'mng_work_authorization.mng_work_authorization_list', 'uses' => 'WorkAuthorizationController@mngr_work_authorization_list']);
        Route::get('mng_work_authorization/{id}/details', ['as' => 'mng_work_authorization.mng_work_authorization_details', 'uses' => 'WorkAuthorizationController@mngr_work_authorization_details']);
    });
    // work auth approving
    Route::post('mng_work_authorization/approving', ['as' => 'mng_work_authorization.mng_work_authorization_approving', 'uses' => 'WorkAuthorizationController@approving']);
    Route::post('mng_work_authorization/remarks', ['as' => 'mng_work_authorization.mng_work_authorization_remarks', 'uses' => 'WorkAuthorizationController@mngr_work_authorization_remarks']);

    Route::group(['middleware' => 'managerobppage'], function () {
        // obp dept manager
        Route::get('mng_obp', ['as' => 'mng_obp.mng_obp_list', 'uses' => 'OBPController@mng_obp_list']);
        Route::get('mng_obp/{id}/details', ['as' => 'mng_obp.mng_obp_details', 'uses' => 'OBPController@mng_obp_details']);
        Route::post('mng_obp/remarks', ['as' => 'mng_obp.mng_obp_remarks', 'uses' => 'OBPController@mngr_remarks']);
    });

    Route::group(['middleware' => 'supobppage'], function () {
        //OBP
        Route::get('mngr_obp', ['as' => 'mngr_obp.mngr_obp_list', 'uses' => 'OBPController@mngr_obp_list']);
        Route::get('mngr_obp/{id}/details', ['as' => 'mngr_obp.details', 'uses' => 'OBPController@mngr_details']);
        Route::post('mngr_obp/remarks', ['as' => 'mngr_obp.mngr_remarks', 'uses' => 'OBPController@mngr_remarks']);
    });

    Route::group(['middleware' => 'supundertimepage'], function () {
        //UNDERTIME
        Route::get('mngr_undertime', ['as' => 'mngr_undertime.mngr_undertime_list', 'uses' => 'UndertimeController@mngr_undertime_list']);
        Route::get('mngr_undertime/{id}/details', ['as' => 'mngr_undertime.details', 'uses' => 'UndertimeController@mngr_details']);
        Route::post('mngr_undertime/remarks', ['as' => 'mngr_undertime.mngr_remarks', 'uses' => 'UndertimeController@mngr_remarks']);
    });

    Route::group(['middleware' => 'managerundertimepage'], function () {
        // UNDERTIME
        Route::get('mng_undertime', ['as' => 'mng_undertime.list', 'uses' => 'UndertimeController@dept_mngr_list']);
        Route::get('mng_undertime/{id}/details', ['as' => 'mng_undertime.details', 'uses' => 'UndertimeController@dept_mngr_details']);
        Route::post('mng_undertime/remarks', ['as' => 'mng_undertime.remarks', 'uses' => 'UndertimeController@mngr_remarks']);
    });

    Route::group(['middleware' => 'supworkauthpage'], function () {
        //WORK AUTH
        Route::get('sup_work_authorization', ['as' => 'sup_work_authorization.sup_work_authorization_list', 'uses' => 'WorkAuthorizationController@mngrsup_work_authorization_list']);
        Route::get('sup_work_authorization/{id}/details', ['as' => 'sup_work_authorization.details', 'uses' => 'WorkAuthorizationController@mngrsup_details']);
        Route::post('mngr_work_auth/remarks', ['as' => 'work_authorization_remarks', 'uses' => 'WorkAuthorizationController@workremarks']);
    });

    Route::group(['middleware' => 'suprequisitionpage'], function () {
        //REQUISITION
        Route::get('mngr_requisition', ['as' => 'mngr_requisition.mngr_requisition_list', 'uses' => 'RequisitionController@mngr_requisition_list']);
        Route::get('mngr_requisition/{id}/details', ['as' => 'mngr_requisition.mngr_details', 'uses' => 'RequisitionController@mngr_details']);
        Route::post('mngr_requisition/remarks', ['as' => 'mngr_requisition.mngr_remarks', 'uses' => 'RequisitionController@mngr_remarks']);
    });

    Route::group(['middleware' => 'managerreqpage'], function () {
        // REQUISITION
        Route::get('mng_requisition', ['as' => 'mng_requisition.list', 'uses' => 'RequisitionController@mng_requisition_list']);
        Route::get('mng_requisition/{id}/details', ['as' => 'mng_requisition.details', 'uses' => 'RequisitionController@mng_requisition_details']);
        Route::post('mng_requisition/remarks', ['as' => 'mng_requisition.remarks', 'uses' => 'RequisitionController@mngr_remarks']);
    });

    Route::group(['middleware' => 'supassetpage'], function () {
        //ASSETS
        Route::get('sup_asset_request', ['as' => 'sup_asset_request.sup_asset_request_list', 'uses' => 'AssetRequestController@mngrsup_asset_request_list']);
        Route::get('sup_asset_request/{id}/details', ['as' => 'sup_asset_request.mngr_details', 'uses' => 'AssetRequestController@mngr_details']);
    });

    Route::group(['middleware' => 'manageritempage'], function () {
        // ASSETS
        Route::get('mng_itemrequest', ['as' => 'mng_itemrequest.list', 'uses' => 'AssetRequestController@dept_mng_asset_request_list']);
        Route::get('mng_itemrequest/{id}/details', ['as' => 'mng_itemrequest.details', 'uses' => 'AssetRequestController@dept_mng_details']);
    });
    // superior remarks asset
    Route::post('sup_asset_request/remarks', ['as' => 'sup_asset_request.mngr_remarks', 'uses' => 'AssetRequestController@mngr_remarks']);

    Route::group(['middleware' => 'supjopage'], function () {
        //JOB ORDERS
        Route::get('sup_jo_request', ['as' => 'sup_jo_request.jo_list', 'uses' => 'JobOrderRequestController@mng_list']);
        Route::get('sup_jo_request/{id}/details', ['as' => 'sup_jo_request.jo_detail', 'uses' => 'JobOrderRequestController@mng_details']);
    });
    Route::post('sup_jo_request/remarks', ['as' => 'sup_jo_request.jo_remarks', 'uses' => 'JobOrderRequestController@mng_remarks']);

    //user access request
    Route::get('it_helpdesk/user_access_request', ['as' => 'it_helpdesk.user_access_request', 'uses' => 'ITRequestController@user_access_request_index']);
    Route::post('it_helpdesk/user_access_request/store', ['as' => 'it_helpdesk.user_access_request_store', 'uses' => 'ITRequestController@user_access_request_store']);
    Route::post('it_helpdesk/u_access_sub_category', 'ITRequestController@u_access_sub_category');
    Route::post('it_helpdesk/u_access_error_category', 'ITRequestController@u_access_error_category');

    //user service request
    Route::get('it_helpdesk/service_request', ['as' => 'it_helpdesk.service_request', 'uses' => 'ITRequestController@service_request_index']);
    Route::post('it_helpdesk/service_request/store', ['as' => 'it_helpdesk.service_request_store', 'uses' => 'ITRequestController@service_request_store']);
    Route::post('it_helpdesk/service_request_sub_category', 'ITRequestController@service_request_sub_category');
    Route::post('it_helpdesk/service_request_error_category', 'ITRequestController@service_request_error_category');

    Route::post('it_request_list/remarks_download_files', ['as' => 'it_request_list.remarks_download_files', 'uses' => 'ITRequestListController@remarks_download_files']);
    Route::post('it_request_list/download_files', ['as' => 'it_request_list.download_files', 'uses' => 'ITRequestListController@download_files']);

    //my request

    Route::resource('my_request_list', 'MyRequestController');
    Route::get('my_request_list/it/{id}/details', ['as' => 'my_request_list.details', 'uses' => 'ITRequestListController@details_user']);
    Route::get('my_request_list/it/{id}/cancel', ['as' => 'my_request_list.it_cancel', 'uses' => 'ITRequestListController@cancel']);
    Route::post('my_request_list/asset/add_remarks', ['as' => 'my_request_list.add_remarks', 'uses' => 'MyRequestController@add_remarks']);
    Route::get('my_request_list/asset/{id}/details', ['as' => 'my_request_list.details_asset', 'uses' => 'MyRequestController@davies_asset_request_details']);
    Route::get('my_request/asset/{id}/cancel', ['as' => 'my_request_list.cancel', 'uses' => 'MyRequestController@cancel_asset']);
    Route::post('my_request_list/remarks', ['as' => 'my_request_list.remarks', 'uses' => 'MyRequestController@davies_asset_remarks']);
    Route::get('my_request_list/obp/{id}/details', ['as' => 'my_request_list.details_obp', 'uses' => 'MyRequestController@davies_obp_request_details']);
    Route::post('my_request_list/obp/remarks', ['as' => 'my_request_list.remarks_obp', 'uses' => 'MyRequestController@davies_obp_request_remarks']);
    Route::get('my_request_list/exit_pass/{id}/details', ['as' => 'my_request_list.details_exit_pass', 'uses' => 'MyRequestController@davies_exit_pass_request_details']);
    Route::post('my_request_list/exit_pass/remarks', ['as' => 'my_request_list.remarks_exit_pass', 'uses' => 'MyRequestController@davies_exit_pass_request_remarks']);
    Route::get('my_request_list/undertime/{id}/details', ['as' => 'my_request_list.details_undertime', 'uses' => 'MyRequestController@davies_undertime_request_details']);
    Route::post('my_request_list/undertime/remarks', ['as' => 'my_request_list.remarks_undertime', 'uses' => 'MyRequestController@davies_undertime_request_remarks']);
    Route::get('my_request_list/work_req/{id}/details', ['as' => 'my_request_list.details_work_req', 'uses' => 'MyRequestController@davies_work_req_request_details']);
    Route::get('my_request_list/work_auth/{id}/details', ['as' => 'my_request_list.details_work_auth', 'uses' => 'MyRequestController@davies_work_auth_request_details']);

    //remove item
    Route::get('my_request_list/asset/{id}/delete_item', ['as' => 'my_request_list.delete_item', 'uses' => 'MyRequestController@delete_item']);

    // tagged request
    Route::get('tagged_request_list', ['as' => 'tagged_request_list.list', 'uses' => 'TaggedRequestController@index']);
    Route::get('tagged_request_list/{id}/details', ['as' => 'tagged_request_list.details', 'uses' => 'TaggedRequestController@work_auth_details']);

    Route::group(['middleware' => 'announcepage'], function () {
        //announcement
        Route::get('announcements/list', ['as' => 'announcements.hrlist', 'uses' => 'AnnouncementController@hrlist']);
        Route::post('announcements/delete', ['as' => 'announcements.deleted', 'uses' => 'AnnouncementController@deleted']);
        Route::post('announcements/deptsave', ['as' => 'announcements.deptsave', 'uses' => 'AnnouncementController@deptsave']);
        Route::post('announcements/editsave', ['as' => 'announcements.editsave', 'uses' => 'AnnouncementController@editsave']);
        Route::get('announcements/{id}/depts', ['as' => 'announcements.depts', 'uses' => 'AnnouncementController@depts']);
        Route::resource('announcements', 'AnnouncementController');
    });
    Route::post('getMemoDetails', 'AnnouncementController@getDetails');
    Route::post('memo/download', ['as' => 'memo.download', 'uses' => 'AnnouncementController@download']);
    Route::get('memo/{id}/details', 'AnnouncementController@memo_details');
    Route::post('memo/file/download', ['as' => 'memo.download_files', 'uses' => 'AnnouncementController@download_file']);

    //directory
    Route::resource('directory', 'DirectoryController');

    //asset tracking
    Route::get('userasset_trackings', ['as' => 'userasset_trackings.list', 'uses' => 'AssetTrackingUserController@index']);
    Route::get('userasset_trackings/{id}/route_history', ['as' => 'userasset_trackings.details', 'uses' => 'AssetTrackingUserController@show']);
    Route::resource('asset_trackings', 'AssetTrackingController');
    Route::get('asset_trackings/{id}/route_history', ['as' => 'asset_trackings.route_history', 'uses' => 'AssetTrackingController@route_history']);
    Route::get('asset_trackings/{id}/borrow_history', ['as' => 'asset_trackings.borrow_history', 'uses' => 'AssetTrackingController@borrow_history']);
    Route::post('asset_trackings/route_history_update', ['as' => 'asset_trackings.route_history_update', 'uses' => 'AssetTrackingController@route_history_update']);
    Route::get('asset_trackings/{id}/deactivate', ['as' => 'asset_trackings.deactivate', 'uses' => 'AssetTrackingController@deactivate']);
    Route::get('asset_trackings/{id}/delete', ['as' => 'asset_trackings.delete', 'uses' => 'AssetTrackingController@delete']);
    Route::get('asset_trackings/{id}/activate', ['as' => 'asset_trackings.activate', 'uses' => 'AssetTrackingController@activate']);
    Route::get('asset_trackings/{id}/edit_quantity', ['as' => 'asset_trackings.edit_quantity', 'uses' => 'MyRequestController@edit_quantity']);
    //job order
    Route::get('job_order', ['as' => 'job_order.index', 'uses' => 'JobOrderRequestController@index']);
    Route::get('job_order/create', ['as' => 'job_order.create', 'uses' => 'JobOrderRequestController@create']);
    Route::post('job_order/store', ['as' => 'job_order.store', 'uses' => 'JobOrderRequestController@store']);
    Route::get('job_order_user/{id}/details', ['as' => 'job_order_user.details', 'uses' => 'JobOrderRequestController@user_details']);
    Route::get('job_order_user/{id}/cancel', ['as' => 'job_order_user.cancel', 'uses' => 'JobOrderRequestController@cancel']);
    Route::post('job_order/remarks', ['as' => 'job_order.remarks', 'uses' => 'JobOrderRequestController@remarks']);
    Route::post('job_order/add_dets', ['as' => 'job_order.add_dets', 'uses' => 'JobOrderRequestController@add_dets']);
    Route::post('job_order/remarks_download_files', ['as' => 'job_order.download_file', 'uses' => 'JobOrderRequestController@download']);
    Route::post('get_jo_item_classes', ['as' => 'job_order.getJoItemClasses', 'uses' => 'JobOrderRequestController@getJoItemClasses']);

    //asset Request
    Route::resource('asset_request', 'AssetRequestController');

    Route::post('asset_request/remarks_download_files', ['as' => 'asset_request.remarks_download_files', 'uses' => 'AssetRequestController@download_files']);

    //obp
    Route::resource('obp', 'OBPController');
    Route::get('obp/{id}/details', ['as' => 'obp.details', 'uses' => 'OBPController@details']);
    Route::post('obp/remarks', ['as' => 'obp.remarks', 'uses' => 'OBPController@remarks']);
    Route::post('obp/download', ['as' => 'obp.download', 'uses' => 'OBPController@download']);
    Route::post('obp/cancel', ['as' => 'obp.cancel', 'uses' => 'OBPController@cancel']);

    //undertime
    Route::resource('undertime', 'UndertimeController');
    Route::get('undertime/{id}/details', ['as' => 'undertime.details', 'uses' => 'UndertimeController@details']);
    // Route::get('undertime/{id}/cancel',['as'=>'undertime.cancel_asset','uses'=>'UndertimeController@cancel']);
    Route::post('undertime/cancel', ['as' => 'undertime.cancel', 'uses' => 'UndertimeController@cancel']);
    Route::post('undertime/remarks', ['as' => 'undertime.remarks', 'uses' => 'UndertimeController@remarks']);
    Route::post('undertime/download', ['as' => 'undertime.download', 'uses' => 'UndertimeController@download']);

    //work authorization

    Route::resource('work_authorization', 'WorkAuthorizationController');
    Route::get('work_authorization/{id}/details', ['as' => 'work_authorization.details', 'uses' => 'WorkAuthorizationController@details']);
    // Route::get('work_authorization/{id}/cancel',['as'=>'work_authorization.cancel','uses'=>'WorkAuthorizationController@cancel']);
    Route::post('work_authorization/cancel', ['as' => 'work_authorization.cancel', 'uses' => 'WorkAuthorizationController@cancel']);
    Route::post('work_authorization/remarks', ['as' => 'work_authorization.remarks', 'uses' => 'WorkAuthorizationController@remarks']);

    //manager access
    Route::group(['middleware' => 'suprpage'], function () {
        //
        // Route::get('it_manager/mng_obp_list',['as'=>'manager_obp_index','uses'=>'ManagerController@obp_index']);
        // Route::get('it_manager/{id}/mng_obp_detail',['as'=>'manager_obp_details','uses'=>'ManagerController@obp_details']);
        // //UNDERTIME
        // Route::get('it_manager/mng_undertime_list',['as'=>'manager_undertime_index','uses'=>'ManagerController@undertime_index']);
        // Route::get('it_manager/{id}/mng_undertime_detail',['as'=>'manager_undertime_detail','uses'=>'ManagerController@undertime_detail']);
        // Route::post('it_manager/remarks',['as'=>'manager_undertime_remarks','uses'=>'UndertimeController@undertime_remarks']);
        // Route::post('it_manager/download',['as'=>'manager_undertime_download','uses'=>'UndertimeController@undertime_download']);
        // //REQUISITION
        // Route::get('it_manager/mngr_requisition_list',['as'=>'manager_requisition_index','uses'=>'ManagerController@requisition_index']);
        // Route::get('it_manager/{id}/mngr_requisition_details',['as'=>'manager_requisition_details','uses'=>'ManagerController@requisition_details']);
        // Route::post('it_manager/remarks',['as'=>'manager_requisition_remarks','uses'=>'ManagerController@reqremarks']);
        // //WORK AUTHORIZATION
        // Route::get('it_manager/mng_workauth_list',['as'=>'manager_workauth_index','uses'=>'ManagerController@workauth_index']);
        // Route::get('it_manager/{id}/mng_workauth_detail',['as'=>'manager_workauth_detail','uses'=>'ManagerController@workauth_details']);
        // Route::post('it_manager/remarks',['as'=>'work_authorization_remarks','uses'=>'ManagerController@workremarks']);
    });

    //requisition
    Route::resource('requisition', 'RequisitionController');
    Route::get('requisition/{id}/details', ['as' => 'requisition.details', 'uses' => 'RequisitionController@details']);
    Route::get('requisition/{id}/cancel', ['as' => 'requisition.cancel', 'uses' => 'RequisitionController@cancel']);
    Route::post('requisition/remarks', ['as' => 'requisition.remarks', 'uses' => 'RequisitionController@remarks']);

    // supp emp requisition
    Route::group(['middleware' => 'supempreqpage'], function () {
        Route::get('sup_emp_requisition/list', ['as' => 'sup_emp_requisition.list', 'uses' => 'EmployeeRequisitionController@sup_list']);
        Route::get('sup_emp_requisition/{id}/details', ['as' => 'sup_emp_requisition.details', 'uses' => 'EmployeeRequisitionController@sup_details']);
        Route::post('sup_emp_requisition/remarks', ['as' => 'sup_emp_requisition.remarks', 'uses' => 'EmployeeRequisitionController@remarks']);
    });

    // emp requisition
    Route::resource('emp_requisition', 'EmployeeRequisitionController');
    Route::get('emp_requisition/{id}/details', ['as' => 'emp_requisition.details', 'uses' => 'EmployeeRequisitionController@details']);
    Route::get('emp_requisition/{id}/cancel', ['as' => 'emp_requisition.cancel', 'uses' => 'EmployeeRequisitionController@cancel']);
    Route::post('emp_requisition/remarks', ['as' => 'emp_requisition.remarks', 'uses' => 'EmployeeRequisitionController@remarks']);
    Route::post('emp_requisition/download', ['as' => 'emp_requisition.download', 'uses' => 'EmployeeRequisitionController@download']);

    //supplies request
    Route::resource('supplies_request', 'SuppliesRequestController');
    Route::post('get_supply', 'SuppliesRequestController@getSupply');

    Route::group(['middleware' => 'assetpage'], function () {
        Route::get('supp_request_list', ['as' => 'supplies_request.all_list', 'uses' => 'SuppliesRequestController@all_list']);
        Route::get('supplies_request/{id}/details', ['as' => 'supplies_request.details', 'uses' => 'SuppliesRequestController@details']);
        Route::post('supplies_request/remarks', ['as' => 'supplies_request.remarks', 'uses' => 'SuppliesRequestController@remarks']);
    });

    //employee exit pass
    Route::resource('emp_exit_pass', 'EmployeeExitPassController');
    Route::get('emp_exit_pass/{id}/details', ['as' => 'emp_exit_pass.details', 'uses' => 'EmployeeExitPassController@emp_details']);

    //guard module
    Route::resource('guard_check', 'GuardController');
    Route::post('getpassdetails', 'GuardController@passDetails');
    Route::post('guard_check/store_obp', ['as' => 'guard_check.store_obp', 'uses' => 'GuardController@store_obp']);

    //Sticky Notes
    Route::resource('sticky_notes', 'NoteController');
    Route::post('sticky_notes/delete', ['as' => 'sticky_notes.delt', 'uses' => 'NoteController@delt']);
    Route::post('sticky_notes/details', ['as' => 'sticky_notes.details', 'uses' => 'NoteController@details']);
    Route::post('sticky_notes/updating', ['as' => 'sticky_notes.updating', 'uses' => 'NoteController@updating']);

    // Superior All requests
    Route::group(['middleware' => 'suprequest'], function () {
        Route::resource('superior', 'SuperiorController');
        Route::get('superior_user_access/{id}/details', ['as' => 'sup_user_access.details', 'uses' => 'ITRequestListController@supdetails']);
        Route::post('superior_user_access/remarks', ['as' => 'sup_user_access.remarks', 'uses' => 'ITRequestListController@add_remarks']);
    });

    // Dept Head Employee Requisition
    Route::group(['middleware' => 'mngempreq'], function () {
        Route::get('mng_emp_req_list', ['as' => 'mng_emp_req.view', 'uses' => 'EmployeeRequisitionController@mnglist']);
        Route::get('mng_emp_req/{id}/details', ['as' => 'mng_emp_req.details', 'uses' => 'EmployeeRequisitionController@mngdetails']);
    });

    // Dept Head Job order
    Route::group(['middleware' => 'mngjoreq'], function () {
        Route::get('mng_jo_req_list', ['as' => 'mng_jo_req.list', 'uses' => 'JobOrderRequestController@mnglist']);
        Route::get('mng_jo_req/{id}/details', ['as' => 'mng_jo_req.details', 'uses' => 'JobOrderRequestController@mngdetails']);
    });

    Route::resource('borrow_history', 'AssetHistoryController');

    // approver of employee requisition
    Route::group(['middleware' => 'emprequisitionapprover'], function () {
        Route::get('approver_index', ['as' => 'approver.index', 'uses' => 'EmployeeRequisitionController@approver_index']);
        Route::get('approver_index/{id}/details', ['as' => 'approver.details', 'uses' => 'EmployeeRequisitionController@approver_details']);
        Route::post('approver_index/remarks', ['as' => 'approver.remarks', 'uses' => 'EmployeeRequisitionController@approver_remarks']);
    });

    // Work Auth Checker
    Route::group(['middleware' => 'workauthguard'], function () {
        Route::get('work_auth_checker', ['as' => 'workauth.checker', 'uses' => 'WorkAuthorizationController@guardindex']);
        // Route::post('work_auth_checker_add',['as'=>'workauth.addtime','uses'=>'WorkAuthorizationController@guardadd']);
        Route::post('work_auth_checker_add_time', ['as' => 'workauth.getTime', 'uses' => 'WorkAuthorizationController@get_time']);
        Route::post('work_auth_checker_add_time_to_user', ['as' => 'workauth.addTimeLeft', 'uses' => 'WorkAuthorizationController@add_time']);
        Route::get('guard_reports', ['as' => 'guardrep.index', 'uses' => 'GuardController@guardrepindex']);
        Route::post('guard_reports/getreports', ['as' => 'guardrep.getreports', 'uses' => 'GuardController@guardgetreports']);
    });

    // Supplies request admin
    Route::resource('supplies_request', 'AdminSupplyRequestController');
    Route::post('get_supply_category', ['as' => 'getsupply.category', 'uses' => 'SupplyMaintenanceController@getsupplycategory']);
    Route::get('supplies_request/{id}/details', ['as' => 'supplies_request.view', 'uses' => 'AdminSupplyRequestController@view']);
    Route::post('supplies_request/addNewItem', ['as' => 'supplies_request.addNewItem', 'uses' => 'AdminSupplyRequestController@addNewItem']);

    Route::get('supplies_request/{id}/edit_item_quantity', ['as' => 'supplies_request.edit_item_quantity', 'uses' => 'AdminSupplyRequestController@edit_item_quantity']);
    Route::get('supplies_request/{id}/remove_item', ['as' => 'supplies_request.remove_item', 'uses' => 'AdminSupplyRequestController@remove_item']);

    Route::post('supplies_request/remarks', ['as' => 'supplies_request.remarks', 'uses' => 'AdminSupplyRequestController@remarks']);
    Route::post('supplies_request/cancel', ['as' => 'supplies_request.cancel', 'uses' => 'AdminSupplyRequestController@cancel']);

    // Supplies request superior
    Route::group(['middleware' => 'suppliespagemngr'], function () {
        // Route::get('supplies_request_manager',['as'=>'supplies_request_manager.index','uses'=>'AdminSupplyRequestController@managerindex']);
        Route::get('supplies_request_manager/{id}/details', ['as' => 'supplies_request_manager.view', 'uses' => 'AdminSupplyRequestController@managerview']);
        Route::post('supplies_request_manager/remarks', ['as' => 'supplies_request_manager.remarks', 'uses' => 'AdminSupplyRequestController@remarks']);
    });

    // Supplies request admin
    Route::group(['middleware' => 'suppliespageadmin'], function () {
        Route::get('supplies_request_admin/{id}/releasing', ['as' => 'supplies_request_admin.releasing', 'uses' => 'AdminSupplyRequestController@adminreleasing']);
        Route::post('supplies_request_admin/release', ['as' => 'supplies_request_admin.release', 'uses' => 'AdminSupplyRequestController@release']);

        Route::get('supplies_request_admin/{id}/release_all', ['as' => 'supplies_request_admin.release_all', 'uses' => 'AdminSupplyRequestController@release_all']);
        Route::get('supplies_request_admin/{id}/release_all_items', ['as' => 'supplies_request_admin.release_all_items', 'uses' => 'AdminSupplyRequestController@release_all_items']);
        Route::get('supplies_request_admin', ['as' => 'supplies_request_admin.index', 'uses' => 'AdminSupplyRequestController@adminindex']);
        Route::get('supplies_request_admin/{id}/details', ['as' => 'supplies_request_admin.view', 'uses' => 'AdminSupplyRequestController@adminview']);
        Route::post('supplies_request_admin/remarks', ['as' => 'supplies_request_admin.remarks', 'uses' => 'AdminSupplyRequestController@remarks']);
        Route::post('supplies_request_admin/reject', ['as' => 'supplies_request_admin.reject', 'uses' => 'AdminSupplyRequestController@reject']);
        Route::post('supplies_request_admin/other_details', ['as' => 'supplies_request_admin.add_details', 'uses' => 'AdminSupplyRequestController@other_details']);
    });

    // Supplies request dept head
    Route::group(['middleware' => 'mngsuppreq'], function () {
        Route::get('supplies_request_head', ['as' => 'supplies_request_head.index', 'uses' => 'AdminSupplyRequestController@headindex']);
        Route::get('supplies_request_head/{id}/details', ['as' => 'supplies_request_head.view', 'uses' => 'AdminSupplyRequestController@headview']);
        Route::post('supplies_request_head/remarks', ['as' => 'supplies_request_head.remarks', 'uses' => 'AdminSupplyRequestController@remarks']);
    });

    //Admin Job Order
    Route::group(['middleware' => 'adminjoborder'], function () {
        Route::get('job_order_admin', ['as' => 'job_order_admin.list', 'uses' => 'JobOrderRequestController@admin_list']);
        Route::get('job_order_admin/{id}/details', ['as' => 'job_order_admin.details', 'uses' => 'JobOrderRequestController@admin_details']);
        Route::get('job_order_admin/{id}/editprovider', ['as' => 'job_order_admin.editprovider', 'uses' => 'JobOrderRequestController@editprovider']);
        Route::post('job_order_admin/add_info', ['as' => 'job_order_admin.add_info', 'uses' => 'JobOrderRequestController@add_info']);
    });

    // Room Maintenance
    Route::group(['middleware' => 'roompage'], function () {
        Route::resource('rooms', 'RoomMaintenanceController');
    });

    // Room Request
    Route::resource('room_reqs', 'RoomRequestController');
    Route::post('room_reqs/remarks', ['as' => 'room_reqs.remarks', 'uses' => 'RoomRequestController@remarks']);
    Route::post('room_reqs/cancel', ['as' => 'room_reqs.cancel', 'uses' => 'RoomRequestController@cancel']);

    // Room Request Admin
    Route::group(['middleware' => 'adminroomreq'], function () {
        Route::get('room_request_list', ['as' => 'room_request_list.index', 'uses' => 'RoomRequestController@adminindex']);
        Route::get('room_request_list/{id}/details', ['as' => 'room_request_list.details', 'uses' => 'RoomRequestController@admindetails']);
        Route::get('room_request_list/{id}/cancel', ['as' => 'room_request_list.cancel', 'uses' => 'RoomRequestController@cancel']);
        Route::post('room_request_list/remarks', ['as' => 'room_request_list.remarks', 'uses' => 'RoomRequestController@adminremarks']);
    });

    // Supply Maintenance
    Route::group(['middleware' => 'adminsupreq'], function () {
        Route::resource('supply_m', 'SupplyMaintenanceController');
        Route::post('supply_m/import', ['as' => 'supply_m.import', 'uses' => 'SupplyMaintenanceController@import']);
    });

    // all users gatepass
    Route::resource('gatepass', 'GatePassController');
    Route::post('gatepass/new_item', ['as' => 'gatepass.addNewItem', 'uses' => 'GatePassController@addNewItem']);
    Route::post('gatepass/remarks', ['as' => 'gatepass.remarks', 'uses' => 'GatePassController@remarks']);
    Route::post('gatepass/download', ['as' => 'gatepass.download', 'uses' => 'GatePassController@download']);
    Route::get('gatepass/{id}/edit_gatepass_item_quantity', ['as' => 'gatepass.edit_gatepass_item_quantity', 'uses' => 'GatePassController@edit_gatepass_item_quantity']);
    Route::get('gatepass/{id}/cancel', ['as' => 'gatepass.cancel', 'uses' => 'GatePassController@cancel']);


    // admin gatepass (issued by)
    Route::group(['middleware' => 'adminissueby'], function () {
        Route::get('gatepassadmin', ['as' => 'gatepass.adminlist', 'uses' => 'GatePassController@admin_list']);
        Route::get('gatepassadmin/{id}/details', ['as' => 'gatepass.admindetails', 'uses' => 'GatePassController@admin_details']);
    });

    // admin manager gatepass
    Route::group(['middleware' => 'adminmanagerby'], function () {
        Route::get('gatepassadminmanager', ['as' => 'gatepass.m_admin_list', 'uses' => 'GatePassController@admin_manager_list']);
        Route::get('gatepassadminmanager/{id}/details', ['as' => 'gatepass.m_admin_details', 'uses' => 'GatePassController@admin_manager_details']);
        Route::get('gatepassadminmanager/{id}/edit_gatepass_item_quantity', ['as' => 'gatepass.edit_gatepass_item_quantity', 'uses' => 'GatePassController@edit_gatepass_item_quantity']);
        Route::get('gatepassadminmanager/{id}/cancel', ['as' => 'gatepass.cancel', 'uses' => 'GatePassController@cancel']);
    });

    // guard gatepass
    Route::group(['middleware' => 'adminbyguard'], function () {
        Route::get('guardgatepass', ['as' => 'gatepass.guard', 'uses' => 'GatePassController@guard_admin_list']);
        Route::get('guardgatepass/{id}/details', ['as' => 'gatepass.g_admin_list', 'uses' => 'GatePassController@guard_details']);
    });

    Route::get('obp/{obpid}/{uid}/generate', 'OBPController@downloadPDF');
    Route::get('undertime/{underID}/{uid}/generate', 'UndertimeController@downloadPDF');
    Route::get('job_order/{joID}/{uid}/generate', 'JobOrderRequestController@downloadPDF');
    Route::get('borrower_slip/{reqno}/{uid}/generate', 'AssetRequestController@downloadPDF');
    Route::get('mrs-generate/{req_no}/{uid}/generate', 'AdminSupplyRequestController@downloadPDF');
    Route::get('gatepass/{gpid}/{uid}/generate', 'GatePassController@downloadPDF');
});
