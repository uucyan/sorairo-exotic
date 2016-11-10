<?php
namespace app\controllers\frontend\lists;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ClanMember
{
    public function indexAction(Application $app, Request $request){

        return $app['twig']->render('index.twig', array(
            'titleAnimation' => "rubberBand",
            'urlCode' => CLAN_MEMBER_URL,
        ));
    }
}
