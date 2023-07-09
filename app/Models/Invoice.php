<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id', 'id');
    }

    protected $guarded = ['id'];
}
