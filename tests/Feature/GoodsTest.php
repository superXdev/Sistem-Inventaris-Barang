<?php

namespace Tests\Feature;

use App\Models\{User, Barang, Gudang};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GoodsTest extends TestCase
{
    use DatabaseTransactions;

    public function test_goods_screen_can_be_rendered()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->get(route('admin.barang.index'));

        $response->assertStatus(200);
    }

    public function test_new_goods_can_be_created()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.barang.store'), [
            'kode' => 'SP',
            'nama' => 'Topi',
            'jumlah' => rand(10,60),
            'kondisi' => rand(0,1),
            'gudang_id' => $gudang->id
        ]);


        $response->assertSessionHas('success', function($value) {
            return $value == 'barang berhasil ditambahkan';
        });
        $response->assertStatus(302); 
    }

    public function test_goods_info_can_be_rendered()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);

        $response = $this->actingAs($user)->get(route('admin.barang.info').'?id='.$barang->id);

        $response->assertStatus(200); 
    }

    public function test_goods_can_not_be_created_with_duplicate_data()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);

        $response = $this->actingAs($user)->post(route('admin.barang.store'), [
            'kode' => $barang->kode,
            'nama' => 'Topi',
            'jumlah' => rand(10,60),
            'kondisi' => rand(0,1),
            'gudang_id' => $gudang->id
        ]);


        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_goods_can_not_be_created_with_missing_input()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->post(route('admin.barang.store'), [
            'kode' => 'SP',
            'nama' => 'Topi',
            'jumlah' => rand(10,60),
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_goods_can_not_be_created_with_minus_amount()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.barang.store'), [
            'kode' => 'SP',
            'nama' => 'Topi',
            'jumlah' => -1,
            'kondisi' => rand(0,1),
            'gudang_id' => $gudang->id
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_goods_can_not_be_created_with_wrong_condition()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.barang.store'), [
            'kode' => 'SP',
            'nama' => 'Topi',
            'jumlah' => 1,
            'kondisi' => 3,
            'gudang_id' => $gudang->id
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_goods_can_be_edited()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);

        $response = $this->actingAs($admin)->post(route('admin.barang.update'), [
            'id' => $barang->id,
            'kode' => $barang->kode,
            'nama' => 'Topi',
            'jumlah' => rand(10,60),
            'kondisi' => rand(0,1),
            'gudang_id' => $gudang->id
        ]);

        $response->assertStatus(302); 
    }

    public function test_goods_can_be_deleted()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();
        $barang = Barang::factory()->create(['gudang_id' => $gudang->id]);

        $response = $this->actingAs($admin)->post(route('admin.barang.destroy', $barang->id), []);

        $response->assertStatus(302); 
    }
}
