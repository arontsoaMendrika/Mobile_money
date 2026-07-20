<?php
namespace App\Controllers\Client;
use App\Controllers\BaseController;
use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\BaremeModel;
use App\Models\OperateurModel;
use Config\Database;

class Operation extends BaseController
{
    public function dashboard()
    {
        $numero = session('numero');
        if (!$numero) return redirect()->to('/');

        return view('clients/dashboard', [
            'compte'     => (new CompteModel())->findByNumero($numero),
            'historique' => (new TransactionModel())->historique($numero),
            'numero'     => $numero,
        ]);
    }
  

public function retraitForm()
{
    $numero = session('numero');
    if (!$numero) return redirect()->to('/');

    return view('clients/retrait', [
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

public function transfert()
{
    $numero = session('numero');
    if (!$numero) return redirect()->to('/');   

    $destinataireInput = $this->request->getPost('destinataire');
    $montantTotal = (float) $this->request->getPost('montant');

    if($montantTotal <= 0){
        return redirect()->back()->with('error', 'Montant invalide.');
    }


    $destinataires = array_filter(array_map('trim', explode(',', $destinataireInput)));
    $nbDestinataires = count($destinataires);

    if ($nbDestinataires === 0) {
        return redirect()->back()->with('error', 'Veuillez saisir au moins un destinataire.');
    }

    
    $montantParPersonne = $montantTotal / $nbDestinataires;

    $compteModel = new CompteModel();
    $operateurModel = new OperateurModel();
    $transactionModel = new TransactionModel();

   
    $operateurInitialId = null;
    foreach ($destinataires as $dest) {
        if($dest === $numero){
            return redirect()->back()->with('error', 'Vous ne pouvez pas inclure votre propre numéro.');
        }

        $compteDestinataire = $compteModel->findByNumero($dest);
        if(!$compteDestinataire){
            return redirect()->back()->with('error', "Le destinataire {$dest} n'existe pas.");
        }

       
        $operateurDest = $operateurModel->findByNumero($dest);
        $currentOperateurId = $operateurDest['id'] ?? null;
        
        if ($operateurInitialId === null) {
            $operateurInitialId = $currentOperateurId;
        } elseif ($operateurInitialId !== $currentOperateurId) {
            return redirect()->back()->with('error', 'Tous les destinataires doivent appartenir au même opérateur.');
        }
    }

    $compteExpediteur = $compteModel->findByNumero($numero);
    if($compteExpediteur['solde'] < $montantTotal){
        return redirect()->back()->with('error', 'Solde insuffisant pour effectuer l\'envoi multiple.');
    }


    $db = Database::connect();
    $db->transStart();

    foreach ($destinataires as $dest) {
        $operateurDest = $operateurModel->findByNumero($dest);
        $commission = $operateurModel->commission($dest, $montantParPersonne);

        $compteModel->debiter($numero, $montantParPersonne);
        $compteModel->crediter($dest, $montantParPersonne);
        
        $transactionModel->insert([
            'type_operation'    => 'transfert',
            'expediteur'        => $numero,
            'destinataire'      => $dest,
            'montant'           => $montantParPersonne,
            'frais'             => 0, 
            'id_operateur_dest' => $operateurDest['id'] ?? null,
            'commission'        => $commission,
        ]);
    }

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Erreur lors de l\'envoi multiple.');
    }

    return redirect()->to('dashboard')->with('message', 
        'Envoi multiple de ' . number_format($montantTotal, 0, ',', ' ') . ' Ar réussi vers ' . $nbDestinataires . ' destinataire(s) !');
}


public function formulaireTransfert()
{
    
    $numero = session('numero');
    if (!$numero) return redirect()->to('/');   

 
    $compteModel = new CompteModel();
    $data['compte'] = $compteModel->findByNumero($numero);


    return view('clients/transfert', $data);
}

public function formulaireDepot()
{
   
    $numero = session('numero');
    if (!$numero) return redirect()->to('/');   

  
    $compteModel = new CompteModel();
    $data['compte'] = $compteModel->findByNumero($numero);


    return view('clients/depot', $data);
}

}