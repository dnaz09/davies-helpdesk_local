<?php

use Illuminate\Database\Seeder;

class RequisitionDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requisition_descriptions')->truncate();
        DB::statement("INSERT INTO requisition_descriptions (id, description, created_at, updated_at) VALUES
			(1, 'Employment Certificate of Employee','2018-04-17 22:39:23','2018-04-17 22:39:23'),
			(2, 'Income Tax Return of Emloyee','2018-04-17 22:39:23','2018-04-17 22:39:23'),
			(3, 'Philhealth Documents of Employee','2018-04-17 22:39:23','2018-04-17 22:39:23');");
    }
}
