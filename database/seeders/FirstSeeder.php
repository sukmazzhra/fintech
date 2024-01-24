<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirstSeeder extends Seeder
{
    public function run(): void
    {

        User::create([
            'name'=>'Tenizen Bank',
            'username'=>'bank',
            'password'=>Hash::make('bank'),
            'role'=>'bank'
        ]);

        User::create([
            'name'=>'Tenizen Mart',
            'username'=>'kantin',
            'password'=>Hash::make('kantin'),
            'role'=>'kantin'
        ]);

        User::create([
            'name'=>'Sukma',
            'username'=>'sukma',
            'password'=>Hash::make('sukma'),
            'role'=>'siswa'
        ]);

        Student::create([
            'user_id'=>'3',
            'nis'=>'12347',
            'classroom'=>'XII RPL'
        ]);

        Category::create([
            'name'=>'Minuman'
        ]);

        Category::create([
            'name'=>'Makanan'
        ]);

        Category::create([
            'name'=>'Snack'
        ]);

        Product::create([
            'name'=>'Taro',
            'price'=>'12000',
            'stock'=>25,
            'photo'=>'https://www.foodandwine.com/thmb/C4k6-Xg840Vowa4-FjHflEQTOHk=/1200x1200/filters:fill(auto,1)/taro-bubble-tea-XL-RECIPE0316-6a4d5b49afcd41ab8ea6b5ef5805858a.jpg',
            'description'=>'Taro',
            'category_id'=>1,
            'stand'=>2
        ]);

        Product::create([
            'name'=>'Mie Ayam',
            'price'=>'15000',
            'stock'=>10,
            'photo'=>'https://halalpedia.oss-ap-southeast-5.aliyuncs.com/2020/06/20200626205018-5ef5fd1ab5f63-bakso3.jpeg',
            'description'=>'Mie Ayam',
            'category_id'=>2,
            'stand'=>1
        ]);

        Product::create([
            'name'=>'Kentang Goreng',
            'price'=>'10000',
            'stock'=>15,
            'photo'=>'https://aromarasa.com/wp-content/uploads/2021/07/resep-kentang-goreng-crispy-ala-mcd-sederhana-1024x756.jpg',
            'description'=>'Kentang Goreng',
            'category_id'=>3,
            'stand'=>1
        ]);

        Wallet::create([
            'user_id'=>3,
            'credit'=>100000,
            'debit'=>null,
            'description'=>'Pembukaan Tabungan'
        ]);

        Wallet::create([
            'user_id'=>3,
            'credit'=>15000,
            'debit'=>null,
            'description'=>'Pembelian'
        ]);

        Wallet::create([
            'user_id'=>3,
            'credit'=>20000,
            'debit'=>null,
            'description'=>'Pembelian'
        ]);

        Transaction::create([
            'user_id'=>3,
            'product_id'=>1,
            'status'=>'di keranjang',
            'order_id'=>"INV_12345",
            'price'=>10000,
            'quantity'=>1
        ]);

        Transaction::create([
            'user_id'=>3,
            'product_id'=>2,
            'status'=>'di keranjang',
            'order_id'=>"INV_12345",
            'price'=>20000,
            'quantity'=>1
        ]);

        Transaction::create([
            'user_id'=>3,
            'product_id'=>3,
            'status'=>'di keranjang',
            'order_id'=>"INV_12345",
            'price'=>15000,
            'quantity'=>2
        ]);

        $total_debit=0;

        $transactions=Transaction::where('order_id' == 'INV_12345');

        foreach($transactions as $transaction){
            $total_price=$transaction->price * $transaction->quantity;
            $total_debit += $total_price;
        };

        Wallet::create([
            'user_id'=>3,
            'credit'=>$total_debit,
            'description'=>'Pembelian produk'
        ]);

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status'=>'dibayar'
            ]);
        };

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status'=>'diambil'
            ]);
        };

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                'status'=>'di keranjang'
            ]);
        };
    }
}
