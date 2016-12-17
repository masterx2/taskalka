<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 17.12.16
 * Time: 17:53
 */

namespace Taskalka\Exceptions;

class RedirectNow extends \Exception {

    public $url;

    public function __construct($url) {
        $message = "Redirect";
        $code = 302;
        $previous = null;

        $this->url =$url;

        parent::__construct($message, $code, $previous);

    }
}