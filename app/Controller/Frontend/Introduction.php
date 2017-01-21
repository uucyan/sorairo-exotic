<?php
namespace app\Controller\Frontend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Introduction
{
    public function indexAction(Application $app, Request $request){

        return $app['twig']->render('frontend\index.twig', array(
            'titleAnimation' => "fadeInDown",
            'urlCode' => INTRODUCTION_URL,
        ));
    }
}
