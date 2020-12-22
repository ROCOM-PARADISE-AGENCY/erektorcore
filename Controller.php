<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/19/2019
 * Time: 1:40 PM
 * PHP Version 7
 */

namespace rpa\erektorcore;

use App\Models\Post;
use rpa\erektorcore\Auth;
use rpa\erektorcore\Flash;
use rpa\erektorcore\Tracker;


/*
 * Base Controller
 *
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }


    public function __call($name, $args)
    {
        $method = $name.'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {

                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Error('<h1 class="display-1 fw-bold my-5">404 - Not found !</h1>');
        }
    }


    /*
     * Before filter - called before an action method
     *
     * @return void
     */
    protected function before()
    {
        /*
         * The Tracker is in beta for the moment
         */
        //$tracker = new Tracker();
    }


    /*
     * After filter - called after an action method
     *
     * @return void
     */
    protected function after()
    {

    }


    /*
     * Redirect to different page
     *
     * @param string $url The relative URL
     *
     * @return void
     */
    public static function redirect($url)
    {
        return Response::redirect($url);
    }


    /*
     * Require the user to be logged in before giving access to the  requested page.
     * Remember the requested page for later, then redirect to the login page.
     *
     * @return void
     */
    public function requireLogin()
    {

        if ( !Auth::getUser() ) {
            Flash::addMessage('Please login to acces that page', Flash::INFO);
            Application::$app->response::rememberRequestedPage();
            Application::$app->response::redirect('/login');
        }
    }
}