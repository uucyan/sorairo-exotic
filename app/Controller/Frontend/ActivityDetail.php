<?php
namespace app\Controller\Frontend;

use Silex\Application;

class ActivityDetail
{
    public function indexAction(Application $app){
        return $app['twig']->render('frontend\activityDetail.twig', array());
    }
}
