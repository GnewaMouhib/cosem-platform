<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche Technique Variétale — {{ $variety->name }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1E293B;
            margin: 0;
            padding: 0;
        }

        /* ---------- HEADER ---------- */
        .header {
            width: 100%;
            border-collapse: collapse;
        }
        .header td {
            vertical-align: middle;
            padding: 0;
        }
        .logo-cell { width: 88px; }
        .logo-cell img { width: 76px; height: auto; }
        .brand-name {
            font-size: 22px;
            font-weight: bold;
            color: #047857;
            letter-spacing: 2px;
        }
        .brand-full {
            font-size: 9px;
            color: #475569;
            letter-spacing: 0.6px;
            margin-top: 2px;
        }
        .header-right {
            text-align: right;
            font-size: 8px;
            color: #64748B;
            line-height: 1.5;
        }
        .certif-badge {
            display: inline-block;
            background: #047857;
            color: #FFFFFF;
            font-size: 8px;
            font-weight: bold;
            padding: 4px 10px;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .bar-emerald { height: 5px; background: #047857; margin: 8px 0 0 0; }
        .bar-gold  { height: 2px; background: #d97706; margin: 0 0 14px 0; }

        /* ---------- TITLE ---------- */
        .doc-title {
            font-size: 9.5px;
            font-weight: bold;
            color: #d97706;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .variety-name {
            font-size: 27px;
            font-weight: bold;
            color: #0F172A;
            margin: 0 0 2px 0;
            line-height: 1.1;
        }
        .species-line {
            font-size: 11px;
            color: #047857;
            font-weight: bold;
            margin-bottom: 14px;
        }
        .species-line span { color: #64748B; font-weight: normal; }

        /* ---------- SECTION TITLES ---------- */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 2px solid #d97706;
            padding-bottom: 4px;
            margin: 16px 0 8px 0;
        }
        .section-title:first-of-type { margin-top: 0; }

        /* ---------- IDENTITY GRID ---------- */
        .identity {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .identity td {
            width: 33.33%;
            background: #F0FDF4;
            border: 1px solid #D1FAE5;
            padding: 9px 12px;
            vertical-align: top;
        }
        .label {
            font-size: 7.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #047857;
            margin-bottom: 3px;
        }
        .value {
            font-size: 10.5px;
            font-weight: bold;
            color: #0F172A;
            line-height: 1.35;
        }

        /* ---------- AGRONOMIC TABLE ---------- */
        .agro {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .agro th {
            background: #047857;
            color: #FFFFFF;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            text-align: left;
            padding: 7px 12px;
            width: 36%;
        }
        .agro td {
            border: 1px solid #D1FAE5;
            padding: 7px 12px;
            font-size: 10px;
            color: #1E293B;
            vertical-align: top;
            line-height: 1.45;
        }
        .agro tr:nth-child(even) td { background: #F8FAFC; }
        .agro tr:nth-child(odd)  td { background: #FFFFFF; }
        .empty { color: #94A3B8; font-style: italic; }

        /* ---------- TREATED SEED NOTE ---------- */
        .treated-note {
            background: #F0FDF4;
            border: 1px solid #A7F3D0;
            border-left: 4px solid #047857;
            padding: 9px 13px;
            font-size: 9.5px;
            line-height: 1.55;
            color: #064E3B;
            margin-bottom: 4px;
        }
        .treated-note strong { color: #047857; }

        /* ---------- ITINERAIRE LIST ---------- */
        .itinerary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .itinerary td {
            border: 1px solid #D1FAE5;
            padding: 8px 12px;
            font-size: 10px;
            line-height: 1.5;
            vertical-align: top;
        }
        .itinerary td.key {
            width: 36%;
            background: #FFFBEB;
            border-color: #FDE68A;
            font-weight: bold;
            color: #92400E;
        }

        /* ---------- SPECIFICITY BOX ---------- */
        .specificity-box {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            border-left: 4px solid #d97706;
            padding: 10px 14px;
            font-size: 10px;
            line-height: 1.6;
            color: #334155;
            margin-bottom: 6px;
        }
        .specificity-box strong { color: #92400E; }

        /* ---------- FOOTER ---------- */
        .footer-stamp {
            background: #047857;
            color: #FFFFFF;
            padding: 9px 14px;
            font-size: 9px;
            line-height: 1.5;
            margin-top: 16px;
        }
        .footer-stamp strong { color: #FDE68A; }

        .footer {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .footer td {
            padding: 6px 0 0 0;
            font-size: 8px;
            color: #64748B;
            vertical-align: top;
        }
        .footer-left { width: 55%; }
        .footer-right { width: 45%; text-align: right; }
        .ref-line { font-size: 7.5px; color: #94A3B8; margin-top: 3px; }
    </style>
</head>
<body>

@php
    // Données INGC structurées par variété (mêmes référentiels que la fiche modale publique)
    $varietyDetails = [
        'Karim' => [
            'precocite' => 'Précoce à moyenne (80-100 jours)',
            'height'    => '80-100 cm, très bon enracinement',
            'lodging'   => 'Moyenne',
            'septoria'  => 'Sensible — Surveillance stricte',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Variété de référence nationale. Surveillance et traitement fongicide impératif au stade 2 nœuds à la dernière feuille étalée contre la Septoriose.",
        ],
        'Razzak' => [
            'precocite' => 'Moyen',
            'height'    => '80-90 cm, très bon enracinement',
            'lodging'   => 'Élevée (paille courte et solide)',
            'septoria'  => 'Sensible — Surveillance stricte',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Paille courte et solide résistant à la verse; tolère le stress hydrique et l'échaudage de fin de cycle.",
        ],
        'Khiar' => [
            'precocite' => 'Moyen',
            'height'    => '80-150 cm selon conduite, très bon enracinement',
            'lodging'   => 'Moyenne',
            'septoria'  => 'Sensible — Surveillance stricte',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Excellente réponse à l'irrigation d'appoint, valorise les sols profonds du Nord.",
        ],
        'Salim' => [
            'precocite' => 'Moyen',
            'height'    => '90-110 cm, très bon enracinement',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Haute qualité industrielle semoulière; tolérant aux maladies principales du blé dur.",
        ],
        'Maali' => [
            'precocite' => 'Semi-précoce',
            'height'    => '80-100 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'rusts'     => 'Sensibilité faible (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Fort potentiel en irrigation d'appoint; semoulerie de référence, sols fertiles valorisés.",
        ],
        'INRAT 100' => [
            'precocite' => 'Moyen',
            'height'    => '80-100 cm',
            'lodging'   => 'Élevée (rustique & régulier)',
            'septoria'  => 'Tolérance moyenne',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Rustique et régulière; adaptée aux conditions pluviales du Centre.",
        ],
        'Dhahbi' => [
            'precocite' => 'Précoce',
            'height'    => '70-90 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'rusts'     => 'Sensibilité faible (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Adapté au semi-aride; tolère les sols pauvres et le déficit hydrique de fin de cycle.",
        ],
        'Utique' => [
            'precocite' => 'Semi-précoce',
            'height'    => '80-110 cm, bon tallage',
            'lodging'   => 'Moyenne',
            'septoria'  => 'Tolérance moyenne',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Blé panifiable de bon tallage; meunerie de première qualité.",
        ],
        'Maktaris' => [
            'precocite' => 'Moyen',
            'height'    => '90-120 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'rusts'     => 'Sensibilité moyenne (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Bonne valeur boulangère; semis dans la fenêtre optimale pour sécuriser le rendement.",
        ],
        'Tahent' => [
            'precocite' => 'Moyen',
            'height'    => '80-110 cm',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Tolérance moyenne',
            'rusts'     => 'Sensibilité faible (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Productivité en pluvial; limites en irrigation excessive.",
        ],
        'Rihane' => [
            'precocite' => 'Semi-précoce',
            'height'    => '70-100 cm',
            'lodging'   => 'Élevée',
            'septoria'  => 'Résistant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Adaptation remarquable à la sécheresse et double aptitude grain/fourrage.",
        ],
        'Kounouz' => [
            'precocite' => 'Précoce à moyenne',
            'height'    => '80-110 cm, haut calibrage',
            'lodging'   => 'Bonne résistance',
            'septoria'  => 'Résistant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Adaptation remarquable à la sécheresse et double aptitude grain/fourrage.",
        ],
        'El Khir' => [
            'precocite' => 'Moyen',
            'height'    => '90-130 cm',
            'lodging'   => 'Rustique, bonne tenue de la paille',
            'septoria'  => 'Tolérant',
            'rusts'     => 'Tolérant (brune et jaune)',
            'oidium'    => 'Tolérance moyenne',
            'reco'      => "Rustique fourragère & grainière; adaptation au semi-aride.",
        ],
    ];
    $details = $varietyDetails[$variety->name] ?? [];
@endphp

    {{-- ============ HEADER ============ --}}
    <table class="header">
        <tr>
            <td class="logo-cell">
                <img src="{{ $logoBase64 }}" alt="Logo COSEM">
            </td>
            <td>
                <div class="brand-name">COSEM</div>
                <div class="brand-full">Société Coopérative Centrale des Semences</div>
            </td>
            <td class="header-right">
                <span class="certif-badge">SEMENCES CERTIFIÉES</span><br>
                Campagne de référence : <strong style="color:#047857;">{{ $campaign }}</strong><br>
                Tunisie
            </td>
        </tr>
    </table>
    <div class="bar-emerald"></div>
    <div class="bar-gold"></div>

    {{-- ============ TITLE ============ --}}
    <div class="doc-title">Fiche Technique Variétale — Semences Certifiées</div>
    <div class="variety-name">{{ $variety->name }}</div>
    <div class="species-line">
        Catégorie botanique : {{ $species }}
        @if(!empty($subline))
            <span>— {{ $subline }}</span>
        @endif
    </div>

    {{-- ============ SECTION 1 : FICHE D'IDENTITÉ VARIÉTALE ============ --}}
    <div class="section-title">1. Fiche d'Identité Variétale</div>
    <table class="identity">
        <tr>
            <td>
                <div class="label">Espèce & Nom de la variété</div>
                <div class="value">{{ $species }} — {{ $variety->name }}</div>
            </td>
            <td>
                <div class="label">Année d'inscription / Campagne</div>
                <div class="value">{{ $campaign }}</div>
            </td>
            <td>
                <div class="label">Obtenteur</div>
                <div class="value">{{ ($variety->breeder ?? null) ?: 'INRAT / COSEM' }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label">Cycle & Précocité</div>
                <div class="value">{{ $details['precocite'] ?? ($variety->optimal_cycle ?: '—') }}</div>
            </td>
            <td>
                <div class="label">Port végétatif & Hauteur de paille</div>
                <div class="value">{{ $details['height'] ?? '—' }}</div>
            </td>
            <td>
                <div class="label">Résistance mécanique à la verse</div>
                <div class="value">{{ $details['lodging'] ?? '—' }}</div>
            </td>
        </tr>
    </table>

    {{-- ============ SECTION 2 : PROFIL SANITAIRE ============ --}}
    <div class="section-title">2. Profil Sanitaire & Tolérance aux Pathogènes (Normes INGC)</div>
    <table class="agro">
        <tr>
            <th>Septoriose <em>(Zymoseptoria tritici)</em></th>
            <td>{{ $details['septoria'] ?? ($variety->disease_resistance ?: '—') }}</td>
        </tr>
        <tr>
            <th>Rouille Brune <em>(Puccinia triticina)</em> & Rouille Jaune</th>
            <td>{{ $details['rusts'] ?? ($variety->disease_resistance ?: '—') }}</td>
        </tr>
        <tr>
            <th>Oïdium</th>
            <td>{{ $details['oidium'] ?? 'Tolérance moyenne' }}</td>
        </tr>
    </table>
    <div class="treated-note">
        <strong>Traitement de semences garanti :</strong> Désinfection fongicide certifiée COSEM contre le Charbon nu et la Carie.
        Qualité des grains : {{ $variety->grain_quality ?? '—' }}.
    </div>

    {{-- ============ SECTION 3 : ITINÉRAIRE TECHNIQUE ============ --}}
    <div class="section-title">3. Itinéraire Technique & Conseils Agronomiques (Guide INGC)</div>
    <table class="itinerary">
        <tr>
            <td class="key">Densité de semis recommandée</td>
            <td><strong style="color:#047857;">{{ $density }}</strong></td>
        </tr>
        <tr>
            <td class="key">Période optimale de semis</td>
            <td>Du 15 novembre au 10 décembre, pour une implantation vigoureuse.</td>
        </tr>
        <tr>
            <td class="key">Profondeur de semis</td>
            <td>3 à 5 cm maximum, sur sol fineement travaillé, pour une levée rapide et homogène.</td>
        </tr>
        <tr>
            <td class="key">Gestion de la fertilisation</td>
            <td>Règle des 3 apports d'azote : Tallage, 1er nœud, Épiaison. Potentiel de rendement : {{ $variety->yield_potential ?? '—' }}. Zones ciblées : {{ $variety->targeted_zone ?? '—' }}.</td>
        </tr>
    </table>
    <div class="specificity-box">
        <strong>Spécificité variétale :</strong>
        {{ $details['reco'] ?? ($variety->description ?: 'Conduite selon l\'itinéraire technique officiel de l\'INGC pour la zone bioclimatique ciblée.') }}
    </div>

    {{-- ============ FOOTER STAMP ============ --}}
    <div class="footer-stamp">
        <strong>Société Coopérative Centrale des Semences (COSEM)</strong> — Données validées selon l'itinéraire technique officiel de l'INGC.
    </div>

    <table class="footer">
        <tr>
            <td class="footer-left">
                Document officiel COSEM — Semences Certifiées Tunisiennes.<br>
                Toute reproduction ou modification non autorisée est interdite. Ce document est généré dynamiquement à partir des données officielles de la base COSEM.
            </td>
            <td class="footer-right">
                Édité le {{ now()->format('d/m/Y') }} à {{ now()->format('H:i') }}<br>
                Réf. FTV-{{ strtoupper(substr($variety->name, 0, 3)) }}-{{ str_pad((string) $variety->id, 4, '0', STR_PAD_LEFT) }}-{{ date('Y') }}
                <div class="ref-line">www.cosem.tn — Contact : info@cosem.tn</div>
            </td>
        </tr>
    </table>

</body>
</html>
