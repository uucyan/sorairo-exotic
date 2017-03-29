<?php
namespace app\Model;

use Silex\Application;

class Request
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
     * 入隊申請をすべて取得
     *
     * @return array
     */
    public function getRequests() {
        $sql = "SELECT * FROM request";
        return $this->app['db']->fetchAll($sql);
    }

    /**
     * 新規の入隊申請を登録
     *
     * @param array $data
     */
    public function create($data) {
        $this->app['db']->insert('request', array(
            'name'          => $data['name'],
            'contact'       => $data['contact'],
            'playing_games' => $data['playingGames'],
            'introduction'  => $data['introduction'],
        ));
    }

    /**
     * 入隊申請のステータスを更新
     *
     * @param array $data
     */
    public function update($data) {
        $this->app['db']->update('request', array(
            'is_new'    => $data['is_new'],
            'processed' => $data['processed'],
        ), array('id' => $data['id']));
    }

    /**
     * 入隊申請の削除
     *
     * @param string $id
     */
    public function delete($id) {
        $this->app['db']->delete('request', array('id' => $id));
    }
}
