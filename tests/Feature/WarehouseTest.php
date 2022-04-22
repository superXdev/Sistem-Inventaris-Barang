<?php

namespace Tests\Feature;

use App\Models\{Gudang, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class WarehouseTest extends TestCase
{
    
    use DatabaseTransactions;

    public function test_warehouse_screen_can_be_rendered()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->get(route('admin.gudang.index'));

        $response->assertStatus(200); 
    }

    public function test_new_warehouse_can_be_created()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->post(route('admin.gudang.store'), [
            'kode' => 'AA',
            'nama' => 'Alpha',
            'catatan' => 'Oke'
        ]);


        $response->assertSessionHas('success', function($value) {
            return $value == 'Gudang berhasil ditambahkan';
        });
        $response->assertStatus(302); 
    }

    public function test_warehouse_can_not_be_created_with_duplicate_data()
    {
        $user = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.gudang.store'), [
            'kode' => $gudang->kode,
            'nama' => $gudang->nama,
            'catatan' => 'Oke'
        ]);


        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_warehouse_can_not_be_created_with_missing_input()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->post(route('admin.gudang.store'), [
            'kode' => 'AA',
            'catatan' => 'Oke'
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_warehouse_can_be_edited()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.gudang.update'), [
            'id' => $gudang->id,
            'kode' => $gudang->kode,
            'nama' => 'Alpha 2',
            'catatan' => $gudang->catatan
        ]);

        $response->assertStatus(302); 
    }

    public function test_warehouse_can_be_deleted()
    {
        $admin = User::factory()->create()->assignRole(1);
        $gudang = Gudang::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.gudang.destroy', $gudang->id), []);

        $response->assertStatus(302); 
    }
}
