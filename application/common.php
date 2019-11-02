<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function getRSAEncode($text)
{
    $private_key='-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQCytYlGIkLH8Vp6FY72PSfjnlkwIkR6r8Iw6DJvSwVil8ww88hN
x3sf86CeE1ttoyIJO1jV52Oijr6P5cvtG3oG9J0ULp+wrJmtiEBJkAKuK/45+D65
boBKrI8ye/AGiQe0tm611JVGDMFyBJUKlAVQjsrkkjf93uzY562B448U4QIDAQAB
AoGAJ3eLEQeY+wI06phfQcdgy1aZuNUgjX3KY7WsCcMmNc9zY247Ut4WtYg+9Rou
S2jHKAXIyTi4WtqugCYOYtd6G7epam2V0q+RrIVwGJKXJzoR4RLYmDITAOlU/9H9
0PohTg11NMP3UjiqFWE5QG7vDFQBY9CrBFHifhJLWReW9MkCQQDWEAzSAoURyAaz
XYgoWlkYYVnhX5/IHXY+ONR2RUwY9aceBJ2WD4OPoccu3bOtKqf95i2dXiEILJWE
Em3tJIXVAkEA1bhjWHh7TnktXpt+DDEGSKES1vImHdyQc7dIgWW62ric8GV05ar2
SW949+UaY7prGdpKg2yQHv+6DKfMG7Nc3QJAeyHsXfk5FktbH13T7nJaAZ4uF2fr
/y6DT7Nc81NVPJ5BrRC2nRT7dml2q8y3iAqba382CemVUqBiuP/o35o8qQJBAJrP
+17Nv3xjuOKsPg00wfmAfDYpqES/TgAUhzf8afMgAcb9p0Tqp4cgcX8YfRo6onRS
tOEolelukuWx8t8p+R0CQBrMG0l4bvHH+nBXKGUkD8oruAKADUs33+vdt39BdhyI
Fnb+8RvK/z3S+JnSFdxCKB8tcKbyuJKC4L5Vz5r0Pm4=
-----END RSA PRIVATE KEY-----';


    //私钥解密
    openssl_private_decrypt(base64_decode($text),$decrypted,$private_key);
    $encrypt_exist=false;
    if(!empty($decrypted)) {
        $arr = json_decode($decrypted, true);
    }
    //继续后续处理
    return $arr;
}

