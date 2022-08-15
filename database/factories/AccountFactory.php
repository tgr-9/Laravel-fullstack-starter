<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /** @var Account\Gender $gender */
        $gender = $this->faker->randomElement(Account\Gender::cases());
        /** @var Account\Type $gender */
        $type = $this->faker->randomElement(Account\Type::cases());

        return [
            'user_id' => null,
            'photo_id' => null,
            'name' => $this->faker->name($gender->value !== 'other' ? $gender->value : null),
            'slug' => null,
            'display' => null,
            'summary' => $this->faker->sentence(2),
            'type' => $type,
            'gender' => $gender,
        ];
    }

    public function withUser(User $user)
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }

    public function withPhoto(File $photo)
    {
        return $this->state([
            'photo_id' => $photo->id,
        ]);
    }

    public function billling()
    {
        return $this->state([
            'name' => $this->faker->words(3, true),
            'type' => Account\Type::Billings,
            'gender' => null,
        ]);
    }

    public function company()
    {
        return $this->state([
            'name' => $this->faker->company(),
            'type' => Account\Type::Companies,
            'gender' => null,
        ]);
    }

    public function person(Account\Gender $gender = Account\Gender::Other)
    {
        return $this->state([
            'name' => $this->faker->name($gender->value !== 'other' ? $gender->value : null),
            'type' => Account\Type::People,
            'gender' => $gender,
        ]);
    }
}
