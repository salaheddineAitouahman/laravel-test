<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $properties = [
            [
                'name' => 'Villa Les Oliviers',
                'description' => "Belle villa avec piscine et vue sur la mer. Idéale pour les familles. Grand jardin, terrasse ombragée, cuisine équipée. À 5 min de la plage.",
                'price_per_night' => 180.00,
            ],
            [
                'name' => 'Studio Centre-Ville',
                'description' => "Studio cosy en plein cœur de la ville. Proche des commerces et des transports. Parfait pour un séjour en couple.",
                'price_per_night' => 65.00,
            ],
            [
                'name' => 'Chalet Montagne',
                'description' => "Chalet en bois au pied des pistes. Cheminée, tout équipé. Accès direct ski aux pieds. 4 chambres, 2 salles de bain.",
                'price_per_night' => 220.00,
            ],
        ];

        foreach ($properties as $data) {
            Property::create($data);
        }
    }
}
