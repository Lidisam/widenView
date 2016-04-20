<?php

use App\Models\Wuser;
use App\Repositories\WuserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WuserRepositoryTest extends TestCase
{
    use MakeWuserTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var WuserRepository
     */
    protected $wuserRepo;

    public function setUp()
    {
        parent::setUp();
        $this->wuserRepo = App::make(WuserRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateWuser()
    {
        $wuser = $this->fakeWuserData();
        $createdWuser = $this->wuserRepo->create($wuser);
        $createdWuser = $createdWuser->toArray();
        $this->assertArrayHasKey('id', $createdWuser);
        $this->assertNotNull($createdWuser['id'], 'Created Wuser must have id specified');
        $this->assertNotNull(Wuser::find($createdWuser['id']), 'Wuser with given id must be in DB');
        $this->assertModelData($wuser, $createdWuser);
    }

    /**
     * @test read
     */
    public function testReadWuser()
    {
        $wuser = $this->makeWuser();
        $dbWuser = $this->wuserRepo->find($wuser->id);
        $dbWuser = $dbWuser->toArray();
        $this->assertModelData($wuser->toArray(), $dbWuser);
    }

    /**
     * @test update
     */
    public function testUpdateWuser()
    {
        $wuser = $this->makeWuser();
        $fakeWuser = $this->fakeWuserData();
        $updatedWuser = $this->wuserRepo->update($fakeWuser, $wuser->id);
        $this->assertModelData($fakeWuser, $updatedWuser->toArray());
        $dbWuser = $this->wuserRepo->find($wuser->id);
        $this->assertModelData($fakeWuser, $dbWuser->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteWuser()
    {
        $wuser = $this->makeWuser();
        $resp = $this->wuserRepo->delete($wuser->id);
        $this->assertTrue($resp);
        $this->assertNull(Wuser::find($wuser->id), 'Wuser should not exist in DB');
    }
}
