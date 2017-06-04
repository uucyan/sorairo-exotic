<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\User;

class UserAccount
{
    /**
     * IndexAction
     *
     * @param Application $app
     */
    public function indexAction(Application $app)
    {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        $loginUser = $app['session']->get('loginUser');

        $errorMessage = $app['session']->get('errorMessage');   // バリデーションエラーメッセージ
        $isCreateError = $app['session']->get('isCreateError'); // ユーザー作成時のエラー判定
        $messageType = $app['session']->get('messageType');     // 成功と失敗のメッセージ表示判定
        $app['session']->remove('errorMessage');
        $app['session']->remove('isCreateError');
        $app['session']->remove('messageType');

        return $app['twig']->render('backend\user_account.twig', array(
            'loginUser'     => $loginUser,
            'errorMessage'  => $errorMessage,
            'isCreateError' => $isCreateError,
            'messageType'   => $messageType,
        ));
    }

    /**
     * パスワードの変更
     *
     * @param  Application $app
     * @param  Request $request
     */
    public function changeAction(Application $app, Request $request)
    {
        $user = new User($app);
        $loginUser = $app['session']->get('loginUser');

        // パスワードのバリデーション
        $errorMessage = $user->changeValidate($loginUser['id'], [
            'password'      => $request->get('password'),
            'newPassword'   => $request->get('newPassword'),
            'reNewPassword' => $request->get('reNewPassword'),
        ]);

        // バリデーションエラーが存在する場合、エラーメッセージを画面に返却
        if (!empty($errorMessage)) {
            $app['session']->set('errorMessage', $errorMessage);
            $app['session']->set('messageType', 'changeError');
            return $app->redirect('/UserAccount');
        }

        $user->change([
            'password' => $request->get('newPassword'),
            'id' => $loginUser['id'],
        ]);

        $app['session']->set('messageType', 'changeSuccess');
        return $app->redirect('/UserAccount');
    }

    /**
     * アカウントの新規作成
     *
     * @param  Application $app
     * @param  Request $request
     */
    public function createAction(Application $app, Request $request)
    {
        $user = new User($app);

        // ユーザー名とパスワードのバリデーション
        $errorMessage = $user->createValidate([
            'name'       => $request->get('name'),
            'password'   => $request->get('regpass'),
            'rePassword' => $request->get('reregpass'),
        ]);

        // バリデーションエラーが存在する場合、エラーメッセージを画面に返却
        if (!empty($errorMessage)) {
            $app['session']->set('errorMessage', $errorMessage);
            $app['session']->set('isCreateError', true);
            $app['session']->set('messageType', 'createError');
            return $app->redirect('/UserAccount');
        }

        $user->create([
            'name'     => $request->get('name'),
            'password' => $request->get('regpass'),
        ]);

        $app['session']->set('messageType', 'createSuccess');
        return $app->redirect('/UserAccount');
    }
}
