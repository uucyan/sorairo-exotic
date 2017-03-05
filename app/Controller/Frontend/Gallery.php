<?php
namespace app\Controller\Frontend;

use Silex\Application;

class Gallery
{
    public function indexAction(Application $app){
        return $app['twig']->render('frontend\gallery.twig', array());
    }
}
