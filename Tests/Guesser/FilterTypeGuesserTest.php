<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DoctrineMongoDBAdminBundle\Tests\Guesser;

use Sonata\DoctrineMongoDBAdminBundle\Guesser\FilterTypeGuesser;

class FilterTypeGuesserTest extends \PHPUnit_Framework_TestCase
{
    private $guesser;
    private $modelManager;
    private $metadata;

    protected function setUp()
    {
        $this->guesser = new FilterTypeGuesser();
        $this->modelManager = $this->prophesize('Sonata\DoctrineMongoDBAdminBundle\Model\ModelManager');
        $this->metadata = $this->prophesize('Doctrine\ODM\MongoDB\Mapping\ClassMetadata');
    }

    /**
     * @expectedException \Sonata\DoctrineMongoDBAdminBundle\Model\MissingPropertyMetadataException
     */
    public function testThrowsOnMissingField()
    {
        $class = 'My\Model';
        $property = 'whatever';
        $this->modelManager->getParentMetadataForProperty($class, $property)->willReturn(array(
            $this->metadata->reveal(),
            $property,
            'parent mappings, no idea what it looks like',
        ));
        $this->guesser->guessType($class, $property, $this->modelManager->reveal());
    }
}
