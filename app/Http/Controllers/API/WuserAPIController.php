<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWuserAPIRequest;
use App\Http\Requests\API\UpdateWuserAPIRequest;
use App\Models\Wuser;
use App\Repositories\WuserRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Controller\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class WuserController
 * @package App\Http\Controllers\API
 */

class WuserAPIController extends AppBaseController
{
    /** @var  WuserRepository */
    private $wuserRepository;

    public function __construct(WuserRepository $wuserRepo)
    {
        $this->wuserRepository = $wuserRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/wusers",
     *      summary="Get a listing of the Wusers.",
     *      tags={"Wuser"},
     *      description="Get all Wusers",
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
     *                  @SWG\Items(ref="#/definitions/Wuser")
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
        $this->wuserRepository->pushCriteria(new RequestCriteria($request));
        $this->wuserRepository->pushCriteria(new LimitOffsetCriteria($request));
        $wusers = $this->wuserRepository->all();

        return $this->sendResponse($wusers->toArray(), 'Wusers retrieved successfully');
    }

    /**
     * @param CreateWuserAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/wusers",
     *      summary="Store a newly created Wuser in storage",
     *      tags={"Wuser"},
     *      description="Store Wuser",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Wuser that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Wuser")
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
     *                  ref="#/definitions/Wuser"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateWuserAPIRequest $request)
    {
        $input = $request->all();

        $wusers = $this->wuserRepository->create($input);

        return $this->sendResponse($wusers->toArray(), 'Wuser saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/wusers/{id}",
     *      summary="Display the specified Wuser",
     *      tags={"Wuser"},
     *      description="Get Wuser",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Wuser",
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
     *                  ref="#/definitions/Wuser"
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
        /** @var Wuser $wuser */
        $wuser = $this->wuserRepository->find($id);

        if (empty($wuser)) {
            return Response::json(ResponseUtil::makeError('Wuser not found'), 400);
        }

        return $this->sendResponse($wuser->toArray(), 'Wuser retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateWuserAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/wusers/{id}",
     *      summary="Update the specified Wuser in storage",
     *      tags={"Wuser"},
     *      description="Update Wuser",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Wuser",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Wuser that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Wuser")
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
     *                  ref="#/definitions/Wuser"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateWuserAPIRequest $request)
    {
        $input = $request->all();

        /** @var Wuser $wuser */
        $wuser = $this->wuserRepository->find($id);

        if (empty($wuser)) {
            return Response::json(ResponseUtil::makeError('Wuser not found'), 400);
        }

        $wuser = $this->wuserRepository->update($input, $id);

        return $this->sendResponse($wuser->toArray(), 'Wuser updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/wusers/{id}",
     *      summary="Remove the specified Wuser from storage",
     *      tags={"Wuser"},
     *      description="Delete Wuser",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Wuser",
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
        /** @var Wuser $wuser */
        $wuser = $this->wuserRepository->find($id);

        if (empty($wuser)) {
            return Response::json(ResponseUtil::makeError('Wuser not found'), 400);
        }

        $wuser->delete();

        return $this->sendResponse($id, 'Wuser deleted successfully');
    }
}
