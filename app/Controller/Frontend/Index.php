<?php
namespace app\Controller\Frontend;

use Silex\Application;
use App\Model\Member;

class Index
{
    public function indexAction(Application $app){
        $member = new Member($app);
        $memberDatas = $member->getMembers();

        return $app['twig']->render('frontend\index.twig', array(
            'members' => $memberDatas,
        ));
    }
}
