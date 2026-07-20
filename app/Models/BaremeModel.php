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
public function resoudreFraisInclus(string $type, float $total, float $pct = 0): array
{
    $montant = $total;
    $frais = 0; $comm = 0;

    for ($i = 0; $i < 10; $i++) {
        $frais   = $this->calculerFrais($type, $montant);
        $comm    = round($montant * $pct / 100);
        $nouveau = $total - $frais - $comm;
        if (abs($nouveau - $montant) < 1) break;
        $montant = $nouveau;
    }

    return [
        'montant'    => round($montant),
        'frais'      => $frais,
        'commission' => $comm,
        'debit'      => round($montant) + $frais + $comm,
    ];
}
}