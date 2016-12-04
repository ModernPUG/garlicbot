<?php
return [
    'timezone' => 'Asia/Seoul',
    'garlicbot' => [
        
    ],
    'slack' => [
        'rtm' => [
            'token' => SLACK_RTM_TOKEN,
        ],
    ],
    'mecab' => [
        'dict_path' => MECAB_DICT_PATH,
    ],
    'monolog' => [
        'path' => 'garlicbot.log',
    ],
];
