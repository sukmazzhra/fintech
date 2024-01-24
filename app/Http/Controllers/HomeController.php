<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == 'kantin'){
            // $products=Product::withTrashed()->all();
            $products=Product::all();
            $categories=Category::all();
            $transactions = Transaction::where('status','dibayar')->get();

            // dd($products);

            return view('home',compact('products','categories','transactions'));
        };

        if(Auth::user()->role == 'bank'){
            $wallets=Wallet::where('status','selesai')->where('user_id','4')->get();
            $credit=0;
            $debit=0;

            foreach($wallets as $wallet){
                $credit+=$wallet->credit;
                $debit+=$wallet->debit;
            };

            $saldo=$credit-$debit;
            $nasabah=User::where('role', 'siswa')->get()->count();
            $daftar_user=User::where('role','siswa')->get();
            $daftar_transactions=Transaction::where('user_id','4')->get();
            $transactions=Transaction::all()->groupBy('order_id')->count();
            $request_topup=Wallet::where('status','proses')->get();

            return view('home',compact('saldo','nasabah','transactions','daftar_user','daftar_transactions','wallets','request_topup'));

        };

        if(Auth::user()->role == 'siswa'){
            $wallets=Wallet::where('user_id', Auth::user()->id)->where('status','selesai')->get();
                $credit=0;
                $debit=0;

            foreach($wallets as $wallet){
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            };

            $saldo=$credit-$debit;

            $products=Product::all();

            $carts=Transaction::where('status','di keranjang')->where('user_id', Auth::user()->id)->get();

            $total_biaya=0;

            foreach($carts as $cart){
                $total_price=$cart->price * $cart->quantity;

                if($cart->product->stock <= 0){
                    $total_biaya - ($cart->price * $cart->quantity);
                }
                else{
                    $total_biaya += $total_price;
                }
            };

            $mutasi = Wallet::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->get();

            $transactions = Transaction::where('status','dibayar')->where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->paginate(5)->groupBy('order_id');

            
            return view('home', compact('saldo','products','carts','total_biaya','mutasi','transactions'));
        }

        if(Auth::user()->role == 'admin'){
            $user=User::where('role','siswa')->get()->count();
            $transactions=Transaction::all()->count();
            $products=Product::all()->count();
            // $products=Product::withTrashed()->all();

            return view('home',compact('user','transactions','products'));
        }
    }
}
