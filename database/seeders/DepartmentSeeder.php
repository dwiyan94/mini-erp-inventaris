<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Sumber Daya Manusia (HR / Personalia)',
                'description' => 'Mengelola rekrutmen, pelatihan, data karyawan, dan kebijakan kerja.'
            ],
            [
                'name' => 'Keuangan & Akuntansi (Finance & Accounting)',
                'description' => 'Mengatur anggaran, pencatatan keuangan, laporan pajak, dan arus kas.'
            ],
            [
                'name' => 'Pemasaran (Marketing)',
                'description' => 'Menyusun strategi branding, riset pasar, dan kampanye promosi produk.'
            ],
            [
                'name' => 'Penjualan (Sales)',
                'description' => 'Menangani interaksi langsung dengan pembeli untuk mencapai target penjualan.'
            ],
            [
                'name' => 'Produksi / Operasional',
                'description' => 'Mengawasi proses pembuatan barang atau penyediaan jasa utama perusahaan.'
            ],
            [
                'name' => 'Teknologi Informasi (IT)',
                'description' => 'Mengelola infrastruktur jaringan, keamanan data, dan perangkat lunak internal.'
            ],
            [
                'name' => 'Hukum & Kepatuhan (Legal)',
                'description' => 'Menangani kontrak kerja, regulasi, dan aspek perlindungan hukum perusahaan.'
            ],
            [
                'name' => 'Penelitian dan Pengembangan (R&D)',
                'description' => 'Melakukan inovasi serta menciptakan produk atau layanan baru.'
            ],
            [
                'name' => 'Pengadaan (Procurement)',
                'description' => 'Mencari vendor, menegosiasikan harga, dan mengelola pembelian barang.'
            ],
            [
                'name' => 'Layanan Pelanggan (Customer Service)',
                'description' => 'Menangani keluhan, pertanyaan, serta menjaga kepuasan klien.'
            ],
        ];

        // Memasukkan data departemen ke tabel departments
        foreach ($departments as $dept) {
            // Gunakan updateOrCreate agar tidak error duplikat jika di-seed ulang
            \App\Models\Department::updateOrCreate(
                ['name' => $dept['name']],
                ['description' => $dept['description']]
            );
        }
    }
}
