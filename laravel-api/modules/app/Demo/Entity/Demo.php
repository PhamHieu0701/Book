<?php

namespace Chaos\Modules\Demo\Entity;

use Chaos\Entity\Entity;
use Chaos\Entity\Mixin\EntityAppTrait;
use Chaos\Entity\Mixin\EntityAuditTrait;
use Chaos\Entity\Mixin\EntityIdTrait;
use Chaos\Entity\Mixin\EntityStatusTrait;
use Chaos\Entity\Mixin\EntityVersionTrait;

/**
 * Class Demo.
 *
 * @Doctrine\ORM\Mapping\Entity(repositoryClass="Chaos\Modules\Demo\Repository\DemoRepository")
 * @Doctrine\ORM\Mapping\EntityListeners({ "Chaos\Modules\Demo\Repository\DemoListener" })
 * @Doctrine\ORM\Mapping\Table(name="demo")
 */
class Demo extends Entity
{
    use EntityIdTrait, EntityStatusTrait, EntityAuditTrait, EntityVersionTrait, EntityAppTrait;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string", name="vehicle_id")
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $VehicleId;

    /**
     * @Doctrine\ORM\Mapping\Column(type="datetime", name="start_time", nullable=true)
     * @JMS\Serializer\Annotation\Type("DateTime<'Y-m-d'>")
     */
    protected $StartTime;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string", name="place")
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $Place;
}
