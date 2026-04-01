#!/bin/bash
# Vérification de la syntaxe de tous les fichiers PHP

echo "╔═════════════════════════════════════════╗"
echo "║  VÉRIFICATION DE SYNTAXE PHP             ║"
echo "╚═════════════════════════════════════════╝"
echo ""

# Fichiers critiques à vérifier
files=(
    "config/config.php"
    "index.php"
    "backend/repertoire_etudiants_backend.php"
    "backend/classes/DataManager.php"
    "diagnostic.php"
    "test_queries.php"
    "auto_fix.php"
)

errors=0

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        # Utiliser php pour checker la syntaxe
        if php -l "$file" 2>&1 | grep -q "No syntax errors"; then
            echo "✓ $file"
        else
            echo "✗ $file"
            php -l "$file"
            errors=$((errors + 1))
        fi
    else
        echo "? $file (fichier non trouvé)"
    fi
done

echo ""
echo "─────────────────────────────────────────"
if [ $errors -eq 0 ]; then
    echo "✓ Tous les fichiers sont corrects"
else
    echo "✗ $errors fichier(s) avec erreur(s)"
fi
