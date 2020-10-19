<?php

namespace Chaos\Modules\Demo\Repository;

use Chaos\Entity\AbstractEntityListener;

/**
 * Class DemoListener.
 */
class DemoListener extends AbstractEntityListener
{
    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $eventArgs
     *
     * @return void
     */
    public function postPersist($eventArgs)
    {
        // echo '<pre>';
        // var_dump(func_get_args());
        // die;
    }
}
