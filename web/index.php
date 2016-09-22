<?php
// header("Content-Type: text/html; charset=UTF-8");

require_once __DIR__.'/../vendor/autoload.php';

const INTRODUCTION_URL = 'list/introduction.twig';
const ACTIVITY_DETAIL_URL = 'list/activityDetail.twig';
const CLAN_MEMBER_URL = 'list/clanMember.twig';
const GALLERY_URL = 'list/gallery.twig';
const JOIN_TO_CLAN_URL = 'list/joinToClan.twig';

$app = new Silex\Application();
$app['debug'] = true;
$app['isMember'] = false;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
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

// メイン
$app->get('/', function() use($app) {
    $sql = " SELECT * FROM test ";
    $test = $app['db']->fetchAll($sql);
    // var_dump($test);
    // echo('<pre>');var_dump(print_r(mb_get_info()));exit;echo('</pre>');

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "fadeInDown",
        'urlCode' => INTRODUCTION_URL,
        'isMember' => $app['isMember'],
    ));
});

// クラン紹介
$app->get('/introduction', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "flash",
        'urlCode' => INTRODUCTION_URL,
        'isMember' => $app['isMember'],
    ));
});

// 活動内容
$app->get('/activityDetail', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "bounce",
        'urlCode' => ACTIVITY_DETAIL_URL,
        'isMember' => $app['isMember'],
    ));
});

// メンバ紹介
$app->get('/clanMember', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "rubberBand",
        'urlCode' => CLAN_MEMBER_URL,
        'isMember' => $app['isMember'],
    ));
});

// ギャラリー
$app->get('/gallery', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "tada",
        'urlCode' => GALLERY_URL,
        'isMember' => $app['isMember'],
    ));
});

// 加入申請
$app->get('/joinToClan', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "swing",
        'urlCode' => JOIN_TO_CLAN_URL,
        'isMember' => $app['isMember'],
    ));
});

$app->get('/hello/{name}', function($name) use($app) {
    return $app['twig']->render('hello.twig', array(
        'name' => $name,
    ));
});
$app->run();
