<?php

use Illuminate\Database\Seeder;

class RequisitionPurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requisition_purposes')->truncate();
        DB::statement("INSERT INTO requisition_purposes (id, purpose, created_at, updated_at) VALUES
        	(1, 'LOAN', '2018-05-11 17:04:34','2018-05-11 17:04:34'),
            (2, 'PERSONAL COPY', '2018-05-11 17:04:34','2018-05-11 17:04:34'),
        	(3, 'TAX RELATED', '2018-05-11 17:04:34','2018-05-11 17:04:34');");
    }
}
