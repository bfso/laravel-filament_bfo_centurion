<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\CreatesApplication;
use Tests\TestCase;

class ApiLoginTest extends TestCase
{
    use CreatesApplication;

    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        //Artisan::call('migrate:refresh');
    }

    /**
     * @return void
     */
    public function test_login_successful()
    {
        $password = Hash::make(Str::random(10));
        $user = User::create(
            [

                'email' => $this->faker->email,
                'name' => $this->faker->firstName.' '.$this->faker->lastName,
                'password' => Hash::make($password),
            ]
        );

        $response = $this->post('api/v1/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson(
                [
                    'success' => true,
                    'data' => [
                        'token' => $user->id,
                        'name' => $user->name,
                    ],
                    'message' => 'User signed in',
                ]
            );
    }
}
