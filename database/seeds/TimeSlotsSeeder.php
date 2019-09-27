<?php

use Illuminate\Database\Seeder;

class TimeSlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timeslots')->truncate();
        DB::statement("INSERT INTO timeslots (id, time, created_at, updated_at) VALUES 
        	(1,'10:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(2,'11:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(3,'12:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(4,'1:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(5,'2:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(6,'3:30','2018-04-17 22:39:23','2018-04-17 22:39:23');");
    }
}
