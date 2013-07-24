<?php

namespace jaludo\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use jaludo\LeaderBoard;
use jaludo\LeaderBoardPeer;
use jaludo\LeaderBoardQuery;

/**
 * Base class that represents a query for the 'leaderboard' table.
 *
 *
 *
 * @method LeaderBoardQuery orderById($order = Criteria::ASC) Order by the id column
 * @method LeaderBoardQuery orderByUserid($order = Criteria::ASC) Order by the userid column
 * @method LeaderBoardQuery orderByGameid($order = Criteria::ASC) Order by the gameid column
 * @method LeaderBoardQuery orderByScore($order = Criteria::ASC) Order by the score column
 * @method LeaderBoardQuery orderBydate($order = Criteria::ASC) Order by the when column
 *
 * @method LeaderBoardQuery groupById() Group by the id column
 * @method LeaderBoardQuery groupByUserid() Group by the userid column
 * @method LeaderBoardQuery groupByGameid() Group by the gameid column
 * @method LeaderBoardQuery groupByScore() Group by the score column
 * @method LeaderBoardQuery groupBydate() Group by the when column
 *
 * @method LeaderBoardQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method LeaderBoardQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method LeaderBoardQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method LeaderBoard findOne(PropelPDO $con = null) Return the first LeaderBoard matching the query
 * @method LeaderBoard findOneOrCreate(PropelPDO $con = null) Return the first LeaderBoard matching the query, or a new LeaderBoard object populated from the query conditions when no match is found
 *
 * @method LeaderBoard findOneByUserid(int $userid) Return the first LeaderBoard filtered by the userid column
 * @method LeaderBoard findOneByGameid(int $gameid) Return the first LeaderBoard filtered by the gameid column
 * @method LeaderBoard findOneByScore(int $score) Return the first LeaderBoard filtered by the score column
 * @method LeaderBoard findOneBydate(int $when) Return the first LeaderBoard filtered by the when column
 *
 * @method array findById(int $id) Return LeaderBoard objects filtered by the id column
 * @method array findByUserid(int $userid) Return LeaderBoard objects filtered by the userid column
 * @method array findByGameid(int $gameid) Return LeaderBoard objects filtered by the gameid column
 * @method array findByScore(int $score) Return LeaderBoard objects filtered by the score column
 * @method array findBydate(int $when) Return LeaderBoard objects filtered by the when column
 *
 * @package    propel.generator.jaludo.om
 */
abstract class BaseLeaderBoardQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseLeaderBoardQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'jaludo', $modelName = 'jaludo\\LeaderBoard', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new LeaderBoardQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   LeaderBoardQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return LeaderBoardQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof LeaderBoardQuery) {
            return $criteria;
        }
        $query = new LeaderBoardQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   LeaderBoard|LeaderBoard[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = LeaderBoardPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(LeaderBoardPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 LeaderBoard A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 LeaderBoard A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `userid`, `gameid`, `score`, `when` FROM `leaderboard` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new LeaderBoard();
            $obj->hydrate($row);
            LeaderBoardPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return LeaderBoard|LeaderBoard[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|LeaderBoard[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LeaderBoardPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LeaderBoardPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LeaderBoardPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LeaderBoardPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LeaderBoardPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the userid column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE userid = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE userid IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE userid >= 12
     * $query->filterByUserid(array('max' => 12)); // WHERE userid <= 12
     * </code>
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(LeaderBoardPeer::USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(LeaderBoardPeer::USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LeaderBoardPeer::USERID, $userid, $comparison);
    }

    /**
     * Filter the query on the gameid column
     *
     * Example usage:
     * <code>
     * $query->filterByGameid(1234); // WHERE gameid = 1234
     * $query->filterByGameid(array(12, 34)); // WHERE gameid IN (12, 34)
     * $query->filterByGameid(array('min' => 12)); // WHERE gameid >= 12
     * $query->filterByGameid(array('max' => 12)); // WHERE gameid <= 12
     * </code>
     *
     * @param     mixed $gameid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function filterByGameid($gameid = null, $comparison = null)
    {
        if (is_array($gameid)) {
            $useMinMax = false;
            if (isset($gameid['min'])) {
                $this->addUsingAlias(LeaderBoardPeer::GAMEID, $gameid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($gameid['max'])) {
                $this->addUsingAlias(LeaderBoardPeer::GAMEID, $gameid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LeaderBoardPeer::GAMEID, $gameid, $comparison);
    }

    /**
     * Filter the query on the score column
     *
     * Example usage:
     * <code>
     * $query->filterByScore(1234); // WHERE score = 1234
     * $query->filterByScore(array(12, 34)); // WHERE score IN (12, 34)
     * $query->filterByScore(array('min' => 12)); // WHERE score >= 12
     * $query->filterByScore(array('max' => 12)); // WHERE score <= 12
     * </code>
     *
     * @param     mixed $score The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function filterByScore($score = null, $comparison = null)
    {
        if (is_array($score)) {
            $useMinMax = false;
            if (isset($score['min'])) {
                $this->addUsingAlias(LeaderBoardPeer::SCORE, $score['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($score['max'])) {
                $this->addUsingAlias(LeaderBoardPeer::SCORE, $score['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LeaderBoardPeer::SCORE, $score, $comparison);
    }

    /**
     * Filter the query on the when column
     *
     * Example usage:
     * <code>
     * $query->filterBydate(1234); // WHERE when = 1234
     * $query->filterBydate(array(12, 34)); // WHERE when IN (12, 34)
     * $query->filterBydate(array('min' => 12)); // WHERE when >= 12
     * $query->filterBydate(array('max' => 12)); // WHERE when <= 12
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function filterBydate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(LeaderBoardPeer::WHEN, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(LeaderBoardPeer::WHEN, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LeaderBoardPeer::WHEN, $date, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   LeaderBoard $leaderBoard Object to remove from the list of results
     *
     * @return LeaderBoardQuery The current query, for fluid interface
     */
    public function prune($leaderBoard = null)
    {
        if ($leaderBoard) {
            $this->addUsingAlias(LeaderBoardPeer::ID, $leaderBoard->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
