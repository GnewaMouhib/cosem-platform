<?php

namespace Database\Seeders;

use App\Models\Cereal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CerealSeeder extends Seeder
{
    /**
     * Seed ONLY the 13 authorized cereal varieties (INGC agronomic data).
     * Any deprecated entry present in the table is removed.
     */
    public function run(): void
    {
        DB::table('cereals')->truncate();

        $cereals = [
            // ---------------- BLÉ DUR (7) ----------------
            [
                'category' => 'ble_dur',
                'name' => 'Karim',
                'type' => 'Semoulier',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Précoce / Moyen (80-100 cm)',
                'yield_potential' => 'Élevé / Très bon',
                'disease_resistance' => 'Sensible à la Septoriose et la Rouille brune, moyen Oïdium',
                'targeted_zone' => 'Nord et zones irriguées',
                'grain_quality' => 'Semoulier de qualité supérieure',
                'description' => 'Verse : Résistance moyenne à la verse, très bon enracinement. Variété de référence nationale, adaptée au Nord et à l\'irrigué, vigilance et traitement impératif contre la Septoriose.',
            ],
            [
                'category' => 'ble_dur',
                'name' => 'Razzak',
                'type' => 'Semoulier',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Précoce, paille courte (80-90 cm)',
                'yield_potential' => 'Très bon',
                'disease_resistance' => 'Sensible Septoriose et Rouille brune, moyen Oïdium',
                'targeted_zone' => 'Nord et zones irriguées à fortes fumures',
                'grain_quality' => 'Bon grain semoulier',
                'description' => 'Verse : Bonne résistance à la verse. Résistant au stress de fin de cycle (échaudage), valorise les fortes fumures azotées et l\'irrigation sans risque de verse.',
            ],
            [
                'category' => 'ble_dur',
                'name' => 'Salim',
                'type' => 'Semoulier',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Semi-précoce, fort tallage',
                'yield_potential' => 'Élevé',
                'disease_resistance' => 'Tolérant aux maladies foliaires',
                'targeted_zone' => 'Nord et Centre',
                'grain_quality' => 'Excellente qualité technologique (protéines élevées, bonne vitrosité)',
                'description' => 'Verse : Bonne tenue de tige. Excellente qualité technologique du grain (teneur en protéines élevée, bonne vitrosité).',
            ],
            [
                'category' => 'ble_dur',
                'name' => 'Maali',
                'type' => 'Semoulier',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Moyen',
                'yield_potential' => 'Très élevé',
                'disease_resistance' => 'Tolérance moyenne',
                'targeted_zone' => 'Milieux favorables et irrigués',
                'grain_quality' => 'Forte valeur semoulière',
                'description' => 'Verse : Bonne résistance. Très bon potentiel en milieu favorable et irrigué, forte valeur semoulière.',
            ],
            [
                'category' => 'ble_dur',
                'name' => 'Khiar',
                'type' => 'Semoulier',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Précoce, hauteur 80-150 cm, fort enracinement',
                'yield_potential' => 'Très bon',
                'disease_resistance' => 'Sensible à la Septoriose et Rouille brune',
                'targeted_zone' => 'Nord humide et sub-humide',
                'grain_quality' => 'Bon potentiel semoulier',
                'description' => 'Verse : Résistance moyenne à la verse. Valorise remarquablement l\'irrigation d\'appoint et les terres fertiles du Nord humide/sub-humide.',
            ],
            [
                'category' => 'ble_dur',
                'name' => 'INRAT 100',
                'type' => 'Semoulier',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Moyen',
                'yield_potential' => 'Bon',
                'disease_resistance' => 'Tolérance correcte',
                'targeted_zone' => 'Zones céréalières du Nord',
                'grain_quality' => 'Qualité semoulière standard',
                'description' => 'Verse : Bonne résistance. Régularité et robustesse en zones céréalières du Nord.',
            ],
            [
                'category' => 'ble_dur',
                'name' => 'Dhahbi',
                'type' => 'Semoulier',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Semi-précoce',
                'yield_potential' => 'Bon',
                'disease_resistance' => 'Tolérance moyenne',
                'targeted_zone' => 'Semi-aride supérieur et bour favorable',
                'grain_quality' => 'Bon grain de semoulerie',
                'description' => 'Verse : Moyenne à bonne. Bonne tolérance au déficit hydrique modéré, adapté au semi-aride supérieur et bour favorable.',
            ],

            // ---------------- BLÉ TENDRE (3) ----------------
            [
                'category' => 'ble_tendre',
                'name' => 'Utique',
                'type' => 'Panifiable',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Adapté au Nord, bon tallage',
                'yield_potential' => 'Élevé',
                'disease_resistance' => 'Tolérance standard',
                'targeted_zone' => 'Nord',
                'grain_quality' => 'Panifiable, bon potentiel meunier',
                'description' => 'Verse : Bonne tenue. Variété panifiable performante, bon potentiel meunier.',
            ],
            [
                'category' => 'ble_tendre',
                'name' => 'Maktaris',
                'type' => 'Boulangère',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Moyen',
                'yield_potential' => 'Bon',
                'disease_resistance' => 'Tolérance moyenne',
                'targeted_zone' => 'Terroirs favorables',
                'grain_quality' => 'Bonne valeur boulangère',
                'description' => 'Verse : Paille solide. Bonne valeur boulangère, adapté aux terroirs favorables.',
            ],
            [
                'category' => 'ble_tendre',
                'name' => 'Tahent',
                'type' => 'Panifiable',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Moyen',
                'yield_potential' => 'Bon',
                'disease_resistance' => 'Rustique',
                'targeted_zone' => 'Zones pluviales du Nord',
                'grain_quality' => 'Qualité panifiable standard',
                'description' => 'Verse : Bonne résistance. Bonne productivité et régularité en conditions pluviales.',
            ],

            // ---------------- ORGE (2) ----------------
            [
                'category' => 'orge',
                'name' => 'Rihane',
                'type' => 'Polyvalente grain & fourrage',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Précoce à semi-précoce',
                'yield_potential' => 'Très bon',
                'disease_resistance' => 'Rustique',
                'targeted_zone' => 'Semi-aride et Centre',
                'grain_quality' => 'Polyvalente grain et fourrage',
                'description' => 'Verse : Moyenne. Orge d\'élite polyvalente (grain & fourrage), forte tolérance à la sécheresse, idéale pour le semi-aride et le Centre.',
            ],
            [
                'category' => 'orge',
                'name' => 'Kounouz',
                'type' => 'Grainière',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Précoce',
                'yield_potential' => 'Élevé',
                'disease_resistance' => 'Tolérance foliaire correcte',
                'targeted_zone' => 'Plaines du Nord et zones favorables',
                'grain_quality' => 'Excellent calibrage',
                'description' => 'Verse : Bonne résistance. Haut potentiel grainier, excellent calibrage, recommandée pour les plaines du Nord et zones favorables.',
            ],

            // ---------------- TRITICALE (1) ----------------
            [
                'category' => 'triticale',
                'name' => 'El Khir',
                'type' => 'Fourragère & grainière',
                'breeder' => 'INRAT',
                'optimal_cycle' => 'Moyen',
                'yield_potential' => 'Régulier et élevé',
                'disease_resistance' => 'Excellente résistance aux stress biotiques et abiotiques',
                'targeted_zone' => 'Sols marginaux et zones céréalières',
                'grain_quality' => 'Usage fourragier et grainier',
                'description' => 'Verse : Très rustique, paille vigoureuse. Culture fourragère et grainière robuste, adaptée aux sols marginaux.',
            ],
        ];

        $images = [
            'Karim' => 'images/cereales/karim.jpg',
            'Razzak' => 'images/cereales/razzak.jpg',
            'Salim' => 'images/cereales/salim.jpg',
            'Maali' => 'images/cereales/maali.jpg',
            'Khiar' => 'images/cereales/khiar.jpg',
            'INRAT 100' => 'images/cereales/inrat100.jpg',
            'Dhahbi' => 'images/cereales/dhahbi.jpg',
            'Utique' => 'images/cereales/utique.jpg',
            'Maktaris' => 'images/cereales/maktaris.jpg',
            'Tahent' => 'images/cereales/tahent.jpg',
            'Rihane' => 'images/cereales/rihane.jpg',
            'Kounouz' => 'images/cereales/kounouz.jpg',
            'El Khir' => 'images/cereales/elkhir.jpg',
        ];

        foreach ($cereals as $index => $cereal) {
            Cereal::create($cereal + [
                'order_index' => $index + 1,
                'image_path' => $images[$cereal['name']] ?? null,
            ]);
        }
    }
}
