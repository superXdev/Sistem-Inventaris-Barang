<?php

namespace Tests\Feature;

use App\Models\{User, Supplier};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SupplierTest extends TestCase
{
    use DatabaseTransactions;

    public function test_supplier_screen_can_be_rendered()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->get(route('admin.supplier.index'));

        $response->assertStatus(200); 
    }

    public function test_new_supplier_can_be_created()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->post(route('admin.supplier.store'), [
            'nama' => 'Mamat',
            'alamat' => 'Binjai',
            'telepon' => '08xxxx',
            'catatan' => '...'
        ]);


        $response->assertSessionHas('success', function($value) {
            return $value == 'Supplier berhasil ditambahkan';
        });
        $response->assertStatus(302); 
    }

    public function test_unauthorized_user_can_not_create_new_supplier()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.supplier.store'), [
            'nama' => 'Mamat',
            'alamat' => 'Binjai',
            'telepon' => '08xxxx',
            'catatan' => '...'
        ]);

        $response->assertStatus(403); 
    }

    public function test_supplier_can_not_be_created_with_missing_input()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->post(route('admin.supplier.store'), [
            'nama' => 'Mamat',
            'alamat' => 'Binjai'
        ]);

        $response->assertSessionHas('errors');
        $response->assertStatus(302); 
    }

    public function test_supplier_can_be_edited()
    {
        $admin = User::factory()->create()->assignRole(1);
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.supplier.update'), [
            'id' => $supplier->id,
            'nama' => $supplier->nama,
            'alamat' => 'Binjai',
            'telepon' => $supplier->telepon,
            'catatan' => $supplier->catatan
        ]);

        $response->assertStatus(302); 
    }

    public function test_supplier_can_be_deleted()
    {
        $admin = User::factory()->create()->assignRole(1);
        $supplier = Supplier::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.supplier.destroy', $supplier->id), []);

        $response->assertStatus(302); 
    }
}
