<?php

namespace App\Models;

use CodeIgniter\Model;

class KeywordModel extends Model
{
    protected $table = 'keywords'; // Assuming the table name is 'keywords'
    protected $primaryKey = 'id'; // Assuming primary key is 'id'
    protected $allowedFields = [
        'keyword',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ]; // Adjust fields as needed

    // Enable timestamps if your table has created_at and updated_at fields
    protected $useTimestamps = true;

    // You can add custom methods for keyword-related queries here
}
