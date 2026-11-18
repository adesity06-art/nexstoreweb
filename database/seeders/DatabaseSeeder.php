<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Aman dijalankan berkali-kali (tidak lagi error "Duplicate entry").
     */
    public function run(): void
    {
        // 1. Akun
        User::updateOrCreate(
            ['email' => 'admin@nexstore.com'],
            ['name' => 'Admin Nexstore', 'password' => Hash::make('password123'), 'role' => 'admin']
        );
        User::updateOrCreate(
            ['email' => 'kasir@nexstore.com'],
            ['name' => 'Kasir Andi', 'password' => Hash::make('password123'), 'role' => 'kasir']
        );

        // 2. Kategori
        $kategori = [];
        foreach ([
            'sembako' => 'Sembako',
            'makanan' => 'Makanan & Camilan',
            'minuman' => 'Minuman',
            'susu' => 'Produk Susu & Olahan',
            'buah' => 'Buah & Sayuran',
            'tubuh' => 'Perawatan Tubuh',
            'rumah' => 'Perlengkapan Rumah Tangga',
            'alat' => 'Alat Tulis & Lainnya',
        ] as $key => $nama) {
            $kategori[$key] = Category::firstOrCreate(['name' => $nama]);
        }

        // 3. Produk
        $produk = [
            ['PRD-001', 'Indomie Goreng', 'makanan', 3500, 45],
            ['PRD-002', 'Aqua 600ml', 'minuman', 3000, 8],
            ['PRD-003', 'Teh Botol', 'minuman', 4000, 22],
            ['PRD-004', 'Roti Tawar', 'makanan', 15000, 30],
            ['PRD-005', 'Kopi Sachet', 'minuman', 2000, 100],
        ];

        foreach ($produk as [$kode, $nama, $kat, $harga, $stok]) {
            Product::firstOrCreate(
                ['kode_produk' => $kode],
                ['nama_produk' => $nama, 'category_id' => $kategori[$kat]->id, 'harga' => $harga, 'stok' => $stok]
            );
        }
    }
}
