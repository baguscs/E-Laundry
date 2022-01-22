<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use App\Models\User;

class PasswordController extends Controller
{
    public function forgot()
    {
        return view('dashboard.forgot_password.index');
    }

    public function newPassword(Request $req)
    {
        $check = Pegawai::where('email', $req->email)->get();
        foreach ($check as $key) {
            $nama = $key->nama;
            $id = $key->id;
        }
        $valid = count($check);
        if ($valid == 0) {
            return redirect()->back()->with('pesan', 'Email yang anda masukkan tidak diketahui');
        }
        else{
            // return view('dashboard.request_password');
            //kirim email
            $id = Crypt::encrypt($id);
            $email = $req->email;
            $link = array(
                'nama' => $nama,
                'id' => $id,
            );

            Mail::send('dashboard.forgot_password.request_password', $link, function($mail) use($email){
                $mail->to($email, 'no-reply')->subject('Reset Password');
                $mail->from('E-Laundry@gmail.com', 'E-Laundry');
            });
            if(Mail::failures()){
                return redirect()->back()->with('pesan', 'Link Reset Password Gagal dikirim');
            }
            else{
                return redirect()->back()->with('alert', 'Link Reset Password Telah Dikirim mohon cek E-Mail anda');
            }
        }
    }

    public function reset($id)
    {
        $parameter = Crypt::decrypt($id);
        $data = Pegawai::find($parameter);
        $nama = $data->nama;
        $id = $data->id;
        return view('dashboard.forgot_password.reset', compact('nama', 'id'));
    }

    public function change(Request $req, $id)
    {
        $parameter = Crypt::decrypt($id);
        if ($req->password == $req->password_confirmation) {
            $data = User::where('pegawai_id', $parameter)->firstOrFail();
            $data->update([
                'password' => Hash::make($req->input('password')),
            ]);
            return redirect()->route('information');
        }
        else{
            return redirect()->back()->with('pesan', 'Konfirmasi Password Anda Tidak Cocok');
        }
    }

    public function done()
    {
        return view('dashboard.forgot_password.information');
    }
}
