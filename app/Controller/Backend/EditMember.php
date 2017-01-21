<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Backend\Login;

class EditMember
{
    public function indexAction(Application $app, Request $request) {
        // ログイン判定
        if (!$app['session']->get('isMember')) { return Login::isNotMemberRedirectLoginPage($app); }

        return $app['twig']->render('backend\editMember.twig', array(
            'name' => 'メンバー編集',
        ));
    }
}
