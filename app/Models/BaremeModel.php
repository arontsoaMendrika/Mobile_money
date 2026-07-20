<?php
namespace App\Models;
use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table = 'bareme_frais';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type_operation', 'montant_min', 'montant_max', 'frais'];
    protected $returnType = 'array';

    public function calculerFrais(string $type, float $montant): float
    {
        $row = $this->where('type_operation', $type)
                    ->where('montant_min <=', $montant)
                    ->groupStart()
                        ->where('montant_max >=', $montant)
                        ->orWhere('montant_max IS NULL')
                    ->groupEnd()
                    ->first();

        return $row ? (float) $row['frais'] : 0.0;
    }
}