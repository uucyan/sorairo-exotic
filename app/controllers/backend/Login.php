<?php
namespace app\controllers\backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Service\LoginService;

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
        // 画面で入力したパスワードをテーブルの情報と照合
        $isMember = LoginService::verificationPassword($app, $request->get('watchword'));

        // 入力した合言葉が一致していたか判定
        if (!$isMember) {
            $app['session']->set('isMember', $isMember);

            // ドロワーからのログインの場合、トップページへリダイレクト
            // ログイン画面からの場合、エラーメッセージをログイン画面へ返却
            if (!is_null($request->get('isDrawer'))) {
                return $app->redirect('/');
            } else {
                return $app['twig']->render('backend\login.twig', array(
                    'name' => 'ログインページ',
                    'errorMessage' => ERROR_MESSAGE,
                ));
            }
        }

        // ログイン成功時はメンバーページへ遷移
        $app['session']->set('isMember', $isMember);
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
