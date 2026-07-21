<?php
namespace App\Models;
use CodeIgniter\Model;

class PromotionModel extends Model{
    protected $table = 'promotion';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields=['valeur'];

    public function getPromotion(float $valeur){
         $row = $this->where('valeur', $valeur)
                    ->first();

        return $row ? (float) $row['valeur'] : 0.0;
    }
}