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
foreach ($domain_plus as $value) {

    $url = $value.$domain_clear;
    $code = get_headers($url, 1);
    echo $url." - ".$code[0];
    echo "<br/>";
};