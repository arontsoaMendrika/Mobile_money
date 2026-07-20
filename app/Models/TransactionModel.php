<?php
namespace App\Models;
use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation','expediteur','destinataire','montant','frais'];
    protected $returnType = 'array';

    public function historique(string $numero)
    {
        return $this->groupStart()
                        ->where('expediteur', $numero)
                        ->orWhere('destinataire', $numero)
                    ->groupEnd()
                    ->orderBy('date_creation', 'DESC')
                    ->findAll();
    }

    public function gainTotal(): float
    {
        $r = $this->selectSum('frais', 'total')->first();
        return (float) ($r['total'] ?? 0);
    }
}