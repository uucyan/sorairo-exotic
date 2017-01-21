<?php
namespace app\Service;

use Silex\Application;

class LoginService
{
    /**
     * 画面で入力したパスワードをloginテーブルの情報と照合。
     * カウントが取得できた場合はメンバーとみなす。
     *
     * @param  Application $app
     * @param  string $watchword
     * @return boolean
     */
    public static function verificationPassword(Application $app, $watchword) {
        $sql = "SELECT COUNT(*) FROM login AS l WHERE l.password = '$watchword'";
        $count = $app['db']->fetchAll($sql);

        return $count[0]["COUNT(*)"] > '0' ? true : false;
    }

}
