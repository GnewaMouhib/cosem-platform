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
        $stations = [
            [
                'name' => 'Station de Conditionnement de Manouba',
                'type' => 'conditioning_station',
                'city' => 'Manouba',
                'governorate' => 'Manouba',
                'latitude' => 36.8081,
                'longitude' => 10.0972,
                'capacity' => 40000,
                'surface' => null,
                'description' => 'Station de conditionnement de semences créée en 1955, agrandie en 1984 avec 1955 et 1984 lignes de conditionnement. Capacité de stockage de 40000 QX de semences certifiées.',
                'images' => null,
                'installation_year' => 1955,
            ],
            [
                'name' => 'Station de Conditionnement de Tebourba',
                'type' => 'conditioning_station',
                'city' => 'Tebourba',
                'governorate' => 'Bizerte',
                'latitude' => 37.1667,
                'longitude' => 10.1000,
                'capacity' => null,
                'surface' => null,
                'description' => 'Station de conditionnement installée en 2018 avec une capacité de traitement de 10 tonnes/heure.',
                'images' => null,
                'installation_year' => 2018,
            ],
            [
                'name' => 'Entrepôts SNCFT',
                'type' => 'warehouse',
                'city' => 'Tunis',
                'governorate' => 'Tunis',
                'latitude' => 36.8065,
                'longitude' => 10.1815,
                'capacity' => null,
                'surface' => 2873,
                'description' => 'Entrepôts de stockage de semences d\'une surface totale de 2873 m², utilisés pour le stockage et la logistique des semences certifiées.',
                'images' => null,
                'installation_year' => null,
            ],
        ];

        foreach ($stations as $station) {
            Station::updateOrCreate(
                ['name' => $station['name']],
                $station
            );
        }
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
                'affected_crops' => ['ble_dur', 'ble_tendre', 'orge', 'triticale'],
                'symptoms' => 'Pourriture rose du collet et des épis, graines légères et déscolorees.',
                'cultural_practices' => 'Rotation longue, destruction des résidus, semis non profond, variétés résistantes.',
                'chemical_treatment' => 'Fongicides triazoles (prothioconazole, tebuconazole) à l\'épiaison.',
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
