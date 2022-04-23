<?php

namespace Tests\Feature;

use App\Models\{User, Barang, BarangMasuk, Gudang, Supplier};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IncomingGoodsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_incoming_goods_screen_can_be_rendered()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->get(route('admin.barang-masuk.index'));

        $response->assertStatus(200);
    }

    public function test_new_incoming_goods_can_be_created()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.barang-masuk.store'), [
            'supplier_id' => $supplier->id, 
            'berat' => 2, 
            'barang_id' => $barang->id, 
            'harga' => '20,000',
            'jumlah' => 10
        ]);


        $response->assertSessionHas('success', function($value) {
            return $value == 'Stok berhasil ditambahkan';
        });
        $response->assertStatus(302); 
    }

    public function test_incoming_goods_can_not_be_created_with_missing_input()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.barang-masuk.store'), [
            'supplier_id' => $supplier->id, 
            'berat' => 2, 
            'barang_id' => $barang->id
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_incoming_goods_can_not_be_created_with_minus_amount()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.barang-masuk.store'), [
            'supplier_id' => $supplier->id, 
            'berat' => 2, 
            'barang_id' => $barang->id, 
            'harga' => '20,000',
            'jumlah' => -1
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }


    public function test_incoming_goods_can_be_edited()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);
        $supplier = Supplier::factory()->create();
        $barang_masuk = BarangMasuk::factory()->create([
            'supplier_id' => $supplier->id,
            'barang_id' => $barang->id
        ]);

        $response = $this->actingAs($admin)->post(route('admin.barang-masuk.update'), [
            'berat' => 2,
            'harga' => '22,000',
            'jumlah' => 5
        ]);

        $response->assertStatus(302); 
    }

    public function test_incoming_goods_can_be_deleted()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);
        $supplier = Supplier::factory()->create();
        $barang_masuk = BarangMasuk::factory()->create([
            'supplier_id' => $supplier->id,
            'barang_id' => $barang->id
        ]);

        $response = $this->actingAs($admin)->post(route('admin.barang-masuk.destroy', $barang_masuk->id), []);

        $response->assertStatus(302); 
    }
}
