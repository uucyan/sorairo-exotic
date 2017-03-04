<?php
namespace app\Controller\Frontend;

use Silex\Application;

class Index
{
    public function indexAction(Application $app){
        return $app['twig']->render('frontend\index.twig', array());
    }
}
