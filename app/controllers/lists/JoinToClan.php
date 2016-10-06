<?php
namespace app\controllers\lists;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class JoinToClan
{
    public function indexAction(Application $app, Request $request){

        return $app['twig']->render('index.twig', array(
            'titleAnimation' => "swing",
            'urlCode' => JOIN_TO_CLAN_URL,
        ));
    }
}
