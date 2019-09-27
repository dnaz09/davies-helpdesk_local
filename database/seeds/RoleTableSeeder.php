<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	\DB::table('roles')->truncate();
    	\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		DB::statement("INSERT INTO roles (id, role, description) VALUES
			(1, 'CHEMIST','CHEMIST'),
			(2, 'COLLECTOR / MESSENGER','COLLECTOR / MESSENGER'),
			(3, 'COORDINATOR','COORDINATOR'),			
			(4, 'MANAGER','MANAGER'),
            (5, 'OFFICER','OFFICER'),
            (6, 'SALES OFFICER','SALES OFFICER'),
            (7, 'STAFF','STAFF'),
            (8, 'SUPERVISOR','SUPERVISOR'),
            (9, 'TEAM LEADER','TEAM LEADER'),
            (10, 'TINTER','TINTER'),
            (11, 'VICE PRESIDENT','VICE PRESIDENT'),
            (12, 'CharChem_Vice President','CharChem_Vice President'),
            (13, 'CharChem_Supervisor','CharChem_Supervisor'),
            (14, 'CharChem_President','CharChem_President'),
            (15, 'CharChem_Corporate Secretary','CharChem_Corporate Secretary'),
            (16, 'CharChem_Comptroller','CharChem_Comptroller')
            ;");
    }
}












