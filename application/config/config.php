<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */

return new \Phalcon\Config([
    'application' => [
        'database'  => require_once APP_PATH.'/config/database.php',
        'logsPath'  => '/data/logs/'.APP_NAME.'/',
        'viewsDir'  => APP_PATH.'/views',
    ]
]);
