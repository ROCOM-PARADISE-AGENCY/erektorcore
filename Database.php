<?php
/**
 * Created by PhpStorm.
 * User: Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 * Date: 12/15/2020
 * Time: 2:03 PM
 * Erektor2 MVC Framework
 */

namespace rpa\erektorcore;


use rpa\erektorcoreConfig;
use PDO;

/**
 * Class Database
 *
 * @author Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 * @package Core
 */
abstract class Database
{

    abstract public function tableName() : string;
    /*
     * Get the PDO Database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {

            $dsn = "mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME.";charset=utf8";
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASS);

            $db->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;

    }



}