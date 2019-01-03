<?php
/*
 * Secret key and Site key get on https://www.google.com/recaptcha
 * */
return [
    'secret' => env('CAPTCHA_SECRET', '6LflCjwUAAAAAFSou-IVlwjm_GVlQ37ZZ2S6aZ_p'),
    'sitekey' => env('CAPTCHA_SITEKEY', '6LflCjwUAAAAAEj4dISfbNyEPhSv3TTh3JtvdWv8')
];