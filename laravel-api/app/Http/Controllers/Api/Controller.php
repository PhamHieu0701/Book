<?php

namespace App\Http\Controllers\Api;

use Chaos\Support\Config\VarsConfigAdapter;
use Chaos\Support\Container\ContainerAware;
use Chaos\Support\Doctrine\ManagerRegistry;
use Chaos\Support\Doctrine\ODM\DocumentManagerFactory;
use Chaos\Support\Doctrine\ORM\EntityManagerFactory;
use Chaos\Support\Messenger\LaravelEventDispatcherAdapter;
use Chaos\Support\Serializer\SerializerFactory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\RouteDependencyResolverTrait;
use M1\Vars\Vars;

/**
 * Class Controller.
 *
 * A controller can call multiple services.
 *
 * <code>
 * public function __construct(
 *   LookupService $lookupService,
 *   DashboardService $dashboardService,
 *   DashboardRepository $dashboardRepository
 * ) {
 *   parent::__construct(
 *     $this->service = $lookupService,
 *     $this->dashboardService = $dashboardService,
 *     $this->dashboardRepository = $dashboardRepository
 *   );
 * }
 * </code>
 *
 * @author t(-.-t) <ntd1712@mail.com>
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use ContainerAware;
    use ControllerTrait;
    use RouteDependencyResolverTrait;

    /**
     * The Container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->setContainer($this->container = app());

        // <editor-fold defaultstate="collapsed" desc="Initializes Config">

        $basePath = $this->container->basePath();
        $config = $this->container['config'];

        $vars = new VarsConfigAdapter(
            new Vars(
                array_merge(
                    glob($basePath . '/modules/core/*/config.yml', GLOB_NOSORT),
                    glob($basePath . '/modules/app/*/config.yml', GLOB_NOSORT),
                    [$basePath . '/modules/config.yml']
                ),
                [
                    'cache' => $this->container->isProduction(),
                    'cache_path' => $basePath . '/storage/framework/cache',
                    'loaders' => ['yaml'],
                    'merge_globals' => false,
                    'replacements' => [
                        'base_path' => $basePath,
                        'app' => $config['app'],
                        'db' => $config['database.connections'][$config['database.default']]
                    ]
                ]
            )
        );
        $this->container->instance('vars', $vars);

        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="Initializes Dispatcher">

        $dispatcher = new LaravelEventDispatcherAdapter(app('events'));
        $this->container->instance('dispatcher', $dispatcher);

        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="Initializes Doctrine">

        try {
            $connections = $managers = [];

            foreach ($vars['doctrine']['connections'] as $id => $name) {
                $connections[$id] = $id . '_connection'; // e.g. ['default' => 'default_connection']
            }

            if (isset($vars['doctrine']['entity_managers'])) {
                foreach ($vars['doctrine']['entity_managers'] as $id => $name) {
                    /* @var \Doctrine\ODM\MongoDB\DocumentManager|\Doctrine\ORM\EntityManager $manager */
                    $this->container->instance(
                        $managers[$id] = $id . '_entity_manager',
                        $manager = (new EntityManagerFactory())($this->container, $id, $vars['doctrine'])
                    );
                    $this->container->instance($connections[$name['connection']], $manager->getConnection());
                }
            }

            if (isset($vars['doctrine']['document_managers'])) {
                foreach ($vars['doctrine']['document_managers'] as $id => $name) {
                    $this->container->instance(
                        $managers[$id] = $id . '_document_manager',
                        $manager = (new DocumentManagerFactory())($this->container, $id, $vars['doctrine'])
                    );
                    $this->container->instance($connections[$name['connection']], $manager->getClient());
                }
            }

            $doctrine = new ManagerRegistry(
                'anonymous',
                $connections,
                $managers,
                'default',
                'default',
                $vars['doctrine']['proxy_interface_name']
            );
            $doctrine->setContainer($this->container);

            $this->container->instance('doctrine', $doctrine);
        } catch (\Exception $exception) {
            @header('HTTP/1.1 503 Service Unavailable.', true, 503);
            echo 'The application environment is not set correctly.';
            exit(1);
        }

        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="Initializes Serializer">

        $serializer = (new SerializerFactory())($this->container, null, $vars['serializer']);
        $this->container->instance('serializer', $serializer);

        // </editor-fold>

        foreach (func_get_args() as $service) {
            $this->container->instance(get_class($service), $service($this->container, null));
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param string $method The method to be called.
     * @param array $parameters The parameters to be passed.
     *
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if (!method_exists($this, $method)) {
            $parameters = $this->resolveClassMethodDependencies(
                request()->route()->parametersWithoutNulls(),
                $this,
                $method = "{$method}Action"
            );
        }

        return call_user_func_array([$this, $method], $parameters);
    }
}
