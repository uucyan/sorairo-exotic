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

    /**
     * メンバーの情報編集
     *
     * @param array $data
     */
    public function editMember($data) {
        $this->app['db']->update('member', array(
            'name'          => $data['name'],
            'contact'       => $data['contact'],
            'playing_games' => $data['playingGames'],
            'introduction'  => $data['introduction'],
        ), array('id' => $data['id']));
    }

    /**
     * メンバーの削除
     *
     * @param string $id
     */
    public function deleteMember($id) {
        $this->app['db']->delete('member', array('id' => $id));
    }
}
