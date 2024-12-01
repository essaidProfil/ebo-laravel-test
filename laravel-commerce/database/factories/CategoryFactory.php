<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Définir le modèle de données par défaut pour cette factory.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word, // Utiliser Faker pour générer un nom de catégorie
        ];
    }
}
