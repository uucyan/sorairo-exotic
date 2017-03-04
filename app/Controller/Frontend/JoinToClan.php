<?php
namespace app\Controller\Frontend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class JoinToClan
{
    public function indexAction(Application $app, Request $request){
        return $app['twig']->render('frontend\joinToClan.twig', array());
    }
}
