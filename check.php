<?php
/**
 * Created by PhpStorm.
 * User: Serdjio
 * Date: 02.05.2018
 * Time: 13:08
 */
function check_redirect ($start_domain)
{
    stream_context_set_default([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);
//Надо проверить точку в адресе
    $sumb = array("www.", "http:", "https:", "/");//Составить регулярку и удалять все после / в конце
    $domain_clear = str_replace($sumb, "", htmlspecialchars($start_domain));
    $domain_plus = array("http://", "https://", "http://www.", "https://www.");//
    $http_header = 0;//Надо подсчитать сколько 200/401/500 и выдавать рекомендацию.
    $code502 = @get_headers($domain_plus[0] . $domain_clear, 1);
    $result = "<ul class=\"list-group\">";
    if ($code502 == true) {
        foreach ($domain_plus as $value) {
            $url = $value . $domain_clear;
            @file_get_contents($url, null, stream_context_create(['http' => ['method' => 'GET']]));
            $code = $http_response_header[0];

            switch ($code) {
                case 'HTTP/1.1 200 OK':
                    $http_header++;
                    $result .= "<li class=\"list-group-item\">Версия с " . $value . "(<b>" . $url . "</b>) - Открывается (HTTP/1.1 200 OK)</li>";
                    break;
                case 'HTTP/1.1 301 Moved Permanently':
                    $result .= "<li class=\"list-group-item\">Версия с " . $value . "(<b>" . $url . "</b>) - Редирект (HTTP/1.1 301 Moved Permanently)";
                    echo "<br/>";
                    $result .= "(Редирект на " . str_replace("Location: ", "", $http_response_header[5]) . ")</li>";
                    break;
                case 'HTTP/1.1 401 Unauthorized':
                    $http_header++;
                    $result .= "<li class=\"list-group-item\">Версия с " . $value . "(<b>" . $url . "</b>) - Доступ на сайт запрещен (HTTP/1.1 401 Unauthorized)</li>";
                    break;
                case 'HTTP/1.1 500 Internal Server Error'://Создать ошибку, протестить
                    $http_header++;
                    $result .= "<li class=\"list-group-item\">Версия с " . $value . "(<b>" . $url . "</b>) - Ошибка на сайте (HTTP/1.1 500 Internal Server Error)</li>";
                    break;
            }
        };
        echo "</ul>";
        if ($http_header > 1) {
            $result .= "<div class=\"p-3 mb-2 bg-warning text-dark\">Необходимо настроить редирект на одно зеркало</div>";
            return $result;
        } else {
            $result .= "<div class=\"p-3 mb-2 bg-success text-white\">Все отлично, главное зеркало ".$domain_clear." настроено</div>";
            return $result;
        }
    } else {
        $result .= "<div class=\"p-3 mb-2 bg-danger text-white\">Сайт ".$domain_clear." не зарегистрирован или не размещен на сервере</div>";
        return $result;
    }
}