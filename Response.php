<?php
/**
 * Created by PhpStorm.
 * User: Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 * Date: 12/7/2020
 * Time: 4:31 PM
 * Erektor2 MVC Framework
 */

namespace rpa\erektorcore;


/**
 * Class Response
 *
 * @author Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 *
 */
class Response
{

    public static int $code = 200;

    public static function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public static function redirect(string $url) : void
    {

        header('Location: https://'. $_SERVER['HTTP_HOST'] .$url, true);
        exit;
    }


    /*
 * Remember the originally-requested page in the session
 *
 * @return void;
 */
    public static function rememberRequestedPage()
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }


    /*
     * Get the originally-requested page to return to after requiring login, or default to the homepage
     *
     * @return void;
     */
    public static function getReturnToPage()
    {
        return $_SESSION['return_to'] ?? '/';
    }
}