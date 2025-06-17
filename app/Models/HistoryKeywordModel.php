<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryKeywordModel extends Model
{
    protected $table = 'history_keywords'; // Assuming the table name is 'history_keywords'
    protected $primaryKey = 'id'; // Assuming primary key is 'id'
    protected $allowedFields = [
        'keyword',
        'created_at',
        'updated_at',
    ]; // Adjust fields as needed

    // Enable timestamps if your table has created_at and updated_at fields
    protected $useTimestamps = true;
}
