<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WuserApiTest extends TestCase
{
    use MakeWuserTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateWuser()
    {
        $wuser = $this->fakeWuserData();
        $this->json('POST', '/api/v1/wusers', $wuser);

        $this->assertApiResponse($wuser);
    }

    /**
     * @test
     */
    public function testReadWuser()
    {
        $wuser = $this->makeWuser();
        $this->json('GET', '/api/v1/wusers/'.$wuser->id);

        $this->assertApiResponse($wuser->toArray());
    }

    /**
     * @test
     */
    public function testUpdateWuser()
    {
        $wuser = $this->makeWuser();
        $editedWuser = $this->fakeWuserData();

        $this->json('PUT', '/api/v1/wusers/'.$wuser->id, $editedWuser);

        $this->assertApiResponse($editedWuser);
    }

    /**
     * @test
     */
    public function testDeleteWuser()
    {
        $wuser = $this->makeWuser();
        $this->json('DELETE', '/api/v1/wusers/'.$wuser->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/wusers/'.$wuser->id);

        $this->assertResponseStatus(404);
    }
}
