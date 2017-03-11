<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 1)
            ->create()
            ->each(function ($u) {
                $u->email = 'test@test.de';
                $u->super_user = true;
                $u->domains()->attach([1,2,3]);
                $u->save();
            });
    }
}
