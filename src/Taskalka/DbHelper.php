<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 17.12.16
 * Time: 18:07
 */

namespace Taskalka;


use MongoDB\Collection;

trait DbHelper {
    function getCollection($name) {
        /** @var Collection $usersCollection */
        return $this->container[$name.'.collection'];
    }
}