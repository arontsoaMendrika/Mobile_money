<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session('numero')) {
            return redirect()->to('dashboard');
        }

        return view('clients/login');
    }

    public function login()
    {
        $numero = $this->request->getPost('numero');
        if (!$numero) {
            return redirect()->back()->with('error', 'Numéro de téléphone requis.');
        }

        $model = new CompteModel();
        $client = $model->findByNumero($numero);

        if (!$client) {
            $model->insert(['numero_telephone' => $numero, 'solde' => 0.0]);
            $client = $model->findByNumero($numero);
        }

        session()->set('numero', $client['numero_telephone']);

        return redirect()->to('dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
