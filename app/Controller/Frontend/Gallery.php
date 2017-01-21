<?php
namespace app\Controller\Frontend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Gallery
{
    public function indexAction(Application $app, Request $request){

        return $app['twig']->render('frontend\index.twig', array(
            'titleAnimation' => "tada",
            'urlCode' => GALLERY_URL,
        ));
    }
}
