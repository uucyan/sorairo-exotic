<?php
// header("Content-Type: text/html; charset=UTF-8");

require_once __DIR__.'/../vendor/autoload.php';

const INTRODUCTION_URL = 'frontend/introduction.twig';
const ACTIVITY_DETAIL_URL = 'frontend/activityDetail.twig';
const CLAN_MEMBER_URL = 'frontend/clanMember.twig';
const GALLERY_URL = 'frontend/gallery.twig';
const JOIN_TO_CLAN_URL = 'frontend/joinToClan.twig';

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

// クラン紹介
$app->get('/', 'App\Controllers\Frontend\Introduction::indexAction')->bind('index');
$app->get('/introduction', 'App\Controllers\Frontend\Introduction::indexAction')->bind('introduction_index');

// 活動内容
$app->get('/activityDetail', 'App\Controllers\Frontend\ActivityDetail::indexAction')->bind('activity_detail_index');

// メンバ紹介
$app->get('/clanMember', 'App\Controllers\Frontend\ClanMember::indexAction')->bind('clan_member_index');

// ギャラリー
$app->get('/gallery', 'App\Controllers\Frontend\Gallery::indexAction')->bind('gallery_index');

// 加入申請
$app->get('/joinToClan', 'App\Controllers\Frontend\JoinToClan::indexAction')->bind('join_to_clan_index');

/* ---------------------------------------------------------------------------------------------- */

/* ---- Backend --------------------------------------------------------------------------------- */

// ログイン
$app->get('/login', 'App\Controllers\Backend\Login::indexAction')->bind('login_index');

// ログインリクエスト送信時
$app->get('/loginAction', 'App\Controllers\Backend\Login::loginAction')->bind('login_action');

// メンバーページトップ
$app->get('/MemberPage', 'App\Controllers\Backend\MemberPage::indexAction')->bind('member_page_index');

/* ---------------------------------------------------------------------------------------------- */

// メイン
// $app->get('/', function() use($app) {
//     $sql = " SELECT * FROM test ";
//     $test = $app['db']->fetchAll($sql);
//     // var_dump($test);
//     // echo('<pre>');var_dump(print_r(mb_get_info()));exit;echo('</pre>');
//
//     return $app['twig']->render('index.twig', array(
//         'titleAnimation' => "fadeInDown",
//         'urlCode' => INTRODUCTION_URL,
//     ));
// });

$app->run();
