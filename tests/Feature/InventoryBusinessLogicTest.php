<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\StockMutation;
use Illuminate\Foundation\Testing\DatabaseMigrations; // Ganti RefreshDatabase dengan ini
use Tests\TestCase;

class InventoryBusinessLogicTest extends TestCase
{
    use DatabaseMigrations; // Menggunakan migrasi bersih per tes tanpa nested transaction konflik SQLite

    public function test_product_sku_must_be_unique()
    {
        $user = User::factory()->create();

        Product::create([
            'sku' => 'SKU-TEST-001',
            'name' => 'Produk A',
            'category' => 'Elektronik',
            'unit' => 'Pcs',
            'price' => 10000,
            'stock' => 10,
            'user_id' => $user->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Product::create([
            'sku' => 'SKU-TEST-001',
            'name' => 'Produk B',
            'category' => 'Elektronik',
            'unit' => 'Pcs',
            'price' => 15000,
            'stock' => 5,
            'user_id' => $user->id,
        ]);
    }

    public function test_stock_out_cannot_exceed_available_stock()
    {
        $user = User::factory()->create();

        $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'view-stock_mutations']);
        $user->givePermissionTo($permission);

        $product = Product::create([
            'sku' => 'SKU-TEST-002',
            'name' => 'Produk Test Stok',
            'category' => 'Grosir',
            'unit' => 'Pcs',
            'price' => 5000,
            'stock' => 5,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post('/stock_mutations', [
            'product_id' => $product->id,
            'type' => 'out',
            'quantity' => 10,
            'notes' => 'Pengeluaran melebihi stok',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals(5, $product->fresh()->stock);
    }

    public function test_inventory_valuation_calculation()
    {
        $user = User::factory()->create();

        Product::create([
            'sku' => 'SKU-V-1',
            'name' => 'Barang 1',
            'category' => 'A',
            'unit' => 'Pcs',
            'price' => 10000,
            'stock' => 10,
            'user_id' => $user->id,
        ]);

        Product::create([
            'sku' => 'SKU-V-2',
            'name' => 'Barang 2',
            'category' => 'A',
            'unit' => 'Pcs',
            'price' => 20000,
            'stock' => 5,
            'user_id' => $user->id,
        ]);

        $totalValuation = Product::all()->sum(function($product) {
            return $product->price * $product->stock;
        });

        $this->assertEquals(200000, $totalValuation);
    }
}