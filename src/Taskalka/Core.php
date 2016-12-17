<?php

namespace Taskalka;

use Fenom;
use Pimple\Container;
use Symfony\Component\HttpFoundation\Request;
use Taskalka\Exceptions\PageError;
use Taskalka\Exceptions\RedirectNow;
use Taskalka\Models\User;
use Taskalka\ServiceProviders\MongoDbServiceProvider;

/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 16.12.16
 * Time: 1:56
 */
class Core {

    use DbHelper;

    /** @var Container */
    public $container;

    /** @var Fenom  */
    public $fenom;

    function __construct() {
        $this->container = new Container();
        $this->container->register(new MongoDbServiceProvider());

        $this->fenom = Fenom::factory(
            ROOT.'/templates',
            ROOT.'/var/compiled',
            Fenom::FORCE_COMPILE
        );
    }

    public function dispatch(Request $request) {
        $ctrPath = "Taskalka\\Controllers\\";

        $reqUri = $request->getRequestUri();
        $parts = $reqUri == '/' ? [] : explode('/', substr($reqUri, 1));
        $ctrl = count($parts) == 0 ? $ctrPath.'Home' : $ctrPath.ucfirst($parts[0]);
        $originalCtrlName = count($parts) == 0 ? 'home' : strtolower($parts[0]);
        $sid = $request->cookies->getAlnum('tsk-user');

        // #TODO Заебенить кастомных эксепшенов на все случаи жизни)
        // #TODO Вкорячить сюда проверку на залогиненость

        try {

            if ($sid) {
                $this->container['user'] = User::fromCollection(
                    ['sessionId' => $sid],
                    $this->getCollection('users')
                );
            }

            if (!class_exists($ctrl)) {
                throw new \Exception("Controller ".$ctrl." not found!");
            }

            /** @var ControllerAbstract $controller */
            $controller = new $ctrl($request, $this->container);

            $method = count($parts) > 1 ? ucfirst($parts[1]) : 'index';
            if (!method_exists($controller, $method.'Action')) {
                throw new \Exception("Method $method not found!");
            }

            try {
                $result = call_user_func_array([$controller,$method.'Action'], $parts);
            } catch (PageError $e) {
                $result = ["error" => $e->getMessage()];
            } catch (RedirectNow $e) {
                // заебись работает =)
                $controller->response->headers->set('Location', $e->url);
                die();
            }

            unset($controller);

            $methodTemplate = $originalCtrlName.'/'.strtolower($method).'.tpl';
            $template = $this->fenom->templateExists($methodTemplate) ? $methodTemplate : 'default.tpl';

            $this->fenom->display([$template, 'layout.tpl'], [
                'content' => $result
            ]);

        } catch (\Exception $e) {
            $this->fenom->display('error.tpl', [
                "message" => $e->getMessage()
            ]);
        }
    }
}