<?php

return [
    'adminEmail' => 'admin@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'supportEmail' => 'robot@example.com',
    'rbac.roleOnRegister' => 'user',
    'pjax.timeout.default' => 10000,
    'pagination.perpage.begin' => [ 2 => 2],
    'pagination.perpage.default' => [ 2 => 2, 10 => 10, 30 => 30 ],
    'queryparams.ignore.names' => ['r', '_pjax']
];
