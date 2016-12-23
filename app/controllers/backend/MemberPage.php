<?php
namespace app\controllers\backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Controllers\Backend\Login;

const WATCHWORD = '空色えきぞちっく';

class MemberPage
{
    public function indexAction(Application $app, Request $request) {
        // ログイン判定
        if (!$app['session']->get('isMember')) { return Login::isNotMemberRedirectLoginPage($app); }

        return $app['twig']->render('backend\index.twig', array(
            'name' => 'メンバーページ',
        ));
    }
}
