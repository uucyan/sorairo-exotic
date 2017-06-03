<?php
namespace app\Model;

use Silex\Application;

class User
{

    const PASSWORD_MISMATCH_MESSAGE = '今のパスワードが正しくありません。';
    const NEW_PASSWORD_MISMATCH_MESSAGE = '再入力と不一致です';
    const NEW_PASSWORD_NOT_INPUT_MESSAGE = '新しいパスワードで未入力があります。';

    /**
     * 画面で入力した情報がDBの情報と一致すればユーザー情報を返却
     *
     * @param  Application $app
     * @param  array $inputData
     * @return array | null
     */
    public static function getLoginUser(Application $app, $inputData)
    {
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

    /**
     * パスワード変更時のバリデーション
     *
     * @param  string $loginUserPassword
     * @param  array  $request
     * @return array
     */
    public function changePasswordValidate($loginUserPassword, $request)
    {
         $errorMessage = [];

        // 変更前のパスワードチェック
        if ($loginUserPassword !== $request['password']) {
            $errorMessage += ['passwordMismatch' => self::PASSWORD_MISMATCH_MESSAGE];
        }

        // 新しいパスワードに未入力があるか
        if ($request['newPassword'] == null || $request['reNewPassword'] == null) {
            return $errorMessage += ['newPasswordNotInput' => self::NEW_PASSWORD_NOT_INPUT_MESSAGE];
        }

        // 新しいパスワードが再入力したものと一致しているか
        if ($request['newPassword'] !== $request['reNewPassword']) {
            $errorMessage += ['newPasswordMismatch' => self::NEW_PASSWORD_MISMATCH_MESSAGE];
        }

        return $errorMessage;
    }

}
