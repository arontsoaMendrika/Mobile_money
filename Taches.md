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

---

## Version 2 : Évolution Inter-Opérateurs et Options Avancées (Livraison v2)

### Côté Opérateur
- [ ] Configuration des préfixes valables pour les autres opérateurs (ex: 032 et 031, ...) - **Mandresy**
  - [ ] Modifier la table `configuration` (ou créer une table `operateurs`) pour lister les préfixes concurrents.
  - [ ] Mettre à jour la vue et le contrôleur `Admin\Config` pour saisir ces préfixes.
- [ ] Configuration du pourcentage (%) en plus de commissions pour les transferts vers les autres opérateurs - **Mendrika**
  - [ ] Ajouter un champ `frais_inter_operateur` dans la configuration.
  - [ ] Intégrer ce pourcentage dans la logique de calcul des frais de transfert.
- [ ] Sur la page "Situation gain via les différents frais", séparer opérateur et autres opérateurs - **Mendrika**
  - [ ] Modifier la requête SQL de l'historique pour filtrer les gains par type d'opérateur.
  - [ ] Mettre à jour l'affichage avec deux colonnes ou tableaux distincts.
- [ ] Situation des montants à envoyer à chaque opérateur - **Mandresy**
  - [ ] Créer un tableau récapitulatif calculant la somme des transferts sortants par préfixe.

### Côté Client
- [ ] Option inclure frais de retrait lors de l'envoi - **Mandresy**
  - [ ] Ajouter une case à cocher dans la vue du formulaire de transfert.
  - [ ] Modifier le contrôleur pour calculer et soustraire les frais du montant reçu si cochée.
- [ ] Envoi multiple vers plusieurs numéros (divisé le montant pour chaque numéro) - **Mendrika**
  - [ ] Adapter le champ numéro pour accepter une liste (ex: séparée par des virgules).
  - [ ] Diviser le montant total par le nombre de numéros valides et exécuter une boucle de transfert.