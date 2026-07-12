<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirReportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_kasir_can_view_reports_page_with_print_button(): void
    {
        $user = User::factory()->create([
            'role' => 'kasir',
        ]);

        $this->actingAs($user);

        $response = $this->get(route('kasir.reports.index'));

        $response->assertOk();
        $response->assertSee('Print Report');
    }
}
