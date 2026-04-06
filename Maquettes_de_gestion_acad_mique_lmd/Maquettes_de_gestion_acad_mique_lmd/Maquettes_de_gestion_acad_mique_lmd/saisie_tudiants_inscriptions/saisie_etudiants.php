<?php
$page_title = 'Inscription Étudiant';
$current_page = 'etudiants';
include __DIR__ . '/../../../../backend/includes/sidebar.php';

// Variables assumed to be extracted from backend
$filieres = $filieres ?? [];
$etudiants = $etudiants ?? [];
$message = $message ?? '';
$type_message = $type_message ?? '';
?>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-lg <?= $type_message === 'success' ? 'bg-green-50 text-green-800 border-l-4 border-green-500' : 'bg-red-50 text-red-800 border-l-4 border-red-500' ?> shadow-sm">
        <?= $message ?>
    </div>
<?php endif; ?>

<!-- Registration Form Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
    <!-- Main Form Body -->
    <div class="lg:col-span-8 space-y-8">
        <div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)]">
            <div class="flex items-center gap-3 mb-8 pb-4 border-b border-surface-container">
                <span class="material-symbols-outlined text-primary" data-icon="person_add">person_add</span>
                <h4 class="text-lg font-bold">Informations Personnelles</h4>
            </div>
            
            <form method="POST" action="<?= $base_url . $backend_url ?>saisie_etudiants_backend.php" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_student">
                
                <!-- Matricule -->
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Numéro Matricule</label>
                    <div class="relative">
                        <input name="matricule" required class="w-full bg-slate-50 border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary shadow-sm transition-all outline-none" placeholder="Ex: LMD-2024-001" type="text"/>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-300 text-lg">fingerprint</span>
                    </div>
                </div>
                
                <!-- Filière Selection -->
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Filière d'inscription</label>
                    <select name="filiere" required class="w-full bg-slate-50 border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary shadow-sm transition-all appearance-none outline-none">
                        <option value="">Sélectionner une filière</option>
                        <?php foreach ($filieres as $f): ?>
                            <option value="<?= $f['id_filiere'] ?>"><?= htmlspecialchars($f['nom_filiere']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Nom -->
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nom de famille</label>
                    <input name="nom" required class="w-full bg-slate-50 border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary shadow-sm transition-all outline-none" placeholder="Entrez le nom" type="text"/>
                </div>
                
                <!-- Prénom -->
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Prénoms</label>
                    <input name="prenom" required class="w-full bg-slate-50 border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary shadow-sm transition-all outline-none" placeholder="Entrez les prénoms" type="text"/>
                </div>
                
                <!-- Email -->
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Email</label>
                    <input name="email" class="w-full bg-slate-50 border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary shadow-sm transition-all outline-none" placeholder="etudiant@univ.edu" type="email"/>
                </div>
                
                <!-- Téléphone -->
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Téléphone</label>
                    <input name="telephone" class="w-full bg-slate-50 border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary shadow-sm transition-all outline-none" placeholder="+224..." type="text"/>
                </div>
                
                <!-- Date de naissance -->
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Date de naissance</label>
                    <input name="date_naissance" class="w-full bg-slate-50 border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary shadow-sm transition-all outline-none" type="date"/>
                </div>
                
                <div class="md:col-span-2 flex justify-end gap-4 mt-4">
                    <button type="reset" class="px-6 py-3 rounded-lg font-bold text-sm text-slate-500 hover:bg-slate-100 transition-colors">Réinitialiser</button>
                    <button type="submit" class="px-10 py-3 rounded-lg font-bold text-sm bg-primary text-white shadow-lg shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-2">
                        Valider l'inscription
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Profile Photo Upload & Statistics -->
    <aside class="lg:col-span-4 space-y-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] text-center">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6 text-left">Photo d'identité</h4>
            <div class="relative group cursor-pointer border-2 border-dashed border-slate-200 rounded-xl p-8 hover:border-primary/50 hover:bg-primary/5 transition-all" onclick="document.getElementById('photo-input').click()">
                <input type="file" name="photo" id="photo-input" accept="image/jpeg,image/png,image/gif" class="hidden" onchange="previewPhoto(event)">
                <span class="material-symbols-outlined text-5xl text-slate-300 mb-4 block" id="photo-icon">add_a_photo</span>
                <img id="photo-preview" class="hidden w-32 h-40 object-cover rounded-lg mx-auto mb-4" alt="Aperçu photo">
                <p class="text-sm font-medium text-slate-600" id="photo-text">Sélectionner une photo</p>
                <p class="text-[10px] text-slate-400 mt-1">PNG, JPG ou JPEG (Max. 2 Mo)</p>
            </div>
            <div class="mt-6 p-4 bg-slate-50 rounded-lg text-left">
                <div class="flex items-start gap-3 text-slate-500">
                    <span class="material-symbols-outlined text-primary text-xl">info</span>
                    <p class="text-[11px] leading-relaxed italic">Format recommandé : 4x4cm, fond uni blanc ou bleu clair.</p>
                </div>
            </div>
        </div>
        
        <div class="bg-slate-800 text-white p-6 rounded-xl shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <h4 class="text-xs font-bold uppercase tracking-widest opacity-70 mb-4">Mise à jour Dossiers</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <span class="text-xs">Capacité Session</span>
                        <span class="text-xl font-black">85%</span>
                    </div>
                    <div class="w-full bg-white/20 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-primary h-full w-[85%]"></div>
                    </div>
                    <p class="text-[10px] opacity-60">Estimation basée sur l'année précédente.</p>
                </div>
            </div>
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-primary/10 rounded-full blur-3xl"></div>
        </div>
    </aside>
</div>

<!-- Recent Students Table -->
<section>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h4 class="text-xl font-bold text-slate-800">Derniers Inscrits</h4>
            <p class="text-sm text-slate-500">Aperçu en temps réel des enregistrements récents.</p>
        </div>
        <a href="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php" class="flex items-center gap-2 text-primary font-bold text-sm hover:underline">
            Voir l'annuaire complet
            <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Étudiant</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Matricule</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Filière</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($etudiants)): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic font-medium">Rechargez la page pour voir les dernières inscriptions.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($etudiants as $et): ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                        <?= strtoupper(substr($et['nom'], 0, 1) . substr($et['prenom'], 0, 1)) ?>
                                    </div>
                                    <span class="text-sm font-bold text-slate-800"><?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-mono text-slate-600"><?= htmlspecialchars($et['matricule']) ?></td>
                            <td class="px-6 py-4 text-sm text-slate-500"><?= htmlspecialchars($et['nom_filiere']) ?></td>
                            <td class="px-6 py-4 text-sm text-slate-400 text-right"><?= date('d/m/Y', strtotime($et['date_inscription'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
