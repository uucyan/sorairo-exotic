<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

const INTRODUCTION_URL = 'list/introduction.twig';
const ACTIVITY_DETAIL_URL = 'list/activityDetail.twig';
const CLAN_MEMBER_URL = 'list/clanMember.twig';
const GALLERY_URL = 'list/gallery.twig';
const JOIN_TO_CLAN_URL = 'list/joinToClan.twig';

// メイン
$app->get('/', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "fadeInDown",
        'urlCode' => INTRODUCTION_URL,
    ));
});

// クラン紹介
$app->get('/introduction', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "flash",
        'urlCode' => INTRODUCTION_URL,
    ));
});

// 活動内容
$app->get('/activityDetail', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "bounce",
        'urlCode' => ACTIVITY_DETAIL_URL,
    ));
});

// メンバ紹介
$app->get('/clanMember', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "rubberBand",
        'urlCode' => CLAN_MEMBER_URL,
    ));
});

// ギャラリー
$app->get('/gallery', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "tada",
        'urlCode' => GALLERY_URL,
    ));
});

// 加入申請
$app->get('/joinToClan', function() use($app) {

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "swing",
        'urlCode' => JOIN_TO_CLAN_URL,
    ));
});

$app->get('/test', function() use($app) {

    $test1 = 300;
    $test1 = $test1 + 1000;
    $test2 =& $test1;

    $a = "値１";
    $b = "値２";
    $c = "値３";
    $index = 0;
    $array = array('','','');


    foreach ($array as &$arr) {
      switch ($index) {
        case 0:
          $arr = $a;
          break;
        case 1:
          $arr = $b;
          break;
        case 2:
          $arr = $c;
          break;
      }
      $index ++;
    }

    return $app['twig']->render('index.twig', array(
        'test0'  => '継承テスト！',
        'test1' => "$test1",
        'test2' => "$test2",
        'array' => "$array[2]",
        'urlCode' => "test.twig"
    ));
});

$app->get('/hello/{name}', function($name) use($app) {
    return $app['twig']->render('hello.twig', array(
        'name' => $name,
    ));
});
$app->run();
