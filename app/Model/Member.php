<?php
namespace app\Model;

use Silex\Application;

class Member
{
    private $app;

    /**
     * コンストラクター
     *
     * @param Application $app
     */
    function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * メンバーの新規登録
     *
     * @param array $data
     */
    public function createMember($data) {
        $this->app['db']->insert('member', array(
            'name'         => $data['name'],
            'contact'      => $data['contact'],
            'playingGames' => $data['playingGames'],
            'introduction' => $data['introduction'],
        ));
    }

}
