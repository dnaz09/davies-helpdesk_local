<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MessageSent' => [
            'App\Listeners\SendChatMessage',
        ],

        'App\Events\UserLogged' => [
            'App\Listeners\UserLogged1'
        ],
        
        'App\Events\GroupCreated' => [
            'App\Listeners\CreatedGroup',
        ],

        'App\Events\GroupMessageSent' => [
            'App\Listeners\SentGroupMessage',
        ],

        'App\Events\ServiceRequestSent' => [
            'App\Listeners\SentServiceRequest',
        ],

        'App\Events\UserAccessRequestSent' => [
            'App\Listeners\SentUserAccessRequest'
        ],

        'App\Events\MTDashboardLoader' => [
            'App\Listeners\LoaderMTDashboard'
        ],

        'App\Events\UsersRemoved' => [
            'App\Listeners\RemovedUsers',
        ],

        'App\Events\UserAdded' => [
            'App\Listeners\AddedUsers',
        ],

        'App\Events\ManagerOBPSent' => [
            'App\Listeners\SentManagerOBP',
        ],

        'App\Events\ManagerReqSent' => [
            'App\Listeners\SentManagerReq',
        ],

        'App\Events\ManagerUndertimeSent' => [
            'App\Listeners\SentManagerUndertime',
        ],

        'App\Events\ManagerWorkAuthSent' => [
            'App\Listeners\SentManagerWorkAuth',
        ],

        'App\Events\OBPSent' => [
            'App\Listeners\SentOBP',
        ],

        'App\Events\UndertimeSent' => [
            'App\Listeners\SentUndertime',
        ],

        'App\Events\ReqSent' => [
            'App\Listeners\SentReq',
        ],

        'App\Events\SuppReqSent' => [
            'App\Listeners\SentSuppReq'
        ],

        'App\Events\AssetReqSent' => [
            'App\Listeners\SentAssetReq'
        ],

        'App\Events\WorkAuthSent' => [
            'App\Listeners\SentWorkAuth',
        ],

        'App\Events\HrDashboardLoader' => [
            'App\Listeners\LoaderHrDashboard'
        ],

        'App\Events\ItDashboardLoader' => [
            'App\Listeners\LoaderItDashboard'
        ],

        'App\Events\AdminDashboardLoader' => [
            'App\Listeners\LoaderAdminDashboard'
        ],

        'App\Events\ExpiredAssetSent' => [
            'App\Listeners\SentExpiredAsset'
        ],

        'App\Events\AnnouncementPosted' => [
            'App\Listeners\PostedAnnouncement'
        ],

        'App\Events\SuperiorAssetSent' => [
            'App\Listeners\SentSuperiorAsset'
        ],

        'App\Events\SuperiorJOSent' => [
            'App\Listeners\SentSuperiorJO'
        ],

        'App\Events\JOReqSent' => [
            'App\Listeners\SentJOReq'
        ],

        'App\Events\AssetReqApproved' => [
            'App\Listeners\ApprovedAssetReq'
        ],

        'App\Events\JOReqApproved' => [
            'App\Listeners\ApprovedJOReq'
        ],

        'App\Events\OBPReqApproved' => [
            'App\Listeners\ApprovedOBPReq'
        ],

        'App\Events\ReqApproved' => [
            'App\Listeners\ApprovedReq'
        ],

        'App\Events\UndertimeApproved' => [
            'App\Listeners\ApprovedUndertime'
        ],

        'App\Events\WorkAuthApproved' => [
            'App\Listeners\ApprovedWorkAuth'
        ],

        'App\Events\MamTiffSent' => [
            'App\Listeners\SentMamTiff'
        ],

        'App\Events\ExitPassSent' => [
            'App\Listeners\SentExitPass'
        ],

        'App\Events\ExitPassApproved' => [
            'App\Listeners\ApprovedExitPass',
        ],
        
        'App\Events\WorkAuthUserOk' => [
            'App\Listeners\OkWorkAuthUser',
        ],

        'App\Events\FileSent' => [
            'App\Listeners\SentFile'
        ],

        'App\Events\GroupFileSent' => [
            'App\Listeners\SentGroupFile'
        ],

        'App\Events\WorkAuthApprovedPerson' => [
            'App\Listeners\PersonWorkAuthApproved'
        ],

        'App\Events\SAPSentToSuperior' => [
            'App\Listeners\SuperiorSAPSent'
        ],

        'App\Events\OBPRequestSent' => [
            'App\Listeners\SentOBPRequest'
        ],

        'App\Events\WorkAuthRequested' => [
            'App\Listeners\RequestedWorkAuth'
        ],

        'App\Events\UndertimeRequested' => [
            'App\Listeners\RequestedUndertime'
        ],

        'App\Events\RequisitionRequested' => [
            'App\Listeners\RequestedRequisition'
        ],

        'App\Events\AssetRequested' => [
            'App\Listeners\RequestedAsset'
        ],

        'App\Events\UserAccessSent' => [
            'App\Listeners\SentUserAccess'
        ],

        'App\Events\UserAccessSentSup' => [
            'App\Listeners\SentSupUserAccess'
        ],

        'App\Events\EmployeeReqSent' => [
            'App\Listeners\SentEmployeeReq'
        ],

        'App\Events\EmployeeReqApprovedSup' => [
            'App\Listeners\SupApprovedEmployeeReq'
        ],

        'App\Events\EmployeeReqApprovedHR' => [
            'App\Listeners\HRApprovedEmployeeReq'
        ],

        'App\Events\EmployeeReqSentToDeptHead' => [
            'App\Listeners\DeptHeadEmployeeReqSent'
        ],

        'App\Events\DeptHeadJOSent' => [
            'App\Listeners\SentJODeptHead'
        ],

        'App\Events\SentToMamVicky' => [
            'App\Listeners\MamVickyNotified'
        ],

        'App\Events\ApprovedByMamVicky' => [
            'App\Listeners\MamVickyApproved'
        ],

        'App\Events\SupplyRequestSend' => [
            'App\Listeners\SentSupplyRequest'
        ],

        'App\Events\SupplyRequestSendtoHead' => [
            'App\Listeners\SenttoHeadSupplyRequest'
        ],

        'App\Events\SendToAdminDept' => [
            'App\Listeners\SentToAdminDept'
        ],

        'App\Events\ApproveByAdminDept' => [
            'App\Listeners\ApprovedByAdminDept'
        ],

        'App\Events\JobOrderStatusToggler' => [
            'App\Listeners\TogglerJobOrder'
        ],

        'App\Events\SendRoomRequest' => [
            'App\Listeners\RoomRequestSent'
        ],

        'App\Events\ChangeStatusRoomRequest' => [
            'App\Listeners\RoomRequestStatusChanged'
        ],

        'App\Events\RoomRequestClosed' => [
            'App\Listeners\ClosedRoomRequest'
        ],

        'App\Events\NewGatePass' => [
            'App\Listeners\NewGatePassGenerated'
        ],

        'App\Events\GatePassMoveToManager' => [
            'App\Listeners\GatePassMovedToManager'
        ],

        'App\Events\GatePassMoveToGuard' => [
            'App\Listeners\GatePassMovedToGuard'
        ],

        'App\Events\GatePassApproved' => [
            'App\Listeners\ApprovedGatePass'
        ],

        'App\Events\GatePassForClosing' => [
            'App\Listeners\ClosingGatePass'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
