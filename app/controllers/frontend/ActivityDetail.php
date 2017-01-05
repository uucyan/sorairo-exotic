<?php
namespace app\Controllers\Frontend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ActivityDetail
{
    public function indexAction(Application $app, Request $request){

        return $app['twig']->render('frontend\index.twig', array(
            'titleAnimation' => "bounce",
            'urlCode' => ACTIVITY_DETAIL_URL,
        ));
    }
}
