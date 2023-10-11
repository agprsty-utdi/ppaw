<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstPangkat extends Model
{
    use HasFactory;

    protected $table = 'mst_pangkats';
    protected $primaryKey = 'id';
    protected $perPage = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_pangkat',
        'pangkat_gol',
    ];
}
