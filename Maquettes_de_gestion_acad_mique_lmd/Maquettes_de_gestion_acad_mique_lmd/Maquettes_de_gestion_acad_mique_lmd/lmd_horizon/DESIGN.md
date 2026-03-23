```markdown
# Principes d'Excellence : Le Design System Académique

Ce document définit les standards visuels et interactifs pour notre plateforme de gestion LMD. Notre objectif est de transcender l'aspect utilitaire des logiciels de gestion pour offrir une expérience **éditoriale, rigoureuse et statutaire**.

## 1. Vision Créative : "L'Autorité Translucide"

Le "Creative North Star" de ce système est l'équilibre entre la **rigueur institutionnelle** et la **clarté moderne**. Contrairement aux interfaces administratives classiques qui s'appuient sur des grilles rigides et des bordures omniprésentes, nous adoptons une approche de **hiérarchie tonale**. 

L'interface doit évoquer la précision d'une publication scientifique de haut rang : de grands espaces blancs, une typographie chirurgicale et une profondeur subtile créée par la superposition de couches de "papier numérique".

---

## 2. Palette Chromatique & Système de Surfaces

L'utilisation de la couleur doit être fonctionnelle. Le bleu (`primary`) n'est pas un simple décor, c'est un signal d'autorité et d'action.

### La Règle du "No-Line"
**Il est formellement interdit d'utiliser des bordures de 1px pour séparer les sections.** La structure doit être définie exclusivement par des changements de tons de fond.
- Utilisez `surface` (#f7f9fb) pour le fond de page global.
- Utilisez `surface-container-low` (#f2f4f6) pour délimiter des zones de contenu secondaires.
- Utilisez `surface-container-lowest` (#ffffff) pour les cartes de données principales.

### Hiérarchie des Surfaces & Imbrication
Le design repose sur un empilement de couches. Un élément "imbriqué" doit toujours être visuellement distinct par sa nuance :
1. **Niveau 0 (Fond) :** `surface`
2. **Niveau 1 (Conteneur) :** `surface-container-low`
3. **Niveau 2 (Carte de donnée) :** `surface-container-lowest` (Blanc pur)

### Effet "Glassmorphism"
Pour les éléments flottants (menus contextuels, modales, tooltips), utilisez une semi-transparence de `surface-container-highest` avec un `backdrop-blur` de 12px. Cela permet de garder un lien visuel avec les données sous-jacentes tout en affirmant la priorité de l'action en cours.

---

## 3. Typographie Éditoriale

Nous utilisons **Inter** pour sa neutralité technique et sa lisibilité exceptionnelle dans les tableaux denses.

- **Display (L/M/S) :** Réservé aux indicateurs de performance clés (ex: Moyenne Générale). Utilise un `letter-spacing` serré (-0.02em).
- **Headline & Title :** Pour les titres de modules. Le passage de `headline-lg` à `title-sm` doit marquer une rupture nette pour guider l'œil sans ambiguïté.
- **Body & Label :** Le cœur du système LMD. Pour les tableaux de notes, privilégiez `body-sm` (0.75rem) avec un `line-height` généreux pour compenser la densité des chiffres.

---

## 4. Élévation et Profondeur Tonale

L'ombre portée est un aveu de faiblesse structurelle. Préférez la **Superposition Tonale**.

- **Shadows Ambiantes :** Si un élément doit absolument "flotter", utilisez une ombre ultra-diffuse : `0 12px 32px rgba(25, 28, 30, 0.04)`. La couleur de l'ombre doit être teintée par `on-surface`.
- **Ghost Border :** Si l'accessibilité exige une séparation visuelle (ex: champs de saisie), utilisez `outline-variant` à **20% d'opacité**. Ne jamais utiliser d'aplats de gris opaques.
- **Texture Signature :** Pour les boutons principaux, appliquez un léger gradient linéaire allant de `primary` (#003fb1) vers `primary-container` (#1a56db) pour donner du volume sans charger l'interface.

---

## 5. Composants Clés

### Tableaux de Données (Data Grids)
- **Zéro Ligne :** Supprimez les filets horizontaux et verticaux. Utilisez une alternance de fond `surface-container-low` au survol de la ligne (hover).
- **Densité Spatiale :** Utilisez `spacing-2` (0.4rem) pour le padding vertical des cellules pour maximiser l'affichage des notes, mais gardez `spacing-4` (0.9rem) en horizontal pour la respiration.

### Formulaires de Saisie de Notes
- **Focus Statutaire :** Lors de la saisie, le champ doit passer d'un fond `surface-container-highest` à un fond `surface-container-lowest` avec une "Ghost Border" `primary`.
- **Micro-interactions :** La validation d'une note doit déclencher un changement fugace de la couleur de fond du champ vers `primary-fixed-dim` pour confirmer l'enregistrement.

### Badges de Statut (LMD)
Les badges ne doivent pas être des blocs de couleur pleine (trop "lourds").
- **Validé :** Fond `secondary-container`, Texte `on-secondary-container`. Arrondi `full`.
- **Rattrapage :** Fond `tertiary-container`, Texte `on-tertiary-container`. 
- **Style :** Pas de bordure, police `label-sm` en majuscules avec un espacement de 0.05em.

### Graphiques de Performance
- Utilisez la palette `primary` et `secondary` pour les courbes.
- Les zones de seuil (ex: limite de compensation) doivent être marquées par un plan `surface-variant` subtil plutôt qu'une ligne rouge agressive.

---

## 6. Do's and Don'ts

| **À Faire (Do)** | **À Proscrire (Don't)** |
| :--- | :--- |
| Utiliser le vide (`spacing-12`) pour séparer les grands blocs logiques. | Utiliser des lignes de séparation (dividers) HR. |
| Créer de l'asymétrie : un menu latéral étroit contre un tableau large. | Centrer tout le contenu de manière monolithique. |
| Utiliser `surface-tint` pour les micro-indicateurs d'activité. | Utiliser des couleurs fluos ou non-référencées dans la palette. |
| Superposer une modale avec un `backdrop-blur`. | Utiliser un overlay noir opaque derrière les modales. |
| Aligner les données numériques à droite dans les tableaux. | Aligner les chiffres à gauche ou au centre. |

---

## 7. Spécifications Techniques des Primitives

- **Arrondis :** 
  - Cartes et grands conteneurs : `lg` (0.5rem).
  - Boutons et Inputs : `md` (0.375rem).
  - Badges : `full` (9999px).
- **Espacement :** Le rythme de base est de `0.2rem` (spacing-1). Toujours privilégier les multiples de 4 pour les marges externes (`spacing-4`, `spacing-8`, `spacing-12`).

Ce système de design est conçu pour durer. En respectant la hiérarchie des surfaces plutôt que la multiplication des lignes, nous créons un outil qui ne fatigue pas l'œil de l'utilisateur, même après plusieurs heures de saisie de notes.```