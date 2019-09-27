<?php

use Illuminate\Database\Seeder;

class RequisitionFormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requisition_forms')->truncate();
        DB::statement("INSERT INTO requisition_forms (id, form, created_at, updated_at) VALUES
			(1, 'Certificate Of Employment','2018-04-17 22:39:23','2018-04-17 22:39:23'),
			(2, 'ITR - 2316','2018-04-17 22:39:23','2018-04-17 22:39:23'),
			(3, 'Philhealth Documents','2018-04-17 22:39:23','2018-04-17 22:39:23');");
    }
}
