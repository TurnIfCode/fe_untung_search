<?php

namespace App\Models;

use CodeIgniter\Model;

class KeywordDetailModel extends Model
{
    protected $table = 'keyword_details';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'keyword_id',
        'title',
        'link',
        'description',
        'position',
        'image',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
