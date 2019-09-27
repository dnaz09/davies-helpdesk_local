<?php

use Illuminate\Database\Seeder;

class ServiceRequestCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	DB::table('service_request_categories')->truncate();

		DB::statement("INSERT INTO service_request_categories (id, category) VALUES  
            (1, 'HARDWARE'),
            (2, 'SOFTWARE'),
            (3, 'CONNECTIVITY');");	       
    }
}
