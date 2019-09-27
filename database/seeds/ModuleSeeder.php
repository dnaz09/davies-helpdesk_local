<?php

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('modules')->truncate();
        DB::statement("INSERT INTO modules (id, module, description, department, routeUri, default_url, icon, created_at, updated_at) VALUES
			(4, 'Work Authorization Request','Work Authorization Request Dept (For Department Head)','My Department (For Department Head)','mng_work_authorization.mng_work_authorization_list','mng_work_authorization','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(5, 'OB Request','OB Dept (For Department Head)','My Department (For Department Head)','mng_obp.mng_obp_list','mng_obp.mng_obp_list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(6, 'OB','OB Request Superior','Superior (For Superiors)','mngr_obp.mngr_obp_list','mngr_obp','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(7, 'Leave','Leave Request Superior','Superior (For Superiors)','mngr_undertime.mngr_undertime_list','mngr_undertime','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(8, 'Requisition','Requisition Request Superior','Superior (For Superiors)','mngr_requisition.mngr_requisition_list','mngr_requisition','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(9, 'Work Authorization','Work Authorization Superior','Superior (For Superiors)','sup_work_authorization.sup_work_authorization_list','sup_work_authorization','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(10, 'Borrowed Items Request','Borrowed Items Request Superior','Superior (For Superiors)','sup_asset_request.sup_asset_request_list','sup_asset_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(11, 'Job Order Request','Job Order Request Superior','Superior (For Superiors)','sup_jo_request.jo_list','sup_jo_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(12, 'Item Categories','Item Categories Maintenance','Maintenance (For IT Department)','item_categories.list','item_categories/list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(13, 'File Maintenance','File Maintenance ','Maintenance (For IT Department)','files.itindex','maintenance/files','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(14, 'Role','Roles Maintenance','Maintenance (For IT Department)','roles.index','roles','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(15, 'Departments','Department Maintenance','Maintenance (For IT Department)','departments.index','departments','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(16, 'Locations','Locations Maintenance','Maintenance (For IT Department)','locations.index','locations','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(17, 'Users','Users Maintenance','Maintenance (For IT Department)','users.index','users','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(18, 'M-User Access Request','M-User Access Request','Maintenance (For IT Department)','user_access_request.index','user_access_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(19, 'M-Supplies','M-Supply','Maintenance (For IT Department)','supplies.index','supplies','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(20, 'M-Service Request','M-Service Request','Maintenance (For IT Department)','service_request.index','service_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(21, 'SAP Approval','For Approval Request (For Ms. Tiffany Ngkaion Only)','SAP Approval (For Ms. Tiffany Ngkaion Only)','it_manager.index','it_manager','fa fa-thumbs-up fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(22, 'User Access','User Access Request','Information Technology Request','it_helpdesk.user_access_request','it_helpdesk/user_access_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(23, 'Service','Service Request','Information Technology Request','it_helpdesk.service_request','it_helpdesk/service_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(24, 'IT Request Lists','IT Request Lists','Information Technology Department (For IT Department)','it_request_list.index','it_request_list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(25, 'IT Reports','IT Reports','Information Technology Department (For IT Department)','reports.it','reports/it/department','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(26, 'Announcement','Announcement','Announcements','announcements.index','announcements','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(27, 'OB','OB User Request','HRD Request','obp.index','obp','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(28, 'HRD OB List','HRD OB List','HRD Department (For HRD Department)','hrd_obp.hr_obp_list','hrd_obp','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(29, 'Requisition','Requisition User Request','HRD Request','requisition.index','requisition','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(30, 'HRD Requisition List','HRD Requisition List','HRD Department (For HRD Department)','hrd_requisition.hr_requisition_list','hrd_requisition','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(31, 'Leave','Leave User Request','HRD Request','undertime.index','undertime','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(32, 'HRD Leave List','HRD Leave List','HRD Department (For HRD Department)','hrd_undertime.hr_undertime_list','hrd_undertime','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(33, 'Work Authorization','Work Authorization User Request','HRD Request','work_authorization.index','work_authorization','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(34, 'HRD Work Authorization List','HRD Work Authorization List','HRD Department (For HRD Department)','hrd_work_authorization.hr_work_authorization_list','hrd_work_authorization','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(35, 'HRD Exit Pass List','HRD Exit Pass List','HRD Department (For HRD Department)','hrd_exit_list.hrd_list','hrd_exit_list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(36, 'HRD Reports','HRD Reports','HRD Department (For HRD Department)','hrd_reports.index','hrd_reports','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(37, 'Borrowers Request','Borrowers Request User','Admin Request','asset_request.index','asset_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(38, 'Job Order Request','Job Order Request User','Admin Request','job_order.index','job_order','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(39, 'Borrowed Items Tracking','Item Tracking Admin','Admin Department (For Admin Department)','asset_trackings.index','asset_trackings','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(40, 'Released Items','Released Items Admin','Admin Department (For Admin Department)','released_assets.list','released_assets/list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(41, 'Returned Items','Returned Items Admin','Admin Department (For Admin Department)','returned_assets.list','returned_assets/list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(42, 'Borrowers Request List','Borrowers Request List Admin','Admin Department (For Admin Department)','asset_request.lists','released_assets/list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(44, 'Admin Reports','Admin Reports','Admin Department (For Admin Department)','admin_reports.index','admin_reports','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(45, 'Exit Pass Checker','Exit Pass Checker','Guard','guard_check.index','guard_check','fa fa-unlock-alt fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(46, 'Module Maintenance','Module Maintenance','Maintenance (For IT Department)','modules.list','modules/list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(47, 'SAP Request','Sap Manager Approval','Superior (For Superiors)','sap_manager.list','sap_manager','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(48, 'Requisition Maintenance','Requisition Maintenance','Maintenance (For IT Department)','requisition_maintenance.index','requisition_maintenance','fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(49, 'Employee Requisition List (Approver)','List of Requisition of Employee Approver','HRD Department (For HRD Employee Requisition Approver)','hrd_emp_req.list','hrd_emp_req','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(50, 'Employee Requisition','Requisition Employee Request','HRD Request (For Department Head Only)','emp_requisition.index','emp_requisition','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(51, 'Employee Requisition Request','Request List of Requisition of Employee','Superior (For Superiors)','sup_emp_requisition.list','sup_emp_requisition/list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(52, 'Leave Request','Request List of Leave (For Department Head)','My Department (For Department Head)','mng_undertime.list','mng_undertime','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(53, 'Requisition Request','Request List of Requisition (For Department Head)','My Department (For Department Head)','mng_requisition.list','mng_requisition','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(54, 'Borrowed Items','Request List of Items (For Department Head)','My Department (For Department Head)','mng_itemrequest.list','mng_itemrequest','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(55, 'Request for Approval', 'Request List of Superior','Superior (For Superiors)', 'superior.index', 'superior', 'fa fa-thumbs-up fa-1x', '2018-05-11 16:39:12', '2018-05-11 16:39:12'),
			(56, 'User Access', 'Request List of User Access (For Department Head)', 'My Department (For Department Head)', 'user_access.index', 'user_access_list', 'fa fa-thumbs-up fa-1x', '2018-05-11 16:39:12', '2018-05-11 16:39:12'),
			(57, 'Employee Requisition List (HR)', 'Request List of Employee Requisition', 'HRD Department (For HRD Department)', 'hrd_emp_req.view_list', 'hrd_emp_req/viewlist', 'fa fa-thumbs-up fa-1x', '2018-05-11 16:39:12', '2018-05-11 16:39:12'),
			(58, 'Employee Requisition', 'Request List of Employee Requisition', 'My Department (For Department Head)', 'mng_emp_req.view', 'mng_emp_req_list', 'fa fa-thumbs-up fa-1x', '2018-05-11 16:39:12', '2018-05-11 16:39:12'),
			(59, 'Job Order', 'Request List of Job Order', 'My Department (For Department Head)', 'mng_jo_req.list', 'mng_jo_req_list', 'fa fa-thumbs-up fa-1x', '2018-05-11 16:39:12', '2018-05-11 16:39:12'),
			(60, 'Employee Requisition Approval', 'List of Employee Requisitions', 'HRD Department (For Ms. Vicky Only)', 'approver.index', 'approver_index', 'fa fa-thumbs-up fa-2x', '2018-05-11 16:39:12', '2018-05-11 16:39:12'),
			(61, 'Announcements List', 'List of Announcements', 'Announcements', 'announcements.hrlist', 'announcements/list', 'fa fa-thumbs-up fa-1x', '2018-05-11 16:39:12', '2018-05-11 16:39:12'),
			(62, 'WAS Checker', 'List Of Work Auths', 'Guard', 'workauth.checker', 'work_auth_checker','fa fa-unlock-alt fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(63, 'MRS List', 'List of Material Request', 'Admin Department (For Admin Department)', 'supplies_request_admin.index', 'supplies_request_admin','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(64, 'Material Request Form', 'Request Material', 'Admin Request', 'supplies_request.index', 'supplies_request','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(65, 'Material Request', 'List of Suppplies Request', 'My Department (For Department Head)', 'supplies_request_head.index', 'supplies_request_head','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(66, 'Job Order List', 'List of Approved Job Order', 'Admin Department (For Admin Department)', 'job_order_admin.list', 'job_order_admin','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(67, 'Room Request List', 'List of Room Request List', 'Admin Department (For Admin Department)', 'room_request_list.index', 'room_request_list','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(68, 'Room Request Maintenance', 'Room Maintenance', 'Maintenance (For IT Department)', 'rooms.index', 'rooms','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(69, 'Room Reservation Request', 'Room Request', 'Admin Request', 'room_reqs.index', 'room_reqs','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(70, 'Material List Maintenance', 'Supplies Maintenance', 'Admin Department (For Admin Department)', 'supply_m.index', 'supply_m','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(71, 'Job Order Maintenance', 'Job Order Maintenance', 'Maintenance (For IT Department)', 'job_order_m.index', 'job_order_m','fa fa-thumbs-up fa-1x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(72, 'Guard Reports', 'Guard Report', 'Guard', 'guardrep.index', 'guard_reports','fa fa-file fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(73, 'Gatepass List (Issued By)', 'Gatepass', 'Admin Department (For Admin Department)', 'gatepass.adminlist', 'gatepassadmin','fa fa-file fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(74, 'Gate Pass List (Admin Manager)', 'Gate Pass', 'Admin Department (For Admin Department Manager)', 'gatepass.m_admin_list', 'gatepassadminmanager','fa fa-file fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(75, 'Gate Pass Request', 'Gate Pass', 'Admin Request', 'gatepass.index', 'gatepassadmin','fa fa-file fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12'),
			(76, 'Gate Pass Checker', 'Gate Pass', 'Guard', 'gatepass.guard', 'guardgatepass','fa fa-unlock-alt fa-2x','2018-05-11 16:39:12','2018-05-11 16:39:12')
			;");
    }
}
