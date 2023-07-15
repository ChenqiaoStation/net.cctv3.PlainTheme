<?php
//声明：这是泽泽原创的api，虽然原理很简单，重要的是灵感，原理就是模拟读取移动端网友豆瓣的api接口。
//以下代码可供学习使用，切勿在互联网上泛滥，毕竟泛滥了，官方发现的概率就大了，被发现可能就用不了了。
function douban($id = "216943416", $type = "movie", $page = "1")
{
    header("Access-Control-Allow-Origin: *");
    define('CACHE', true);
    define('CACHE_TIME', 3600 * 24); //缓存时间间隔为24小时
    header('Content-type:text/json');

    $path = './Plain/cache/';
    //创建上传目录
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
    //电影
    $file_path = __TYPECHO_ROOT_DIR__ . '/Plain/cache/movie' . $id . '-' . $page . '.json';

    if ($type == 'book') { //图书
        $file_path = __TYPECHO_ROOT_DIR__ . '/Plain/cache/book' . $id . '-' . $page . '.json';
    }

    if (file_exists($file_path) && ($_SERVER['REQUEST_TIME'] - filectime($file_path) < CACHE_TIME)) {
        $json_strings = file_get_contents($file_path);
    } else {

        $start = ($page - 1) * 20;
        $json_strings = curl_file_get_contents('https://m.douban.com/rexxar/api/v2/user/' . $id . '/interests?type=' . $type . '&status=done&start=' . $start . '&count=20&ck=2mve&for_mobile=1', 'm');

        if (!empty(json_decode($json_strings, true)['total'])) {
            if (CACHE) {
                file_put_contents($file_path, $json_strings);
            }
        }
    }
    return $json_strings;
}

function curl_file_get_contents($_url, $type = 'www', $other = '')
{
    $ip_long = array(
        array('607649792', '608174079'), //36.56.0.0-36.63.255.255
        array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
        array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
        array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
        array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
        array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
        array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
        array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
        array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
        array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
    );

    $rand_key = mt_rand(0, 9);

    $ip = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));

    $header = array("Connection: Keep-Alive", "Accept: application/json", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36", 'CLIENT-IP:' . $ip, 'X-FORWARDED-FOR:' . $ip);

    $ch = curl_init();
    $cookie = '';
    curl_setopt($ch, CURLOPT_URL, $_url);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_REFERER, 'https://' . $type . '.douban.com/');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36');

    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function curl_download($url, $dir)
{

    $ch = curl_init($url);

    $fp = fopen($dir, "wb");

    curl_setopt($ch, CURLOPT_FILE, $fp);

    curl_setopt($ch, CURLOPT_HEADER, 0);

    $res = curl_exec($ch);

    curl_close($ch);

    fclose($fp);

    return $res;
}
