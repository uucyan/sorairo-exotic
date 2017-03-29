<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
// Session
$app->register(new Silex\Provider\SessionServiceProvider());
// MySQL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'host' => '127.0.0.1',
        'dbname' => 'sorairo_exotic',
        'user' => 'root',
        'password' => 'catty229',
        'charset' => 'utf8',
    )
));

/* ---- Frontend -------------------------------------------------------------------------------- */

// トップページ
$app->get('/', 'App\Controller\Frontend\Index::indexAction')->bind('index');
// $app->get('/top', 'App\Controller\Frontend\Index::indexAction')->bind('top');

// クラン紹介
$app->get('/introduction', 'App\Controller\Frontend\Introduction::indexAction')->bind('introduction_index');

// 活動内容
$app->get('/activityDetail', 'App\Controller\Frontend\ActivityDetail::indexAction')->bind('activity_detail_index');

// メンバ紹介
$app->get('/clanMember', 'App\Controller\Frontend\ClanMember::indexAction')->bind('clan_member_index');

// ギャラリー
$app->get('/gallery', 'App\Controller\Frontend\Gallery::indexAction')->bind('gallery_index');

// 入隊申請
$app->get('/joinToClan', 'App\Controller\Frontend\JoinToClan::indexAction')->bind('join_to_clan_index');
$app->post('/requestAction', 'App\Controller\Frontend\JoinToClan::requestAction')->bind('join_to_clan_request');

/* ---------------------------------------------------------------------------------------------- */

/* ---- Backend --------------------------------------------------------------------------------- */

// ログイン
$app->get('/login', 'App\Controller\Backend\Login::indexAction')->bind('login_index');

// ログアウト
$app->get('/logout', 'App\Controller\Backend\Login::logoutAction')->bind('logout_action');

// ログインリクエスト送信時
$app->post('/loginAction', 'App\Controller\Backend\Login::loginAction')->bind('login_action');

// メンバーページトップ
$app->get('/MemberPage', 'App\Controller\Backend\MemberPage::indexAction')->bind('member_page_index');

// メンバー編集
$app->get('/EditMember', 'App\Controller\Backend\EditMember::indexAction')->bind('edit_member_index');
$app->post('/createAction', 'App\Controller\Backend\EditMember::createAction')->bind('create_index');
$app->post('/editAction', 'App\Controller\Backend\EditMember::editAction')->bind('edit_index');
$app->post('/deleteAction', 'App\Controller\Backend\EditMember::deleteAction')->bind('delete_index');

// 入隊申請一覧
$app->get('/RequestList', 'App\Controller\Backend\RequestList::indexAction')->bind('request_list_index');
$app->post('/requestUpdateAction', 'App\Controller\Backend\RequestList::updateAction')->bind('request_update_index');
$app->post('/requestDeleteAction', 'App\Controller\Backend\RequestList::deleteAction')->bind('request_delete_index');

/* ---------------------------------------------------------------------------------------------- */

$app->run();
