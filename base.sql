CREATE DATABASE mobile;
USE mobile;
CREATE TABLE configuration (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cle VARCHAR(50) NOT NULL UNIQUE,
    valeur TEXT NOT NULL
);

CREATE TABLE bareme_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(20) NOT NULL, -- 'retrait' ou 'transfert'
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL
);

CREATE TABLE compte_client (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    solde REAL NOT NULL DEFAULT 0.0
);

CREATE TABLE transaction (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(20) NOT NULL, -- 'depot', 'retrait' ou 'transfert'
    expediteur VARCHAR(15),              -- NULL si c'est un dépôt
    destinataire VARCHAR(15),            -- NULL si c'est un retrait
    montant REAL NOT NULL,
    frais REAL NOT NULL DEFAULT 0.0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);