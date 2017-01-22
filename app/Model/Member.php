<?php
namespace app\Model;

use Silex\Application;

class Member
{
    private $app;

    /**
     * コンストラクタ
     *
     * @param Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * 登録されているメンバーのデータをすべて取得
     *
     * @return array
     */
    public function getMembers() {
        $sql = "SELECT * FROM member";
        return $this->app['db']->fetchAll($sql);
    }

    /**
     * メンバーの新規登録
     *
     * @param array $data
     */
    public function createMember($data) {
        $this->app['db']->insert('member', array(
            'name'          => $data['name'],
            'contact'       => $data['contact'],
            'playing_games' => $data['playingGames'],
            'introduction'  => $data['introduction'],
        ));
    }
}
