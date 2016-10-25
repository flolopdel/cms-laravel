<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductTypeAPIRequest;
use App\Http\Requests\API\UpdateProductTypeAPIRequest;
use App\Models\ProductType;
use App\Repositories\ProductTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProductTypeController
 * @package App\Http\Controllers\API
 */

class ProductTypeAPIController extends InfyOmBaseController
{
    /** @var  ProductTypeRepository */
    private $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepo)
    {
        $this->productTypeRepository = $productTypeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/productTypes",
     *      summary="Get a listing of the ProductTypes.",
     *      tags={"ProductType"},
     *      description="Get all ProductTypes",
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
     *                  @SWG\Items(ref="#/definitions/ProductType")
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
        $this->productTypeRepository->pushCriteria(new RequestCriteria($request));
        $this->productTypeRepository->pushCriteria(new LimitOffsetCriteria($request));
        $productTypes = $this->productTypeRepository->all();

        return $this->sendResponse($productTypes->toArray(), 'ProductTypes retrieved successfully');
    }

    /**
     * @param CreateProductTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/productTypes",
     *      summary="Store a newly created ProductType in storage",
     *      tags={"ProductType"},
     *      description="Store ProductType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductType")
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
     *                  ref="#/definitions/ProductType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductTypeAPIRequest $request)
    {
        $input = $request->all();

        $productTypes = $this->productTypeRepository->create($input);

        return $this->sendResponse($productTypes->toArray(), 'ProductType saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/productTypes/{id}",
     *      summary="Display the specified ProductType",
     *      tags={"ProductType"},
     *      description="Get ProductType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductType",
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
     *                  ref="#/definitions/ProductType"
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
        /** @var ProductType $productType */
        $productType = $this->productTypeRepository->find($id);

        if (empty($productType)) {
            return Response::json(ResponseUtil::makeError('ProductType not found'), 404);
        }

        return $this->sendResponse($productType->toArray(), 'ProductType retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProductTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/productTypes/{id}",
     *      summary="Update the specified ProductType in storage",
     *      tags={"ProductType"},
     *      description="Update ProductType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductType")
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
     *                  ref="#/definitions/ProductType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductType $productType */
        $productType = $this->productTypeRepository->find($id);

        if (empty($productType)) {
            return Response::json(ResponseUtil::makeError('ProductType not found'), 404);
        }

        $productType = $this->productTypeRepository->update($input, $id);

        return $this->sendResponse($productType->toArray(), 'ProductType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/productTypes/{id}",
     *      summary="Remove the specified ProductType from storage",
     *      tags={"ProductType"},
     *      description="Delete ProductType",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductType",
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
        /** @var ProductType $productType */
        $productType = $this->productTypeRepository->find($id);

        if (empty($productType)) {
            return Response::json(ResponseUtil::makeError('ProductType not found'), 404);
        }

        $productType->delete();

        return $this->sendResponse($id, 'ProductType deleted successfully');
    }
}
