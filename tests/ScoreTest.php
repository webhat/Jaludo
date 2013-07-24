<?php

namespace jaludo\score\tests;


use jaludo\Game;
use jaludo\LeaderBoardQuery;
use jaludo\score\Score;
use jaludo\score\ScoringException;
use jaludo\User;

class ScoreTest extends \PHPUnit_Framework_TestCase
{

    private $score;
    private $game;
    private $user1;
    private $user2;

    private $game_name = "jaludogame";
    private $user_name1 = "dave";
    private $user_name2 = "mike";

    public function setUp()
    {
        $this->game_name .= rand(1, 100);
        $this->user_name1 .= rand(1, 100);
        $this->user_name2 .= rand(1, 100);


        $this->game = new Game();
        $this->game->setName($this->game_name);
        $this->game->save();

        $this->user1 = new User();
        $this->user1->setUsername($this->user_name1);
        $this->user1->save();

        $this->user2 = new User();
        $this->user2->setUsername($this->user_name2);
        $this->user2->save();

        $this->score = new Score();
    }

    public function tearDown()
    {
        $this->lb = LeaderBoardQuery::create()
            ->filterByGameid($this->game->getId())->find();

        $this->lb->delete();
        $this->game->delete();
        $this->user1->delete();
        $this->user2->delete();
    }

    public function testSetScore()
    {
        $id = $this->game->getId();
        $expected = array(
            score => 20,
            game => $this->game_name,
            user => $this->user_name1
        );
        $this->score->setScore($expected);

        $actual = $this->score->getScoreByUser($expected["user"]);

        $this->assertEquals($expected, $actual);
    }


    public function testGetHighScores()
    {
        $id = $this->game->getId();
        $score1 = array(
            score => 20,
            game => $this->game_name,
            user => $this->user_name1
        );
        $score2 = array(
            score => 21,
            game => $this->game_name,
            user => $this->user_name2
        );
        $this->score->setScore($score1);
        $this->score->setScore($score2);

        $actual = $this->score->getScoresByGame($this->game_name);

        // echo json_encode($actual); // DEBUG

        unset($score1['game']);
        unset($score2['game']);

        $expected = array(
            $this->game_name =>
            array($score1, $score2)
        );

        $this->assertEquals($expected, $actual);
    }

    public function testGetHighScoresToday()
    {
        $id = $this->game->getId();
        $score1 = array(
            score => 20,
            game => $this->game_name,
            user => $this->user_name1
        );
        $score2 = array(
            score => 21,
            game => $this->game_name,
            user => $this->user_name2
        );
        $this->score->setScore($score1);
        $this->score->setScore($score2);

        $actual = $this->score->getScoresByGame($this->game_name, true);

        //echo json_encode($actual); // DEBUG

        unset($score1['game']);
        unset($score2['game']);

        $expected = array(
            $this->game_name =>
            array($score1, $score2)
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException ScoringException
     *
     * Reflection Error in PHPUnit
     */
    public function broke()
    {
        $this->score->getScoresByGame("");
    }


}
