<?php
$page_title = 'Attestation de Réussite';
$current_page = 'dashboard';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Header Options -->
<div class="mb-4 flex justify-between items-center print:hidden">
    <div>
        <h1 class="text-2xl font-bold">Attestation de Réussite</h1>
        <p class="text-slate-500 text-sm">Aperçu avant impression</p>
    </div>
    <div class="flex gap-2">
        <button class="bg-primary text-white px-4 py-2 rounded shadow flex items-center gap-2" onclick="window.print()">
            <span class="material-symbols-outlined">print</span> Imprimer
        </button>
        <button class="bg-white border text-slate-700 px-4 py-2 rounded shadow flex items-center gap-2" onclick="history.back()">
            Retour
        </button>
    </div>
</div>

<?php if (!$is_admis): ?>
<div class="bg-red-50 text-red-600 p-4 border border-red-200 rounded-lg mb-4 text-center mx-auto max-w-4xl print:hidden">
    <span class="material-symbols-outlined text-4xl mb-2">error</span>
    <h3 class="font-bold">Génération impossible</h3>
    <p>L'étudiant n'a pas validé ce semestre (Statut: Non Admis).</p>
</div>
<?php else: ?>
<!-- A4 Page Container -->
<div class="bg-white border shadow-lg mx-auto relative overflow-hidden print:shadow-none print:border-none" style="width: 210mm; min-height: 297mm; padding: 20mm;">
    
    <!-- Header Repblique -->
    <div class="flex justify-between items-start mb-12">
        <div class="text-center w-[60mm]">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Coat_of_arms_of_Senegal.svg/100px-Coat_of_arms_of_Senegal.svg.png" alt="Armoiries" class="h-16 mx-auto mb-2 opacity-80">
            <h4 class="font-bold text-xs uppercase">République du Sénégal</h4>
            <div class="h-0.5 w-8 bg-slate-800 mx-auto my-1"></div>
            <p class="text-[9px] uppercase">Un Peuple - Un But - Une Foi</p>
            <br>
            <h4 class="font-bold text-[10px] uppercase">Ministère de l'Enseignement Supérieur</h4>
            <div class="h-px w-24 bg-slate-400 mx-auto my-1"></div>
        </div>
        
        <div class="text-center w-[80mm]">
            <div class="w-16 h-16 border border-slate-300 rounded-full mx-auto mb-2 flex items-center justify-center font-bold text-slate-400">
                LOGO
            </div>
            <h2 class="font-black tracking-wider text-sm uppercase text-slate-800">Université Académique</h2>
            <p class="text-xs mt-1 text-slate-600">Direction de la scolarité et des examens</p>
        </div>
    </div>
    
    <!-- Title -->
    <div class="text-center mb-12">
        <h1 class="text-3xl font-black uppercase tracking-widest text-[#1a365d] border-b-2 border-[#1a365d] inline-block pb-2 px-8 mb-2">
            Attestation de Réussite
        </h1>
        <p class="text-sm font-bold mt-2 text-slate-600">Année Académique : 2023 - 2024</p>
    </div>
    
    <!-- Body -->
    <div class="space-y-6 text-sm leading-relaxed mb-12">
        <p>Le Président de l'Université, soussigné, atteste que :</p>
        
        <div class="bg-slate-50 border border-slate-200 p-6 rounded-lg ml-6">
            <table class="w-full">
                <tr>
                    <td class="w-40 py-1 text-slate-500 uppercase text-xs font-bold">M. / Mme :</td>
                    <td class="font-black text-lg text-slate-800"><?= mb_strtoupper($etudiant['nom']) . ' ' . $etudiant['prenom'] ?></td>
                </tr>
                <tr>
                    <td class="w-40 py-1 text-slate-500 uppercase text-xs font-bold">Matricule :</td>
                    <td class="font-mono font-bold"><?= $etudiant['matricule'] ?></td>
                </tr>
                <tr>
                    <td class="w-40 py-1 text-slate-500 uppercase text-xs font-bold">Né(e) le :</td>
                    <td class="font-semibold"><?= date('d/m/Y', strtotime($etudiant['date_naissance'])) ?></td>
                </tr>
            </table>
        </div>
        
        <p>A satisfait aux conditions de contrôle des connaissances et des aptitudes et a été déclaré(e) <strong class="uppercase text-green-700">Admis(e)</strong> aux examens de :</p>
        
        <div class="ml-6 border-l-4 border-[#1a365d] pl-4">
            <h3 class="font-black text-lg text-[#1a365d] uppercase"><?= $etudiant['nom_filiere'] ?></h3>
            <p class="font-bold text-slate-700 mt-1">Au titre du SEMESTRE <?= $semestre ?></p>
        </div>
        
        <div class="ml-6 space-y-2 pt-4">
            <p><span class="inline-block w-48 text-slate-500">Moyenne Générale :</span> <strong class="text-lg"><?= number_format($moyenne_generale, 2, ',', ' ') ?> / 20</strong></p>
            <p><span class="inline-block w-48 text-slate-500">Crédits ECTS validés :</span> <strong><?= $credits_obtenus ?> / 30</strong></p>
            <p><span class="inline-block w-48 text-slate-500">Mention :</span> <strong class="uppercase"><?= $mention ?></strong></p>
        </div>
        
        <p class="pt-6">En foi de quoi, la présente attestation lui est délivrée pour servir et valoir ce que de droit.</p>
        <p class="text-xs italic text-slate-500">Il n'est délivré qu'une seule attestation de réussite. Il appartient à l'intéressé(e) d'en faire des copies certifiées conformes.</p>
    </div>
    
    <!-- Signatures -->
    <div class="flex justify-between items-start mt-16 px-4">
        <div class="text-center w-64 border border-dashed border-slate-300 p-2 opacity-50">
            <p class="text-[10px] text-slate-400">Timbre sec de l'établissement</p>
        </div>
        <div class="text-center">
            <p class="mb-2 italic">Fait à Dakar, le <?= date('d/m/Y', strtotime($date_emission)) ?></p>
            <p class="font-bold uppercase text-xs">Le Directeur de la Scolarité</p>
            <div class="h-24 w-48 bg-slate-50 border-b-2 border-slate-800/10 mx-auto mt-2"></div>
        </div>
    </div>
    
    <!-- Footer Verify Code -->
    <div class="absolute bottom-8 left-0 w-full px-[20mm] flex justify-between items-end text-[10px] text-slate-400 font-mono">
        <div>Réf: <?= $code_verification ?></div>
        <div class="bg-slate-100 p-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=50x50&data=<?= urlencode('VERIFY:'.$code_verification) ?>" alt="QR" class="w-10 h-10 mix-blend-multiply"></div>
    </div>

</div>
<?php endif; ?>

<style>
@media print {
    body { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    aside, header, .print\:hidden { display: none !important; }
    main { margin: 0 !important; padding: 0 !important; }
}
</style>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
