<?php

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->truncate();

		DB::statement("INSERT INTO modules (id, module, description, routeUri, default_url, icon) VALUES
			(1, 'Modules', 'Maintenance for Module','modules','modules.index','fa fa-leaf  fa-2x'),

			(2, 'Departments', 'Maintenance for Department','departments','departments.index','fa fa-building fa-2x'),

			(3, 'Roles', 'Maintenance for Role','roles','roles.index','fa fa-futbol-o fa-2x'),

			(4, 'Users', 'Maintenance for Users','users','users.index','fa fa-users fa-2x'),

			(5, 'Access Control', 'Maintenance for Access Control','access_controls','access_controls.index','fa fa-shield fa-2x'),

			(6, 'System Logs', 'This will have an audit trail','system_logs','system_logs.index','fa fa-book fa-2x'),
			
			(7, 'Messages', 'Private Message To other Users','messages','messages.index','fa fa-envelope fa-2x'),

			(8, 'Message Report', 'Monitor Employees who did not read messages','report/messages','reports.messages','fa fa-gavel fa-2x'),
		
			(9, 'Directory', 'List of all active users with their locals, status and location in the building.','directory','directory.index','fa fa-search fa-2x'),

			(10, 'User Access Request', 'Where you can submit a request to IT Department.','it_helpdesk/user_access_request','it_helpdesk.index','fa fa-computer fa-2x'),

			(11, 'M-UAR', 'Maintenance for User Access Request By Adding Category and Sub Category.','user_access_request','user_access_request.index','fa fa-computer fa-2x'),

			(12, 'M-SR', 'Maintenance for Service Request By Adding Category and Sub Category.','service_request','service_request.index','fa fa-computer fa-2x'),			
			
			(13, 'Service Request', 'Where you can submit a request to IT Department.','it_helpdesk/service_request','it_helpdesk.service_index','fa fa-computer fa-2x'),

			(14, 'IT Requests Lists', 'Module where you can see all request for it department.','it_request_list','it_request_list.index','fa fa-computer fa-2x'),

			(15, 'My Request', 'Module where you can see all your request.','my_request_list','my_request_list.index','fa fa-computer fa-2x'),

			(16, 'Announcement', 'Module where you can send Announcement To All.','announcement','hr.announcement','fa fa-computer fa-2x'),

			(17, 'Asset Request', 'Module where you can request an asset.','asset_request','asset_request.asset','fa fa-computer fa-2x'),

			(18, 'Asset Request Lists', 'Module where you can see all request of asset.','asset_request_lists','asset_request_lists.asset_lists','fa fa-computer fa-2x'),

			(19, 'Asset Tracking', 'Davies Asset Tracking Module.','asset_trackings','asset_trackings.index','fa fa-cube fa-2x'),

			(20, 'Employee Exit Pass', 'Employee Exit Pass Form.','emp_ext_pass','emp_ext_pass.index','fa fa-cube fa-2x'),			

			(21, 'HR Exit Pass Lists', 'Employee Exit Pass Filed Lists.','emp_ext_pass_hr_lists','emp_ext_pass.hrlists','fa fa-cube fa-2x'),

			(22, 'Employee OBP', 'Employee Official Business Pass.','emp_obp','emp_obp.index','fa fa-cube fa-2x'),

			(23, 'HR OBP Lists', 'Employee Official Business Pass Filed Lists.','emp_obp_hr_lists','emp_obp.hrlists','fa fa-cube fa-2x');");
    }
}
