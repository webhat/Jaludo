<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danielcrompton
 * Date: 7/23/13
 * Time: 9:33 PM
 * To change this template use File | Settings | File Templates.
 */

namespace jaludo\score;


use jaludo\Game;
use jaludo\GameQuery;
use jaludo\LeaderBoard;
use jaludo\LeaderBoardQuery;
use jaludo\UserQuery;
use jaludo\score\ScoringException;

class Score
{
    private $game;
    private $user;
    private $lb;

    public function setScore($data)
    {
        $this->user = UserQuery::create()->filterByUsername($data['user'])->findOne();
        $this->game = GameQuery::create()->filterByName($data['game'])->findOne();

        $lb = new LeaderBoard();
        if(!is_object($this->user))
            throw new ScoringException("Missing user in DB");
        $lb->setUserid($this->user->getId());

        if(!is_object($this->game))
            throw new ScoringException("Missing game in DB");
        $lb->setGameid($this->game->getId());
        $lb->setdate(time());
        $lb->setScore($data['score']);
        $lb->save();
    }

    public function getScoreByUser($user)
    {
        $this->user = UserQuery::create()->filterByUsername($user)->findOne();
        $this->lb = LeaderBoardQuery::create()
            ->filterByGameid($this->game->getId())
            ->filterByUserid($this->user->getId())->findOne();

        $ret = array(
            score => $this->lb->getScore(),
            game => $this->game->getName(),
            user => $user
        );

        return $ret;
    }

    public function getScoresByGame($game = "", $today = false)
    {
        if(!is_string($game))
            throw new ScoringException("Missing name for game");

        $this_day = 0;

        if ($today) {
            $now = time();
            $this_day = $now - ($now % 86400);
        }

        $this->game = GameQuery::create()->filterByName($game)->findOne();

        if(!is_object($this->game))
            throw new ScoringException("Missing game in DB");


        $lb = LeaderBoardQuery::create()
            ->filterBy("date", $this_day, \Criteria::GREATER_EQUAL)
            ->orderBy("score")
            ->findByGameid($this->game->getId());

        $leaderboard = array($game => array());
        $i = 0;
        foreach ($lb as $elem) {
            $user = UserQuery::create()->findOneById($elem->getUserid());
            $leaderboard[$game][$i++] = array(
                "user" => $user->getUsername(),
                "score" => $elem->getScore()
            );
        }

        return $leaderboard;
    }
}