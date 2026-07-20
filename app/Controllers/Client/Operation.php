<?php
namespace App\Controllers\Client;
use App\Controllers\BaseController;
use App\Models\CompteModel;
use App\Models\TransactionModel;

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
}