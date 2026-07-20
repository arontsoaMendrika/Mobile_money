<?php
namespace App\Models;
use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixe';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields=['valeur', 'id_operateur'];
}
