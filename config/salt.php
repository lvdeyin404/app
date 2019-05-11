<?php
/**
 * 私钥
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/9 0009
 * Time: 0:03
 */
return [
    'AES_PRIVATE_KEY' => '12f862d21dcfeafb57bckfrrt5yuiopf', //AES加密 key
    'iv' => 'edfunbhtcjfwoclh', //AES加密iv
    'app_type' => [
        'ios',
        'android'
    ],
    'app_sign_time' => 3600,  //sign失效时间
    'app_sign_cache_time' => 20,    //sign缓存失效时间
];