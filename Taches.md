# Examen Projet Final - S4 Info et Design (Juillet 2026)

## Binôme :
- Mendrika [ETU004081]
- Mandresy [ETU004342]

## Technologie utilisée :
- PHP avec CodeIgniter 4
- SQLite embarqué
- HTML / CSS / JS (Bootstrap)

---

##  Version 1 : Système Mobile Money (Livraison v1)

###  Architecture & Base de données
- [x] Création du script `base.sql` (Tables : configuration, comptes, baremes, transactions) - **Mendrika**
- [x] Configuration de la base SQLite dans CodeIgniter 4 (`Database.php`) - **Mendrika**
- [x] Création des Modèles CI4 (`CompteModel`, `TransactionModel`, `BaremeModel`) - **Mandresy**

###  Côté Client
- [x] Interface et Route de connexion par numéro de téléphone - **Mandresy**
- [x] Système de Login automatique (création de compte si inexistant) en Contrôleur - **Mendrika**
- [x] Interface du tableau de bord client (Affichage solde et historique) - **Mandresy**
- [x] Fonctionnalité de Dépôt (sans frais) - **Mendrika**
- [x] Fonctionnalité de Retrait (avec application du barème de frais) - **Mandresy**
- [x] Fonctionnalité de Transfert (vérification solde + destinataire + frais) - **Mendrika**

###  Côté Opérateur
- [x] Interface du tableau de bord Opérateur (Situation des comptes) - **Mandresy**
- [x] Calcul et affichage du gain total via les frais perçus - **Mendrika**
- [x] Configuration des préfixes valides et gestion des barèmes de frais - **Mandresy**