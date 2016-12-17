<?php


namespace Taskalka\Controllers;

use Taskalka\ControllerAbstract;


/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 16.12.16
 * Time: 3:03
 */
class Home extends ControllerAbstract {
    public function indexAction() {
        return [
            'user' => $this->user
        ];
    }
}