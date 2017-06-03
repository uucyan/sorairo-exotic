<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\User as UserModel;

class UserAccount
{
    public function indexAction(Application $app)
    {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        $errorMessage = $app['session']->get('errorMessage');
        $app['session']->remove('errorMessage');

        return $app['twig']->render('backend\user_account.twig', array(
            'errorMessage' => $errorMessage,
        ));
    }

    public function changeAction(Application $app, Request $request)
    {
        $userModel = new UserModel();

        $errorMessage = $userModel->changePasswordValidate($loginUser['password'], [
            'password'      => $request->get('password'),
            'newPassword'   => $request->get('newPassword'),
            'reNewPassword' => $request->get('reNewPassword'),
        ]);

        if (!empty($errorMessage)) {
            $app['session']->set('errorMessage', $errorMessage);
            return $app->redirect('/UserAccount');
        }
    }
}
