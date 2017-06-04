<?php
namespace app\Model;

use Silex\Application;

class User
{
    const OLD_PASSWORD_MISMATCH_MESSAGE = '・今のパスワードが正しくありません。';
    const PASSWORD_MISMATCH_MESSAGE = '・再入力と不一致です。';
    const PASSWORD_NOT_INPUT_MESSAGE = '・新しいパスワードで未入力があります。';
    const PASSWORD_UNMATCHED_TO_CRITERIA = '・パスワードは半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上で登録してください。';
    const USER_NAME_DUPLICATE_MESSAGE = '・既に存在するユーザー名です。';
    const USER_NAME_NOT_INPUT_MESSAGE = '・ユーザー名が未入力です。';
    const USER_NAME_NOT_HALFWIDTH_ALPHANUMERIC_MESSAGE = '・ユーザー名は半角英数字のみです。';

    private $app;

    /**
     * コンストラクタ
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

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
    public function changeValidate($loginUserPassword, $request)
    {
        $errorMessage = [];

        // 変更前のパスワードチェック
        if ($loginUserPassword !== $request['password']) {
            $errorMessage += ['oldPasswordMismatch' => self::OLD_PASSWORD_MISMATCH_MESSAGE];
        }

        // 新規パスワードのチェック
        $errorMessage = $this->checkPassword($errorMessage, $request['newPassword'], $request['reNewPassword'], [
            'newPasswordNotInput',
            'newPasswordUnmatchedToCriteria',
            'newPasswordMismatch',
        ]);

        return $errorMessage;
    }

    /**
     * 新規ユーザー作成時のバリデーション
     *
     * @param  array $request
     * @return array
     */
    public function createValidate($request)
    {
        $errorMessage = [];

        // 新規パスワードのチェック
        $errorMessage = $this->checkPassword($errorMessage, $request['password'], $request['rePassword'], [
            'passwordNotInput',
            'passwordUnmatchedToCriteria',
            'passwordMismatch',
        ]);

        // ユーザー名が未入力かどうかチェック
        if (empty($request['name'])) {
            return $errorMessage += ['userNameNotInput' => self::USER_NAME_NOT_INPUT_MESSAGE];
        }

        // ユーザー名が半角英数字かチェック
        if (!preg_match("/^[a-zA-Z0-9]+$/", $request['name'])) {
            return $errorMessage += ['userNameNotHalfwidthAlphanumeric' => self::USER_NAME_NOT_HALFWIDTH_ALPHANUMERIC_MESSAGE];
        }

        // DBに重複したユーザー名が存在しているかチェック
        $sql = "SELECT COUNT(*) FROM user AS u WHERE u.name = '{$request['name']}'";
        $count = $this->app['db']->fetchAll($sql);
        if ($count[0]["COUNT(*)"] != '0') {
            $errorMessage += ['userNameDuplicate' => self::USER_NAME_DUPLICATE_MESSAGE];
        }

        return $errorMessage;
    }

    /**
     * 新規登録するパスワードのバリデーション
     *
     * @param  array  $errorMessage
     * @param  string $password
     * @param  string $rePassword
     * @param  array  $messageKeys
     * @return array
     */
    private function checkPassword($errorMessage, $password, $rePassword, $messageKeys)
    {
        // パスワードに未入力があるか
        if (empty($password) || empty($rePassword)) {
            return $errorMessage += [$messageKeys[0] => self::PASSWORD_NOT_INPUT_MESSAGE];
        }

        // パスワードが半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上100文字以下かどうかチェック
        if (!preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $password)) {
            return $errorMessage += [$messageKeys[1] => self::PASSWORD_UNMATCHED_TO_CRITERIA];
        }

        // パスワードが再入力したものと一致しているか
        if ($password !== $rePassword) {
            $errorMessage += [$messageKeys[2] => self::PASSWORD_MISMATCH_MESSAGE];
        }

        return $errorMessage;
    }
}
