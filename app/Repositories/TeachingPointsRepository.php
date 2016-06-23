<?php

namespace App\Repositories;

use App\Models\TeachingPoints;
use InfyOm\Generator\Common\BaseRepository;

class TeachingPointsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TeachingPoints::class;
    }
}
