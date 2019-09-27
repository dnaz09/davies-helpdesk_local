<?php

use Illuminate\Database\Seeder;

class TimeSlots3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timeslots3')->truncate();
        DB::statement("INSERT INTO timeslots3 (id, time, created_at, updated_at) VALUES 
            (1,'15:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
            (2,'15:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(3,'16:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(4,'16:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(5,'17:00','2018-04-17 22:39:23','2018-04-17 22:39:23');");
    }
}
