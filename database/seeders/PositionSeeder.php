<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $position = [
            [
            	'department_id' => 5,
                'name' => 'Chief Operating Officer (COO) / Direktur Operasional',
                'task' => 'Pemimpin tertinggi operasional yang merancang strategi jangka panjang dan memastikan seluruh bisnis berjalan efisien.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Production Manager / Operations Manager',
                'task' => 'Bertanggung jawab atas pengelolaan harian pabrik atau operasional kantor, termasuk memantau anggaran, jadwal, dan produktivitas tim.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Plant Manager (Manajer Pabrik)',
                'task' => 'Khusus di perusahaan manufaktur, posisi ini mengawasi seluruh aktivitas di area pabrik fisik tertentu.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Production Supervisor / Team Leader',
                'task' => 'Mengawasi langsung kinerja staf atau buruh di lapangan, membagi sif kerja, dan memastikan target harian tercapai.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Inventory / Supply Chain Supervisor',
                'task' => 'Mengatur perputaran stok barang, bahan baku, dan penyimpanan di gudang operasional'
            ],
            [
            	'department_id' => 5,
                'name' => 'Quality Control (QC) & Quality Assurance (QA) Specialist',
                'task' => 'Memeriksa dan memastikan produk atau layanan yang dihasilkan memenuhi standar kualitas perusahaan.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Production Planner / PPIC (Production Planning and Inventory Control)',
                'task' => 'Merencanakan jadwal produksi, menghitung kebutuhan bahan baku, dan memastikan proses kerja efisien tanpa kekurangan bahan.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Maintenance & Facilities Engineer',
                'task' => 'Teknisi yang bertugas merawat, memperbaiki, dan menjaga agar mesin-mesin produksi atau fasilitas operasional tidak rusak.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Production Operator',
                'task' => 'Pekerja yang mengoperasikan mesin produksi atau merakit produk di jalur perakitan (assembly line).'
            ],
            [
            	'department_id' => 5,
                'name' => 'Warehouse Staff (Staf Gudang)',
                'task' => 'Menangani bongkar muat barang, mencatat arus keluar-masuk barang, dan menata penyimpanan.'
            ],
            [
            	'department_id' => 5,
                'name' => 'Logistics / Courier',
                'task' => 'Mengatur pengiriman barang dari pabrik ke gudang lain atau langsung ke konsumen (pada perusahaan jasa pengiriman/e-commerce).'
            ],
        ];

        foreach ($position as $pos) {
            \App\Models\Position::updateOrCreate(
                // Parameter 1: Kondisi pencarian (Unik untuk setiap data)
                [
                    'department_id' => $pos['department_id'],
                    'name' => $pos['name']
                ],
                // Parameter 2: Data yang diisi atau diperbarui
                [
                    'task' => $pos['task']
                ]
            );
        }
    }
}
