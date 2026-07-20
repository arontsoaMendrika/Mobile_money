
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

CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(20) NOT NULL, -- 'depot', 'retrait' ou 'transfert'
    expediteur VARCHAR(15),              -- NULL si c'est un dépôt
    destinataire VARCHAR(15),            -- NULL si c'est un retrait
    montant REAL NOT NULL,
    frais REAL NOT NULL DEFAULT 0.0,
    id_operateur_dest INTEGER REFERENCES operateur(id), -- opérateur du destinataire (transferts)
    commission REAL NOT NULL DEFAULT 0.0,               -- commission reversée à l'opérateur externe
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(50) NOT NULL,
    est_interne INTEGER NOT NULL DEFAULT 0,
    commission_pct REAL NOT NULL DEFAULT 0
);

CREATE TABLE prefixe (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    valeur VARCHAR(5) NOT NULL UNIQUE,
    id_operateur INTEGER NOT NULL REFERENCES operateur(id)
);

INSERT INTO operateur (nom, est_interne, commission_pct) VALUES
 ('MonOperateur', 1, 0), ('Orange', 0, 2.0), ('Airtel', 0, 1.5);

INSERT INTO prefixe (valeur, id_operateur) VALUES
 ('033',1),('037',1),('032',2),('034',2),('031',3),('038',3);