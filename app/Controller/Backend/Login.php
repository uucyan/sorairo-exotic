<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\User;

// エラーメッセージ
const ERROR_MESSAGE = 'ログイン情報が一致していません。';

class Login
{
    public function indexAction(Application $app) {
        // Sessionにログイン情報を持っている場合は管理ページに遷移
        if (!empty($app['session']->get('loginUser'))) {
            return $app->redirect('/MemberPage');
        }

        return $app['twig']->render('backend\login.twig', array());
    }

    /**
     * ログイン
     *
     * @param  Application $app
     * @param  Request $request
     */
    public function loginAction(Application $app, Request $request) {
        // 入力情報でLoginMemberを検索して取得
        $loginUser = User::getLoginUser($app, [
            'name' => $request->get('name'),
            'password' => $request->get('password'),
        ]);

        // LoginMemberが取得できなかった場合はエラーメッセージを返却
        if (is_null($loginUser)) {
            return $app['twig']->render('backend\login.twig', array(
                'errorMessage' => ERROR_MESSAGE,
            ));
        }
        // ログイン成功時はメンバーページへ遷移
        $app['session']->set('loginUser', $loginUser);
        return $app->redirect('/MemberPage');
    }

    /**
     * ログアウト
     *
     * @param  Application $app
     */
    public function logoutAction(Application $app) {
        $app['session']->remove('loginUser');
        return $app->redirect('/');
    }
}
