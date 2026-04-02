/**
 * app.js - Central behavioral logic for the Academic Management Platform
 * Implements dynamic sections, CRUD visual feedback, and view switching.
 */

document.addEventListener('DOMContentLoaded', function() {
    // 1. Dynamic EC Rows in UE Creation Form
    const ecContainer = document.getElementById('ec-dynamic-container');
    const addEcBtn = document.getElementById('add-ec-row-btn');

    if (addEcBtn && ecContainer) {
        addEcBtn.addEventListener('click', function() {
            const rowIndex = ecContainer.children.length;
            const row = document.createElement('div');
            row.className = 'grid grid-cols-12 gap-3 items-end bg-slate-50 p-3 rounded-lg border border-slate-100 animate-in fade-in slide-in-from-top-2 duration-300';
            row.innerHTML = `
                <div class="col-span-3">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Code EC</label>
                    <input name="ecs[${rowIndex}][code]" required class="w-full bg-white border-slate-200 rounded text-xs p-2 focus:ring-2 focus:ring-primary outline-none" placeholder="INF101-1" type="text"/>
                </div>
                <div class="col-span-6">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nom de l'Élément</label>
                    <input name="ecs[${rowIndex}][nom]" required class="w-full bg-white border-slate-200 rounded text-xs p-2 focus:ring-2 focus:ring-primary outline-none" placeholder="Algorithme de base" type="text"/>
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Coeff.</label>
                    <input name="ecs[${rowIndex}][coeff]" required step="0.5" class="w-full bg-white border-slate-200 rounded text-xs p-2 focus:ring-2 focus:ring-primary outline-none" placeholder="2" type="number"/>
                </div>
                <div class="col-span-1">
                    <button type="button" class="remove-ec-btn h-9 w-9 flex items-center justify-center text-slate-300 hover:text-error transition-colors">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </div>
            `;
            ecContainer.appendChild(row);

            // Add remove logic
            row.querySelector('.remove-ec-btn').addEventListener('click', function() {
                row.remove();
            });
        });
    }

    // 2. View Switching (Grid vs List)
    const viewSwitchers = document.querySelectorAll('[data-view-switch]');
    const viewContainer = document.getElementById('maquette-view-container');

    viewSwitchers.forEach(btn => {
        btn.addEventListener('click', function() {
            const viewType = this.getAttribute('data-view-switch');
            
            // Toggle active state on buttons
            viewSwitchers.forEach(b => b.classList.remove('bg-primary', 'text-white'));
            viewSwitchers.forEach(b => b.classList.add('bg-white', 'text-slate-400'));
            this.classList.add('bg-primary', 'text-white');
            this.classList.remove('bg-white', 'text-slate-400');

            // Change grid columns
            if (viewContainer) {
                if (viewType === 'grid') {
                    viewContainer.classList.remove('space-y-4');
                    viewContainer.classList.add('grid', 'md:grid-cols-2', 'gap-6');
                } else {
                    viewContainer.classList.remove('grid', 'md:grid-cols-2', 'gap-6');
                    viewContainer.classList.add('space-y-4');
                }
            }
        });
    });

    // 3. Confirm Delete (CRUD Security)
    const deleteForms = document.querySelectorAll('.btn-delete-confirm');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
                e.preventDefault();
            }
        });
    });

    window.submitDelete = function(url, action, id, idParamName = 'id') {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) return;

        const formData = new FormData();
        formData.append('action', action);
        formData.append(idParamName, id);

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            showToast('Élément supprimé avec succès', 'success');
            setTimeout(() => window.location.reload(), 1000);
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Erreur lors de la suppression', 'error');
        });
    };

    // 4. Modal/Drawer Mock Logic
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    });

    // Close modals
    const modalClosers = document.querySelectorAll('[data-modal-close]');
    modalClosers.forEach(closer => {
        closer.addEventListener('click', function() {
            const modal = this.closest('.modal-container');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });

    // 5. Toast System
    window.showToast = function(message, type = 'success') {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-600' : 'bg-red-600';
        toast.className = `fixed bottom-6 right-6 ${bgColor} text-white px-6 py-3 rounded-xl shadow-2xl z-[9999] flex items-center gap-3 animate-in fade-in slide-in-from-bottom-5 duration-300`;
        toast.innerHTML = `
            <span class="material-symbols-outlined text-[18px]">${type === 'success' ? 'check_circle' : 'error'}</span>
            <span class="text-sm font-bold">${message}</span>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('animate-out', 'fade-out', 'slide-out-to-bottom-5');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // Global Search Highlight & Redirect
    const searchInput = document.getElementById('global-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            const items = document.querySelectorAll('.searchable-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(term)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });

        // Add Enter key redirect for global search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const term = this.value.trim();
                if (term) {
                    window.location.href = `/kara_project/backend/repertoire_etudiants_backend.php?recherche=${encodeURIComponent(term)}`;
                }
            }
        });
    }
});
