<?php
return [
    [
        'username' => 'admin',
        'auth_key' => md5(uniqid('', true)),
        'password_hash' => '$2y$13$lJCyI.n351TLeOFTdoXT6ensrRmcKR85e8thZUd9yGLpRSkMPk8U6',
        'password_reset_token' => md5(uniqid('', true)),
        'created_at' => time(),
        'updated_at' => time(),
        'email' => 'admin@' . md5(uniqid('', true)) . '.info',
    ],
    [
        'username' => 'demo',
        'auth_key' => md5(uniqid('', true)),
        'password_hash' => '$2y$13$QBpC4qVjeSnTDWMOqVlhNuiZWY61WTr3Gww9/S.ygh3PXe1mPh.Da',
        'password_reset_token' => md5(uniqid('', true)),
        'created_at' => time(),
        'updated_at' => time(),
        'email' => 'demo@' . md5(uniqid('', true)) . '.info',
    ]
];
