<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PegawaiRequest;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->get('search');
        $p = Pegawai::paginate(); //mangatur tampil perhalaman
        //menjalankan query builder
        $pegawai = DB::table('pegawais')
            ->join('mst_jabatans','pegawais.mst_jabatan_id','=','mst_jabatans.id')
            ->select('pegawais.id','pegawais.nama','pegawais.alamat',
            'mst_jabatans.nama_jabatan')
            ->where('pegawais.id','LIKE','%'.$search.'%')
            ->orwhere('pegawais.nama','LIKE','%'.$search.'%')
            ->orWhere('pegawais.alamat','LIKE', '%'.$search.'%')
            ->paginate($p->perPage());

        //memanggil view dan menyertakan hasil quey
        return view('pegawai.index', compact('pegawai'))
            ->with('i', (request()->input('page', 1) - 1) * $p->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatan = DB::table('mst_jabatans')->pluck('nama_jabatan','id');
        $pegawai = new Pegawai();
        return view('pegawai.create', compact('pegawai','jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRequest $request)
    {
        DB::beginTransaction();
        try{
            //menjalankan query builder untuk menyimpan ke tabel pegawai
            $file = $request->file('file_foto');
            $ext = $file->getClientOriginalExtension();
            $fileFoto = $request->id.".".$ext;
            //menyimpan ke folder /file
            $request->file('file_foto')->move("foto/", $fileFoto);
            DB::table('pegawais')->insert([
                'id'=>$request->id,
                'nama'=>$request->nama,
                'alamat'=>$request->alamat,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'jenis_kel'=>$request->jenis_kel,
                'agama'=>$request->agama,
                'telepon'=>$request->telepon,
                'email'=>$request->email,
                'file_foto'=>$fileFoto,
                'mst_jabatan_id'=>$request->mst_jabatan_id,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
            //jika tidak ada kesalahan commit/simpan
            DB::commit();
            // mengembalikan tampilan ke view index (halaman sebelumnya)
            return redirect()->route('pegawai.index')
                ->with('success', 'Pegawai telah berhasil disimpan.');
        } catch (\Throwable $e) {
            dd($e);
            //jika terjadi kesalahan batalkan semua
            DB::rollback();
            return redirect()->route('pegawai.index')
                ->with('success', 'Penyimpanan dibatalkan semua, ada kesalahan...');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::find($id);
        //menampikan ke view show
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::find($id);
        $jabatan = DB::table('mst_jabatans')->pluck('nama_jabatan','id');
        //menampikan 1 rekaman ke view edit
        return view('pegawai.edit', compact('pegawai','jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $pegawai = \App\Models\Pegawai::find($id);
            if ($request->hasFile('file_foto')){
                $image_path = "foto/".$pegawai->file_foto;
                if (File::exists($image_path)){
                    File::delete($image_path);
                }
                $file = $request->file('file_foto');
                $ext = $file->getClientOriginalExtension();
                $fileFoto = $id.".".$ext;
                $destinationPath = 'foto/';
                $file->move($destinationPath, $fileFoto);
            } else {
                $fileFoto = $pegawai->file_foto;
            }
            DB::table('pegawais')->where('id',$id)->update([
                'nama'=>$request->nama,
                'alamat'=>$request->alamat,
                'jenis_kel'=>$request->jenis_kel,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'agama'=>$request->agama,
                'telepon'=>$request->telepon,
                'email'=>$request->email,
                'file_foto'=> $fileFoto,
                'mst_jabatan_id'=>$request->mst_jabatan_id,
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
            DB::commit();
            //mengembalikan tampilan ke view index (halaman sebelumnya)
            return redirect()->route('pegawai.index')
                ->with('success', 'Pegawai berhasil diubah');
        } catch (\Throwable $e) {
            //jika terjadi kesalahan batalkan semua
            DB::rollback();
            return redirect()->route('pegawai.index')
                ->with('success', 'Pegawai batal diubah, ada kesalahan.');
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
            //menghapus 1 rekaman tabel pegawai
            Pegawai::find($id)->delete();
            DB::commit();
            // mengembalikan tampilan ke view index (halaman sebelumnya)
            return redirect()->route('pegawai.index')
                ->with('success', 'Pegawai berhasil dihapus');
        } catch (\Throwable $e) {
            //jika terjadi kesalahan batalkan semua
            DB::rollback();
            return redirect()->route('pegawai.index')
                ->with('success', 'Pegawai ada kesalahan hapus batal.');
        }
    }
}
