<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStat extends Model
{
    use HasFactory;

    // Spécifiez la table
    protected $table = 'request_stats';

    // Indiquez les colonnes que vous souhaitez être remplissables
    protected $fillable = [
        'endpoint',
        'request_count',
    ];

    protected $primaryKey = 'id';
}
