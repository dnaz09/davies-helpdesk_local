<?php

use Illuminate\Database\Seeder;

class TimeSlots2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timeslots2')->truncate();
        DB::statement("INSERT INTO timeslots2 (id, time, created_at, updated_at) VALUES 
            (1,'16:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
            (2,'16:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(3,'17:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(4,'17:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(5,'18:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(6,'18:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(7,'19:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(8,'19:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(9,'20:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(10,'20:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(11,'21:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(12,'21:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(13,'22:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(14,'22:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(15,'23:00','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(16,'23:30','2018-04-17 22:39:23','2018-04-17 22:39:23'),
        	(17,'24:00','2018-04-17 22:39:23','2018-04-17 22:39:23');");
    }
}
