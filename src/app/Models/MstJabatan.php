<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstJabatan extends Model
{
    use HasFactory;

    protected $table = 'mst_jabatans';
    protected $primaryKey = 'id';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_jabatan',
        'tunjangan',
    ];
}
