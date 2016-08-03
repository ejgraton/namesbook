<?php

namespace jobeval\tests;

include 'Namesbook.php';

use jobeval as job;

class NamesbookTest extends \PHPUNIT_Framework_TestCase
{
    public function testCanBeNegated()
    {
        $nb = new job\Namesbook();
        // Assert
        $this->assertNotEmpty($nb->allNames());
    }
}
