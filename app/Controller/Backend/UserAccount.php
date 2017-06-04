<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\User;

class UserAccount
{
    public function indexAction(Application $app)
    {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        $errorMessage = $app['session']->get('errorMessage');
        $isCreateError = $app['session']->get('isCreateError');
        $messageType = $app['session']->get('messageType');
        $app['session']->remove('errorMessage');
        $app['session']->remove('isCreateError');
        $app['session']->remove('messageType');

        return $app['twig']->render('backend\user_account.twig', array(
            'errorMessage'  => $errorMessage,
            'isCreateError' => $isCreateError,
            'messageType'   => $messageType,
        ));
    }

    public function changeAction(Application $app, Request $request)
    {
        $user = new User($app);

        $errorMessage = $user->changeValidate($loginUser['password'], [
            'password'      => $request->get('password'),
            'newPassword'   => $request->get('newPassword'),
            'reNewPassword' => $request->get('reNewPassword'),
        ]);

        if (!empty($errorMessage)) {
            $app['session']->set('errorMessage', $errorMessage);
            $app['session']->set('messageType', 'changeError');
            return $app->redirect('/UserAccount');
        }
    }

    public function createAction(Application $app, Request $request)
    {
        $user = new User($app);

        $errorMessage = $user->createValidate([
            'name'      => $request->get('name'),
            'password'   => $request->get('regpass'),
            'rePassword' => $request->get('reregpass'),
        ]);

        if (!empty($errorMessage)) {
            $app['session']->set('errorMessage', $errorMessage);
            $app['session']->set('isCreateError', true);
            $app['session']->set('messageType', 'createError');
            return $app->redirect('/UserAccount');
        }
    }
}
