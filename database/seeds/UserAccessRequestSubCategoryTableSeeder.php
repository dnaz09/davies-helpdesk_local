<?php

use Illuminate\Database\Seeder;

class UserAccessRequestSubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_access_request_sub_categories')->truncate();

		DB::statement("INSERT INTO user_access_request_sub_categories (id, category_id, sub_category) VALUES	
			(1, 1, 'SAP'),
			(2, 1, 'BMS'),
			(3, 1, 'HR WIZARD'),
			(4, 1, 'PPFA'),
			(5, 1, 'BATCHMASTER'),
            (6, 2, 'EMAIL'),
            (7, 2, 'WEBSITE'),
            (8, 2, 'INTERNET ACCESS'),
			(9, 2, 'USB ACCESS'),
			(10, 2, 'WIFI'),			
			(11, 2, 'CD/DVD-ROM ACCESS'),
            (12, 2, 'SHARED FOLDER');");
    }
}
