<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pegawai;
use Auth;
use Str;

class ProfileController extends Controller
{
    public function index()
    {
       return view('dashboard.profil.index');
    }

    public function edited(Request $req)
    {
        $edit = User::find(Auth::user()->id);

        if ($req->email == Auth::user()->email) {
            return redirect()->back();
        }
        $edit->email = $req->email;
        $edit->save();

        $new_email = $req->email;
        
        $kode = Pegawai::find(Auth::user()->pegawai_id);
        $kode->akses = Str::random(5);
        $kode->status = "suspend";
        $kode->save();

        if ($req->email != Null) {
            $verif = array(
                'nama' => Auth::user()->pegawai->nama,
                'kode' => $kode->kode,
            );

            Mail::send('dashboard.profil.verif', $verif, function($mail) use($new_email){
                $mail->to($new_email, 'no-reply')->subject('Verification E-Mail');
                $mail->from('E-laundry@gmail.com', 'E-Laundry');
            });

            if(Mail::failures()){
                return redirect()->back()->with('pesan', 'E-mail gagal dikirm');
            }
            return redirect()->route('email_verif')->with('pesan', 'Kode Akses berhasil dikirim ke E-Mail baru.');
        }
    }

    public function valided(Request $req)
    {
        $valid = Pegawai::find(Auth::user()->pegawai_id);

        if($req->kode == $valid->akses){
            $valid->status = "aktif";
            $valid->save();
            if ($valid->kode == Null) {
                return redirect()->route('registerd');
            }
            return redirect()->route('profile')->with('pesan', 'E-mail anda berhasil diverifikasi');
        }
        else{
            return redirect()->back()->with('eror', 'Kode yang anda masukkan salah');
        }
    }

    public function ganti()
    {
        return view('dashboard.profil.password');
    }

    public function update(Request $req)
    {
        $this->validate($req, [
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $data = User::find(Auth::user()->id);
        
        $old_password = Hash::check($req->input('old_password'), $data->password);
        // dd($old_password);

        if ($old_password) {
            $data->update([
                'password' => Hash::make($req->input('password')),
            ]);
            
            $pegawai = Pegawai::find(Auth::user()->pegawai_id);    
            if ($pegawai->akses != null) {
                $kode = substr($pegawai->nama,0,3);
                $pegawai->kode = strtoupper($kode.$pegawai->id);
                $pegawai->akses = Null;

                $pegawai->save();
                return redirect()->route('profile')->with('pesan', 'Akun Anda Sudah Aktif');
            }

            return redirect()->route('profile')->with('pesan', 'Password Anda Telah Diubah');

        }
        else{
            return redirect()->back()->with('pesan', 'Maaf Password Lama yang anda masukkan salah');
        }
    }

    
}
