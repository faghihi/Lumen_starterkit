<?php

use Faker\Generator as Faker;

$factory->define(\Modules\Course\Entities\Course::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->image(),
        'description' => str_random(10)
    ];
});
