<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/carte_etudiant_backend.php';
// Variables from backend: $etudiant, $carte, $progression, $estValide
$page_title = 'Carte d\'Étudiant';
$current_page = 'etudiants';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Header -->
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6 print:hidden">
    <div>
        <nav class="flex items-center text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
            <a href="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php" class="hover:text-primary transition-colors">Répertoire</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary font-bold">Carte d'Étudiant</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Édition Carte Étudiant</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Générez et imprimez la carte d'identification officielle de cet étudiant.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php" class="bg-white border border-outline-variant/30 text-slate-600 px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Retour 
        </a>
        <button class="bg-primary hover:bg-primary-container text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md shadow-primary/20 transition-all flex items-center gap-2" onclick="window.print()">
            <span class="material-symbols-outlined text-sm">print</span>
            Imprimer la Carte
        </button>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-8 items-start">
    <!-- Visualisation de la carte (Center Stage) -->
    <div class="w-full lg:w-3/5 flex justify-center py-6">
        
        <!-- CARD CONTAINER (CRB size: 85.6mm x 53.98mm approx) -->
        <div class="relative w-[85.6mm] h-[170mm] rounded-xl overflow-hidden print:shadow-none print:border shadow-xl bg-white border border-slate-200" style="width: 323px; height: 504px;">
            
            <!-- RECTO -->
            <div class="w-full h-[53.98mm] relative border-b border-dashed border-slate-300" style="height: 252px;">
                <!-- Header Bandeau Bleu -->
                <div class="absolute top-0 left-0 w-full h-16 bg-[#1A56DB] flex items-center justify-between px-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-[#1A56DB]">
                            <span class="material-symbols-outlined text-[18px]">school</span>
                        </div>
                        <div class="text-white text-[9px] font-bold leading-tight uppercase tracking-widest">
                            Université<br>LMD
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-white font-black tracking-widest text-[11px] uppercase border border-white/30 px-2 py-0.5 rounded">
                            CARTE D'ÉTUDIANT
                        </div>
                        <div class="text-white/80 text-[8px] font-bold mt-0.5">
                            <?= date('Y') ?> - <?= date('Y')+1 ?>
                        </div>
                    </div>
                </div>
                
                <!-- Corner Motif -->
                <div class="absolute top-[64px] right-0 w-16 h-16 bg-[#1A56DB]/5 rounded-bl-full pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#1A56DB]/5 rounded-tr-full pointer-events-none"></div>

                <!-- Info Section -->
                <div class="absolute top-[76px] left-0 w-full px-4 flex gap-4">
                    <!-- Photo -->
                    <div class="w-[80px] h-[100px] border-[3px] border-white shadow-sm bg-slate-100 flex-shrink-0 relative overflow-hidden flex items-center justify-center -rotate-2 z-10">
                        <?php if (!empty($etudiant['photo_url'])): ?>
                            <img src="<?= htmlspecialchars($etudiant['photo_url']) ?>" alt="Photo" class="w-full h-full object-cover">
                        <?php else: ?>
                            <span class="material-symbols-outlined text-4xl text-slate-300">person</span>
                        <?php endif; ?>
                        <!-- Mini bar-code overlay at bottom of photo -->
                        <div class="absolute bottom-0 left-0 w-full h-1.5 bg-[#1A56DB] opacity-80"></div>
                    </div>
                    
                    <!-- Text Info -->
                    <div class="flex-1 space-y-2.5 z-10 pt-1">
                        <div>
                            <span class="block text-[7px] text-slate-400 font-bold uppercase mb-0.5">Noms & Prénoms</span>
                            <span class="block text-[13px] font-black text-slate-800 leading-tight">
                                <?= mb_strtoupper(htmlspecialchars($etudiant['nom'])) ?><br>
                                <span class="font-bold text-[11px]"><?= htmlspecialchars($etudiant['prenom']) ?></span>
                            </span>
                        </div>
                        <div>
                            <span class="block text-[7px] text-slate-400 font-bold uppercase mb-0.5">Matricule</span>
                            <span class="block text-[11px] font-mono font-bold text-[#1A56DB] bg-[#1A56DB]/10 px-1.5 py-0.5 inline-block rounded">
                                <?= htmlspecialchars($etudiant['matricule']) ?>
                            </span>
                        </div>
                        <div>
                            <span class="block text-[7px] text-slate-400 font-bold uppercase mb-0.5">Filière</span>
                            <span class="block text-[10px] font-bold text-slate-600 leading-tight truncate">
                                <?= htmlspecialchars($etudiant['nom_filiere']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Bar Recto -->
                <div class="absolute bottom-3 left-0 w-full px-4 flex justify-between items-end">
                    <div class="text-[8px] font-bold text-slate-500">
                        Né(e) le: <span class="text-slate-700"><?= date('d/m/Y', strtotime($etudiant['date_naissance'])) ?></span>
                    </div>
                    <?php if (!$estValide): ?>
                        <div class="bg-red-500 text-white text-[8px] font-bold px-1.5 py-0.5 rounded rotate-12 absolute right-4 bottom-8 border border-white">
                            EXIPRÉE
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- VERSO -->
            <div class="w-full h-[53.98mm] relative bg-white" style="height: 252px;">
                <!-- Magnetic stripe representation -->
                <div class="w-full h-10 bg-slate-800 mt-4 mb-3"></div>
                
                <div class="px-5 flex gap-4">
                    <!-- Text Verso -->
                    <div class="flex-1 space-y-2">
                        <p class="text-[7.5px] leading-snug text-slate-600 italic">
                            Strictement personnelle. Cette carte est une propriété de l'Université.<br>
                            En cas de perte, merci de la retourner au service de scolarité.
                        </p>
                        <div class="pt-2 border-t border-slate-200 mt-2 space-y-2">
                            <div>
                                <span class="text-[7px] font-bold text-slate-400 uppercase">N° Carte RFID</span><br>
                                <span class="text-[9px] font-mono text-slate-700"><?= $carte['numero_carte'] ?></span>
                            </div>
                            <div class="flex justify-between w-full">
                                <div>
                                    <span class="text-[7px] font-bold text-slate-400 uppercase">Émise le</span><br>
                                    <span class="text-[9px] font-bold text-slate-700"><?= date('d/m/Y', strtotime($carte['date_emission'])) ?></span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[7px] font-bold text-slate-400 uppercase">Expire le</span><br>
                                    <span class="text-[9px] font-bold <?= $estValide ? 'text-slate-700' : 'text-red-500' ?>"><?= date('d/m/Y', strtotime($carte['date_expiration'])) ?></span>
                                </div>
                            </div>
                        </div>
                        <!-- Signature placeholder -->
                        <div class="text-right pt-2 mr-2">
                            <span class="text-[8px] font-bold text-[#1A56DB] inline-block border-b border-[#1A56DB]/30 pb-4 w-16 text-center">Le Directeur Académique</span>
                        </div>
                    </div>
                    
                    <!-- QR CODE -->
                    <div class="w-[70px] flex-shrink-0 flex flex-col items-center justify-start pt-1">
                        <img src="<?= htmlspecialchars($carte['qr_code']) ?>" alt="QR Code" class="w-[60px] h-[60px] border border-slate-300 rounded p-1">
                        <span class="text-[6px] text-center text-slate-400 mt-1 uppercase">Scan de<br>vérification</span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- Informations & Statut (Right panel, hidden on print) -->
    <div class="w-full lg:w-2/5 flex flex-col gap-6 print:hidden">
        
        <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
            <h3 class="font-bold text-slate-800 text-lg mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">verified_user</span>
                Statut de la Carte
            </h3>
            
            <div class="flex items-center gap-4 mb-6">
                <?php if ($estValide): ?>
                    <div class="h-12 w-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center border-4 border-green-100 flex-shrink-0">
                        <span class="material-symbols-outlined">check</span>
                    </div>
                    <div>
                        <span class="block text-lg font-black text-green-600">Carte Active</span>
                        <span class="text-xs text-slate-500 font-medium">Valide jusqu'au <?= date('d/m/Y', strtotime($carte['date_expiration'])) ?></span>
                    </div>
                <?php else: ?>
                    <div class="h-12 w-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center border-4 border-red-100 flex-shrink-0">
                        <span class="material-symbols-outlined">block</span>
                    </div>
                    <div>
                        <span class="block text-lg font-black text-red-600">Carte Expirée / Invalide</span>
                        <span class="text-xs text-slate-500 font-medium">Échapée le <?= date('d/m/Y', strtotime($carte['date_expiration'])) ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 font-bold uppercase text-[11px] tracking-widest">Numéro RFID</span>
                    <span class="font-mono text-slate-800 font-bold bg-slate-50 px-2 py-0.5 rounded border border-slate-200"><?= $carte['numero_carte'] ?></span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-slate-500 font-bold uppercase text-[11px] tracking-widest">Délivrée le</span>
                    <span class="text-slate-700 font-bold"><?= date('d/m/Y', strtotime($carte['date_emission'])) ?></span>
                </div>
            </div>
            
            <div class="mt-6 flex gap-2">
                <button class="flex-1 bg-white border border-slate-300 text-slate-700 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
                    Renouveler (1 an)
                </button>
                <button class="flex-1 bg-red-50 border border-red-200 text-red-600 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-red-100 transition-all">
                    Bloquer
                </button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
            <h3 class="font-bold text-slate-800 text-sm mb-4">Progression Académique</h3>
            
            <div class="space-y-5">
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-slate-500">UE TENTÉES (<?= $progression['ues_validees'] + $progression['ues_non_validees'] ?> / <?= $progression['ues_prevues'] ?>)</span>
                        <?php $p_tente = $progression['ues_prevues'] > 0 ? (($progression['ues_validees'] + $progression['ues_non_validees']) / $progression['ues_prevues']) * 100 : 0; ?>
                        <span class="text-slate-700"><?= round($p_tente) ?>%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-slate-400 rounded-full" style="width: <?= $p_tente ?>%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-slate-500">UE VALIDÉES (<?= $progression['ues_validees'] ?> / <?= $progression['ues_prevues'] ?>)</span>
                        <?php $p_valide = $progression['ues_prevues'] > 0 ? ($progression['ues_validees'] / $progression['ues_prevues']) * 100 : 0; ?>
                        <span class="text-primary"><?= round($p_valide) ?>%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full" style="width: <?= $p_valide ?>%"></div>
                    </div>
                </div>
            </div>
            <div class="mt-5 text-center px-4">
                <a href="<?= $base_url . $backend_url ?>parcours_academique_backend.php?id=<?= $etudiant['id_etudiant'] ?>" class="text-[11px] font-bold text-primary hover:underline flex items-center justify-center gap-1">
                    Voir le parcours complet <span class="material-symbols-outlined text-sm">open_in_new</span>
                </a>
            </div>
        </div>
        
    </div>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
