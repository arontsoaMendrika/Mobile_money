# Examen Projet Final - S4 Info et Design (Juillet 2026)

## Binôme :
- Mendrika [ETU004081]
- Mandresy [ETU004342]

## Technologie utilisée :
- PHP avec CodeIgniter 4
- SQLite embarqué
- HTML / CSS / JS (Bootstrap)

---

## Version 1 : Système Mobile Money (Livraison v1)

### Architecture & Base de données
- [x] Création du script base.sql (Tables : configuration, comptes, baremes, transactions) - Mendrika
- [x] Configuration de la base SQLite dans CodeIgniter 4 (Database.php) - Mendrika
- [x] Création des Modèles CI4 (CompteModel, TransactionModel, BaremeModel) - Mandresy

### Côté Client
- [x] Interface et Route de connexion par numéro de téléphone - Mandresy
- [x] Système de Login automatique (création de compte si inexistant) en Contrôleur - Mendrika
- [x] Interface du tableau de bord client (Affichage solde et historique) - Mandresy
- [x] Fonctionnalité de Dépôt (sans frais) - Mendrika
- [x] Fonctionnalité de Retrait (avec application du barème de frais) - Mandresy
- [x] Fonctionnalité de Transfert (vérification solde + destinataire + frais) - Mendrika

### Côté Opérateur
- [x] Interface du tableau de bord Opérateur (Situation des comptes) - Mandresy
- [x] Calcul et affichage du gain total via les frais perçus - Mendrika
- [x] Configuration des préfixes valides et gestion des barèmes de frais - Mandresy

---

## Version 2 : Évolution Inter-Opérateurs et Options Avancées (Livraison v2)

### Côté Opérateur (Gestion des commissions & préfixes)

#### Tâches de Mandresy :
- [x] Modélisation et création des nouvelles tables operateur et prefixe dans le script SQL.
- [x] Implémentation de la logique métier dans OperateurModel.php (findByNumero, estInterne, commission).
- [ ] Interface et situation des montants cumulés à envoyer à chaque opérateur tiers.

#### Tâches de Mendrika :
- [x] Création et configuration initiale du modèle PrefixeModel.php.
- [x] Mise à jour du contrôleur Config.php avec la méthode operateurs() pour charger les données des commissions.
- [ ] [EN COURS] Création de la méthode saveCommissions() dans le contrôleur Config.php pour sauvegarder les taux modifiés par l'administrateur.
- [ ] Conception de la vue d'administration admin/operateurs.php pour la mise à jour des commissions.
- [ ] Modification de la page "Situation gain" dans Dashboard.php pour séparer les gains internes et inter-opérateurs.

### Côté Client (Fonctionnalités avancées)

#### Tâches de Mandresy :
- [ ] Intégration de l'option de case à cocher "Inclure les frais de retrait" dans le formulaire de transfert.
- [ ] Adaptation du contrôleur de transfert pour calculer et déduire les frais du montant reçu.

#### Tâches de Mendrika :
- [ ] Modification de la vue du formulaire de transfert pour autoriser la saisie de numéros multiples séparés par des virgules.
- [ ] Développement de la logique d'envoi multiple (nettoyage de la chaîne, division équitable du montant et boucle de transactions).