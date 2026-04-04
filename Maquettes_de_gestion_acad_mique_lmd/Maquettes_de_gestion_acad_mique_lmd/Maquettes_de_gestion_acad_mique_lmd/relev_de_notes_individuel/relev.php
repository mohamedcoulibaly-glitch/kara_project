<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/relev_backend.php';
$page_title = $page_title ?? 'Relevé de Notes Individuel';
$current_page = $current_page ?? 'releve';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
$erreur_releve = $erreur_releve ?? '';
?>

<!-- Header Options -->
<div class="mb-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 print:hidden">
    <div>
        <nav class="flex items-center text-[10px] font-bold text-slate-500 mb-1 gap-1 uppercase tracking-widest">
            <a href="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php" class="hover:text-primary">Répertoire</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <?php if (!empty($etudiant['id_etudiant'])): ?>
            <a href="<?= $base_url . $backend_url ?>parcours_academique_backend.php?id=<?= (int)$etudiant['id_etudiant'] ?>" class="hover:text-primary">Parcours</a>
            <?php endif; ?>
        </nav>
        <h1 class="text-2xl font-bold flex items-center gap-2">
            <span class="material-symbols-outlined">receipt_long</span> Relevé de Notes
        </h1>
        <?php if (!empty($etudiant['id_etudiant'])): ?>
        <form method="get" action="<?= $base_url . $backend_url ?>relev_backend.php" class="mt-3 flex flex-wrap items-center gap-2 text-sm">
            <input type="hidden" name="etudiant_id" value="<?= (int)$etudiant['id_etudiant'] ?>">
            <label class="text-slate-500 font-medium">Semestre</label>
            <select name="semestre" class="bg-slate-50 border-none rounded-lg px-3 py-1.5 font-semibold text-primary" onchange="this.form.submit()">
                <?php for ($s = 1; $s <= 6; $s++): ?>
                    <option value="<?= $s ?>" <?= ($semestre ?? 1) === $s ? 'selected' : '' ?>>S<?= $s ?></option>
                <?php endfor; ?>
            </select>
        </form>
        <?php endif; ?>
    </div>
    <div class="flex gap-2">
        <button class="bg-primary text-white px-4 py-2 rounded-lg shadow-sm font-bold text-sm flex items-center gap-2 hover:bg-primary-container transition-colors" onclick="window.print()">
            <span class="material-symbols-outlined text-sm">print</span> Imprimer le relevé
        </button>
        <button class="bg-white border text-slate-700 font-bold px-4 py-2 text-sm rounded-lg shadow-sm hover:bg-slate-50 flex items-center gap-2" onclick="history.back()">
            Retour
        </button>
    </div>
</div>

<?php if (!empty($erreur_releve)): ?>
<div class="bg-amber-50 text-amber-800 p-8 border border-amber-200 rounded-lg mb-4 max-w-4xl print:hidden">
    <span class="material-symbols-outlined text-4xl mb-2 block">info</span>
    <p class="font-medium"><?= $erreur_releve ?></p>
</div>
<?php elseif (empty($parcours) || empty($parcours['ues'])): ?>
<div class="bg-amber-50 text-amber-600 p-8 border border-amber-200 rounded-lg mb-4 text-center max-w-4xl print:hidden">
    <span class="material-symbols-outlined text-4xl mb-2">info</span>
    <h3 class="font-bold">Aucune donnée trouvée</h3>
    <p>Ce relevé ne contient aucune note enregistrée pour ce semestre.</p>
</div>
<?php else: ?>
<!-- A4 Page Container -->
<div class="bg-white shadow-lg mx-auto relative print:shadow-none print:border border border-slate-200" style="width: 210mm; min-height: 297mm; padding: 15mm 20mm;">
    
    <!-- EN-TÊTE OFFICIEL -->
    <div class="flex justify-between items-start mb-6 border-b-2 border-slate-800 pb-4">
        <!-- Logo Univ -->
        <div class="text-center w-[60mm]">
            <div class="w-16 h-16 border-2 border-slate-800 rounded-full mx-auto mb-2 flex items-center justify-center font-bold text-slate-800">
                LMD
            </div>
            <h2 class="font-black tracking-widest text-xs uppercase text-slate-800 leading-tight">Université<br>Académique LMD</h2>
            <p class="text-[9px] mt-1 text-slate-600">Direction de la Scolarité</p>
        </div>
        
        <!-- Info Releve -->
        <div class="text-right w-[80mm] mt-2">
            <h1 class="text-xl font-black uppercase text-slate-800 mb-1">Relevé de Notes</h1>
            <p class="text-sm font-bold text-slate-600 border border-slate-300 inline-block px-3 py-1">Semestre <?= $semestre ?></p>
            <p class="text-[10px] text-slate-400 mt-2 italic">Année Académique: <?= date('Y')-1 ?>-<?= date('Y') ?></p>
        </div>
    </div>
    
    <!-- INFOS ETUDIANT -->
    <div class="flex gap-4 mb-8">
        <div class="w-24 h-32 border border-slate-300 p-1 flex-shrink-0 bg-slate-50">
            <?php if (!empty($etudiant['photo_url'])): ?>
                <img src="<?= htmlspecialchars($etudiant['photo_url']) ?>" alt="Photo" class="h-full w-full object-cover grayscale">
            <?php else: ?>
                <div class="h-full w-full flex items-center justify-center text-slate-300"><span class="material-symbols-outlined text-4xl">person</span></div>
            <?php endif; ?>
        </div>
        <div class="flex-1 grid grid-cols-2 gap-x-8 gap-y-3 content-center">
            <div>
                <span class="block text-[9px] text-slate-500 font-bold uppercase uppercase tracking-wider">Matricule</span>
                <span class="block text-sm font-mono font-bold text-slate-800 border-b border-slate-200 pb-1"><?= $etudiant['matricule'] ?></span>
            </div>
            <div>
                <span class="block text-[9px] text-slate-500 font-bold uppercase uppercase tracking-wider">Filière / Parcours</span>
                <span class="block text-sm font-bold text-slate-800 border-b border-slate-200 pb-1 truncate" title="<?= htmlspecialchars($etudiant['nom_filiere']) ?>"><?= htmlspecialchars($etudiant['nom_filiere']) ?></span>
            </div>
            <div class="col-span-2">
                <span class="block text-[9px] text-slate-500 font-bold uppercase uppercase tracking-wider">Noms et Prénoms de l'Étudiant</span>
                <span class="block text-lg font-black uppercase text-slate-800"><?= mb_strtoupper($etudiant['nom']) . ' ' . $etudiant['prenom'] ?></span>
            </div>
        </div>
    </div>
    
    <!-- TABLE DES NOTES -->
    <div class="mb-8 min-h-[400px]">
        <table class="w-full text-left border-collapse border border-slate-800 text-sm">
            <thead>
                <tr class="bg-slate-100 text-slate-800">
                    <th class="border border-slate-400 py-1.5 px-3 text-xs w-24">Code UE</th>
                    <th class="border border-slate-400 py-1.5 px-3 text-xs">Unité d'Enseignement / Élément Constitutif</th>
                    <th class="border border-slate-400 py-1.5 px-3 text-xs text-center w-16">Coef</th>
                    <th class="border border-slate-400 py-1.5 px-3 text-xs text-center w-16">Crédits</th>
                    <th class="border border-slate-400 py-1.5 px-3 text-xs text-center w-24">Note / 20</th>
                    <th class="border border-slate-400 py-1.5 px-3 text-xs text-center w-24">Session</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parcours['ues'] as $ue): ?>
                    <!-- Ligne UE -->
                    <tr class="bg-slate-50 text-slate-800 font-bold">
                        <td class="border border-slate-400 py-2 px-3 text-[11px] font-mono"><?= $ue['code_ue'] ?></td>
                        <td class="border border-slate-400 py-2 px-3 uppercase text-xs"><?= htmlspecialchars($ue['libelle_ue']) ?></td>
                        <td class="border border-slate-400 py-2 px-3 text-center text-xs"><?= $ue['coefficient'] ?? '-' ?></td>
                        <td class="border border-slate-400 py-2 px-3 text-center text-xs"><?= $ue['credits_ects'] ?></td>
                        <td class="border border-slate-400 py-2 px-3 text-center text-xs bg-slate-200">
                            <?= number_format($ue['moyenne_ue'], 2, ',', ' ') ?>
                        </td>
                        <td class="border border-slate-400 py-2 px-3 text-center text-[10px] italic font-normal text-slate-500">-</td>
                    </tr>
                    <!-- Lignes EC -->
                    <?php if (!empty($ue['notes'])): ?>
                        <?php foreach ($ue['notes'] as $note): ?>
                            <tr class="text-slate-700">
                                <td class="border border-slate-300 py-1 px-3 border-r-0 border-l-slate-400"></td>
                                <td class="border border-slate-300 py-1 px-3 pl-6 text-xs italic">- <?= htmlspecialchars($note['ec']) ?></td>
                                <td class="border border-slate-300 py-1 px-3 text-center text-[11px]"><?= $note['coef_ec'] ?? '-' ?></td>
                                <td class="border border-slate-300 py-1 px-3 text-center text-[11px]">-</td>
                                <td class="border border-slate-300 py-1 px-3 text-right pr-4 text-xs font-mono <?= $note['note'] < 10 ? 'text-slate-400' : '' ?>">
                                    <?= number_format($note['note'], 2, ',', ' ') ?>
                                </td>
                                <td class="border border-slate-300 border-r-slate-400 py-1 px-3 text-center text-[10px]">
                                    <?= substr($note['session'], 0, 4) ?>.
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- RESULTATS DU SEMESTRE -->
    <div class="flex gap-4 border-2 border-slate-800 rounded bg-slate-50 p-4 mb-16 shadow-none">
        
        <div class="flex-1 grid grid-cols-2 gap-4 divide-x divide-slate-300 text-center">
            <div>
                <span class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Moyenne du Semestre</span>
                <span class="text-2xl font-black text-slate-800">
                    <?= number_format($moyenne_semestre, 2, ',', ' ') ?> <span class="text-sm font-bold text-slate-500">/ 20</span>
                </span>
            </div>
            <div>
                <span class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Crédits ECTS Capitalisés</span>
                <span class="text-2xl font-black text-slate-800">
                    <?= $credits_obtenus ?> <span class="text-sm font-bold text-slate-500">/ <?= $total_credits ?></span>
                </span>
            </div>
        </div>
        
        <div class="w-[80mm] pl-4 border-l border-slate-300 flex flex-col justify-center">
            <span class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Décision du Jury</span>
            <span class="text-base font-black uppercase <?= $moyenne_semestre >= 10 ? 'text-slate-800' : 'text-slate-500' ?>">
                <?= $moyenne_semestre >= 10 ? 'SEMESTRE VALIDÉ' : 'SEMESTRE NON VALIDÉ' ?>
            </span>
        </div>
    </div>
    
    <!-- SIGNATURES & PIED DE PAGE -->
    <div class="flex justify-between items-end">
        <div class="w-64">
            <p class="text-[9px] text-slate-500 text-justify mb-4">
                <em>* L'étudiant qui ne trouve pas une note affichée doit se rapprocher du service des examens dans un délai ne dépassant pas les 72h. Aucun duplicata ne sera délivré.</em>
            </p>
            <div class="bg-slate-100 p-1 w-16 h-16 border border-slate-200">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=<?= urlencode('RLV-'.$code_verification) ?>" alt="QR" class="w-full h-full mix-blend-multiply opacity-80">
            </div>
        </div>
        
        <div class="text-center">
            <p class="text-[11px] mb-8 font-medium">Fait à Dakar, le <?= date('d/m/Y', strtotime($date_emission)) ?></p>
            <p class="font-bold uppercase text-xs mb-10">La Direction des Études</p>
            <p class="text-[10px] italic text-slate-400 border-t border-slate-400 pt-1 border-dashed">Signature & Cachet</p>
        </div>
    </div>
    
    <div class="absolute bottom-2 left-0 w-full text-center text-[7px] text-slate-400 font-mono tracking-widest">
        VER/<?= current(explode('-', $code_verification)) ?>/<?= date('YmdHis') ?>/<?= $etudiant['id_etudiant'] ?>
    </div>
</div>
<?php endif; ?>

<style>
@media print {
    body { background: white !important; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    aside, header, .print\:hidden { display: none !important; }
    main { margin: 0 !important; padding: 0 !important; }
}
</style>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
