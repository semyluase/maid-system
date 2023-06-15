<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'document_workers';
    protected $guarded = ['id'];

    public function scopeGetData($query)
    {
        $query->select('*')
            ->fromRaw("(SELECT a.* FROM maids a
            LEFT JOIN document_workers b
            ON a.id = b.maid_id
            WHERE a.code_maid <> ''
            AND LENGTH(a.code_maid) > 3
            AND (b.location_file IS NULL)) tb");
    }
}
