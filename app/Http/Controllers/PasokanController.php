<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Images;
use App\Models\Barang;
use Auth;
use File;
use Image;

class PasokanController extends Controller
{
    public function index()
    {
        $data = Barang::all();
        return view('dashboard.pasok.index', compact('data'));
    }

    public function add()
    {
        return view('dashboard.pasok.add');
    }

    public function post(Request $req)
    {
        $message =[
            'mimes' => 'Extensi file tidak sesuai ketentuan',
            'max' => 'Size file melebihi batas',
            'required' => 'Bagian ini wajib diisi',
        ];

        $this->validate($req, [
            'bukti' => 'file|mimes:jpg,jpeg,png|max:1000'
        ],$message);

        $post = new barang;

        $post->pegawai_id = Auth::user()->pegawai_id;
        $post->nama = ucfirst($req->barang);
        $post->detail = $req->detail;
        $post->jumlah = $req->jumlah;
        $post->total = $req->total;

        $bukti =  $req->file('bukti');
        $title = time()."_".$bukti->getClientOriginalName();
        $resize = Image::make($bukti)->resize(800,900);
        $patch = public_path(). '/storage/nota/' .$title;
        $resize = Image::make($resize)->save($patch);
        $post->nota = $title;

        $post->save();

        return redirect()->route('pasokan')->with('pesan', 'Berhasil Menambah Barang '. $post->nama);
    }

    public function edited(Request $req, $id)
    {
        $message =[
            'mimes' => 'Extensi file tidak sesuai ketentuan',
            'max' => 'Size file melebihi batas',
            'required' => 'Bagian ini wajib diisi',
        ];

        $this->validate($req, [
            'bukti' => 'file|mimes:jpg,jpeg,png|max:1000'
        ],$message);

        $parameter = Crypt::decrypt($id);
        
        $edit = Barang::where('id', $parameter)->firstOrFail();

        if ($req->bukti) {
            $nota = $req->file('bukti');
            $title = time()."_".$nota->getClientOriginalName();
            $resize = Image::make($nota)->resize(800,900);
            $location = public_path(). '/storage/nota/'. $title;
            $change = Image::make($resize)->save($location);
            $old = public_path(). '\\storage\\nota\\'. $edit->nota;
            unlink($old);

            $edit->nota = $title;
        }
        
        $edit->pegawai_id = Auth::user()->pegawai_id;
        $edit->nama = ucfirst($req->barang);
        $edit->detail = $req->detail;
        $edit->jumlah = $req->jumlah;
        $edit->total = $req->total;


        $edit->save();
        return redirect()->back()->with('pesan', 'Berhasil Mengubah Pasokan Barang '. $edit->nama);
    }

    public function delete($id)
    {
        $parameter = Crypt::decrypt($id);
        $nota = Barang::where('id', $parameter)->firstOrFail();
        File::delete('storage/nota/'.$nota->nota);

        $nota->delete();
        return redirect()->back()->with('pesan', 'Berhasil Menghapus Pasokan');
    }

    public function verif(Request $req, $id)
    {
        $parameter = Crypt::decrypt($id);
        $verif = Barang::where('id', $parameter)->firstOrFail();

        $verif->verif = $req->input;
        $verif->save();

        return redirect()->back()->with('pesan', 'Berhasil Memverifikasi Pasokan Barang '.$verif->nama);
    }
}
