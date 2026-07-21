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

    $inclureFrais = $this->request->getPost('inclure_frais') === '1';

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
    $baremeModel = new BaremeModel();

    $operateurInitialId = null;
    $estInterne = false;

  
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
       
            $estInterne = isset($operateurDest['est_interne']) && $operateurDest['est_interne'] == 1;
        } elseif ($operateurInitialId !== $currentOperateurId) {
            return redirect()->back()->with('error', 'Tous les destinataires doivent appartenir au même opérateur.');
        }
    }


    $fraisRetraitParPersonne = 0;
    if ($inclureFrais) {
        if ($estInterne) {
            $fraisTotal= $baremeModel->calculerFrais('retrait', $montantParPersonne);
            $reductionFrais= $promotionModel->getPromotion('valeur');
            $fraisRetraitParPersonne = $fraisTotal - $reductionFrais;
        } else {
            return redirect()->back()->with('error', 'L\'inclusion des frais n\'est pas disponible pour les autres opérateurs.');
        }
    }

   
    $totalADebiter = $montantTotal + ($fraisRetraitParPersonne * $nbDestinataires);

    $compteExpediteur = $compteModel->findByNumero($numero);
    if($compteExpediteur['solde'] < $totalADebiter){
        return redirect()->back()->with('error', 'Solde insuffisant pour effectuer l\'envoi (Montant + Frais requis).');
    }


    $db = Database::connect();
    $db->transStart();

    foreach ($destinataires as $dest) {
        $operateurDest = $operateurModel->findByNumero($dest);
        $commission = $operateurModel->commission($dest, $montantParPersonne);

       
        $compteModel->debiter($numero, $montantParPersonne + $fraisRetraitParPersonne);
        
            if ($epargnemodel->verify($id_compte_client)==true) {
                 $compteModel->crediter($dest, $montantParPersonne-($epargnemodel->getPourcentage($id_compte_client)));
            }else{
                 $compteModel->crediter($dest, $montantParPersonne);
            }
       
        
        $transactionModel->insert([
            'type_operation'    => 'transfert',
            'expediteur'        => $numero,
            'destinataire'      => $dest,
            'montant'           => $montantParPersonne,
            'frais'             => $fraisRetraitParPersonne, 
            'id_operateur_dest' => $operateurDest['id'] ?? null,
            'commission'        => $commission,
        ]);
    }

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Erreur lors de l\'envoi multiple.');
    }

    $msgSuccess = 'Envoi multiple réussi ! ';
    if ($inclureFrais) {
        $msgSuccess .= 'Les frais de retrait ont été pris en charge.';
    }

    return redirect()->to('dashboard')->with('message', $msgSuccess);
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
public function epargner(){
    $numero = session('numero');
     $compteModel = new CompteModel();
    $id_compte_client = $compteModel->findByNumero($numero);
    if ($this->request->getPost('epargne_pct')) {
        $pourcentage=$this->request->getPost('epargne_pct');
       $epargner = new EpargnerModel()->epargner($pourcentage, $id_compte_client );
    }
    return view('clients/epargne');
}
}