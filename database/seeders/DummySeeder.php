<?php

namespace Database\Seeders;

use App\Enum\Role;
use App\Models\Category;
use App\Models\CategoryRule;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(15)->create();

        Category::factory(10)->create();

        $categoryIds = Category::query()->pluck('id')->toArray();
        foreach ($categoryIds as $id) {
            CategoryRule::factory(mt_rand(1, 10))->create([
                'category_id' => $id,
            ]);
        }

        $userIds = User::query()->where('role', Role::SUBSIDIARY)->pluck('id')->toArray();
        foreach ($userIds as $id) {
            Equipment::factory(mt_rand(1, 25))->create([
                'user_id' => $id,
                'category_id' => fake()->randomElement($categoryIds),
            ]);
        }
    }
}
