<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>AperÃ§u Carte Ã‰tudiant - Portail AcadÃ©mique</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary-container": "#1a56db",
              "tertiary-fixed": "#ffdbcf",
              "on-tertiary-fixed": "#380d00",
              "surface-variant": "#e0e3e5",
              "primary": "#003fb1",
              "on-primary-container": "#d4dcff",
              "on-tertiary-fixed-variant": "#802a00",
              "on-tertiary-container": "#ffd4c5",
              "outline-variant": "#c3c5d7",
              "surface-container-highest": "#e0e3e5",
              "on-background": "#191c1e",
              "tertiary-fixed-dim": "#ffb59a",
              "surface-tint": "#1353d8",
              "secondary-fixed-dim": "#b5c4ff",
              "surface-container-low": "#f2f4f6",
              "on-tertiary": "#ffffff",
              "outline": "#737686",
              "on-primary-fixed-variant": "#003dab",
              "tertiary": "#852b00",
              "secondary-fixed": "#dbe1ff",
              "on-surface-variant": "#434654",
              "surface-container": "#eceef0",
              "on-secondary": "#ffffff",
              "inverse-primary": "#b5c4ff",
              "on-primary": "#ffffff",
              "surface-container-lowest": "#ffffff",
              "secondary": "#4b5c92",
              "surface-dim": "#d8dadc",
              "on-error": "#ffffff",
              "error": "#ba1a1a",
              "surface-bright": "#f7f9fb",
              "on-error-container": "#93000a",
              "inverse-on-surface": "#eff1f3",
              "secondary-container": "#b1c2ff",
              "background": "#f7f9fb",
              "inverse-surface": "#2d3133",
              "surface": "#f7f9fb",
              "on-surface": "#191c1e",
              "on-primary-fixed": "#00174d",
              "error-container": "#ffdad6",
              "surface-container-high": "#e6e8ea",
              "primary-fixed-dim": "#b5c4ff",
              "primary-fixed": "#dbe1ff",
              "on-secondary-fixed-variant": "#334479",
              "on-secondary-container": "#3d4e84",
              "tertiary-container": "#ad3b00",
              "on-secondary-fixed": "#01174b"
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .card-ratio {
            aspect-ratio: 1.586 / 1;
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm dark:shadow-none">
<div class="flex justify-between items-center px-6 py-3 w-full">
<div class="flex items-center gap-4">
<span class="text-xl font-bold text-slate-900 dark:text-white font-inter antialiased tracking-tight">Portail AcadÃ©mique</span>
<div class="h-6 w-px bg-outline-variant/30 mx-2"></div>
<h1 class="text-sm font-semibold text-primary">AperÃ§u Carte Ã‰tudiant</h1>
</div>
<div class="flex items-center gap-2">
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors rounded-lg">
<span class="material-symbols-outlined text-[20px]">print</span>
<span>Imprimer</span>
</button>
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium bg-primary text-on-primary hover:bg-primary-container transition-all scale-95 active:opacity-80 rounded-lg">
<span class="material-symbols-outlined text-[20px]">download</span>
<span>TÃ©lÃ©charger PDF</span>
</button>
<button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors rounded-lg">
<span class="material-symbols-outlined text-[20px]">mail</span>
<span>Envoyer par mail</span>
</button>
</div>
</div>
</header>
<div class="flex min-h-screen pt-16">
<!-- SideNavBar -->
<aside class="h-screen w-64 hidden md:flex flex-col bg-slate-50 dark:bg-slate-950 border-r border-slate-200/50 dark:border-slate-800/50 fixed">
<div class="p-6 flex flex-col items-center border-b border-slate-200/30">
<div class="w-16 h-16 rounded-full bg-surface-container overflow-hidden mb-3">
<img alt="Photo de profil Ã©tudiant" class="w-full h-full object-cover" data-alt="Student professional portrait for ID card" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCk214s6k5dvCmtRbsLuv0O42VPBOTNnYIkczis2OQWn-GgXAuRzxW-Roh7QRvwG-7KSsxtBbbU_bkUpZ6OJw_-kPUQkSAoc8NxXzL08TKTq-BC3-uzdcKZPxWei35Pf-C0AO6IGi5M9XZjCjoWuVE1LioK06sDkd70u5SJDDNCpx66objUkivWbosgglJZedjNu1hk9w5ZVq0f6aGngmgJD-CxMhR7BBcF91qqQ7_1AIINzPjREjeqm5TurmleZGrqlcedytyi8Jg"/>
</div>
<h2 class="text-lg font-black tracking-tighter text-blue-800 dark:text-blue-300">Service de ScolaritÃ©e</h2>
<p class="text-xs text-slate-500 uppercase tracking-widest font-bold mt-1">ID: 2023-FR-092</p>
</div>
<nav class="flex flex-col gap-2 p-4">
<a class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-blue-700 dark:text-blue-400 bg-blue-50/50 dark:bg-blue-900/20 rounded-xl transition-transform" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">badge</span>
<span>Ma Carte</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-blue-600 dark:hover:text-blue-300 hover:translate-x-1 transition-transform rounded-xl" href="#">
<span class="material-symbols-outlined">school</span>
<span>Cursus</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-blue-600 dark:hover:text-blue-300 hover:translate-x-1 transition-transform rounded-xl" href="#">
<span class="material-symbols-outlined">grade</span>
<span>Notes</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 hover:text-blue-600 dark:hover:text-blue-300 hover:translate-x-1 transition-transform rounded-xl" href="#">
<span class="material-symbols-outlined">settings</span>
<span>ParamÃ¨tres</span>
</a>
</nav>
</aside>
<!-- Main Content -->
<main class="flex-1 ml-64 p-12 bg-surface">
<div class="max-w-4xl mx-auto">
<div class="mb-12">
<h2 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">PrÃ©visualisation de la Carte</h2>
<p class="text-on-surface-variant max-w-2xl">VÃ©rifiez les informations de votre carte acadÃ©mique avant l'impression finale ou le tÃ©lÃ©chargement du certificat numÃ©rique.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
<!-- Card Front -->
<div class="flex flex-col gap-4">
<span class="text-xs font-bold uppercase tracking-widest text-outline">Recto (Avers)</span>
<div class="card-ratio w-full bg-white rounded-[1.25rem] shadow-[0_12px_32px_rgba(25,28,30,0.06)] relative overflow-hidden border border-white">
<!-- Background Pattern -->
<div class="absolute inset-0 opacity-[0.03] pointer-events-none">
<svg height="100%" preserveaspectratio="none" viewbox="0 0 100 100" width="100%">
<path class="text-primary" d="M0 0 L100 100 M0 50 L50 100 M50 0 L100 50" fill="none" stroke="currentColor" stroke-width="0.5"></path>
</svg>
</div>
<!-- Blue Accent Top -->
<div class="absolute top-0 left-0 right-0 h-16 bg-gradient-to-r from-primary to-primary-container px-6 flex justify-between items-center">
<div class="flex items-center gap-2">
<div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
<span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">account_balance</span>
</div>
<span class="text-white font-black text-xs tracking-tight">UNIVERSITÃ‰ HORIZON LMD</span>
</div>
<span class="text-white/80 font-bold text-[10px] uppercase tracking-tighter">Carte d'Ã‰tudiant</span>
</div>
<div class="absolute inset-0 pt-20 pb-6 px-8 flex gap-6">
<!-- Photo -->
<div class="w-28 h-36 bg-surface-container-low rounded-lg border-2 border-surface-container-highest overflow-hidden shrink-0">
<img alt="KOUAMÃ‰ Marc-Antoine" class="w-full h-full object-cover grayscale-[20%] contrast-[1.1]" data-alt="Official student identification photo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBLHhhDnujo7z7kpvV9epuSxq-QKT2NKBh7QPUSbzU7ksfiarf_sHJGiwu11rlN21xcLGy51mgxN6J3dTJ9w4EuifUaMKTgTOLzCyLWfMO8ynMNZ2j3K0nvCbX2t9Kv1wuZYNBn5IWfMiKn-IvACEHuV5xFglIYMBc6GeG3LmU2UhmVS-83-CE9ZSqttxRhZvd7vOSjBmzRewjoEHtuQwowQMsa_ciBdUxLChCanbDwuKl39h9nkv36lLiRmUu3TLLG3K09CR_klTY"/>
</div>
<!-- Info -->
<div class="flex-1 flex flex-col justify-between py-1">
<div>
<h3 class="text-[10px] font-bold text-outline uppercase tracking-wider mb-0.5">Nom &amp; PrÃ©noms</h3>
<p class="text-lg font-black text-on-surface leading-tight tracking-tight">KOUAMÃ‰ Marc-Antoine</p>
</div>
<div class="grid grid-cols-2 gap-2 mt-4">
<div>
<h3 class="text-[9px] font-bold text-outline uppercase tracking-wider">Matricule</h3>
<p class="text-[11px] font-extrabold text-primary">2023-GL-001</p>
</div>
<div>
<h3 class="text-[9px] font-bold text-outline uppercase tracking-wider">Session</h3>
<p class="text-[11px] font-extrabold text-on-surface">2023-2024</p>
</div>
</div>
<div class="mt-4">
<h3 class="text-[9px] font-bold text-outline uppercase tracking-wider">FiliÃ¨re / SpÃ©cialitÃ©</h3>
<p class="text-[11px] font-extrabold text-on-surface">GÃ‰NIE LOGICIEL (LMD)</p>
</div>
</div>
</div>
<!-- Smart Chip -->
<div class="absolute bottom-6 right-8 w-10 h-7 bg-gradient-to-br from-[#ffd700] to-[#b8860b] rounded-md opacity-40 overflow-hidden flex flex-col justify-center px-1">
<div class="h-px bg-black/10 w-full mb-1"></div>
<div class="h-px bg-black/10 w-full mb-1"></div>
<div class="h-px bg-black/10 w-full"></div>
</div>
</div>
</div>
<!-- Card Back -->
<div class="flex flex-col gap-4">
<span class="text-xs font-bold uppercase tracking-widest text-outline">Verso (Revers)</span>
<div class="card-ratio w-full bg-white rounded-[1.25rem] shadow-[0_12px_32px_rgba(25,28,30,0.06)] relative overflow-hidden border border-white p-6 flex flex-col">
<!-- Magnetic Stripe -->
<div class="absolute top-8 left-0 right-0 h-10 bg-slate-900"></div>
<div class="mt-16 flex-1 flex gap-6">
<div class="flex-1">
<p class="text-[8px] leading-relaxed text-slate-500 italic mb-4">
                                        Cette carte est strictement personnelle et demeure la propriÃ©tÃ© de l'UniversitÃ© Horizon. En cas de perte, veuillez contacter le service de scolaritÃ© immÃ©diatement. L'usage frauduleux est passible de sanctions disciplinaires.
                                    </p>
<div class="flex items-end justify-between">
<div>
<h3 class="text-[9px] font-bold text-outline uppercase mb-2">Signature du Recteur</h3>
<div class="h-8">
<img alt="Signature" class="h-full object-contain mix-blend-multiply opacity-80" data-alt="Official university rector signature scan" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDVmwScRRnci6W6oH2LbdkalIPAM3sQ5l7MuhAktMhOmVOhGyag6-W2lWRI9lM7zDiaz3F3UjayPuNv3J1rJCiJo-wnTcGxdhVTsFsk_sNy9S0Hbp_CGY4qBIw_yMrhj8tUA6ogGFZir6luT9mnAxH1a2ygfimPiJq2mFHpY4mGsQuhGbXgBYkW7OC54ePKGIOGLEeK8hYyenwiiJucm8IZpOzdPPMT3BM9SBHSAF-Ihpey4xLfnsqwgz816IVB-WwBTBNoKICYFrM"/>
</div>
</div>
<div class="text-right">
<h3 class="text-[9px] font-bold text-outline uppercase">Expire le</h3>
<p class="text-[11px] font-bold text-error">30 OCT. 2024</p>
</div>
</div>
</div>
<!-- Security QR -->
<div class="w-24 h-24 bg-surface-container-low p-2 rounded-lg border border-outline-variant/30 flex items-center justify-center shrink-0">
<div class="w-full h-full bg-slate-900 rounded-sm relative">
<!-- Placeholder for QR Code with CSS -->
<div class="absolute inset-0 flex flex-wrap p-1 gap-px">
<div class="w-2 h-2 bg-white m-px"></div>
<div class="w-2 h-2 bg-white m-px"></div>
<div class="flex-1"></div>
<div class="w-2 h-2 bg-white m-px"></div>
<div class="w-full h-1 bg-white/20 mt-1"></div>
<div class="w-1/2 h-4 bg-white/10 mt-1"></div>
</div>
<div class="absolute inset-0 flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[16px]">qr_code_2</span>
</div>
</div>
</div>
</div>
<div class="mt-auto flex justify-between items-center pt-2 border-t border-slate-100">
<span class="text-[8px] font-medium text-slate-400">ID-1 Format 85.60 x 53.98 mm</span>
<div class="flex gap-1">
<div class="w-4 h-4 rounded-full bg-primary/20"></div>
<div class="w-4 h-4 rounded-full bg-secondary/20"></div>
</div>
</div>
</div>
</div>
</div>
<!-- Bento Grid for Details -->
<div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="md:col-span-2 p-6 bg-surface-container-lowest rounded-xl shadow-sm">
<h4 class="text-sm font-bold text-primary uppercase tracking-wider mb-4">Informations de SÃ©curitÃ©</h4>
<div class="space-y-4">
<div class="flex items-start gap-4 p-4 bg-surface-container-low rounded-lg">
<span class="material-symbols-outlined text-primary">verified_user</span>
<div>
<p class="text-sm font-bold">Hologramme de SÃ©curitÃ©</p>
<p class="text-xs text-on-surface-variant">Un hologramme 3D est appliquÃ© lors de l'impression physique pour prÃ©venir la contrefaÃ§on.</p>
</div>
</div>
<div class="flex items-start gap-4 p-4 bg-surface-container-low rounded-lg">
<span class="material-symbols-outlined text-primary">contactless</span>
<div>
<p class="text-sm font-bold">Puce NFC IntÃ©grÃ©e</p>
<p class="text-xs text-on-surface-variant">Compatible avec les lecteurs d'accÃ¨s aux bibliothÃ¨ques et cafÃ©tÃ©rias du campus.</p>
</div>
</div>
</div>
</div>
<div class="p-6 bg-primary text-on-primary rounded-xl shadow-lg flex flex-col justify-between overflow-hidden relative">
<div class="z-10">
<h4 class="text-sm font-bold uppercase tracking-widest opacity-80 mb-2">Statut</h4>
<div class="inline-flex px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold uppercase tracking-tighter">PrÃªt pour Impression</div>
</div>
<div class="mt-8 z-10">
<p class="text-[10px] opacity-70 mb-1">DerniÃ¨re mise Ã  jour</p>
<p class="text-sm font-bold">Aujourd'hui, 14:32</p>
</div>
<!-- Abstract Deco -->
<div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
</div>
</div>
<!-- Footer Info -->
<div class="mt-12 text-center">
<p class="text-xs text-outline">Â© 2024 UniversitÃ© Horizon - Tous droits rÃ©servÃ©s. SystÃ¨me de Gestion AcadÃ©mique LMD.</p>
</div>
</div>
</main>
</div>
</body></html>
