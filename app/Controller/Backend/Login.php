<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Login as LoginModel;

// エラーメッセージ
const ERROR_MESSAGE = 'どうやら違うみたいですね…。';

class Login
{
    public function indexAction(Application $app) {
        // Sessionにログイン情報を持っている場合は管理ページに遷移
        if ($app['session']->get('isMember')) {
            return $app->redirect('/MemberPage');
        }

        return $app['twig']->render('backend\login.twig', array());
    }

    public function loginAction(Application $app, Request $request) {
        // 画面で入力したパスワードをテーブルの情報と照合
        $isMember = LoginModel::verificationPassword($app, $request->get('watchword'));

        // 入力した合言葉が一致していたか判定
        if (!$isMember) {
            $app['session']->set('isMember', $isMember);
            // ログイン画面からの場合、エラーメッセージをログイン画面へ返却
            if (is_null($request->get('isDrawer'))) {
                return $app['twig']->render('backend\login.twig', array(
                    'name' => 'ログインページ',
                    'errorMessage' => ERROR_MESSAGE,
                ));
            }
            // ドロワーからのログインの場合、トップページへリダイレクト
            return $app->redirect('/');
        }
        // ログイン成功時はメンバーページへ遷移
        $app['session']->set('isMember', $isMember);
        return $app->redirect('/MemberPage');
    }

    /**
     * $isMemberがtrueじゃない場合にログインページにリダイレクトさせる
     */
    public static function isNotMemberRedirectLoginPage($app) {
        return $app->redirect('/login');
    }
}
