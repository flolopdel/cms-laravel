<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeachingPointsApiTest extends TestCase
{
    use MakeTeachingPointsTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateTeachingPoints()
    {
        $teachingPoints = $this->fakeTeachingPointsData();
        $this->json('POST', '/api/v1/teachingPoints', $teachingPoints);

        $this->assertApiResponse($teachingPoints);
    }

    /**
     * @test
     */
    public function testReadTeachingPoints()
    {
        $teachingPoints = $this->makeTeachingPoints();
        $this->json('GET', '/api/v1/teachingPoints/'.$teachingPoints->id);

        $this->assertApiResponse($teachingPoints->toArray());
    }

    /**
     * @test
     */
    public function testUpdateTeachingPoints()
    {
        $teachingPoints = $this->makeTeachingPoints();
        $editedTeachingPoints = $this->fakeTeachingPointsData();

        $this->json('PUT', '/api/v1/teachingPoints/'.$teachingPoints->id, $editedTeachingPoints);

        $this->assertApiResponse($editedTeachingPoints);
    }

    /**
     * @test
     */
    public function testDeleteTeachingPoints()
    {
        $teachingPoints = $this->makeTeachingPoints();
        $this->json('DELETE', '/api/v1/teachingPoints/'.$teachingPoints->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/teachingPoints/'.$teachingPoints->id);

        $this->assertResponseStatus(404);
    }
}
