<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\Backend\Login;
use App\Model\Member;

class EditMember
{
    private $isCreateErrer = false;

    public function indexAction(Application $app) {
        // ログイン判定
        if (!$app['session']->get('isMember')) { return Login::isNotMemberRedirectLoginPage($app); }

        $member = new Member($app);
        $memberDatas = $member->getMembers();

        return $app['twig']->render('backend\editMember.twig', array(
            'members' => $memberDatas,
        ));
    }

    public function createAction(Application $app, Request $request) {
        // ログイン判定
        if (!$app['session']->get('isMember')) { return Login::isNotMemberRedirectLoginPage($app); }

        $member = new Member($app);
        $member->createMember([
            'name'         => $request->get('name'),
            'contact'      => $request->get('contact'),
            'playingGames' => $request->get('playingGames'),
            'introduction' => $request->get('introduction'),
        ]);

        // DBへの登録が成功したらメンバー編集画面にリダイレクト
        // っていっても、現状エラーになるケースはない
        if (!$this->isCreateErrer) {
            return $app->redirect('/EditMember');
        }
        return $app['twig']->render('backend\editMember.twig', array(
            'isErrer' => $this->isCreateErrer,
        ));
    }
}
