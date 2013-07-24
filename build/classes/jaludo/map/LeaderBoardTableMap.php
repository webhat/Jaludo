<?php

namespace jaludo\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'leaderboard' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.jaludo.map
 */
class LeaderBoardTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'jaludo.map.LeaderBoardTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('leaderboard');
        $this->setPhpName('LeaderBoard');
        $this->setClassname('jaludo\\LeaderBoard');
        $this->setPackage('jaludo');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('userid', 'Userid', 'INTEGER', true, null, null);
        $this->addColumn('gameid', 'Gameid', 'INTEGER', true, null, null);
        $this->addColumn('score', 'Score', 'INTEGER', true, null, null);
        $this->addColumn('when', 'date', 'INTEGER', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // LeaderBoardTableMap
