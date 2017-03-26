<?php
namespace app\Controller\Frontend;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Model\Request as EnlistmentRequest;

class JoinToClan
{
    public function indexAction(Application $app) {
        $messageType = null;
        if ($app['session']->get('messageType') == 'success') {
            $messageType = $app['session']->get('messageType');
            $app['session']->set('messageType', null);
        }

        return $app['twig']->render('frontend\joinToClan.twig', array(
            'messageType' => $messageType,
        ));
    }

    public function requestAction(Application $app, Request $request){
        $enlistmentRequest = new EnlistmentRequest($app);
        $enlistmentRequest->createRequest([
            'name'         => $request->get('name'),
            'contact'      => $request->get('contact'),
            'playingGames' => $request->get('playingGames'),
            'introduction' => $request->get('introduction'),
        ]);
        $app['session']->set('messageType', 'success');
        return $app->redirect('/joinToClan');
    }
}
