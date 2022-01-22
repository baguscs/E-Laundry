<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Models\Menu;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Work;
use Auth;

class OrderController extends Controller
{
    public function index()
    {
        $data = Order::all();
        return view('dashboard.order.index', compact('data'));
    }

    public function detail($id)
    {
        $parameter = Crypt::decrypt($id);
        $data = Order::where('id', $parameter)->get();
        $work = Work::where('order_id', $parameter)->get();
        return view('dashboard.order.detail', compact('data', 'work'));
    }

    public function new_customer($page)
    {
        $parameter = $page;
        $menu = Menu::where('status', 'aktif')->get();
        return view('dashboard.order.add', compact('parameter', 'menu'));
    }

    public function old_customer($page)
    {
        $parameter = $page;
        $customer = Customer::all();
        $menu = Menu::where('status', 'aktif')->get();
        return view('dashboard.order.add', compact('parameter', 'menu', 'customer'));
    }

    public function post(Request $req, $ex)
    {
        if ($ex == 'new') {
            //menambah customer baru
            $message =[
                'unique' => 'Masukkan anda telah terdaftar',
            ];
    
            $this->validate($req, [
                'email' => 'required|unique:customers',
            ],$message);
            
            $new_cs = new Customer;

            $new_cs->email = $req->email;
            $new_cs->nama = $req->nama;
            $new_cs->alamat = $req->alamat;
            $new_cs->wash = 1;
            
            $new_cs->save();

            $id_cs = $new_cs->id;
        }
        else{
            $add = Customer::where('id', $req->nama)->firstOrFail();
            $wash = $add->wash + 1;
            $add->wash = $wash;
            $add->save();
        }

        //membuat orderan
        $order = new Order;
        if ($ex == 'new') {
            $order->customer_id = $id_cs;
        }
        else{
            $order->customer_id = $req->nama;
        }
        // dd($order->cutomer_id);
        $order->jumlah = $req->berat;
        $order->kategori = $req->kategori;
        if ($ex == 'new') {
            $order->resi = Auth::user()->pegawai->kode."-"."000".$id_cs.$new_cs->wash;
        }
        else{
            $order->resi = Auth::user()->pegawai->kode."-"."000".$req->nama.$add->wash;
        }
        
        //menghapus format uang string
        $jumlah = $req->total;
        $total = preg_replace("/[^a-zA-Z0-9]/", "", $jumlah);

        $order->total = $total;

        //menghapus format uang string
        $uang = $req->bayar;
        $bayar = preg_replace("/[^a-zA-Z0-9]/", "", $uang);

        $order->bayar = $bayar;

        //setting estimasi
        $today = date("d-m-Y");
        if ($req->kategori == "Standart") {
            $estimasi =  mktime(0,0,0,date("n"),date("j")+3,date("Y"));
        }
        else {
            $estimasi = mktime(0,0,0,date("n"),date("j")+1,date("Y"));
        }
        $ambil = date("d-m-Y", $estimasi);

        $order->estimasi = $ambil;
        $order->status = "non confirm";
        $order->cek = Auth::user()->pegawai_id;
        $order->save();

        //membuat list pekerjaan
        $menu = $req->menu;
        foreach ($menu as $key) {
            $list = new Work;

            $list->order_id = $order->id;
            $list->menu = $key;
            $list->pegawai_id = Auth::user()->pegawai->id;

            $list->save();
        }
        
        //kirim email konfirmasi pesanan
        $id = Crypt::encrypt($order->id);
        if ($ex == 'new') {
            $send_email = $req->email;
        }
        else{
            $send_email = $add->email;
        }
        
        if ($ex == 'new') {
            $verif = array(
                'nama' => $req->nama,
                'alamat' => $req->alamat,
                'id' => $id,
            );
        }
        else{
            $verif = array(
                'nama' => $add->nama,
                'alamat' => $req->alamat,
                'id' => $id,
            );
        }

        Mail::send('dashboard.order.verif', $verif, function($mail) use($send_email){
            $mail->to($send_email, 'no-reply')->subject('Konfirmasi Pesanan');
            $mail->from('E-Laundry@gmail.com', 'E-Laundry');
        });
        if(Mail::failures()){
            return redirect()->back()->with('pesan', 'E-mail gagal dikirm');
        }
        if ($ex =='new') {
            return redirect()->route('order')->with('pesan', 'Berhasil Menambah Pesanan '.$req->nama);
        }
        else{
            return redirect()->route('order')->with('pesan', 'Berhasil Menambah Pesanan '.$add->nama);
        }
        

    }

    public function confirm($id)
    {
        $parameter = Crypt::decrypt($id);
        $data = Order::where('id', $parameter)->get();
        $work = Work::where('order_id', $parameter)->get();
        $cek = Order::where('id', $parameter)->firstOrFail();
        if ($cek->status == 'good' || $cek->status == 'bad') {
            $load = 'try';
            return view('dashboard.order.konfirmasi.try', compact('load', 'data'));
        }
        else{
            return view('dashboard.order.konfirmasi.index', compact('data', 'work'));
        }
    }

    public function confirmed(Request $req, $id)
    {
        $parameter = Crypt::decrypt($id);
        $find = Order::where('id', $parameter)->firstOrFail();
        
        $find->status = $req->status;
        if ($req->status == 'bad') {
            $find->pesan = $req->pesan;
        }
        $find->save();
        
        return redirect()->route('notif', $id);
    }

    public function notif($id)
    {
        $parameter = Crypt::decrypt($id);
        $show = Order::where('id', $parameter)->get();
        return view('dashboard.order.konfirmasi.notif', compact('show'));
    }

    public function invoice($id)
    {
        $parameter = Crypt::decrypt($id);
        $data = Order::where('id', $parameter)->get();
        $work = Work::where('order_id', $parameter)->get();
        $row = Work::where('order_id', $parameter)->count();
        $date = date('d-m-Y');
        return view('dashboard.order.konfirmasi.invoice', compact('data', 'work', 'date', 'row'));
    }
}
