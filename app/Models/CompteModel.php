<?php
namespace App\Models;
use CodeIgniter\Model;

class CompteModel extends Model
{
    protected $table = 'compte_client';
    protected $primaryKey = 'id';
    protected $allowedFields = ['numero_telephone', 'solde'];
    protected $returnType = 'array';

    public function findByNumero(string $numero)
    {
        return $this->where('numero_telephone', $numero)->first();
    }

    public function crediter(string $numero, float $montant)
    {
        return $this->db->query(
            "UPDATE compte_client SET solde = solde + ? WHERE numero_telephone = ?",
            [$montant, $numero]
        );
    }

    public function debiter(string $numero, float $montant)
    {
        return $this->db->query(
            "UPDATE compte_client SET solde = solde - ? WHERE numero_telephone = ?",
            [$montant, $numero]
        );
    }
}