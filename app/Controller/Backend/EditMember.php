<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Member;

class EditMember
{
    private $isCreateErrer = false;

    public function indexAction(Application $app) {
        $loginUser = $app['session']->get('loginUser');

        if (empty($loginUser)) {
            return $app->redirect('/login');
        }

        $member = new Member($app);
        $memberDatas = $member->getMembers();

        // 既に自分のデータを登録しているかどうか
        $isCreated = false;
        foreach ($memberDatas as $member) {
            if ($member['user_id'] == $loginUser['id']) {
                $isCreated = true;
            }
        }

        return $app['twig']->render('backend\editMember.twig', array(
            'members'   => $memberDatas,
            'isCreated' => $isCreated,
            'loginUser' => $loginUser,
        ));
    }

    /**
     * メンバーの新規登録
     *
     * @param Application $app
     * @param Request $request
     */
    public function createAction(Application $app, Request $request) {
        $loginUser = $app['session']->get('loginUser');

        if (empty($loginUser)) {
            return $app->redirect('/login');
        }

        $member = new Member($app);
        $member->createMember([
            'name'         => $request->get('name'),
            'contact'      => $request->get('contact'),
            'playingGames' => $request->get('playingGames'),
            'introduction' => $request->get('introduction'),
            'user_id'      => $loginUser['id'],
            'role'         => $loginUser['role'],
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

    /**
     * メンバーの情報編集
     *
     * @param Application $app
     * @param Request $request
     */
    public function editAction(Application $app, Request $request) {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        $member = new Member($app);
        $member->editMember([
            'id'           => $request->get('id'),
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

    /**
     * メンバーの削除
     *
     * @param Application $app
     * @param Request $request
     */
    public function deleteAction(Application $app, Request $request) {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        $member = new Member($app);
        $member->deleteMember($request->get('id'));

        return $app->redirect('/EditMember');
    }
}
