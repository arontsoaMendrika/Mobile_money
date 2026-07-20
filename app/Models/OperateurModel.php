<?php
namespace App\Models;
use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'est_interne', 'commission_pct'];
    protected $returnType = 'array';

    /** Retourne l'opérateur correspondant à un numéro, ou null si préfixe inconnu */
    public function findByNumero(string $numero): ?array
    {
        $numero = preg_replace('/\D/', '', $numero);

        $row = $this->db->table('prefixe p')
            ->select('o.*, p.valeur AS prefixe')
            ->join('operateur o', 'o.id = p.id_operateur')
            ->where("substr('{$numero}', 1, length(p.valeur)) = p.valeur", null, false)
            ->get()->getRowArray();

        return $row ?: null;
    }

    public function estInterne(string $numero): bool
    {
        $op = $this->findByNumero($numero);
        return $op && (int) $op['est_interne'] === 1;
    }

    /** Commission en Ariary pour un transfert vers ce numéro */
    public function commission(string $numero, float $montant): float
    {
        $op = $this->findByNumero($numero);
        if (!$op || (int) $op['est_interne'] === 1) return 0.0;
        return round($montant * (float) $op['commission_pct'] / 100);
    }

    public function withPrefixes(): array
    {
        $ops = $this->orderBy('est_interne', 'DESC')->findAll();
        foreach ($ops as &$o) {
            $o['prefixes'] = $this->db->table('prefixe')
                ->where('id_operateur', $o['id'])->orderBy('valeur')->get()->getResultArray();
        }
        return $ops;
    }
}