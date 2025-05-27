<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use App\Models\Tenant\Member;
use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i=0; $i < 10; $i++) {
            Member::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'birth_date' => $faker->date('Y-m-d', '2005-01-01'),
                'street' => $faker->streetName,
                'number' => $faker->buildingNumber,
                'complement' => $faker->optional()->secondaryAddress,
                'neighborhood' => $faker->citySuffix,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'postal_code' => $faker->postcode,
                'active' => $faker->boolean(80),
                'registration_date' => $faker->date('Y-m-d', 'now'),
                'plan_id' => $faker->numberBetween(1, 3),
            ]);
        }
    }
}
