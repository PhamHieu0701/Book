<?php

namespace App\Http\Controllers\Api;

use Chaos\Support\Resolver\FilterResolver;
use Chaos\Support\Resolver\OrderResolver;
use Chaos\Support\Resolver\PagerResolver;
use Illuminate\Http\Request;

/**
 * Trait ControllerTrait.
 *
 * @author t(-.-t) <ntd1712@mail.com>
 *
 * @property \Chaos\Service\EntityRepositoryServiceInterface $service
 */
trait ControllerTrait
{
    /**
     * Displays a listing of the resource.
     * This is the default `index` action, you can override this in the derived class.
     *
     * GET /api/v1/resource
     *
     * @param Request $request The request.
     *
     * @return array|\Illuminate\Http\Response
     */
    public function indexAction(Request $request)
    {
        $input = $request->input();
        $criteria = [];

        FilterResolver::make()
            ->setPermit($this->service->repository->fieldMappings)
            ->resolve($input, $criteria);

        OrderResolver::make()
            ->setPermit($this->service->repository->fieldMappings)
            ->resolve($input, $criteria);

        if (false !== PagerResolver::make()->resolve($input, $criteria)) {
            $result = $this->service->paginate($criteria);
            $meta = [
                'current_page' => $criteria['page'],
                'from' => $result['offset'] + 1,
                'last_page' => max((int) ceil($result['total'] / $result['limit']), 1),
                'per_page' => $result['limit'],
                'to' => $result['offset'] + $result['limit'],
                'total' => $result['total']
            ];
        } else {
            $result = $this->service->search($criteria);
            $meta = [
                'total' => $result['total']
            ];
        }

        return [
            'data' => $result['data'],
            'meta' => $meta
        ];
    }

    /**
     * Shows the form for creating a new resource.
     * This is the default `create` action, you can override this in the derived class.
     *
     * GET /api/v1/resource/create
     *
     * @return array|\Illuminate\Http\Response
     */
    public function createAction()
    {
        return ['XXX'];
    }

    /**
     * Stores a newly created resource in storage.
     * This is the default `store` action, you can override this in the derived class.
     *
     * POST /api/v1/resource
     *
     * @param Request $request The request.
     *
     * @return array|\Illuminate\Http\Response
     */
    public function storeAction(Request $request)
    {
        $result = $this->service->create($request->all());

        return [
            'data' => $result
        ];
    }

    /**
     * Displays the specified resource.
     * This is the default `show` action, you can override this in the derived class.
     *
     * GET /api/v1/resource/:id
     *
     * @param mixed $id The route parameter ID.
     *
     * @return array|\Illuminate\Http\Response
     */
    public function showAction($id)
    {
        $result = $this->service->read($id);

        return [
            'data' => $result
        ];
    }

    /**
     * Shows the form for editing the specified resource.
     * This is the default `edit` action, you can override this in the derived class.
     *
     * GET /api/v1/resource/:id/edit
     *
     * @param mixed $id The route parameter ID.
     *
     * @return array|\Illuminate\Http\Response
     */
    public function editAction($id)
    {
        return ["XXX: {$id}"];
    }

    /**
     * Updates the specified resource in storage.
     * This is the default `update` action, you can override this in the derived class.
     *
     * PUT/PATCH /api/v1/resource/:id
     *
     * @param Request $request The request.
     * @param mixed $id The route parameter ID.
     *
     * @return array|\Illuminate\Http\Response
     */
    public function updateAction(Request $request, $id)
    {
        $result = $this->service->update($id, $request->all());

        return [
            'data' => $result
        ];
    }

    /**
     * Removes the specified resource(s) from storage.
     * This is the default `destroy` action, you can override this in the derived class.
     *
     * DELETE /api/v1/resource/:id [, :... ]
     *
     * @param mixed $id The route parameter ID.
     *
     * @return array|\Illuminate\Http\Response
     */
    public function destroyAction($id)
    {
        if (false !== strpos($id, ',')) {
            $id = array_fill_keys($this->service->repository->identifier, explode(',', $id));
        }

        $result = $this->service->delete($id);

        return [
            'data' => $result
        ];
    }
}
