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

    private static $db;




    abstract public function tableName() : string;
    /*
     * Get the PDO Database connection
     *
     * @return mixed
     */
    protected static function getDB()
    {
        if (self::$db === null) {
            static::$db = new \PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

            static::$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, true );
            static::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$db;

    }

}