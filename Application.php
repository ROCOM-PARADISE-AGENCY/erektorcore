<?php
/**
 * Created by PhpStorm.
 * User: Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 * Date: 12/15/2020
 * Time: 1:58 PM
 * Erektor2 MVC Framework
 */

namespace rpa\erektorcore;


use rpa\erektorcore\Request;
use rpa\erektorcore\Response;
use rpa\erektorcore\View;


/**
 * Class Application
 *
 * @author Negoiţă Paul Alexandru ( alexnegoita88@gmail.com )
 * @package Core
 */
class Application
{

    public Router $router;
    public Request $request;
    public Response $response;
    public Model $model;
    public View $view;
    public ?Controller $controller = null;
    public static Application $app;


    public function __construct($config)
    {
        $this->config = $config;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->controller = $controller ?? null;
        $this->model = new Model($this->config);
        $this->view = new View();
        $this->flash_messages = Flash::getMessages();
        $this->current_user = Auth::getUser();
        self::$app = $this;
    }


    public function run() : void
    {
        try {
            $this->router->dispatch($this->request->getPath());
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            View::render('_error.php', [
                'message' => $e->getMessage()
            ]);
        }
    }


}