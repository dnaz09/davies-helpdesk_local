<?php

use Illuminate\Database\Seeder;

class UserAccessRequestCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_access_request_categories')->truncate();

		DB::statement("INSERT INTO user_access_request_categories (id, category) VALUES	
			(1, 'PROGRAM'),
            (2, 'CONNECTIVITY');");
    }
}
