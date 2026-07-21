<?php
namespace App\Models;
use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'compte_epargne';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_compte_client','pourcentage_epargne', 'solde'];
    protected $returnType = 'array';

    public function entrerPourcentage(int $id_compte_client,float $pct){
    return $this->db->query('INSERT INTO pourcentage_epargne(id_compte_client,pourcentage_epargne) VALUES (?)',[$id_compte_client,$pct]);
}
    public function epargner(int $id_compte_client,float $valeur){
    return $this->db->query('INSERT INTO compte_epargne(id_compte_client,solde) VALUES (?,?,?)',[$id_compte_client,$valeur]);
}
 public function getPourcentage(int $id_compte_client){
    return  $this->db->query('SELECT pourcentage_epargne FROM pourcentage_epargne WHERE id_compte_client = ?',[$id_compte_client]);
 }
  public function verify(int $id_compte_client){
    if(  $this->db->query('SELECT pourcentage_epargne FROM pourcentage_epargne WHERE id_compte_client = ?',[$id_compte_client])>0){
        return true;
    }else{
        return false;
    }
 }
}