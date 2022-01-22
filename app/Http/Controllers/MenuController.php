<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $data = Menu::all();
        return view('dashboard.menu.index', compact('data'));
    }

    public function add(Request $req)
    {
        $add = new Menu;

        $add->nama = $req->nama;
        $add->harga = preg_replace("/[^a-zA-Z0-9]/", "", $req->harga);
        $add->status = $req->status;

        $add->save();
        return redirect()->back()->with('pesan', 'Berhasil Menambah Menu Baru '. $req->nama);
    }

    public function status(Request $req, $id)
    {
        $parameter = Crypt::decrypt($id);
        $edit = Menu::where('id', $parameter)->firstOrFail();

        $edit->status = $req->status;

        $edit->save();
        if ($req->status == 'Block') {
            return redirect()->back()->with('pesan', 'Berhasil Memblokir Menu '. $req->nama);
        }
        else{
            return redirect()->back()->with('pesan', 'Berhasil Mengaktifkan Menu '. $req->nama);
        }
    }

    public function edit(Request $req, $id)
    {
        $parameter = Crypt::decrypt($id);
        $change = Menu::where('id', $parameter)->firstOrFail();

        $change->nama = $req->nama;
        $change->harga = $req->harga;

        $change->save();
        return redirect()->back()->with('pesan', 'Berhasil Mengedit Menu '. $req->nama);
    }
}
