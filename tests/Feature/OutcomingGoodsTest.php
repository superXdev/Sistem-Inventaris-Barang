<?php

namespace Tests\Feature;

use App\Models\{User, Barang, Gudang, BarangKeluar, Supplier};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OutcomingGoodsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_outcoming_goods_screen_can_be_rendered()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->get(route('admin.barang-keluar.index'));

        $response->assertStatus(200);
    }

    public function test_new_outcoming_goods_can_be_created()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);

        $response = $this->actingAs($user)->post(route('admin.barang-keluar.store'), [
            'penerima' => 'Juned', 
            'berat' => 2,
            'harga' => '25,000', 
            'jumlah' => 10,
            'barang_id' => $barang->id
        ]);


        $response->assertSessionHas('success', function($value) {
            return $value == 'Stok berhasil dikurangi';
        });
        $response->assertStatus(302); 
    }

    public function test_outcoming_goods_can_not_be_created_with_missing_input()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);

        $response = $this->actingAs($user)->post(route('admin.barang-keluar.store'), [
            'penerima' => 'Juned', 
            'berat' => 2,
            'barang_id' => $barang->id
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_outcoming_goods_can_not_be_created_with_minus_amount()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);

        $response = $this->actingAs($user)->post(route('admin.barang-keluar.store'), [
            'penerima' => 'Juned', 
            'berat' => 2,
            'harga' => '25,000', 
            'jumlah' => -10,
            'barang_id' => $barang->id
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }


    public function test_outcoming_goods_can_be_edited()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);
        $supplier = Supplier::factory()->create();
        $barang_keluar = BarangKeluar::factory()->create(['barang_id' => $barang->id]);

        $response = $this->actingAs($admin)->post(route('admin.barang-keluar.update'), [
            'id' => $barang_keluar->id,
            'penerima' => 'Ahmad', 
            'berat' => 2,
            'harga' => '25,000', 
            'jumlah' => 10,
            'barang_id' => $barang->id
        ]);

        $response->assertStatus(302); 
    }

    public function test_outcoming_goods_can_be_deleted()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);
        $supplier = Supplier::factory()->create();
        $barang_keluar = BarangKeluar::factory()->create(['barang_id' => $barang->id]);

        $response = $this->actingAs($admin)->post(route('admin.barang-keluar.destroy', $barang_keluar->id), []);

        $response->assertStatus(302); 
    }
}
