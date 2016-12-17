<?php

/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 16.12.16
 * Time: 2:16
 */

namespace Taskalka\ServiceProviders;

use MongoDB\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MongoDbServiceProvider implements ServiceProviderInterface {
    public function register(Container $container) {
        $container['mongodb'] = function() {
            return new Client();
        };

        $container['users.collection'] = function ($c) {
            /** @var Client $client */
            $client = $c['mongodb'];
            $db = $client->taskalka;
            return $db->users;
        };
    }
}