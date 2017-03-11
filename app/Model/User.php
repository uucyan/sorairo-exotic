<?php
namespace app\Model;

use Silex\Application;

class User
{
    /**
     * 画面で入力した情報がDBの情報と一致すればユーザー情報を返却
     *
     * @param  Application $app
     * @param  array $inputData
     * @return array | null
     */
    public static function getLoginUser(Application $app, $inputData) {
        $sql = "SELECT COUNT(*) FROM user AS lm WHERE lm.name = '{$inputData['name']}' AND lm.password = '{$inputData['password']}'";
        $count = $app['db']->fetchAll($sql);

        // 入力データに一致するデータが存在しなかった場合はnullを返却
        if ($count[0]["COUNT(*)"] == '0') {
            return null;
        }

        $sql = "SELECT id, name, role FROM user AS lm WHERE lm.name = '{$inputData['name']}' AND lm.password = '{$inputData['password']}'";
        $data = $app['db']->fetchAll($sql);

        return array_shift($data);
    }

}
