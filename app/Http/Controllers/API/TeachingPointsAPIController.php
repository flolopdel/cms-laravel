<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTeachingPointsAPIRequest;
use App\Http\Requests\API\UpdateTeachingPointsAPIRequest;
use App\Models\TeachingPoints;
use App\Repositories\TeachingPointsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TeachingPointsController
 * @package App\Http\Controllers\API
 */

class TeachingPointsAPIController extends InfyOmBaseController
{
    /** @var  TeachingPointsRepository */
    private $teachingPointsRepository;

    public function __construct(TeachingPointsRepository $teachingPointsRepo)
    {
        $this->teachingPointsRepository = $teachingPointsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/teachingPoints",
     *      summary="Get a listing of the TeachingPoints.",
     *      tags={"TeachingPoints"},
     *      description="Get all TeachingPoints",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/TeachingPoints")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->teachingPointsRepository->pushCriteria(new RequestCriteria($request));
        $this->teachingPointsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $teachingPoints = $this->teachingPointsRepository->all();

        return $this->sendResponse($teachingPoints->toArray(), 'TeachingPoints retrieved successfully');
    }

    /**
     * @param CreateTeachingPointsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/teachingPoints",
     *      summary="Store a newly created TeachingPoints in storage",
     *      tags={"TeachingPoints"},
     *      description="Store TeachingPoints",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TeachingPoints that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TeachingPoints")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/TeachingPoints"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTeachingPointsAPIRequest $request)
    {
        $input = $request->all();

        $teachingPoints = $this->teachingPointsRepository->create($input);

        return $this->sendResponse($teachingPoints->toArray(), 'TeachingPoints saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/teachingPoints/{id}",
     *      summary="Display the specified TeachingPoints",
     *      tags={"TeachingPoints"},
     *      description="Get TeachingPoints",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TeachingPoints",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/TeachingPoints"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var TeachingPoints $teachingPoints */
        $teachingPoints = $this->teachingPointsRepository->find($id);

        if (empty($teachingPoints)) {
            return Response::json(ResponseUtil::makeError('TeachingPoints not found'), 404);
        }

        return $this->sendResponse($teachingPoints->toArray(), 'TeachingPoints retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTeachingPointsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/teachingPoints/{id}",
     *      summary="Update the specified TeachingPoints in storage",
     *      tags={"TeachingPoints"},
     *      description="Update TeachingPoints",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TeachingPoints",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TeachingPoints that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TeachingPoints")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/TeachingPoints"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTeachingPointsAPIRequest $request)
    {
        $input = $request->all();

        /** @var TeachingPoints $teachingPoints */
        $teachingPoints = $this->teachingPointsRepository->find($id);

        if (empty($teachingPoints)) {
            return Response::json(ResponseUtil::makeError('TeachingPoints not found'), 404);
        }

        $teachingPoints = $this->teachingPointsRepository->update($input, $id);

        return $this->sendResponse($teachingPoints->toArray(), 'TeachingPoints updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/teachingPoints/{id}",
     *      summary="Remove the specified TeachingPoints from storage",
     *      tags={"TeachingPoints"},
     *      description="Delete TeachingPoints",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TeachingPoints",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var TeachingPoints $teachingPoints */
        $teachingPoints = $this->teachingPointsRepository->find($id);

        if (empty($teachingPoints)) {
            return Response::json(ResponseUtil::makeError('TeachingPoints not found'), 404);
        }

        $teachingPoints->delete();

        return $this->sendResponse($id, 'TeachingPoints deleted successfully');
    }
}
