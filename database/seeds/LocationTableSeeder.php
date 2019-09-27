<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->truncate();

		DB::statement("INSERT INTO locations (id, location) VALUES
			(1, 'ADMINISTRATIVE SERVICES'),
			(2, 'ASSET MAINTENANCE & DISPOSAL'),			
			(3, 'ASSET MANAGEMENT'),
			(4, 'ASSET WAREHOUSE & INVENTORY'),
			(5, 'AUDIT'),
			(6, 'BASES FORMULATION & CHARACTERISTICS'),
            (7, 'CREDIT & COLLECTION'),
            (8, 'CUSTOMER CARE'),
            (9, 'CUSTOMER SERVICES'),
            (10, 'DISBURSEMENT'),
            (11, 'FINANCIAL ACCOUNTING & AUDIT'),
            (12, 'GENERAL ACCOUNTING'),        
			(13, 'HUMAN RESOURCES'),
			(14, 'INFORMATION TECHNOLOGY'),
			(15, 'MARKETING OFFICE'),
			(16, 'MODERN RETAIL'),
			(17, 'NATIONAL CAPITAL REGION'),
			(18, 'PURCHASING'),
			(19, 'REGIONAL'),
			(20, 'RESEARCH & DEVELOPMENT'),
			(21, 'SALES OFFICE'),
			(22, 'TAX REPORTS SECTION'),
			(23, 'WAREHOUSE');");        
    }
}



















