<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\Controller as BaseController;
use Chaos\Modules\Demo\Service\DemoService;

/**
 * Class DemoController.
 *
 * @property \Chaos\Service\EntityRepositoryServiceInterface $lookupService
 * @property \Chaos\Service\DocumentRepositoryServiceInterface $mongoService
 * @property \Chaos\Repository\DocumentRepositoryInterface $mongoRepository
 */
class DemoController extends BaseController
{
    /**
     * {@inheritDoc}
     *
     * GET /api/v1/demo
     *
     * @param DemoService $demoService
     * @param mixed $lookupService
     * @param mixed $mongoService
     * @param mixed $mongoRepository
     */
    public function __construct(
        DemoService $demoService,
        \Chaos\Modules\Lookup\Service\LookupService $lookupService,
        \Chaos\Modules\Mongo\Service\MongoService $mongoService,
        \Chaos\Modules\Mongo\Repository\MongoRepository $mongoRepository
    ) {
        parent::__construct(
            $this->service = $demoService,
            $this->lookupService = $lookupService,
            $this->mongoService = $mongoService,
            $this->mongoRepository = $mongoRepository
        );
    }

    /**
     * {@inheritDoc}
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Exception
     *
     * @return array|\Illuminate\Http\Response
     */
    public function index2(\App\Http\Requests\DemoRequest $request)
    {
        echo '<pre>';
        var_dump(get_class($request), $request->all());
        die;
    }

    /**
     * {@inheritDoc}
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Exception
     *
     * @return array|\Illuminate\Http\Response
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // $this->getDispatcher()->dispatch(
        //     new \Chaos\Support\Messenger\Event(
        //         'foo',
        //         $argv = ['entity' => 'entity2', 'input' => 'input2', 'options' => 'options2', 'context' => $this]
        //     )
        // );
        // die;

        // $mongo = new \Chaos\Modules\Mongo\Document\Mongo;
        // $mongo->Name = 'Name ' . bin2hex(random_bytes(5));
        // $mongo->Email = 'Email ' . bin2hex(random_bytes(5));
        // $this->mongoRepository->create($mongo);
        // $this->mongoRepository->flush();

        // $this->mongoService->create(['Name' => bin2hex(random_bytes(5))]);
        // $this->mongoService->update(['Id' => '5e364d2720832c566952e2f2', 'Name' => bin2hex(random_bytes(5))]);
        // $this->mongoService->delete('5e3bccddfc099539b54f30f2');

        // $dm = $this->getDoctrine()->getManagerForClass(get_class($mongo));
        // $dm->persist($mongo);
        // $dm->flush();

        // $lookup = $this->lookupService->read(1);
        // $lookup->Name = 'Male 2';
        // echo '<pre>';var_dump($lookup->Name);die;

        // $findOneBy = $this->mongoRepository->findOneBy(['Id' => '5f0e84d4e4792d4de275ee12']);
        // $findOneBy->setContainer($this->getContainer());

        /* @var \Doctrine\ODM\MongoDB\Query\Builder $qb */
        $qb = $this->mongoRepository->getQueryBuilder(
            [
                'select' => 'Email'
            ]
        );

        $result = [
            'lookup' => $this->lookupService->search([]),
            'demo' => $this->service->search([]),
            'mongo' => [
                'builder' => $qb->getQuery()->execute()->toArray(),
                // 'findAll' => $this->getSerializer()->toArray($this->mongoRepository->findAll()),
                // 'find' => $this->mongoRepository->find('5e2282c50900b824b64ddda2'),
                // 'findOneBy' => $findOneBy
            ]
        ];

        return [
            'etag' => sha1(serialize($result)),
            'data' => $result
        ];
    }
}
