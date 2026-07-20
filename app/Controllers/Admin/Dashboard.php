<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CompteModel;
use App\Models\TransactionModel;
use Config\Database;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = Database::connect();

        $gainParType = $db->query(
            "SELECT 
                type_operation, 
                COUNT(*) AS nb, 
                SUM(montant) AS total_montant, 
                SUM(frais) AS total_frais,
                SUM(CASE WHEN id_operateur_dest IS NULL THEN frais ELSE (frais - commission) END) AS gain_interne,
                SUM(commission) AS gain_externe
             FROM transactions 
             GROUP BY type_operation"
        )->getResultArray();

        return view('admin/dashboard', [
            'comptes'     => (new CompteModel())->orderBy('solde','DESC')->findAll(),
            'gainTotal'   => (new TransactionModel())->gainTotal(),
            'gainParType' => $gainParType,
            'masseTotale' => $db->query("SELECT SUM(solde) AS t FROM compte_client")->getRowArray()['t'] ?? 0,
        ]);
    }
}