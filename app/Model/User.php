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
     * ユーザーの新規作成
     *
     * @param array $request
     */
    public function create($request)
    {
        $passwordHash = password_hash($request['password'], PASSWORD_DEFAULT);

        $this->app['db']->insert('user', array(
            'name'     => $request['name'],
            'password' => $passwordHash,
            'role'     => 2,
        ));
    }

    /**
     * ユーザーのパスワード更新
     *
     * @param array $request
     */
    public function change($request)
    {
        $passwordHash = password_hash($request['password'], PASSWORD_DEFAULT);

        $this->app['db']->update('user', array(
            'password' => $passwordHash,
        ), array('id' => $request['id']));
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
        $sql = "SELECT COUNT(*) FROM user AS u WHERE u.name = ?";
        $count = $app['db']->fetchAll($sql, [$inputData['name']]);

        // 存在しないユーザー名かチェック
        if ($count[0]["COUNT(*)"] == '0') {
            return null;
        }

        $sql = "SELECT * FROM user AS u WHERE u.name = '{$inputData['name']}'";
        $data = $app['db']->fetchAll($sql);
        $userData = array_shift($data);

        // 入力したパスワードのチェック
        if (!password_verify($inputData['password'], $userData['password'])) {
            return null;
        }

        return $userData;
    }

    /**
     * パスワード変更時のバリデーション
     *
     * @param  string $userId
     * @param  array  $request
     * @return array
     */
    public function changeValidate($userId, $request)
    {
        $errorMessage = [];

        // 変更前のパスワードチェック
        $sql = "SELECT * FROM user AS u WHERE u.id = '{$userId}'";
        $data = $this->app['db']->fetchAll($sql);
        $userData = array_shift($data);
        if (!password_verify($request['password'], $userData['password'])) {
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
