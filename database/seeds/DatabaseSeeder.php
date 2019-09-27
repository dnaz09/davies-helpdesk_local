<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(ServiceRequestCategoryTableSeeder::class);
        $this->call(ServiceRequestSubCategoryTableSeeder::class);
        $this->call(UserAccessRequestCategoryTableSeeder::class);
        $this->call(UserAccessRequestSubCategoryTableSeeder::class);
        $this->call(categorySeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(AccessControllSeeder::class);
        $this->call(TimeSlots2Seeder::class);
        $this->call(TimeSlots3Seeder::class);
        $this->call(TimeSlotsSeeder::class);
        $this->call(RequisitionFormsSeeder::class);
        $this->call(RequisitionDescriptionSeeder::class);
        $this->call(RequisitionPurposeSeeder::class);
    }
}

