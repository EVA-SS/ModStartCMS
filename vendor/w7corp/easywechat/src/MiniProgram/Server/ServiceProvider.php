<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace EasyWeChat\MiniProgram\Server;

use EasyWeChat\MiniProgram\Encryptor;
use EasyWeChat\OfficialAccount\Server\Guard;
use EasyWeChat\OfficialAccount\Server\Handlers\EchoStrHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        !isset($app['encryptor']) && ($app['encryptor'] = function ($app) {
            return new Encryptor($app['config']['app_id'], $app['config']['token'], $app['config']['aes_key']);
        });
        !isset($app['server']) && ($app['server'] = function ($app) {
            $guard = new Guard($app);
            $guard->push(new EchoStrHandler($app));
            return $guard;
        });
    }
}