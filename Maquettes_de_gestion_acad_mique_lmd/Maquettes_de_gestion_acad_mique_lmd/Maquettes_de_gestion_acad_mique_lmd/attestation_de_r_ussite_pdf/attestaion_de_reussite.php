<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "error-container": "#ffdad6",
              "on-primary": "#ffffff",
              "tertiary": "#852b00",
              "surface-container-low": "#f2f4f6",
              "on-tertiary-fixed-variant": "#802a00",
              "tertiary-fixed": "#ffdbcf",
              "on-tertiary-fixed": "#380d00",
              "surface-container": "#eceef0",
              "tertiary-fixed-dim": "#ffb59a",
              "secondary-container": "#b1c2ff",
              "on-surface-variant": "#434654",
              "on-secondary-fixed": "#01174b",
              "on-error": "#ffffff",
              "on-tertiary-container": "#ffd4c5",
              "on-tertiary": "#ffffff",
              "primary": "#003fb1",
              "secondary-fixed": "#dbe1ff",
              "on-primary-container": "#d4dcff",
              "primary-fixed-dim": "#b5c4ff",
              "surface-container-lowest": "#ffffff",
              "surface-container-high": "#e6e8ea",
              "secondary-fixed-dim": "#b5c4ff",
              "primary-fixed": "#dbe1ff",
              "on-secondary-fixed-variant": "#334479",
              "on-secondary-container": "#3d4e84",
              "tertiary-container": "#ad3b00",
              "surface-dim": "#d8dadc",
              "on-primary-fixed-variant": "#003dab",
              "outline": "#737686",
              "on-surface": "#191c1e",
              "error": "#ba1a1a",
              "on-secondary": "#ffffff",
              "on-error-container": "#93000a",
              "surface-variant": "#e0e3e5",
              "surface-tint": "#1353d8",
              "secondary": "#4b5c92",
              "on-primary-fixed": "#00174d",
              "inverse-on-surface": "#eff1f3",
              "on-background": "#191c1e",
              "outline-variant": "#c3c5d7",
              "inverse-primary": "#b5c4ff",
              "surface": "#f7f9fb",
              "surface-container-highest": "#e0e3e5",
              "inverse-surface": "#2d3133",
              "surface-bright": "#f7f9fb",
              "primary-container": "#1a56db",
              "background": "#f7f9fb"
            },
            fontFamily: {
              "headline": ["Inter"],
              "body": ["Inter"],
              "label": ["Inter"]
            },
            borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
          },
        },
      }
    </script>
<style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; padding: 0 !important; }
            .a4-container { shadow: none !important; margin: 0 !important; border: none !important; }
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            font-weight: 900;
            opacity: 0.03;
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
            z-index: 0;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased min-h-screen flex flex-col items-center py-8">
<!-- Top Action Bar (Non-printed) -->
<header class="no-print w-full max-w-4xl mb-8 flex justify-between items-center px-6 py-3 bg-white dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 rounded-xl shadow-sm">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary" data-icon="description">description</span>
<span class="text-lg font-bold tracking-tighter text-blue-900 dark:text-blue-100 uppercase">UNIVERSITÃ‰ ACADÃ‰MIQUE</span>
</div>
<div class="flex gap-2">
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors rounded-md" onclick="window.print()">
<span class="material-symbols-outlined text-lg" data-icon="print">print</span>
<span>Imprimer</span>
</button>
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors rounded-md">
<span class="material-symbols-outlined text-lg" data-icon="download">download</span>
<span>TÃ©lÃ©charger PDF</span>
</button>
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium bg-primary text-white hover:bg-primary-container transition-colors rounded-md">
<span class="material-symbols-outlined text-lg" data-icon="mail">mail</span>
<span>Envoyer par email</span>
</button>
</div>
</header>
<!-- Main Page Layout (Side Nav & Canvas) -->
<div class="w-full flex justify-center gap-8 px-4 lg:px-0">
<!-- Side Nav (Suppressed for focused document task, following context rules) -->
<!-- A4 Document Canvas -->
<main class="relative bg-white shadow-[0_12px_32px_rgba(25,28,30,0.04)] w-[210mm] min-h-[297mm] p-[20mm] flex flex-col overflow-hidden a4-container">
<!-- Watermark -->
<div class="watermark text-primary">UNIVERSITÃ‰ ACADÃ‰MIQUE</div>
<div class="relative z-10 flex flex-col h-full">
<!-- Header: Logos -->
<div class="flex justify-between items-start mb-16">
<div class="w-32">
<img class="w-full h-auto object-contain" data-alt="University Academic official crest logo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYzSfsAp7oaKev-4NqAXy8XR-7CJ7kqYg_ISdz5RxtFkckYtECbW3LmkZBI4fN0aAuM40kB9oywEX2i0HfvqB844cBNq538DXq9zAy-BL7wsEusAdC-9vbMOobkFtitIGbpQdGqermkQY0kN8t7UCvGhzne7lA-oI7iX81EG6cXiLwzl5jyEi08Z-uoU8HmfW5_6JZBZJp-i8A3jNKA-Pd2xJjWVfS8ptKnVuw6QJNhd81dp6XVcBe95XMmX9Sdh-aWEHWgPZYAKU"/>
</div>
<div class="w-24 text-right">
<img class="w-full h-auto object-contain mb-1" data-alt="French Republic official marianne logo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAHwoBDp2jCB-UNxeobw6gaO91R8daqL_EinSVHkcuMkSbQwe5QOTQ9OHpJDmZd5ueHNgQvtxuXVVe6Mi9AA5mEzq-rGRLdfPvxJgJksXVD2kkXHODqoYbS9eamY5KaC7syuHVdV3CD1EPPWsCn9LE06MZAzHieW97Ux5RV26I6Nyzwic5bQT9E5P-oF089LKUdW6fXgKBpxiyDj9LNdbMd2lvCGsI8BjtDi8nEtcr76Ds_pWlPlykrlRLLXQuIvofWbT3oaO0R2os"/>
<p class="text-[0.6rem] font-bold leading-tight uppercase tracking-widest text-on-surface-variant">LibertÃ©<br/>Ã‰galitÃ©<br/>FraternitÃ©</p>
</div>
</div>
<!-- Document Identity -->
<div class="text-center mb-12">
<h1 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2 uppercase">ATTESTATION DE RÃ‰USSITE</h1>
<div class="h-1 w-24 bg-primary mx-auto mb-4"></div>
<p class="text-on-surface-variant italic font-light">Document officiel Ã  caractÃ¨re administratif</p>
</div>
<!-- Certification Text -->
<div class="mb-12 space-y-6 leading-relaxed text-lg">
<p>
                        Le Recteur de l'UniversitÃ© AcadÃ©mique certifie que M./Mme <span class="font-bold">Jean-Marc DUPONT</span>, 
                        nÃ©(e) le <span class="font-bold">12 Mars 2002</span> Ã  <span class="font-bold">Lyon (69)</span>, 
                        immatriculÃ©(e) sous le numÃ©ro <span class="font-bold">ETU-2024-9842</span>, 
                        a validÃ© l'ensemble des enseignements et les Ã©preuves de contrÃ´le des connaissances de la filiÃ¨re :
                    </p>
<p class="text-xl font-bold text-primary py-4 text-center border-y border-outline-variant border-opacity-20 bg-surface-container-low rounded-lg">
                        LICENCE PROFESSIONNELLE - SYSTÃˆMES ET RÃ‰SEAUX LMD
                    </p>
</div>
<!-- Academic Results Table (LMD Format) -->
<div class="mb-12 bg-surface-container-lowest border border-outline-variant border-opacity-20 rounded-xl p-8">
<div class="grid grid-cols-3 gap-8">
<div class="text-center">
<p class="text-label-sm uppercase tracking-wider text-on-surface-variant mb-1">Moyenne GÃ©nÃ©rale</p>
<p class="text-2xl font-bold text-on-surface">14.50 / 20</p>
</div>
<div class="text-center">
<p class="text-label-sm uppercase tracking-wider text-on-surface-variant mb-1">Mention</p>
<div class="inline-block px-4 py-1 bg-secondary-container text-on-secondary-container rounded-full text-sm font-bold tracking-wide uppercase">
                                BIEN
                            </div>
</div>
<div class="text-center">
<p class="text-label-sm uppercase tracking-wider text-on-surface-variant mb-1">CrÃ©dits ECTS</p>
<p class="text-2xl font-bold text-on-surface">180 / 180</p>
</div>
</div>
<div class="mt-8 pt-6 border-t border-outline-variant border-opacity-10 text-center">
<p class="text-sm text-on-surface-variant">
                            Session de dÃ©livrance : <span class="font-semibold text-on-surface">Annuelle 2023-2024</span><br/>
                            Date d'obtention dÃ©finitive : <span class="font-semibold text-on-surface">24 Mai 2024</span>
</p>
</div>
</div>
<!-- Footer Signature -->
<div class="mt-auto flex justify-between items-end pb-12">
<div class="text-sm text-on-surface-variant">
<p>Code de vÃ©rification : <span class="font-mono text-xs">V92-KL9-3X2</span></p>
<p>AuthenticitÃ© vÃ©rifiable sur portal.univ.fr/verify</p>
</div>
<div class="text-right w-64">
<p class="mb-2">Fait Ã  <span class="font-medium text-on-surface">Paris</span>, le <span class="font-medium text-on-surface">15 Juin 2024</span></p>
<div class="relative h-32 flex flex-col justify-center items-center">
<p class="text-xs uppercase tracking-tighter text-on-surface-variant mb-4">Le Doyen de la FacultÃ©</p>
<!-- Placeholder for official stamp and signature -->
<div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-40">
<img class="w-32 h-32 rotate-12" data-alt="Official university circular stamp" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDazQ4OZOahsdmHB84bsQZdtpSAfeEK0rxUgcjSYSl-pgsrhGVotqHVh4mAL1wwdToFuZ5EGWcl4o3DDiafV5-XO9Uixrptn3tb8sDbb-cL1WlR5gsCrMk5WTp5J7Y9rIzqj6PaclH3yw9c-fG12SXQw0AN1TpDqavvOUwGHf4a6D2jYmNsCmAkm0T3NGfgtDelA513aON3MQE5EAlERlurZQjIos62_7cBTtjfE6jlvjJoVlKqdSiZPTcCLx5dVDXhBQIMCkr8h8c"/>
</div>
<img class="relative z-10 w-40 h-auto mix-blend-multiply opacity-80" data-alt="Handwritten digital signature of the Dean" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCGEW9oQHjjz0tI_iAIi0i1JnO0JOPiYP0B2nLsxlAKW2VEf1MkXyT6_VWb1uMJpX7RR51Ai3CavQQDcqCrPDA6kKKAN5iXbsS1fS_fKZGOeweAcvw7L1J4Pw62x9SE51VySTLuuD3UDXFTCtAPCkJp60CdXQPT5s5ThdW-ieQimjVyTr1T7zPyyT6lwCGo4iOp9hC-rwYNAP8QlAItQDqIPHk3WORSKYm-p9YPWRjZ9RS3_HvdSrYp1b8mjGS1fl8NCJ7e6qUtoLQ"/>
<p class="mt-4 font-bold text-on-surface">Pr. Alexandre VALENTIN</p>
</div>
</div>
</div>
<!-- Bottom Meta -->
<div class="border-t border-slate-100 pt-4 text-[0.65rem] text-slate-400 text-center uppercase tracking-widest">
                    UniversitÃ© AcadÃ©mique â€¢ Service de la ScolaritÃ© GÃ©nÃ©rale â€¢ 45 Rue de l'Enseignement, 75005 Paris
                </div>
</div>
</main>
</div>
<!-- Layout Spacing for Print -->
<div class="h-12 no-print"></div>
</body></html>
