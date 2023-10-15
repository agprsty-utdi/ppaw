<?php

namespace App\Http\Controllers;

use App\Models\MstJabatan;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MstJabatanRequest;

class MstJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //variabel pecarian
        $search = request()->get('search');
        $p = MstJabatan::paginate();

        //menjalankan query builder
        $mstJabatan = DB::table('mst_jabatans')
            ->where('nama_jabatan','LIKE','%'.$search.'%')
            ->paginate($p->perPage());

        //memanggil view dan menyertakan hasil quey
        return view('mst-jabatan.index', compact('mstJabatan'))
            ->with('i', (request()->input('page', 1) - 1) * $p->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mstJabatan = new MstJabatan();
        return view('mst-jabatan.create', compact('mstJabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MstJabatanRequest $request)
    {
        //mulai transaksi
        DB::beginTransaction();
        try{
            //menyimpan ke tabel mst_jabatan
            $jabatan= new MstJabatan();
            $jabatan->nama_jabatan=$request->nama_jabatan;
            $jabatan->tunjangan=$request->tunjangan;
            $jabatan->save();
            //jika tidak ada kesalahan commit/simpan
            DB::commit();

            // mengembalikan tampilan ke view index (halaman sebelumnya)
            return redirect()->route('mst-jabatan.index')
            ->with('success', 'MstJabatan telah berhasil disimpan.');
        } catch (\Throwable $e) {
            //jika terjadi kesalahan batalkan semua
            DB::rollback();
            return redirect()->route('mst-jabatan.index')
            ->with('success', 'Penyimpanan dibatalkan semua, ada kesalahan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mstJabatan = MstJabatan::find($id);
        //menampikan ke view show
        return view('mst-jabatan.show', compact('mstJabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mstJabatan = MstJabatan::find($id);
        //menampikan 1 rekaman ke view edit
        return view('mst-jabatan.edit', compact('mstJabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MstJabatanRequest $request, string $id)
    {
        //mulai transaksi
        DB::beginTransaction();
        try{
            $jabatan= MstJabatan::find($id);
            $jabatan->nama_jabatan= $request->nama_jabatan;
            $jabatan->tunjangan= $request->tunjangan;
            $jabatan->save();
            DB::commit();
            //mengembalikan tampilan ke view index (halaman sebelumnya)
            return redirect()->route('mst-jabatan.index')
                ->with('success', 'MstJabatan berhasil diubah');
        } catch (\Throwable $e) {
            //jika terjadi kesalahan batalkan semua
            DB::rollback();
            return redirect()->route('mst-jabatan.index')
                ->with('success', 'MstJabatan batal diubah, ada kesalahan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //mulai transaksi
        DB::beginTransaction();
        try{
            //menghapus 1 rekaman tabel mst_jabatan
            MstJabatan::find($id)->delete();
            DB::commit();
            // mengembalikan tampilan ke view index (halaman sebelumnya)
            return redirect()->route('mst-jabatan.index')
                ->with('success', 'MstJabatan berhasil dihapus');
        } catch (\Throwable $e) {
            //jika terjadi kesalahan batalkan semua
            DB::rollback();
            return redirect()->route('mst-jabatan.index')
                ->with('success', 'MstJabatan ada kesalahan hapus batal.');
        }
    }
}
