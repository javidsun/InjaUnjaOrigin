<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

  /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

  #[Test]
  public function test_login_user_with_credentials()
  {
    $this->withoutExceptionHandling();

    User::factory()->create([
      'email' => 'test@example.com',
      'password' => bcrypt('password'),
    ]);

    $response = $this->withoutMiddleware()->postJson('api/login', [
      'email' => 'test@example.com',
      'password' => 'password',
    ]);
    $response->assertStatus(200);
  }
}
