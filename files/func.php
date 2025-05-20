<?php
//die();

class InstagramApi {
    private $url;
    private $proxy;

    public function __construct($url, $proxy) {
        $this->url = $url;
        $this->proxy = $proxy;
    }

    public function fetchData() {
        $response = $this->sendRequest();
        return $this->parseResponse($response);
//        return $response;
    }

    private function sendRequest() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    private function parseResponse($response) {
        return json_decode($response, true);
    }
}

$proxyList = [file_get_contents('https://apihub.ws/getproxy')];
// Функция для получения случайного прокси
function getRandomProxy($proxyList) {
    $randomIndex = array_rand($proxyList);
    return $proxyList[$randomIndex];
}

$page_id = "";
//$url = "https://www.instagram.com/p/CwVY16AONc1/?igshid=NTc4MTIwNjQ2YQ%3D";
$freeLikesLink = isset($_GET['link']) ? $_GET['link'] : "";

// Извлекаем значение между /p/ и /?igshid=

if (preg_match('/\/p\/([^\/?]+)/', $freeLikesLink, $matches)) {
    $page_id = $matches[1];
    $url = 'https://www.instagram.com/graphql/query/?doc_id=18222662059122027&variables={"child_comment_count":0,"fetch_comment_count":0,"has_threaded_comments":true,"parent_comment_count":0,"shortcode":"' . $page_id . '"}';
    $proxy = getRandomProxy($proxyList); // Укажите ваш прокс

    $data = "";
    $flag = true;
    while ($flag) {
//        $proxy = "http://resmerdk:rDvGDzZMmu@185.175.225.15:50100"; // Укажите ваш прокс
        $instagramApi = new InstagramApi($url, $proxy);
        $data = $instagramApi->fetchData();
        //$flag = !str_contains($data, "edge_media_preview_like");
        $flag = !$data;
    }
    if ($data) {
        $username = $data["data"]["shortcode_media"]["owner"]["username"];
        $likes = $data["data"]["shortcode_media"]["edge_media_preview_like"]["count"];
        echo json_encode(["username"=>$username, "likes"=>$likes]);
    }
} else {
    echo json_encode(["status"=>"error"]);
}