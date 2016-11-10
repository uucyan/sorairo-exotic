<?php
namespace app\controllers\backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

const WATCHWORD = '空色えきぞちっく';

class MemberPage
{
    public function indexAction(Application $app, Request $request){

        if ($request->get('watchword') != WATCHWORD){
            return $app['twig']->render('index.twig', array(
                'titleAnimation' => "flash",
                'urlCode' => INTRODUCTION_URL,
            ));
        }

        return $app['twig']->render('memberPage.twig', array(
            'name' => 'ログイン成功',
        ));
    }
}
