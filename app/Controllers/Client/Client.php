<?php 
namespace App\Controllers\Client;
use App\Controllers\BaseController;
use App\Models\CompteModel;

class Client extends BaseController
{
    public function connexion()
    {
         $model = new CompteModel();
         $numero=$this->request->getPost('numero_telephone');
         $client=$model->findByNumero($numero);
         
         if($client == null){
            $model->insert([
                'numero_telephone' => $numero,
                'solde' => 0.0
            ]);
            $client = $model->findByNumero($numero);
         }

         session()->set('client_connecte',$client['numero_telephone']);

         return redirect()->to(base_url('client/dashboard'));
    }
   
} 