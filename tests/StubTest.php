<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danielcrompton
 * Date: 7/23/13
 * Time: 8:50 PM
 * To change this template use File | Settings | File Templates.
 */

namespace jaludo\score\tests;


use jaludo\score\Stub;

class StubTest extends \PHPUnit_Framework_TestCase {
    public $stub;

    public function setUp() {
        $this->stub = new Stub();
    }

    public function testSet() {
        $expected = "test";
        $actual = "";
        $this->stub->setMe($expected);

        $actual = $this->stub->getMe();

        $this->assertEquals($expected,$actual);
    }
}
