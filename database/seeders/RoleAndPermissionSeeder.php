<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            Role::create(['name' => User::CUSTOMER]);
            Role::create(['name' => User::ADMINISTRATOR]);

            $newUser = User::create([
                'name' => 'Administrator',
                'email' => 'administrator@test.com',
                'password' => bcrypt('password'),
            ]);
            $newUser->assignRole(User::ADMINISTRATOR);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $this->command->error("SQL Error: " . $e->getMessage());
        }
    }
}
