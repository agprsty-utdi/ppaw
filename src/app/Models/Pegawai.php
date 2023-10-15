<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawais';
    protected $primaryKey = 'id';
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'alamat',
        'tanggal_lahir',
        'jenis_kel',
        'agama',
        'telepon',
        'email',
        'file_foto',
    ];

    public function mstJabatan()
    {
        return $this->hasOne('App\Models\MstJabatan', 'id', 'mst_jabatan_id');
    }

    static function listAgama()
    {
        return array(
            1=>'Islam',
            2=>'Katholik',
            3=>'Protestan',
            4=>'Hindu',
            5=>'Budha',
            6=>'Konghucu'
        );
    }

    public function getAgama()
    {
        if ($this->agama=="1")
            return "Islam";
        elseif($this->agama=="2")
            return "Katholik";
        elseif($this->agama=="3")
            return "Protistan";
        elseif($this->agama=="4")
            return "Hindu";
        elseif($this->agama=="5")
            return "Budha";
        elseif($this->agama=="6")
            return "Konghucu";
        else
            return "Tidak diketahui";
    }

    public function getGapok($id)
    {
        $g = DB::table('riwayat_pangkat')
                ->where('pegawai_id',$id)
                ->where('status',1)->first();

        if ($g==null) //jika tidak ada
            return 0;
        else
            return $g->gaji_pokok;
    }

    public function getTunjangan($id)
    {
        $g = DB::table('mst_jabatan')->where('id',$id)->first();

        if ($g==null) //jika tidak ada
            return 0;
        else
            return $g->tunjangan;
    }
}
