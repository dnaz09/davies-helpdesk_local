<?php

use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asset_categories')->truncate();
		DB::statement("INSERT INTO asset_categories (id, category_name, created_at, updated_at) VALUES
			(1, 'LAPTOP','2018-04-17 22:39:23','2018-04-17 22:39:23'),
			(2, 'LAPTOP CHARGER','2018-04-17 22:39:23','2018-04-17 22:39:23'),
			(3, 'MOUSE','2018-04-17 22:39:23','2018-04-17 22:39:23');");
    }
}
