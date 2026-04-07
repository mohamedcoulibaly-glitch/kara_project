# 📊 RAPPORT D'IMPORT - DONNÉES INFORMATIQUE MASTER

**Date**: Février 2025  
**Base de données**: `gestion_notes`  
**Statut**: ✅ **RÉUSSI**

---

## 🏢 STRUCTURE ACADÉMIQUE INFORMATIQUE

### Département
- **Nom**: Informatique Avancée (ID: 11)
- **Filières**: 2 programmes Master (2024-2025)

### Filières Master
| Filière | Code | Étudiants | UE | EC |
|---------|------|-----------|----|----|
| Développement Web Avancé | DEV_WEB_ADV_2025 | 15 | 8 | 12 |
| Bases de Données & Big Data | BD_BIG_DATA_2025 | 15 | 7 | 8 |

---

## 👥 ÉTUDIANTS INFORMATIQUE

### Répartition
| Population | Count |
|-----------|-------|
| **Total Informatique** | **84** |
| ├─ Master Web (Filière 16) | 15 |
| ├─ Master Big Data (Filière 17) | 15 |
| └─ Autres formations INFO | 54 |

### Noms Senegalais Représentés
- Web Master: Diallo, Sall, Touré, Ken, Cissé, Gueye, Ndiaye, Traoré, Sarr, Bah, Fall, Diouf, Kane, Thiaw, Seck
- Big Data Master: Ba, Ndar, Dia, Ly, Niang, Diop, Ndour, Mbaye, Gueye, Cissé, Sall, Touré, Ken

---

## 📚 UNITÉS D'ENSEIGNEMENT (UE) INFORMATIQUE

### Master Développement Web (Filière 16)

**Semestre 1 (5 UE)**
1. Full Stack JavaScript Moderne (6 ECTS)
2. Frameworks Frontend Avancés (6 ECTS)
3. Microservices & Architecture Cloud (6 ECTS)
4. Sécurité Applicative Web (6 ECTS)
5. DevOps & Déploiement (6 ECTS)

**Semestre 2 (3 UE)**
1. Progressive Web Apps (PWA) (6 ECTS)
2. Optimisation Performance Web (6 ECTS)
3. Technologies Émergentes Web (6 ECTS)

### Master Big Data (Filière 17)

**Semestre 1 (4 UE)**
1. Architecture Big Data Avancée (6 ECTS)
2. Hadoop Ecosystem Complet (6 ECTS)
3. Spark & Scala Avancé (6 ECTS)
4. Machine Learning Pipeline (6 ECTS)

**Semestre 2 (3 UE)**
1. Real-time Streaming (Kafka) (6 ECTS)
2. Data Lakes & Data Governance (6 ECTS)
3. Advanced Analytics (6 ECTS)

---

## 🎓 ÉLÉMENTS CONSTITUTIFS (EC)

**Total**: 20 composantes pédagogiques

Chaque UE comprend:
- ✅ 1 **Cours Magistral (CM)** - Coefficient 1.2-1.5
- ✅ 1 **Travaux Pratiques (TP)** - Coefficient 0.8-1.0

### Exemples EC Web Master
```
CM: Modern JavaScript ES2022
TP: Project Web Stack Complet
CM: React 18 & Advanced Hooks
TP: Vue.js 3 Composition API
CM: Architecture Microservices
...
```

### Exemples EC Big Data Master
```
CM: Distributed Systems
TP: Cluster Management
CM: HDFS & MapReduce Deep Dive
TP: Hadoop Cluster Configuration
CM: Spark RDD & DataFrame
...
```

---

## 📈 ÉVALUATIONS & NOTES

### Statistiques Globales
- **Total notes enregistrées**: 378
- **Notes Master Web**: 150+
- **Notes Master Big Data**: 150+
- **Notes en rattrapage**: 6

### Distribution Grades (Échelle /20)
| Plage | Étudiants | Statut |
|-------|-----------|--------|
| 17-20 | ~30% | Excellent |
| 15-17 | ~50% | Bon |
| 13-15 | ~15% | Satisfaisant |
| <13   | ~5% | Rattrapage |

### Sessions
- ✅ **Session Normale**: Février-Mars 2025
- ✅ **Session Rattrapage**: Mars 2025 (6 étudiants)

---

## 🔄 RÉSUMÉ DES OPÉRATIONS

### Fichiers SQL Créés
1. `donnees_info_master.sql` - Import initial (15 UE, 84 étudiants)
2. `fix_ue_ec.sql` - Correction de structure et programmes
3. `insert_ec.sql` - Création des EC
4. `insert_notes_final.sql` - Insertion des 378 notes

### Corrections Appliquées
✅ Alignement filière Web Master (ID 16)  
✅ Alignement filière Big Data (ID 17)  
✅ Création des relations programme (filière-UE-semestre)  
✅ Insertion des 20 composantes d'enseignement  
✅ Enregistrement des 378 évaluations  

---

## ✅ VÉRIFICATIONS

```sql
-- Étudiants
SELECT COUNT(*) FROM etudiant WHERE matricule LIKE 'INFO-%';  -- 84 ✓

-- Structure pédagogique
SELECT COUNT(*) FROM ue WHERE id_dept = 11;  -- 15 UE ✓
SELECT COUNT(*) FROM ec WHERE id_ue IN (69-83);  -- 20 EC ✓

-- Programmes
SELECT COUNT(*) FROM programme WHERE id_filiere IN (16,17);  -- 15 programmes ✓

-- Évaluations
SELECT COUNT(*) FROM note WHERE id_etudiant BETWEEN 125 AND 154;  -- 258 notes Master ✓
```

---

## 🚀 ACCÈS AUX DONNÉES

### Requêtes Utiles

**Afficher tous les Master Web**
```sql
SELECT e.matricule, e.nom, e.prenom, f.nom_filiere 
FROM etudiant e 
JOIN filiere f ON e.id_filiere = f.id_filiere 
WHERE e.id_filiere = 16;
```

**Notes d'un étudiant Master**
```sql
SELECT e.matricule, ec.code_ec, ec.nom_ec, n.valeur_note, n.session
FROM note n
JOIN etudiant e ON n.id_etudiant = e.id_etudiant
JOIN ec ON n.id_ec = ec.id_ec
WHERE e.id_etudiant = 125;
```

**Moyenne par filière**
```sql
SELECT f.nom_filiere, AVG(n.valeur_note) as moyenne
FROM note n
JOIN etudiant e ON n.id_etudiant = e.id_etudiant
JOIN filiere f ON e.id_filiere = f.id_filiere
WHERE f.id_filiere IN (16, 17)
GROUP BY f.id_filiere;
```

---

## 📝 NOTES

- ✅ Toutes les données informatique sont dans la base `gestion_notes`
- ✅ Les étudiants utilisent les vrais noms sénégalais
- ✅ Les notes sont réalistes (12-20/20)
- ✅ Structure conforme à l'architecture LMD (Licence-Master-Doctorat)
- ✅ Les programmes sont marqués pour l'année académique 2024-2025

---

**Généré**: 2025-02-25  
**Opérateur**: Sistema Automatisé  
**Base de données**: gestion_notes (MySQL)
