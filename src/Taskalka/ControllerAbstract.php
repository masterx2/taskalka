<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 17.12.16
 * Time: 2:08
 */

namespace Taskalka;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Taskalka\Models\User;

class ControllerAbstract {

    use DbHelper;

    /** @var Request  */
    public $request;
    /** @var Response */
    public $response;
    /** @var Container */
    public $container;
    /** @var User */
    public $user;

    function __construct(Request $request, Container $container) {
        $this->request = $request;
        $this->container = $container;
        $this->response = new Response();
        $this->response->prepare($request);

        $this->user = isset($this->container['user']) ? $this->container['user'] : false;
    }

    /**
     * Въебашить куку
     *
     * @param string $name Имя
     * @param string $value Значение
     * @param int $ttl Время в секундах
     */
    function setCookie($name, $value, $ttl) {
        // Без проверок. в жопу проверки
        $this->response->headers->setCookie(
            new Cookie($name, $value, time()+$ttl)
        );
    }

    function redirect($url) {
        // О! А так заебись)
        $this->response->headers->set('Location', $url);
    }

    function __destruct() {
        $this->response->sendHeaders();
    }
}