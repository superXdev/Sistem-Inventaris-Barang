<?php

namespace Tests\Feature;

use App\Models\{User, Laporan};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportTest extends TestCase
{
    public function test_report_screen_can_be_rendered()
    {
        $user = User::factory()->create()->assignRole(1);

        $response = $this->actingAs($user)->get(route('admin.laporan.index'));

        $response->assertStatus(200);
    }

    public function test_unauthorized_user_can_not_access()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.laporan.index'));

        $response->assertStatus(403);
    }
}
