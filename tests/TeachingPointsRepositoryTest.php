<?php

use App\Models\TeachingPoints;
use App\Repositories\TeachingPointsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeachingPointsRepositoryTest extends TestCase
{
    use MakeTeachingPointsTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var TeachingPointsRepository
     */
    protected $teachingPointsRepo;

    public function setUp()
    {
        parent::setUp();
        $this->teachingPointsRepo = App::make(TeachingPointsRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateTeachingPoints()
    {
        $teachingPoints = $this->fakeTeachingPointsData();
        $createdTeachingPoints = $this->teachingPointsRepo->create($teachingPoints);
        $createdTeachingPoints = $createdTeachingPoints->toArray();
        $this->assertArrayHasKey('id', $createdTeachingPoints);
        $this->assertNotNull($createdTeachingPoints['id'], 'Created TeachingPoints must have id specified');
        $this->assertNotNull(TeachingPoints::find($createdTeachingPoints['id']), 'TeachingPoints with given id must be in DB');
        $this->assertModelData($teachingPoints, $createdTeachingPoints);
    }

    /**
     * @test read
     */
    public function testReadTeachingPoints()
    {
        $teachingPoints = $this->makeTeachingPoints();
        $dbTeachingPoints = $this->teachingPointsRepo->find($teachingPoints->id);
        $dbTeachingPoints = $dbTeachingPoints->toArray();
        $this->assertModelData($teachingPoints->toArray(), $dbTeachingPoints);
    }

    /**
     * @test update
     */
    public function testUpdateTeachingPoints()
    {
        $teachingPoints = $this->makeTeachingPoints();
        $fakeTeachingPoints = $this->fakeTeachingPointsData();
        $updatedTeachingPoints = $this->teachingPointsRepo->update($fakeTeachingPoints, $teachingPoints->id);
        $this->assertModelData($fakeTeachingPoints, $updatedTeachingPoints->toArray());
        $dbTeachingPoints = $this->teachingPointsRepo->find($teachingPoints->id);
        $this->assertModelData($fakeTeachingPoints, $dbTeachingPoints->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteTeachingPoints()
    {
        $teachingPoints = $this->makeTeachingPoints();
        $resp = $this->teachingPointsRepo->delete($teachingPoints->id);
        $this->assertTrue($resp);
        $this->assertNull(TeachingPoints::find($teachingPoints->id), 'TeachingPoints should not exist in DB');
    }
}
