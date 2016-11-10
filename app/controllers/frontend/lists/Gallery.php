<?php
namespace app\controllers\frontend\lists;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Gallery
{
    public function indexAction(Application $app, Request $request){

        return $app['twig']->render('index.twig', array(
            'titleAnimation' => "tada",
            'urlCode' => GALLERY_URL,
        ));
    }
}
