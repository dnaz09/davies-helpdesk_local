<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'maintenancepage' => \App\Http\Middleware\MaintenancePage::class,
        'hrpage' => \App\Http\Middleware\HRPage::class,
        'assetpage' => \App\Http\Middleware\AssetPage::class,
        'itmanager' => \App\Http\Middleware\ITManagerPage::class,
        'mngrpage' => \App\Http\Middleware\DeptManagerPage::class,
        'hrmanager' => \App\Http\Middleware\HRManagerPage::class,
        'suprpage' => \App\Http\Middleware\SuperiorPage::class,
        'adminmanager' => \App\Http\Middleware\AdminManagerPage::class,
        // maintenance modules
        'chasepage' => \App\Http\Middleware\ChasePage::class,
        'itemcategmpage' => \App\Http\Middleware\ItemCategoriesMaintenancePage::class,
        'filemaintenancepage' => \App\Http\Middleware\FileMaintenancePage::class,
        'rolepage' => \App\Http\Middleware\RolePage::class,
        'departmentpage' => \App\Http\Middleware\DepartmentPage::class,
        'locationpage' => \App\Http\Middleware\LocationPage::class,
        'usermaintenancepage' => \App\Http\Middleware\UserMaintenancePage::class,
        'museraccesspage' => \App\Http\Middleware\MUserMaintenancePage::class,
        'msuppliespage' => \App\Http\Middleware\MSuppliesPage::class,
        'mservicepage' => \App\Http\Middleware\MServicePage::class,
        'itmodulepage' => \App\Http\Middleware\ITModulePage::class,
        'reqmodulepage' => \App\Http\Middleware\ReqMaintenancePage::class,
        'roompage' => \App\Http\Middleware\RoomMaintenancePage::class,
        // it helpdesk
        'itpage' => \App\Http\Middleware\ITPage::class,
        // it reports
        'itrepspage' => \App\Http\Middleware\ITReportPage::class,
        // announcement
        'announcepage' => \App\Http\Middleware\AnnouncementPage::class,
        // hr modules
        'obplistpage' => \App\Http\Middleware\OBPListPage::class,
        'requisitionlistpage' => \App\Http\Middleware\RequisitionListPage::class,
        'undertimelistpage' => \App\Http\Middleware\UndertimeListPage::class,
        'workauthlistpage' => \App\Http\Middleware\WorkAuthListPage::class,
        'exitpasslistpage' => \App\Http\Middleware\ExitPassListPage::class,
        'empreqhrview' => \App\Http\Middleware\EmployeeReqHrView::class,
        'leavereqpage' => \App\Http\Middleware\LeaveReqHrPage::class,
        // hr approver
        'empreqlistpage' => \App\Http\Middleware\EmployeeReqListPage::class,
        // hr reports
        'hrreppage' => \App\Http\Middleware\HRReportPage::class,
        // admin modules
        'assetreqlistpage' => \App\Http\Middleware\AssetRequestListPage::class,
        'assetreleasedlistpage' => \App\Http\Middleware\AssetReleasedListPage::class,
        'assetreturnedlistpage' => \App\Http\Middleware\AssetReturnedListPage::class,
        'jolistpage' => \App\Http\Middleware\JOListPage::class,
        'suppliespageadmin' => \App\Http\Middleware\SuppliesRequestPageAdmin::class,
        'adminjoborder' => \App\Http\Middleware\JobOrderAdminPage::class,
        'adminroomreq' => \App\Http\Middleware\AdminRoomRequestListPage::class,
        'adminsupreq' => \App\Http\Middleware\AdminSupplyMaintenancePage::class,
        'adminissueby' => \App\Http\Middleware\GatePassIssueByPage::class,
        'adminmanagerby' => \App\Http\Middleware\GatePassManagerPage::class,
        'adminbyguard' => \App\Http\Middleware\GatePassGuardPage::class,
        // admin reports
        'adminrepspage' => \App\Http\Middleware\AdminReportsPage::class,
        // dept manager modules
        'managerworkauthpage' => \App\Http\Middleware\ManagerWorkAuthPage::class,
        'managerobppage' => \App\Http\Middleware\ManagerOBPPage::class,
        'managerundertimepage' => \App\Http\Middleware\ManagerUndertimePage::class,
        'managerreqpage' => \App\Http\Middleware\ManagerReqPage::class,
        'manageritempage' => \App\Http\Middleware\ManagerItemRequestPage::class,
        'manageruseraccpage' => \App\Http\Middleware\UserAccessDeptManagerPage::class,
        'mngempreq' => \App\Http\Middleware\ManagerEmployeeRequisition::class,
        'mngjoreq' => \App\Http\Middleware\DeptHeadJobOrder::class,
        'mngsuppreq' => \App\Http\Middleware\SuppliesRequestPageHead::class,
        'mngleave' => \App\Http\Middleware\LeaveRequestManagerPage::class,
        // superior modules
        'supobppage' => \App\Http\Middleware\SuperiorOBPPage::class,
        'supundertimepage' => \App\Http\Middleware\SuperiorUndertimePage::class,
        'suprequisitionpage' => \App\Http\Middleware\SuperiorRequisitionPage::class,
        'supworkauthpage' => \App\Http\Middleware\SuperiorWorkAuthPage::class,
        'supassetpage' => \App\Http\Middleware\SuperiorAssetPage::class,
        'supjopage' => \App\Http\Middleware\SuperiorJOPage::class,
        'supsappage' => \App\Http\Middleware\SAPManagerPage::class,
        'supempreqpage' => \App\Http\Middleware\EmployeeRequisitionSuperiorPage::class,
        'suprequest' => \App\Http\Middleware\SuperiorRequestPage::class,
        'suppliespagemngr' => \App\Http\Middleware\SuperiorRequestPage::class,
        'supleavereq' => \App\Http\Middleware\SuperiorLeaveReqPage::class,
        // employee requisition approver
        'emprequisitionapprover' => \App\Http\Middleware\EmployeeRequisitionApproverPage::class,
        // work auth guard
        'workauthguard' => \App\Http\Middleware\WorkAuthGuardPage::class,
    ];
}
