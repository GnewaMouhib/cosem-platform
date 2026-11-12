<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class RavageursSeeder extends Seeder
{
    public function run(): void
    {
        $pests = [
            [
                'name' => 'Cécidomyie des céréales',
                'scientific_name' => 'Mayetiola destructor',
                'category' => 'ravageur',
                'target_crops' => 'Blé dur, Blé tendre, Orge',
                'affected_crops' => ['ble_dur', 'ble_tendre', 'orge'],
                'period' => 'Novembre à Mars (Tallage au gonflement)',
                'symptoms' => 'Larves logées à la base de la gaine foliaire provoquant le jaunissement, le rabougrissement des talles et une verse mécanique des tiges.',
                'control_methods' => 'Surveillance dès l\'apparition des pontes, traitement insecticide foliaire ciblé avant pénétration de la larve, travail du sol profond et rotation culturale.',
                'cultural_practices' => 'Travail du sol profond et rotation culturale pour détruire les pupes hibernantes.',
                'chemical_treatment' => 'Surveillance dès l\'apparition des pontes, traitement insecticide foliaire ciblé avant pénétration de la larve.',
                'image_path' => null,
            ],
            [
                'name' => 'Puceron jaune des céréales',
                'scientific_name' => 'Sipha maydis',
                'category' => 'ravageur',
                'target_crops' => 'Orge, Blé dur, Avoine',
                'affected_crops' => ['orge', 'ble_dur', 'avoine'],
                'period' => 'Février à Avril (Montaison à l\'épiaison)',
                'symptoms' => 'Ponctions de sève et toxines salivaires provoquant des nécrose linéaires, décoloration en pourpre/jaune et vecteur potentiel du nanisme (JNO).',
                'control_methods' => 'Traitement aphicide homologué lorsque le seuil de 10-15 pucerons par talle est atteint.',
                'cultural_practices' => 'Préservation de la faune auxiliaire (coccinelles, syrphes) et gestion raisonnée des apports azotés.',
                'chemical_treatment' => 'Traitement aphicide homologué lorsque le seuil de 10-15 pucerons par talle est atteint.',
                'image_path' => null,
            ],
            [
                'name' => 'Pyrale des céréales',
                'scientific_name' => 'Ostrinia nubilalis / Chilo spp.',
                'category' => 'ravageur',
                'target_crops' => 'Blé dur, Blé tendre',
                'affected_crops' => ['ble_dur', 'ble_tendre'],
                'period' => 'Mars à Mai (Montaison au remplissage)',
                'symptoms' => 'Galeries internes creusées dans la tige, interruption de la sève élaborée, apparition d\'épis blancs échaudés et casse fréquente de la paille.',
                'control_methods' => 'Gestion agronomique des résidus de culture (broyage et enfouissement des pailles), traitement larvicide préventif avant pénétration dans la tige.',
                'cultural_practices' => 'Gestion agronomique des résidus de culture (broyage et enfouissement des pailles).',
                'chemical_treatment' => 'Traitement larvicide préventif avant pénétration dans la tige.',
                'image_path' => null,
            ],
        ];

        foreach ($pests as $pest) {
            Disease::updateOrCreate(
                ['name' => $pest['name']],
                $pest
            );
        }
    }
}
