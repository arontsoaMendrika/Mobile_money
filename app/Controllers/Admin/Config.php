<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\BaremeModel;
use Config\Database;

class Config extends BaseController
{
    public function prefixes()
    {
        $db = Database::connect();
        $row = $db->table('configuration')->where('cle','prefixes')->get()->getRowArray();
        return view('admin/prefixes', ['valeur' => $row['valeur'] ?? '']);
    }

    public function savePrefixes()
    {
        $valeur = $this->request->getPost('valeur');
        $db = Database::connect();
        $exists = $db->table('configuration')->where('cle','prefixes')->countAllResults();

        if ($exists) {
            $db->table('configuration')->where('cle','prefixes')->update(['valeur' => $valeur]);
        } else {
            $db->table('configuration')->insert(['cle' => 'prefixes', 'valeur' => $valeur]);
        }

        return redirect()->back()->with('message', 'Préfixes enregistrés.');
    }

    public function baremes()
    {
        return view('admin/baremes', [
            'retrait'   => (new BaremeModel())->where('type_operation','retrait')->orderBy('montant_min')->findAll(),
            'transfert' => (new BaremeModel())->where('type_operation','transfert')->orderBy('montant_min')->findAll(),
        ]);
    }

    public function addBareme()
    {
        (new BaremeModel())->insert([
            'type_operation' => $this->request->getPost('type_operation'),
            'montant_min'    => $this->request->getPost('montant_min'),
            'montant_max'    => $this->request->getPost('montant_max') ?: null,
            'frais'          => $this->request->getPost('frais'),
        ]);
        return redirect()->back()->with('message', 'Tranche ajoutée.');
    }

    public function deleteBareme($id)
    {
        (new BaremeModel())->delete($id);
        return redirect()->back()->with('message', 'Tranche supprimée.');
    }
}