<?php
namespace app\Controller\Backend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Request as EnlistmentRequest;

class RequestList
{
    public function indexAction(Application $app) {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        $enlistmentRequest = new EnlistmentRequest($app);
        $requests = $enlistmentRequest->getRequests();

        return $app['twig']->render('backend\request_list.twig', array(
            'requests' => $requests,
            'user' => $app['session']->get('loginUser'),
        ));
    }

    /**
     * 入隊申請のステータスを更新
     *
     * @param Application $app
     * @param Request $request
     */
    public function updateAction(Application $app, Request $request) {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        // TODO：この謎の処理なんとかしたい
        $isNew = is_null($request->get('is_new')) ? 1 : 0;
        $processed = !is_null($request->get('processed')) ? 1 : 0;

        $enlistmentRequest = new EnlistmentRequest($app);
        $enlistmentRequest->update([
            'id'        => $request->get('id'),
            'is_new'    => $isNew,
            'processed' => $processed,
        ]);

        return $app->redirect('/RequestList');
    }

    /**
     * 入隊申請の削除
     *
     * @param Application $app
     * @param Request $request
     */
    public function deleteAction(Application $app, Request $request) {
        if (empty($app['session']->get('loginUser'))) {
            return $app->redirect('/login');
        }

        $enlistmentRequest = new EnlistmentRequest($app);
        $enlistmentRequest->delete($request->get('id'));

        return $app->redirect('/RequestList');
    }
}
