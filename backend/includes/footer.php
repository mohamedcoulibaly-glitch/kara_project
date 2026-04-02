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
    </script>
    <script src="<?= $base_url ?>assets/js/app.js"></script>
</body>
</html>
