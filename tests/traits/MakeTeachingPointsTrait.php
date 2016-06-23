<?php

use Faker\Factory as Faker;
use App\Models\TeachingPoints;
use App\Repositories\TeachingPointsRepository;

trait MakeTeachingPointsTrait
{
    /**
     * Create fake instance of TeachingPoints and save it in database
     *
     * @param array $teachingPointsFields
     * @return TeachingPoints
     */
    public function makeTeachingPoints($teachingPointsFields = [])
    {
        /** @var TeachingPointsRepository $teachingPointsRepo */
        $teachingPointsRepo = App::make(TeachingPointsRepository::class);
        $theme = $this->fakeTeachingPointsData($teachingPointsFields);
        return $teachingPointsRepo->create($theme);
    }

    /**
     * Get fake instance of TeachingPoints
     *
     * @param array $teachingPointsFields
     * @return TeachingPoints
     */
    public function fakeTeachingPoints($teachingPointsFields = [])
    {
        return new TeachingPoints($this->fakeTeachingPointsData($teachingPointsFields));
    }

    /**
     * Get fake data of TeachingPoints
     *
     * @param array $postFields
     * @return array
     */
    public function fakeTeachingPointsData($teachingPointsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $teachingPointsFields);
    }
}
