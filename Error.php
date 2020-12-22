<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/19/2019
 * Time: 8:13 PM
 * PHP Version 7
 */


namespace rpa\erektorcore;

use ErrorException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use rpa\erektorcore\Config;
/*
 * Error and exception handler
 */
class Error
{
    /*
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException
     *
     * @param int $level Error level
     * @param string $message Error message
     * @param string $file Filename the error was raised in
     * @param int $line Line number
     *
     * @return void
     */

    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) { // to keep the @ operator working
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /*
     * Exception handler.
     *
     * @param Exception $exception The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        //Code is 404 (not found) or 500 (general error)
        $code = (int) $exception->getCode();

        http_response_code($code);

        if ( Config::SHOW_ERRORS === true ) {
            echo "<h1>Fatal Error</h1>";
            echo "<p>Uncaught exception: ".get_class($exception)."</p>";
            echo "<p>Message: ".$exception->getMessage()."</p>";
            echo "<p>Stack trace:<pre>".$exception->getTraceAsString()."</pre></p>";
            echo "<p>Thrown in: ".$exception->getFile()." on line ".$exception->getLine()."</p>";
        } else {

            $log = dirname(__DIR__).'/logs/'.date('Y-m-d').'.txt';
            ini_set('error_log', $log);

            $message  = "Uncaught exception: ".get_class($exception);
            $message .= " with message '".$exception->getMessage()."'";
            $message .= "\nStack trace: ".$exception->getTraceAsString();
            $message .= "\nThrown in ".$exception->getFile()." on line ".$exception->getLine();

            error_log($message);
            View::renderLayout("_error.php", ['message' => $exception->getMessage(), 'code' => $exception->getCode()]);


            /*
            * Here should enter in action MonoLogger
            *
            *
            $dir = dirname(__DIR__).'/logs/'.date('Y-m-d').'-monoLogger.txt';

            $log = new Logger($exception->getCode());
            $log->pushHandler(new StreamHandler($dir, Logger::WARNING));

            // add records to the log
            $log->warning($exception->getMessage());
            $log->warning($exception->getTraceAsString());
            $log->warning("Thrown in ".$exception->getFile()." on line ".$exception->getLine());
            //$log->error('Bar');
            View::renderTemplate("$code.html");
            */
        }
    }
}