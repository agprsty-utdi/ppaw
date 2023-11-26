<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pegawai_id',
        'tahun',
        'bulan',
        'gaji_pokok',
        'tunjangan',
        'potongan'
    ];

    //relasi ke tabel Pegawai
    public function getPegawai()
    {
        return $this->belongsTo('\App\Models\Pegawai','pegawai_id');
    }
}
