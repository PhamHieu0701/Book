<?php

namespace Chaos\Modules\Mongo\Document;

use Chaos\Entity\Document;
use Chaos\Entity\Mixin\DocumentIdTrait;

/**
 * Class Mongo.
 *
 * @Doctrine\ODM\MongoDB\Mapping\Annotations\Document(repositoryClass="Chaos\Modules\Mongo\Repository\MongoRepository")
 */
class Mongo extends Document
{
    use DocumentIdTrait;

    /**
     * @Doctrine\ODM\MongoDB\Mapping\Annotations\Field(type="string")
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $Name;

    /**
     * @Doctrine\ODM\MongoDB\Mapping\Annotations\Field(type="string")
     * @JMS\Serializer\Annotation\Type("string")
     */
    protected $Email;
}
