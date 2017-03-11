<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MemberPage
{
    public function indexAction(Application $app, Request $request) {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        return $app['twig']->render('backend\index.twig', array());
    }
}
