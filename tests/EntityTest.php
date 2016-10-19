<?php

namespace Tests\RecastAI;

use RecastAI\Entity;

class EntityTest extends \PHPUnit_Framework_TestCase
{

    public function testEntityClassShouldBeInstanciable()
    {
        $data1 = (object)[
            'person' => '1',
            'number' => 'singular',
            'gender' => 'unkown',
            'raw' => 'me',
        ];

        $data2 = (object)[
            'value' => 'asparagus',
            'raw' => 'asparagus',
        ];

        $this->assertInstanceOf('RecastAI\Entity', new Entity('ingredient', $data2));
    }

    public function testEntityClassShouldHaveAttributes()
    {
        $data1 = (object)[
            'person' => '1',
            'number' => 'singular',
            'gender' => 'unkown',
            'raw' => 'me',
        ];
        $data2 = (object)[
            'value' => 'asparagus',
            'raw' => 'asparagus',
        ];

        $testEntity1 = new Entity('person', $data1);
        $testEntity2 = new Entity('ingredient', $data2);

        $this->assertEquals($testEntity1->name, 'person');
        $this->assertEquals($testEntity1->person, $data1->person);
        $this->assertEquals($testEntity1->number, $data1->number);
        $this->assertEquals($testEntity1->gender, $data1->gender);
        $this->assertEquals($testEntity1->raw, $data1->raw);

        $this->assertEquals($testEntity2->name, 'ingredient');
        $this->assertEquals($testEntity2->value, $data2->value);
        $this->assertEquals($testEntity2->raw, $data2->raw);
    }
}
