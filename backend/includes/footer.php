        </div>
    </main>

    <script>
    // Global search functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add active page highlighting
        const links = document.querySelectorAll('.sidebar-link');
        links.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('bg-white', 'text-[#1A56DB]', 'font-semibold', 'shadow-sm');
                link.classList.remove('text-slate-600', 'hover:text-[#1A56DB]', 'hover:bg-[#f2f4f6]', 'font-medium');
            }
        });
    });

    // Photo preview function for student registration
    function previewPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photo-preview');
                const icon = document.getElementById('photo-icon');
                const text = document.getElementById('photo-text');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                icon.classList.add('hidden');
                text.textContent = file.name;
            }
            reader.readAsDataURL(file);
        }
    }

    // Download Maquette PDF
    function downloadMaquettePDF() {
        const currentUrl = window.location.href;
        const urlParams = new URLSearchParams(currentUrl.split('?')[1]);
        const filiere = urlParams.get('filiere') || urlParams.get('id_filiere') || '';
        const semestre = urlParams.get('semestre') || '1';
        
        // Redirect to PDF generation endpoint
        window.location.href = '<?= $base_url ?>backend/rapport_pdf_backend.php?type=maquette&filiere=' + filiere + '&semestre=' + semestre;
    }
    </script>
    <script src="<?= $base_url ?>assets/js/app.js"></script>
</body>
</html>
