<?php
return [
    [
        'username' => 'admin',
        'auth_key' => md5(uniqid('', true)),
        // admin
        'password_hash' => '$2y$13$lJCyI.n351TLeOFTdoXT6ensrRmcKR85e8thZUd9yGLpRSkMPk8U6',
        'password_reset_token' => md5(uniqid('', true)),
        'created_at' => time(),
        'updated_at' => time(),
        'is_active' => 1,
        'email' => 'admin@' . md5(uniqid('', true)) . '.info',
    ],
    [
        'username' => 'editor',
        'auth_key' => md5(uniqid('', true)),
        // demo
        'password_hash' => '$2y$13$QBpC4qVjeSnTDWMOqVlhNuiZWY61WTr3Gww9/S.ygh3PXe1mPh.Da',
        'password_reset_token' => md5(uniqid('', true)),
        'created_at' => time(),
        'updated_at' => time(),
        'is_active' => 1,
        'email' => 'editor@' . md5(uniqid('', true)) . '.info',
    ],
    [
        'username' => 'demo',
        'auth_key' => md5(uniqid('', true)),
        // demo
        'password_hash' => '$2y$13$QBpC4qVjeSnTDWMOqVlhNuiZWY61WTr3Gww9/S.ygh3PXe1mPh.Da',
        'password_reset_token' => md5(uniqid('', true)),
        'created_at' => time(),
        'updated_at' => time(),
        'is_active' => 1,
        'email' => 'demo@' . md5(uniqid('', true)) . '.info',
    ]
];
