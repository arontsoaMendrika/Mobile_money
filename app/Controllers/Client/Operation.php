<?php
namespace App\Controllers\Client;
use App\Controllers\BaseController;
use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\BaremeModel;
use Config\Database;

class Operation extends BaseController
{
    public function dashboard()
    {
        $numero = session('numero');
        if (!$numero) return redirect()->to('/');

        return view('client/dashboard', [
            'compte'     => (new CompteModel())->findByNumero($numero),
            'historique' => (new TransactionModel())->historique($numero),
            'numero'     => $numero,
        ]);
    }
  

public function retraitForm()
{
    $numero = session('numero');
    if (!$numero) return redirect()->to('/');

    return view('client/retrait', [
        'compte'  => (new CompteModel())->findByNumero($numero),
        'baremes' => (new BaremeModel())->where('type_operation','retrait')->findAll(),
    ]);
}

public function retrait()
{
    $numero = session('numero');
    if (!$numero) return redirect()->to('/');

    $montant = (float) $this->request->getPost('montant');
    if ($montant <= 0) {
        return redirect()->back()->with('error', 'Montant invalide.');
    }

    $compteModel = new CompteModel();
    $compte = $compteModel->findByNumero($numero);

    $frais = (new BaremeModel())->calculerFrais('retrait', $montant);
    $total = $montant + $frais;

    if ($compte['solde'] < $total) {
        return redirect()->back()->with('error',
            'Solde insuffisant. Requis : ' . number_format($total, 0, ',', ' ') . ' Ar (dont ' . $frais . ' Ar de frais).');
    }

    $db = Database::connect();
    $db->transStart();

    $compteModel->debiter($numero, $total);
    (new TransactionModel())->insert([
        'type_operation' => 'retrait',
        'expediteur'     => $numero,
        'destinataire'   => null,
        'montant'        => $montant,
        'frais'          => $frais,
    ]);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Erreur lors du retrait.');
    }

    return redirect()->to('dashboard')->with('message',
        'Retrait de ' . number_format($montant, 0, ',', ' ') . ' Ar effectué (frais : ' . $frais . ' Ar).');
}

public function depot()
{
    $numero = session('numero');
    if (!$numero) return redirect()->to('/');   
    
    $montant = (float) $this->request->getPost('montant');

    if($montant <= 0){
        return redirect()->back()->with('error', 'Montant invalide.');
    }

    $compteModel = new CompteModel();
    $compteModel->crediter($numero, $montant);
    (new TransactionModel())->insert([
        'type_operation' => 'depot',
        'expediteur'     => $numero,
        'destinataire'   => null,
        'montant'        => $montant,
        'frais'          => 0,
    ]);

    return redirect()->to('dashboard')->with('message',
        'Dépôt de ' . number_format($montant, 0, ',', ' ') . ' Ar effectué.');
}
}