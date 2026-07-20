<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Rapport extends BaseController
{
    public function reversements()
    {
        $db = \Config\Database::connect();

        $lignes = $db->query(
            "SELECT o.id, o.nom, o.commission_pct,
                    COUNT(t.id) AS nb_transferts,
                    COALESCE(SUM(t.montant), 0)    AS a_reverser,
                    COALESCE(SUM(t.frais), 0)      AS frais_percus,
                    COALESCE(SUM(t.commission), 0) AS commissions_percues
             FROM operateur o
             LEFT JOIN transactions t
                    ON t.id_operateur_dest = o.id AND t.type_operation = 'transfert'
             WHERE o.est_interne = 0
             GROUP BY o.id
             ORDER BY a_reverser DESC"
        )->getResultArray();

        $detail = $db->query(
            "SELECT t.*, o.nom AS operateur
             FROM transactions t
             JOIN operateur o ON o.id = t.id_operateur_dest
             WHERE o.est_interne = 0 AND t.type_operation = 'transfert'
             ORDER BY t.date_creation DESC LIMIT 50"
        )->getResultArray();

        return view('admin/reversements', [
            'lignes'    => $lignes,
            'detail'    => $detail,
            'totalDu'   => array_sum(array_column($lignes, 'a_reverser')),
            'totalComm' => array_sum(array_column($lignes, 'commissions_percues')),
        ]);
    }
}