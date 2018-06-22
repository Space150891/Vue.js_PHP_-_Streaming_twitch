<?php

use Illuminate\Database\Seeder;
use App\Models\{User, Profile};
use jeremykenedy\LaravelRoles\Models\Role;

class BotUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $botEmail = 'bot@twitch.com';
        $botPassword = 'twitch2018bot';
        $user = User::where('email', '=', $botEmail)->first();
        $role = Role::whereName('Bot')->first();
        $profile = new Profile();
        if ($user === null) {
            $user = User::create([
                'name'                           => 'BOT',
                'first_name'                     => 'BOT',
                'last_name'                      => 'BOT',
                'email'                          => $botEmail,
                'password'                       => Hash::make($botPassword),
                'token'                          => str_random(64),
                'activated'                      => true,
                'signup_confirmation_ip_address' => $faker->ipv4,
                'admin_ip_address'               => $faker->ipv4,
            ]);

            $user->profile()->save($profile);
            $user->attachRole($role);
            $user->save();
        }
        echo $role->id;
    }
}
