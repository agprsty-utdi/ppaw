<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun = request()->get('tahun');
        $bulan = request()->get('bulan');
        $g = Gaji::paginate();
        $gaji = DB::table('gajis')->orderBy('created_at', 'desc');

        if ($tahun &&  $tahun != 'all') {
            $gaji = $gaji->where('tahun', $tahun);
        }

        if ($bulan &&  $bulan != 'all') {
            $gaji = $gaji->where('bulan', $bulan);
        }

        $gaji = $gaji->paginate($g->perPage());

        //memanggil view dan menyertakan hasil quey
        return view('gaji.index', compact('gaji'))
            ->with('i', (request()->input('page', 1) - 1) * $g->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gaji.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tahun = $request->tahun;
        $bulan = $request->bulan;

        # Get all pegawai (id, mst_jabatan_id)
        $pegawais = Pegawai::pluck('mst_jabatan_id', 'id');
        foreach ($pegawais as $id => $mst_jabatan_id) {
            $gajiPokok = Pegawai::getGajiPokok($id);
            $tunjangan = Pegawai::getTunjangan($mst_jabatan_id);
            $hitungPotongan = (1.5 / 100) * ($gajiPokok + $tunjangan);

            $gaji = new Gaji;
            $gaji->tahun = $tahun;
            $gaji->bulan = $bulan;
            $gaji->pegawai_id = $id;
            $gaji->gaji_pokok = $gajiPokok;
            $gaji->tunjangan = $tunjangan;
            $gaji->potongan = (int)$hitungPotongan;
            $gaji->save();
        }

        return redirect()->back()->with('success', 'Data Gaji telah berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gaji = Gaji::find($id);
        //menampikan ke view show
        return view('gaji.show', compact('gaji'));
    }
}
