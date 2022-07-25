<?php

namespace Database\Factories;

use App\Models\Account\MetaType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Metadata>
 */
class MetadataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => null,
            'key' => '',
            'cast' => '',
            'payload' => null,
        ];
    }

    public function relation()
    {
        return $this->state([
            'type' => MetaType::Relations,
        ]);
    }

    public function contact()
    {
        return $this->state([
            'type' => MetaType::Contacts,
        ]);
    }

    public function setting()
    {
        return $this->state([
            'type' => MetaType::Settings,
        ]);
    }
}
