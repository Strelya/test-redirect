<?php
/**
 * Created by PhpStorm.
 * User: Serdjio
 * Date: 02.05.2018
 * Time: 13:08
 */
stream_context_set_default( [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);
$sumb = array("www.", "http:", "https:", "/");
$domain_clear = str_replace($sumb, "", htmlspecialchars($_POST['Domain']));
$domain_plus = array("http://", "https://", "http://www.", "https://www.");//
$http_header=0;//Надо подсчитать сколько 200/401/500 и выдавать рекомендацию.
foreach ($domain_plus as $value) {

    $url = $value.$domain_clear;
    //Alternative method, file_get_contents
    //file_get_contents($url, null, stream_context_create(['http' => ['method' => 'GET']]));
    //$code = $http_response_header[0];
    //echo $url." - ".$code;
    $code = get_headers($url, 1);

    switch ($code[0]) {
        case 'HTTP/1.1 200 OK':
            $http_header++;
            echo $url." - 200";
            echo "<br/>";
            break;
        case 'HTTP/1.1 301 Moved Permanently':
            echo $url." - 301";
            echo "<br/>";
            break;
        case 'HTTP/1.1 401 Unauthorized':
            echo $url." - ".$code[0];
            echo "<br/>";
            break;
        case '502':// Запрос не обработается - доработать через if
            echo $url." - ".$code[0];
            echo "<br/>";
            break;
        case '500'://Создать ошибку, протестить
            echo $url." - ".$code[0];
            echo "<br/>";
            break;
    }
};

if ($http_header==1){
    echo "Все отлично, главное зеркало настроено";
}
else {
    echo "Необходимо настроить редирект на одно зеркало";
}