<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danielcrompton
 * Date: 7/23/13
 * Time: 10:43 PM
 * To change this template use File | Settings | File Templates.
 */

namespace jaludo\score\tests;


use jaludo\Game;
use jaludo\GameQuery;

class GameTest extends \PHPUnit_Framework_TestCase
{
    public $game;

    public function setUp()
    {
        $this->game = new Game();
        $this->game->setName('jaludogame');
        $this->game->save();
    }

    public function tearDown()
    {
        $this->game->delete();
    }

    public function testGame()
    {
        $expected = $this->game->getName();

        $game = GameQuery::create()->filterByName($expected)->findOne();

        $actual = $game->getName();

        $this->assertEquals($expected, $actual);
    }
}
