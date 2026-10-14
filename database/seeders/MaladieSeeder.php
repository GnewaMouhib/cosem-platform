<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaladieSeeder extends Seeder
{
    /**
     * Attach the documentary field-symptom photograph to each
     * of the 6 phytosanitary guide entries (public/images/maladies/).
     */
    public function run(): void
    {
        $images = [
            'Rouille Jaune' => 'images/maladies/rouille-jaune.jpg',
            'Septoriose' => 'images/maladies/septoriose.jpg',
            'Rouille Brune' => 'images/maladies/rouille-brune.jpg',
            'Oïdium' => 'images/maladies/oidium.jpg',
            'Helminthosporiose' => 'images/maladies/helminthosporiose.jpg',
            'Fusariose' => 'images/maladies/fusariose.jpg',
        ];

        foreach ($images as $name => $path) {
            DB::table('diseases')->where('name', $name)->update(['image_path' => $path]);
        }
    }
}
