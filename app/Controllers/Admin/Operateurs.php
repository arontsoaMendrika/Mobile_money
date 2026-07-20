<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\OperateurModel;

class Operateurs extends BaseController
{
    public function index()
    {
        return view('admin/operateurs', ['operateurs' => (new OperateurModel())->withPrefixes()]);
    }

    public function addOperateur()
    {
        (new OperateurModel())->insert([
            'nom'            => $this->request->getPost('nom'),
            'est_interne'    => 0,
            'commission_pct' => (float) $this->request->getPost('commission_pct'),
        ]);
        return redirect()->back()->with('message', 'Opérateur ajouté.');
    }

    public function updateOperateur($id)
    {
        (new OperateurModel())->update($id, [
            'commission_pct' => (float) $this->request->getPost('commission_pct'),
        ]);
        return redirect()->back()->with('message', 'Commission mise à jour.');
    }

    public function addPrefixe()
    {
        $valeur = preg_replace('/\D/', '', $this->request->getPost('valeur'));
        $db = \Config\Database::connect();

        if ($db->table('prefixe')->where('valeur', $valeur)->countAllResults() > 0) {
            return redirect()->back()->with('error', "Le préfixe {$valeur} existe déjà.");
        }

        $db->table('prefixe')->insert([
            'valeur'       => $valeur,
            'id_operateur' => (int) $this->request->getPost('id_operateur'),
        ]);
        return redirect()->back()->with('message', 'Préfixe ajouté.');
    }

    public function deletePrefixe($id)
    {
        \Config\Database::connect()->table('prefixe')->delete(['id' => $id]);
        return redirect()->back()->with('message', 'Préfixe supprimé.');
    }

    public function updateOperateur($id)
    {
    $operateurModel = new OperateurModel();
    $taux = $this->request->getPost('commission_pct'); 

    $operateurModel->update($id, [
        'commission_pct' => $taux
    ]);

    return redirect()->back()->with('message', 'Commission mise à jour.');
    }
}