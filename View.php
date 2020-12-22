<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/19/2019
 * Time: 3:37 PM
 * PHP Version 7
 */

namespace rpa\erektorcore;


use App\Models\User;

class View
{
    public static string $title;
    public static string $layout = 'bootstrap/';

    public static function setLayout($layout)
    {

        return self::$layout ?? self::$layout.$layout.'/';

        //return self::$layout = self::$layout.$layout.'/';
    }

    /*
     * Before filter - called before an action method
     *
     * @return void
     */
    protected function before(){}

    /*
     * After filter - called after an action method
     *
     * @return void
     */
    protected function after(){}


    public static function render($view, $args = [])
    {
        ob_start();
        echo static::renderLayout($view, $args);
        echo ob_get_clean();
    }


    public static function renderLayout($view, $args = [])
    {
        foreach ($args as $key => $value) {
            $$key = $value;
        }
        $file = "../App/Views/$view";

        try {

            include_once "../App/Views/_layouts/".self::$layout."header.php";
            include_once $file;
            include_once "../App/Views/_layouts/".self::$layout."footer.php";

        } catch (\ErrorException $e) {
            throw new \ErrorException($e->getMessage(), 404);
        }

    }


    /*
     * Render a view using Twig
     *
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        echo static::getTemplate($template, $args);
    }


    /*
     * Get the templates of a view using Twig
     *
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function getTemplate($template, $args = [])
    {

        static $twig = null;
        if ($twig === null) {
            //$loader = new \Twig_Loader_Filesystem('../App/Views');
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/../../App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('current_user', Auth::getUser());
            $twig->addGlobal('flash_messages', Flash::getMessages());
        }

        return $twig->render($template, $args);
    }
}