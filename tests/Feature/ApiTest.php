<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * Should check that an authorized connection can be made.
     *
     * @return void
     */
    public function test_api_school_can_be_authenticated()
    {
        $token = config('services.token')['key'];
        $schoolID = config('services.schoolID')['key'];

        $client = new \Wonde\Client($token);
        $response = $client->school($schoolID);

        $response->assertStatus(200);
    }

    /**
     * Should check that an invalid token results in an unauthorized response.
     *
     * @return void
     */
    public function test_api_invalid_token()
    {
        $token = '12345';
        $schoolID = config('services.schoolID')['key'];

        $client = new \Wonde\Client($token);
        $school = $client->school($schoolID);
        $response = $school->employees->all();
        $response->assertStatus(401);
    }
}
