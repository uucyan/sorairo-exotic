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

        $app['session']->set('isMember', true);
        $isMember = $app['session']->get('isMember');

        if ($isMember) {
            $Message = 'ログインに成功しました。';
        } else {
            $Message = 'ログインに失敗しました。';
        }

        return $app['twig']->render('backend\memberPage.twig', array(
            'name' => $Message,
        ));
    }
}
