<?php
/*
 * This file is part of the DislikeNotifier Application
 *
 * (c) Pascal Filipovicz <pascal.filipovicz@frozenk.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace BaseSilex;

use BaseSilex\Entity\BaseSilex;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseSilexControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // Objects
        $controllers = new ControllerCollection();

        // Routing

        $app->match('/{index}', function (Request $request, $index) use($app) {
            $baseSilex = new BaseSilex();

            if ($index) {
                $baseSilex->setId($index);
            }

            $params = array(
                'base' => $baseSilex,
            );

            if (__LOG__) {
                $app['monolog']->addDebug('Index: base =  ' . json_encode(print_r($baseSilex)));
            }

            $render = $app['twig']->render('index.twig', $params);

            return new Response(
                $render,
                200,
                (true === __CACHE__) ? array('Cache-Control' => 'max-age=600, public') : array()
            );
        })
            ->method('GET')
            ->value('index', '999')
            ;

        return $controllers;
    }
}
