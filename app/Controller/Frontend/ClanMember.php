<?php
namespace app\Controller\Frontend;

use Silex\Application;

class ClanMember
{
    public function indexAction(Application $app){
        return $app['twig']->render('frontend\clanMember.twig', array());
    }
}
