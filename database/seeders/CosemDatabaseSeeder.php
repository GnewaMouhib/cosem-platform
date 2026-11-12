<?php

namespace Database\Seeders;

use App\Models\AnnualStat;
use App\Models\Disease;
use App\Models\Pulse;
use App\Models\Station;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Seeder;

class CosemDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedYearAndStats();
        $this->seedStations();
        $this->seedCereals();
        $this->seedPulses();
        $this->seedDiseases();
        $this->call(MaladieSeeder::class);
    }

    private function seedAdmin(): void
    {
        $password = (string) (env('COSEM_ADMIN_PASSWORD') ?: config('services.cosem.admin_password'));

        if ($password === '' || mb_strlen($password) < 12) {
            $this->command?->warn('Seed admin skipped: set COSEM_ADMIN_PASSWORD (12+ chars) in .env first.');

            return;
        }

        $user = User::updateOrCreate(
            ['email' => env('COSEM_ADMIN_EMAIL', 'admin@cosem.tn')],
            [
                'name' => env('COSEM_ADMIN_NAME', 'Administrateur COSEM'),
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        // `role` is deliberately not mass assignable: only trusted code may set it.
        $user->forceFill(['role' => 'admin'])->save();

        $this->command?->info('Admin account ready for '.$user->email.'.');
    }

    private function seedYearAndStats(): void
    {
        $year = Year::updateOrCreate(
            ['harvest_year' => 2026],
            [
                'name' => '2025/2026',
                'harvest_year' => 2026,
                'is_active' => true,
                'notes' => 'Campagne 2025/2026 - Campagne active.',
            ]
        );

        AnnualStat::updateOrCreate(
            ['year_id' => $year->id],
            [
                'durum_wheat_qx' => 215000,
                'soft_wheat_qx' => 8000,
                'barley_qx' => 7000,
                'oats_qx' => 3000,
                'pulses_qx' => 2000,
                'total_hectares' => 11000,
                'total_multipliers' => 100,
                'member_multipliers' => 80,
                'certified_seed_pct' => 85,
                'prebasic_seed_pct' => 12,
                'financing_partner' => 'Ministère de l\'Agriculture',
            ]
        );
    }

    private function seedStations(): void
    {
        // The network is fully replaced on every run: the previous 3 generic sites no
        // longer exist, and updateOrCreate() keyed on the name would leave them behind
        // as duplicates rather than replacing them. Nothing references stations by
        // foreign key, so truncating is safe and resets the id sequence.
        $stations = [
            [
                'name' => 'Siège & Complexe Industriel Principal - Manouba',
                'type' => 'conditioning_station',
                'badge' => 'Siège & Traitement Industriel',
                'city' => 'Manouba',
                'governorate' => 'Manouba',
                'capacity' => 45000,
                'installation_year' => 1951,
                'description' => 'Siège administratif et unité industrielle majeure. Traitement phytosanitaire de pointe, triage certifié et conditionnement à grande échelle.',
                'latitude' => 36.8080,
                'longitude' => 10.0970,
            ],
            [
                'name' => 'Plateforme de Stockage Stratégique - Manouba',
                'type' => 'storage_center',
                'badge' => 'Stockage Stratégique',
                'city' => 'Manouba',
                'governorate' => 'Manouba',
                'capacity' => 30000,
                'installation_year' => 1984,
                'description' => 'Site indépendant dédié à la conservation et au stockage stratégique des stocks régulateurs de semences certifiées.',
                'latitude' => 36.8120,
                'longitude' => 10.0910,
            ],
            [
                'name' => "Laboratoire Central d'Analyses & Qualité - Manouba",
                'type' => 'central_lab',
                'badge' => 'Laboratoire & Contrôle Qualité',
                'city' => 'Manouba',
                'governorate' => 'Manouba',
                'capacity' => null,
                'installation_year' => 1995,
                'description' => 'Pôle scientifique centralisé. Réception et analyse des échantillons de toutes les variétés en provenance de l\'ensemble des centres (tests de faculté germinative, pureté spécifique et contrôle variétal).',
                'latitude' => 36.8105,
                'longitude' => 10.0940,
            ],
            [
                'name' => 'Station de Conditionnement Tébourba 1',
                'type' => 'conditioning_station',
                'badge' => 'Triage & Traitement Céréales',
                'city' => 'Tébourba',
                'governorate' => 'Manouba',
                'capacity' => 35000,
                'installation_year' => 1978,
                'description' => 'Unité de criblage, calibrage et traitement fongicide pour les variétés de céréales sélectionnées.',
                'latitude' => 36.8290,
                'longitude' => 9.8430,
            ],
            [
                'name' => 'Station Spécialisée Tébourba 2 (Pôle Légumineuses)',
                'type' => 'specialized_station',
                'badge' => 'Spécialité Légumineuses',
                'city' => 'Tébourba',
                'governorate' => 'Manouba',
                'capacity' => 20000,
                'installation_year' => 2012,
                'description' => 'Unité spécialisée dans la réception, le traitement et le conditionnement des semences de légumineuses alimentaires (fèves, pois chiches) avec réserve céréalière.',
                'latitude' => 36.8340,
                'longitude' => 9.8510,
            ],
            [
                'name' => 'Centre de Stockage Régional - El Krib',
                'type' => 'regional_depot',
                'badge' => 'Stockage Régional',
                'city' => 'El Krib',
                'governorate' => 'Siliana',
                'capacity' => 25000,
                'installation_year' => 1990,
                'description' => 'Plateforme de collecte et de stockage régional de grande capacité assurant la couverture du nord-ouest.',
                'latitude' => 36.3280,
                'longitude' => 9.1410,
            ],
        ];

        // Common columns every record carries; keeps the inserts explicit rather than
        // inheriting columns the payload deliberately leaves null.
        foreach ($stations as &$station) {
            $station += [
                'surface' => null,
                'images' => null,
                'image_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        unset($station);

        Station::truncate();
        Station::insert($stations);
    }

    private function seedCereals(): void
    {
        $this->call(CerealSeeder::class);
    }

    private function seedPulses(): void
    {
        $pulses = [
            ['name' => 'Poiche', 'variety' => 'Sélection locale', 'optimal_cycle' => '90-110 jours', 'yield_potential' => '15-20 qx/ha', 'description' => 'Pois chiche de type syrien, variété cultivée dans les zones céréalières.', 'image_path' => null],
            ['name' => 'Fève', 'variety' => 'Sélection locale', 'optimal_cycle' => '120-150 jours', 'yield_potential' => '20-30 qx/ha', 'description' => 'Fève adaptée aux cultures d\'hiver en Tunisie.', 'image_path' => null],
            ['name' => 'Lentille', 'variety' => 'Sélection locale', 'optimal_cycle' => '100-130 jours', 'yield_potential' => '10-15 qx/ha', 'description' => 'Lentille de printemps, culture complémentaire.', 'image_path' => null],
            ['name' => 'Haricot', 'variety' => 'Sélection locale', 'optimal_cycle' => '90-120 jours', 'yield_potential' => '15-25 qx/ha', 'description' => 'Haricot commun, légumineuse de diversification.', 'image_path' => null],
        ];

        foreach ($pulses as $pulse) {
            Pulse::updateOrCreate(
                ['name' => $pulse['name'], 'variety' => $pulse['variety']],
                $pulse
            );
        }
    }

    private function seedDiseases(): void
    {
        $diseases = [
            [
                'name' => 'Rouille Jaune',
                'scientific_name' => 'Puccinia striiformis',
                'affected_crops' => ['ble_dur', 'ble_tendre', 'orge'],
                'symptoms' => 'Pustules jaunes allongées sur les feuilles, tiges et épis. Les pustules contiennent des urediniospores orange-jaune.',
                'cultural_practices' => 'Utilisation de variétés résistantes, rotation des cultures, destruction des résidus de récolte, semis à des dates appropriées.',
                'chemical_treatment' => 'Fongicides à base de triazoles (tébuconazole, propiconazole) ou strobilurines appliqués en début d\'épiaison.',
                'image_path' => null,
            ],
            [
                'name' => 'Septoriose',
                'scientific_name' => 'Zymoseptoria tritici',
                'affected_crops' => ['ble_dur', 'ble_tendre'],
                'symptoms' => 'Taches brun pâle sur les feuilles avec picnides noirs au centre. Forte défoliation en cas d\'infection sévère.',
                'cultural_practices' => 'Rotation longue, semis échelonnés, destruction des résidus, variétés tolérantes.',
                'chemical_treatment' => 'Fongicides triazoles + strobilurines en début de récolte, applications préventives en conditions humides.',
                'image_path' => null,
            ],
            [
                'name' => 'Rouille Brune',
                'scientific_name' => 'Puccinia triticina',
                'affected_crops' => ['ble_dur', 'ble_tendre'],
                'symptoms' => 'Pustules brun-rouge sur les feuilles, débutant sur les feuilles inférieures et progressant vers le haut.',
                'cultural_practices' => 'Rotation des cultures, destruction des résidus, sélection variétale.',
                'chemical_treatment' => 'Fongicides triazoles ou strobilurines, applications dès les premiers symptômes.',
                'image_path' => null,
            ],
            [
                'name' => 'Oïdium',
                'scientific_name' => 'Blumeria graminis',
                'affected_crops' => ['ble_dur', 'ble_tendre', 'orge'],
                'symptoms' => 'Efflorescence blanche poudreuse sur les feuilles et tiges, surtout en début de saison.',
                'cultural_practices' => 'Variétés résistantes, fertilisation azotée équilibrée, éviter l\'excès d\'humidité.',
                'chemical_treatment' => 'Fongicides triazoles ou morpholines, traitement préventif.',
                'image_path' => null,
            ],
            [
                'name' => 'Helminthosporiose',
                'scientific_name' => 'Bipolaris sorokiniana',
                'affected_crops' => ['ble_dur', 'orge', 'triticale'],
                'symptoms' => 'Taches brun foncé avec halo clair sur les feuilles. Pourriture des racines et des semences.',
                'cultural_practices' => 'Rotation des cultures, semence de bonne qualité, traitement des semences.',
                'chemical_treatment' => 'Traitement des semences et fongicides foliaires si nécessaire.',
                'image_path' => null,
            ],
            [
                'name' => 'Fusariose',
                'scientific_name' => 'Fusarium culmorum',
                'category' => 'maladie',
                'target_crops' => 'Blé dur, Blé tendre, Orge, Triticale',
                'affected_crops' => ['ble_dur', 'ble_tendre', 'orge', 'triticale'],
                'period' => 'Floraison à maturation',
                'symptoms' => 'Pourriture rose du collet et des épis, graines légères et déscolorees.',
                'control_methods' => 'Rotation longue, destruction des résidus, semis non profond, variétés résistantes, fongicides triazoles.',
                'cultural_practices' => 'Rotation longue, destruction des résidus, semis non profond, variétés résistantes.',
                'chemical_treatment' => 'Fongicides triazoles (prothioconazole, tebuconazole) à l\'épiaison.',
                'image_path' => null,
            ],
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

        foreach ($diseases as $disease) {
            Disease::updateOrCreate(
                ['name' => $disease['name']],
                $disease
            );
        }
    }
}
