<?php

$app->get('/login', function() use($app) {

    $watchword = $_GET['watchword'];

    if ($watchword == WATCHWORD){
        return $app['twig']->render('memberPage.twig', array(
            'name' => 'ログイン成功',
        ));
    }

    return $app['twig']->render('index.twig', array(
        'titleAnimation' => "flash",
        'urlCode' => INTRODUCTION_URL,
    ));
});
