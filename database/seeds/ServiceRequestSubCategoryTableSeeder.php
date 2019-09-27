<?php

use Illuminate\Database\Seeder;

class ServiceRequestSubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_request_sub_categories')->truncate();

		DB::statement("INSERT INTO service_request_sub_categories (id, category_id, sub_category) VALUES	
			(1, 1, 'DESKTOP'),
			(2, 1, 'LAPTOP'),
			(3, 1, 'PRINTER'),
			(4, 1, 'SCANNER'),
			(5, 2, 'SAP'),
            (6, 2, 'BMS'),
            (7, 2, 'HR WIZARD'),
            (8, 2, 'C4C'),
			(9, 2, 'OPEN OFFICE'),
			(10, 2, 'PDF READER'),			
			(11, 2, 'ADOBE PHOTOSHOP'),
            (12, 2, 'MS OFFICE'),
            (13, 3, 'NETWORK'),
            (14, 3, 'INTERNET'),
            (15, 3, 'VIBER');");
    }
}
