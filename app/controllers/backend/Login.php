<?php
namespace app\controllers\backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

// 合言葉
const WATCHWORD_MEMBER = '空色えきぞちっく';
const WATCHWORD_MASTER = 'みゅー';
// エラーメッセージ
const ERROR_MESSAGE = '合言葉が一致していません(´・ω・｀)';

class Login
{
    public function indexAction(Application $app, Request $request) {

        return $app['twig']->render('backend\login.twig', array(
            'name' => 'ログインページ',
        ));
    }

    public function loginAction(Application $app, Request $request) {
        // 入力した合言葉が一致しているか判定
        if ($request->get('watchword') != WATCHWORD_MEMBER) {
            $app['session']->set('isMember', false);

            // ドロワーからのログインの場合、トップページへリダイレクト
            // ログイン画面からの場合、エラーメッセージをログイン画面へ返却
            if ($request->get('isDrawer')) {
                return $app->redirect('/');
            } else {
                return $app['twig']->render('backend\login.twig', array(
                    'name' => 'ログインページ',
                    'errorMessage' => ERROR_MESSAGE,
                ));
            }
        }

        // ログイン成功時はメンバーページへ遷移
        $app['session']->set('isMember', true);
        return $app->redirect('/MemberPage');
    }

    /**
     * $isMemberがtrueじゃない場合にログインページにリダイレクトさせる
     *
     * @param boolean $isMember
     */
    public static function isNotMemberRedirectLoginPage($app) {
        return $app->redirect('/login');
    }
}
