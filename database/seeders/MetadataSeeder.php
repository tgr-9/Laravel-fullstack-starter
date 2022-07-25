<?php

namespace Database\Seeders;

use App\Models\Metadata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetadataSeeder extends Seeder
{
    private const CONTACTS = [
        'phone',
        'email',
        'tax_id',
        'national_id',
        'address',
    ];

    private const RELATIONS = [
        'employee',
        'grandparent',
        'parent',
        'spouse',
        'child',
        'sibling',
        'nephew',
        'cousin',
    ];

    private const SETTINGS = [
        'locale' => [
            'value' => 'id',
            'options' => ['en', 'id'],
        ],
        'timezone' => [
            'value' => 'Asia/Jakarta',
            'options' => ['Asia/Jakarta', 'Asia/Makassar', 'Asia/Jayapura'],
        ],
        'appearance' => [
            'value' => 'light',
            'options' => ['light', 'dark', 'system'],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            /** @var \Database\Factories\MetadataFactory $factory */
            $factory = Metadata::factory();

            foreach (self::CONTACTS as $key) {
                $factory->contact()->create(['key' => $key]);
            }

            foreach (self::RELATIONS as $key) {
                $factory->relation()->create(['key' => $key]);
            }

            foreach (self::SETTINGS as $key => $payload) {
                $factory->setting()->create([
                    'key' => $key,
                    'payload' => $payload,
                ]);
            }
        });
    }
}
