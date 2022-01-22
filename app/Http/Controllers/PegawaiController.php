<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Images;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Pegawai;
use App\Models\User;
use File;
use Image;
use Str;
use Response;

class PegawaiController extends Controller
{
    public function index()
    {
        $data = Pegawai::where('role_id',2)->get();
        return view('dashboard.pegawai.index', compact('data'));
    }

    public function add()
    {
        return view('dashboard.pegawai.add');
    }

    public function post(Request $req)
    {
        $message =[
            'unique' => 'Masukkan anda telah terdaftar',
            'mimes' => 'Extensi file tidak sesuai ketentuan',
            'max' => 'Size file melebihi batas',
            'required' => 'Bagian ini wajib diisi',
        ];

        $this->validate($req, [
            'email' => 'required|unique:pegawais',
            'ijazah' => 'file|mimes:pdf|max:400',
            'foto' => 'file|mimes:jpg,jpeg,png|max:1000',
            'ktp' => 'file|mimes:jpg,jpeg,png|max:1000'
        ],$message);

        $post = new Pegawai;

        $post->role_id = 2;
        $post->nama = $req->first." ".$req->second;
        $post->alamat = $req->alamat;
        $post->telpon = $req->telpon;
        $post->sekolah = $req->sekolah;
        $post->kelamin = $req->kelamin;
        $post->email = $req->email;

        $document = $req->file('ijazah');
        $ijazah = time()."_".$document->getClientOriginalName();
        $location = 'storage/ijazah';
        $document->move($location,$ijazah);
        $post->ijazah = $ijazah;

        $foto =  $req->file('foto');
        $title = time()."_".$foto->getClientOriginalName();
        $resize = Image::make($foto)->resize(160,160);
        $patch = public_path(). '/storage/foto/' .$title;
        $resize = Image::make($resize)->save($patch);
        $post->img = $title;

        $files = $req->file('ktp');
        $name = time()."_".$files->getClientOriginalName(); 
        $make = Image::make($files)->resize(800,400);
        $loc = public_path(). '/storage/ktp/' .$name;
        $make = Image::make($make)->save($loc);
        $post->img_ktp = $name;

        $post->status = "non-aktif";
        $post->akses = Str::random(5);

        $post->save();

        $new_user = new User;
        $new_user->pegawai_id = $post->id;
        $new_user->email = $req->email;
        $new_user->password = Hash::make($post->akses);
        $new_user->save();

        //kirim email
        $send_email = $req->email;
        $verif = array(
            'nama' => $post->nama,
            'kode' => $post->akses,
        );

        Mail::send('dashboard.pegawai.verif', $verif, function($mail) use($send_email){
            $mail->to($send_email, 'no-reply')->subject('Verification E-mail');
            $mail->from('E-Laundry@gmail.com', 'E-Laundry');
        });
        if(Mail::failures()){
            return redirect()->back()->with('pesan', 'E-mail gagal dikirm');
        }
        return redirect()->route('show_pegawai')->with('pesan', 'Berhasil Menambah Pegawai '.$post->nama.', dan kode akses berhasil terkirim');
    }

    public function delete($id)
    {
        $parameter = Crypt::decrypt($id);
        $data = Pegawai::where('id', $parameter)->get();
        foreach ($data as $key) {
            $ijazah = File::delete('storage/ijazah/'.$key->ijazah);
            $foto = File::delete('storage/foto/'. $key->img);
            $ktp = File::delete('storage/ktp/'.$key->img_ktp);
        }
        $hapus_user = User::where('pegawai_id', $parameter)->delete();
        $hapus_pegawai = Pegawai::where('id', $parameter)->delete();
        return redirect()->back()->with('pesan','Berhasil menghapus pegawai');
    }

    public function ijazah($name)
    {
        $find = Pegawai::where('nama', $name)->get();
        foreach($find as $file){
            $ijazah = $file->ijazah;
        }
        return response()->file('storage/ijazah/'. $ijazah);
    }

    public function edited(Request $req, $id)
    {
        $message =[
            'unique' => 'Masukkan anda telah terdaftar',
            'mimes' => 'Extensi file tidak sesuai ketentuan',
            'max' => 'Size file melebihi batas',
            'required' => 'Bagian ini wajib diisi',
        ];

        $this->validate($req, [
            'ijazah' => 'file|mimes:pdf|max:400',
            'foto' => 'file|mimes:jpg,jpeg,png|max:1000',
            'ktp' => 'file|mimes:jpg,jpeg,png|max:1000'
        ],$message);

        $parameter = Crypt::decrypt($id);
        $data = Pegawai::where('id', $parameter)->firstOrfail();
        // dd($data);
        $data->role_id = 2;
        if ($data->nama != $req->nama) {
            $kode = substr($req->nama,0,2);
            $data->kode = strtoupper($kode.$data->id);
        }
        $data->nama = $req->nama;
        $data->alamat = $req->alamat;
        $data->telpon = $req->telpon;
        $data->sekolah = $req->sekolah;
        $data->kelamin = $req->kelamin;
        $data->email = $req->email;

        if ($req->foto) {
            $foto = $req->file('foto');
            $title = time()."_".$foto->getClientOriginalName();
            $resize = Image::make($foto)->resize(800,400);
            $location = public_path(). '/storage/foto/'. $title;
            $change = Image::make($resize)->save($location);
            $old = public_path(). '\\storage\\foto\\'. $data->img;
            unlink($old);

            $data->img = $title;
        }

        if ($req->ktp) {
            $ktp = $req->file('ktp');
            $header = time()."_".$ktp->getClientOriginalName();
            $remake = Image::make($ktp)->resize(800,400);
            $patch = public_path(). '/storage/ktp/'. $header;
            $edit = Image::make($remake)->save($patch);
            $old_location = public_path(). '\\storage\\ktp'.'\\'. $data->img_ktp;
            unlink($old_location);

            $data->img_ktp = $header;
        }

        if ($req->ijazah) {
            $ijazah = $req->ijazah;
            $name = time()."_".$ijazah->getClientOriginalName();
            $destination = 'storage/ijazah';
            $ijazah->move($destination,$name);
            $old_file = public_path(). '\\storage\\ijazah'.'\\'. $data->ijazah;
            unlink($old_file);

            $data->ijazah = $name;
        }
        // dd($data);
        $data->save();

        return redirect()->back()->with('pesan', 'Berhasil Mengedit Data Pegawai '. $data->nama);
    }

    public function status(Request $req, $id)
    {
        $parameter = Crypt::decrypt($id);
        $status = Pegawai::where('id', $parameter)->firstOrFail();
        $status->status = $req->radio;
        $status->save();
        return redirect()->back()->with('pesan', 'Berhasil Merubah Status '. $status->nama);
    }
}
