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
- [ ] Création du script `base.sql` (Tables : configuration, comptes, baremes, transactions) - **Mendrika**
- [ ] Configuration de la base SQLite dans CodeIgniter 4 (`Database.php`) - **Mendrika**
- [ ] Création des Modèles CI4 (`CompteModel`, `TransactionModel`, `BaremeModel`) - **Mandresy**

###  Côté Client
- [ ] Interface et Route de connexion par numéro de téléphone - **Mandresy**
- [ ] Système de Login automatique (création de compte si inexistant) en Contrôleur - **Mendrika**
- [ ] Interface du tableau de bord client (Affichage solde et historique) - **Mandresy**
- [ ] Fonctionnalité de Dépôt (sans frais) - **Mendrika**
- [ ] Fonctionnalité de Retrait (avec application du barème de frais) - **Mandresy**
- [ ] Fonctionnalité de Transfert (vérification solde + destinataire + frais) - **Mendrika**

###  Côté Opérateur
- [ ] Interface du tableau de bord Opérateur (Situation des comptes) - **Mandresy**
- [ ] Calcul et affichage du gain total via les frais perçus - **Mendrika**
- [ ] Configuration des préfixes valides et gestion des barèmes de frais - **Mandresy**