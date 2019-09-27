<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->truncate();

		DB::statement("INSERT INTO departments (id, department) VALUES
			(1, 'ADMINISTRATIVE SERVICES'),
            (2, 'CREDIT & COLLECTION'),
            (3, 'CUSTOMER SERVICES'),			
            (4, 'DISBURSEMENT'),
            (5, 'FINANCIAL ACCOUNTING & AUDIT'),
            (6, 'HUMAN RESOURCES'),
            (7, 'INFORMATION TECHNOLOGY'),
            (8, 'MODERN RETAIL'),
			(9, 'PURCHASING'),		
			(10, 'RESEARCH & DEVELOPMENT'),                    
            (11, 'SUPPORT GROUP'),
            (12, 'WAREHOUSE'),
            (13, 'CharChem_Production Office'),
            (14, 'CharChem_President Office'),
            (15, 'CharChem_General Accounting'),
            (16, 'CharChem_Production_Cavite'),
            (17, 'CharChem_Production_Pasig'),
            (18, 'CharChem_Inbound Logistics'),
            (19, 'CharChem_Planning'),
            (20, 'CharChem_Bases & Colorants')
            ;");        

    }
}























































































































































