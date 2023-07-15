<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
//多域名跨域问题解决方案
define("rooturl", Helper::options()->rootUrl . '/'); //获取首页地址
define("thename", Helper::options()->theme); //定义模板名字
define("theurl", Helper::options()->rootUrl . __TYPECHO_THEME_DIR__ . '/' . Helper::options()->theme . '/'); //多域名跨域问题解决方案
define("getDomain", str_replace(array("https:", "http:", "/"), "", Helper::options()->rootUrl)); //获取domain

define("tepasssignin", Helper::options()->rootUrl . '/tepass/signin');
define("tepasssignup", Helper::options()->rootUrl . '/tepass/signup');
include('icons.php');
include("lib/shortcode.php");
include("lib/buju.php");
include("douban/index.php");
$request = Typecho\Request::getInstance();
$ajaxtype = $request->get('type', false);
define("ajaxtype", $ajaxtype);

$offset = '80'; //偏差值
\Typecho\Widget::widget('\Widget\Stat')->to($stat);
if ($stat->publishedPostsNum > 100) {
    $offset = '70';
}
if ($stat->publishedPostsNum > 300) {
    $offset = '50';
}
if ($stat->publishedPostsNum > 500) {
    $offset = '40';
}
if ($stat->publishedPostsNum > 1000) {
    $offset = '30';
} elseif ($stat->publishedPostsNum > 2000) {
    $offset = '20';
} elseif ($stat->publishedPostsNum > 3000) {
    $offset = '10';
} elseif ($stat->publishedPostsNum > 4000) {
    $offset = '4';
}
define("offset", $offset);


$logourl = theurl . 'img/icon.jpeg';
if (Helper::options()->logourl) {
    $logourl = Helper::options()->logourl;
}
define("logo", $logourl);

function themeConfig($form)
{
    $darkdisabled = '';
    if (!isset($_COOKIE['dark']) || $_COOKIE['dark'] == 'false' || $_COOKIE['dark'] == 'light') {
        $darkdisabled = ' disabled="true"';
    }
?>
    <link href="<?php echo theurl; ?>cssjs/admin.css?2023" rel="stylesheet" type="text/css">
    <link href="<?php echo theurl; ?>cssjs/admindark.css?2023" rel="stylesheet" type="text/css" title="dark" <?php echo $darkdisabled; ?>>
    <script type='text/javascript'>
        /* <![CDATA[ */
        var sitedata = {
            "url": "<?php echo rooturl; ?>"
        };
        /* ]]> */
    </script>
    <script type="text/javascript" src="<?php echo theurl; ?>cssjs/admin.js?2023"></script>
    <div class="card" style="margin: 0 10px 10px;text-align: center;">
        <h2 style="font-size: 2em;margin: 0;
    font-weight: bold;
    -webkit-background-clip: text;
    color: transparent;
    --tw-gradient-to: #ef4444;
    --tw-gradient-stops: #3b82f6, #ec4899, var(--tw-gradient-to, rgb(236 72 153 / 0));
    background-image: linear-gradient(to top right, var(--tw-gradient-stops));"><?php echo thename; ?></h2>
        <span style="font-size:14px">Design By Jrotty Version:<?php echo get_theme_version(); ?></span>
    </div>
    <?php

    if (strpos($_SERVER['SCRIPT_NAME'], "options-theme.php")) {
        echo require_once("lib/backup.php");
    }

    //侧边导航
    $form->addItem(new EchoHtml('<div class="shouquan" style="display:none"><a href="https://blog.zezeshe.com/archives/typecho-plain.html" target="_blank">点击这里前往主题授权页面</a></div><div class="isok"><div class="col-mb-4 col-tb-2"><div class="tab">'));
    $form->addItem(new EchoHtml('<div data-item="index" class="tabLinks active">基础设置</div>'));
    $form->addItem(new EchoHtml('<div data-item="layout" class="tabLinks">布局设置</div>'));
    $form->addItem(new EchoHtml('<div data-item="other" class="tabLinks">功能设置</div>'));
    $form->addItem(new EchoHtml('<div data-item="ad" class="tabLinks">广告设置</div>'));
    $form->addItem(new EchoHtml('<div data-item="say" class="tabLinks">说说设置</div>'));
    $form->addItem(new EchoHtml('<div data-item="menu" class="tabLinks">菜单设置</div>'));
    $form->addItem(new EchoHtml('</div></div>'));
    $form->addItem(new EchoHtml('<div class="col-mb-8 col-tb-10"><div class="card">'));


    $form->addItem(new EchoHtml('<div id="index" class="hiddenx" style="display:block">'));

    $subtitle = new Typecho_Widget_Helper_Form_Element_Text('subtitle', NULL, NULL, _t('副标题'), _t('据说填写了有利于seo'));
    $form->addInput($subtitle);

    $logourl = new Typecho_Widget_Helper_Form_Element_Text(
        'logourl',
        NULL,
        NULL,
        '头像或LOGO',
        '填入头像或logo图片地址，宽高为1:1的图片最佳'
    );
    $form->addInput($logourl);

    $header = new Typecho_Widget_Helper_Form_Element_Textarea('header', NULL, NULL, _t('头部信息'), _t('指html的<code>head</code>部分放置的内容，一般用来放置统计代码'));
    $form->addInput($header);

    $footer = new Typecho_Widget_Helper_Form_Element_Textarea('footer', NULL, NULL, '网站底部信息', _t('可用于填写备案号等内容'));
    $form->addInput($footer);


    $js = new Typecho_Widget_Helper_Form_Element_Textarea('js', NULL, NULL, _t('JavaScript代码放置区'), _t('可以放一些自定义的js函数'));
    $form->addInput($js);


    $rejs = new Typecho_Widget_Helper_Form_Element_Textarea('rejs', NULL, NULL, 'Pjax重载函数', _t('因为主题使用了pjax无刷新加载技术，可能会导致第三方js函数切换页面时不执行，此时可以填入对于js的重载函数<code></code>'));
    $form->addInput($rejs);

    $form->addItem(new EchoHtml('<button type="submit" class="btn primary">保存设置</button>'));
    $form->addItem(new EchoHtml('</div>'));


    $form->addItem(new EchoHtml('<div id="ad" class="hiddenx">'));
    //广告位1
    $ad = new Typecho_Widget_Helper_Form_Element_Textarea('ad', NULL, NULL, '文章底部横幅广告', _t('使用html语法自定义广告，例如谷歌登广告代码'));
    $form->addInput($ad);

    //广告位2
    $ad2 = new Typecho_Widget_Helper_Form_Element_Textarea('ad2', NULL, NULL, '列表区下广告', _t('使用html语法自定义广告，例如谷歌登广告代码'));
    $form->addInput($ad2);

    //广告位3
    $ad3 = new Typecho_Widget_Helper_Form_Element_Textarea('ad3', NULL, NULL, '首页底部', _t('使用html语法自定义广告，例如谷歌登广告代码'));
    $form->addInput($ad3);

    $form->addItem(new EchoHtml('<button type="submit" class="btn primary">保存设置</button>'));
    $form->addItem(new EchoHtml('</div>'));


    $form->addItem(new EchoHtml('<div id="other" class="hiddenx">'));

    $gonggao = new Typecho_Widget_Helper_Form_Element_Textarea('gonggao', NULL, NULL, _t('公告'), _t(''));
    $form->addInput($gonggao);

    $lunbo = new Typecho_Widget_Helper_Form_Element_Textarea('lunbo', NULL, NULL, _t('轮播图设置'), _t('设置方法：文章/广告链接$图片链接$标题$描述  ，然后换行输入下一个，如：<br>https://blog.zezeshe.com/archives/teadmin-typecho-plugin.html$https://p7.qhimg.com/bdr/__85/t01460f4ef7560e6ee2.jpg$Teadmin$Typecho后台主题插件！<br>
https://blog.zezeshe.com/archives/dinner-typecho-theme.html$https://p6.qhimg.com/bdr/__85/t010986f55c5c8aa2a6.jpg$Dinner$自适应的Typecho单栏/双栏主题<br>
https://blog.zezeshe.com/archives/sinner-typecho-theme.html$https://p8.qhimg.com/bdr/__85/t0182c808ffe79247b6.jpg$Sinner$简洁响应式Typecho主题<br><br>PS：标题与描述非必填项，图片推荐宽高比为3:1'));
    $form->addInput($lunbo);


    $sticky_cids = new Typecho_Widget_Helper_Form_Element_Text(
        'sticky_cids',
        NULL,
        '',
        '首页置顶文章的 cid',
        '按照排序输入, 请以半角逗号或空格分隔 cid.'
    );
    $form->addInput($sticky_cids);

    $douid = new Typecho_Widget_Helper_Form_Element_Text('douid', NULL, '216943416', _t('豆瓣账号id'), _t('填写您豆瓣id，然后新建独立页面，页面模板选择豆瓣影单即可建立专属您的豆瓣影单️'));
    $form->addInput($douid);

    $gravatars = new Typecho_Widget_Helper_Form_Element_Select(
        'gravatars',
        array(
            'https://cravatar.cn/avatar/' => _t('Cravatar[建议]'),
            'https://cdn.helingqi.com/avatar/' => _t('禾令奇[建议]'),
            'https://www.gravatar.com/avatar/' => _t('gravatar的www源'),
            'https://cn.gravatar.com/avatar/' => _t('gravatar的cn源'),
            'https://secure.gravatar.com/avatar/' => _t('gravatar的secure源'),
            'https://sdn.geekzu.org/avatar/' => _t('极客族'),
            'https://cdn.v2ex.com/gravatar/' => _t('v2ex源'),
            'https://dn-qiniu-avatar.qbox.me/avatar/' => _t('七牛源'),
            'https://gravatar.loli.net/avatar/' => _t('loli.net源[建议]'),
        ),
        'https://cdn.helingqi.com/avatar/',
        _t('gravatar头像源'),
        _t('默认使用https://cdn.helingqi.com/avatar/')
    );
    $form->addInput($gravatars->multiMode());

    $tools = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'tools',
        array(
            'spam' => _t('开启评论验证码功能'),
            'cc' => _t('开启文章版权显示'),
            'nocaiji' => _t('开启防采集功能（不建议开，可能会引发bug）'),
            'biaoqing' => _t('使用第三方表情（<a href="https://blog.zezeshe.com/doc/Plain/#/index" target="_blank">需要看文档配置</a>）'),
        ),
        array('cc'),
        _t('拓展设置')
    );
    $form->addInput($tools->multiMode());

    $code = new Typecho_Widget_Helper_Form_Element_Checkbox(
        'code',
        array(
            'on' => _t('开启代码高亮'),
            'lines' => _t('开启代码高亮行号显示'),
            'copy' => _t('开启代码复制功能'),
            'br' => _t('开启代码强制换行'),
        ),
        array(''),
        _t('代码高亮设置')
    );
    $form->addInput($code->multiMode());

    $form->addItem(new EchoHtml('<button type="submit" class="btn primary">保存设置</button></div>'));


    $form->addItem(new EchoHtml('<div id="menu" class="hiddenx">'));

    $menu = new Typecho_Widget_Helper_Form_Element_Textarea('menu', NULL, NULL, _t('菜单设置'), _t('<h3>格式如下：</h3><p>
    图标名字1$链接地址1$手机端是否隐藏$是否新窗口打开<br>
    图标名字2$链接地址2$手机端是否隐藏$是否新窗口打开<br>
    图标名字3$链接地址3$手机端是否隐藏$是否新窗口打开<br>
    图标名字4$链接地址4$手机端是否隐藏$是否新窗口打开
    </p>
    <h3>说明：</h3><p>
    图标名字：可以<a href="' . Helper::options()->rootUrl . '?icons=1" target="_blank" style="color: red;">【点击这里】</a>查看<br>
    链接地址：链接地址指的是超链接地址，同时还可以使用以下字符串调用内置页面<br>
<pre><code>首页：{index}，分类页：{cate}，更多：{page}</code></pre>
手机端是否隐藏：true/false （默认为false)<br>
是否新窗口打开：true/false （默认为false，此参数非必填项)
    </p><h3>主题默认的效果如：</h3><p>
    home${index}$false<br>
    tag${cate}$false<br>
    more${page}$false
    </p>
    '));
    $form->addInput($menu);
    $form->addItem(new EchoHtml('<button type="submit" class="btn primary">保存设置</button></div>'));
    $form->addItem(new EchoHtml('<div id="say" class="hiddenx">'));

    $saytt = new Typecho_Widget_Helper_Form_Element_Text(
        'saytt',
        NULL,
        NULL,
        '头图',
        '建议使用风景壁纸，这个怎么裁切都不会太违和'
    );
    $form->addInput($saytt);

    $saytx = new Typecho_Widget_Helper_Form_Element_Text(
        'saytx',
        NULL,
        'https://thirdqq.qlogo.cn/g?b=sdk&k=C7tkVyuH6VClRTXjKSFYFQ&kti=ZBaelgAAAAE&s=100&t=1672198335',
        '头像或LOGO',
        '填入头像图片地址，宽高为1:1的图片'
    );
    $form->addInput($saytx);

    $sayname = new Typecho_Widget_Helper_Form_Element_Text(
        'sayname',
        NULL,
        '泽泽社长',
        '昵称',
        '头图右下方的昵称'
    );
    $form->addInput($sayname);

    $saydes = new Typecho_Widget_Helper_Form_Element_Text(
        'saydes',
        NULL,
        '有些人光是遇到就已经赚到了',
        '描述',
        '头图右下方的描述'
    );
    $form->addInput($saydes);

    $saypage = [];
    for ($i = 8; $i <= 24; $i++) {
        $saypage[$i] = '每页显示' . $i . '条说说';
    }
    $saypage = new Typecho_Widget_Helper_Form_Element_Select(
        'saypage',
        $saypage,
        '8',
        _t('说说分页设置'),
        _t('每页你想显示几条说说，默认为8条')
    );
    $form->addInput($saypage->multiMode());

    $form->addItem(new EchoHtml('<button type="submit" class="btn primary">保存设置</button></div>'));

    $form->addItem(new EchoHtml('<div id="layout" class="hiddenx">'));

    $liststyle = new Typecho_Widget_Helper_Form_Element_Select(
        'liststyle',
        array(
            'img' => _t('朴素文章列表'),
            'color' => _t('多彩文章列表'),
            'text' => _t('纯文字文章列表'),
        ),
        'img',
        _t('文章列表样式'),
        _t('可以设置全局文章列表样式，多彩文章是可以根据封面图自动取色的（取色点为水平居中向下10%的位置）')
    );
    $form->addInput($liststyle->multiMode());

    $layout = new Typecho_Widget_Helper_Form_Element_Radio('layout', array(
        'full' => _t('平铺布局'),
        'box' => _t('盒子布局'),
        'mini' => _t('简约布局'),
    ), 'full', _t('默认布局'), _t('当用户未在前台设置网站布局时默认的布局'));
    $form->addInput($layout);

    $form->addItem(new EchoHtml('<button type="submit" class="btn primary">保存设置</button></div>'));

    $form->addItem(new EchoHtml('</div></div></div>'));
}

function spam_protection_math()
{
    $num1 = rand(1, 38);
    $num2 = rand(1, 38);
    echo "<div>";
    echo "<input type=\"text\" name=\"sum\" class=\"w-full rounded py-1.5 px-1 text-sm comment-form-body text-gray-900 border-gray-100 bg-slate-100 dark:bg-gray-700 dark:text-gray-100\" value=\"\" size=\"25\" tabindex=\"4\" placeholder=\"$num1+$num2=？\" required>\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\"></div>";
}

function themeInit($archive)
{
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    // 强奸用户，强制用户文章最新评论显示在文章首页
    Helper::options()->commentsPageDisplay = 'first';
    // 强奸用户，将较新的评论显示在前面
    Helper::options()->commentsOrder = 'DESC';
    // 强奸程序，突破评论回复楼层限制
    Helper::options()->commentsMaxNestingLevels = 999;

    Helper::options()->commentsHTMLTagAllowed = Helper::options()->commentsHTMLTagAllowed . '<img class="" src="" title="">';

    // 为文章或页面、post操作，且包含参数`themeAction=comment`(自定义)
    if ($archive->is('single') && $archive->request->isPost() && $archive->request->is('themeAction=comment')) {
        ajaxComment($archive);
    }

    if ($archive->is('index') && $archive->request->isGet() && $archive->request->get('xid')) {
        $c = $archive->request->get('xid');
        $db = Typecho_Db::get();
        $f = str_replace('@qq.com', '', $c);
        if (is_numeric($f) && strlen($f) < 11 && strlen($f) > 4) {
            stream_context_set_default([
                'ssl' => [
                    'verify_host' => false,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);
            $geturl = 'https://s.p.qq.com/pub/get_face?img_type=3&uin=' . $f;
            $headers = @get_headers($geturl, TRUE);
            if ($headers) {
                $g = $headers['Location'];
                $g = str_replace("http:", "https:", $g);
            } else {
                $g = '//q.qlogo.cn/g?b=qq&nk=' . $f . '&s=100';
            }
        } else {
            $g = tx($c, 1);
        }
        $r['url'] = $g;
        if ($archive->request->info) {
            $info = $db->fetchRow($db->select('author', 'url')->from('table.comments')
                ->where('table.comments.mail = ?', $c)
                ->order('table.comments.created', Typecho_Db::SORT_DESC));
            if ($info) {
                $r['info'] = $info;
            } else {
                $r['info'] = array('author' => '', 'url' => '');
            }
        }
        echo json_encode($r);
        exit;
    }


    /*QQ头像api*/
    if ($archive->request->isGet() && $archive->request->get('id')) {
        $coid = $archive->request->get('id');
        if (!array_key_exists('qq', $db->fetchRow($db->select()->from('table.comments')->page(1, 1)))) {
            $db->query('ALTER TABLE `' . $prefix . 'comments` ADD `qq` varchar(255) DEFAULT NULL;');
        }
        $plinfo = $db->fetchRow($db->select('mail', 'qq')->from('table.comments')->where('table.comments.coid=?', $coid)->where('table.comments.status=?', 'approved'));
        if (!empty($plinfo['qq'])) {
            $g = $plinfo['qq'];
        } else {

            $c = $plinfo['mail'];
            $f = str_replace('@qq.com', '', $c);
            if (strstr($c, "qq.com") && is_numeric($f) && strlen($f) < 11 && strlen($f) > 4) {
                stream_context_set_default([
                    'ssl' => [
                        'verify_host' => false,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]);
                $geturl = 'https://s.p.qq.com/pub/get_face?img_type=3&uin=' . $f;
                $headers = @get_headers($geturl, TRUE);
                if ($headers) {
                    $g = $headers['Location'];
                    if (is_array($g) && count($g) > 1) {
                        $g = $g[0];
                    }
                    $g = str_replace("http:", "https:", $g);
                    $db->query($db->update('table.comments')->rows(array('qq' => $g . '&byzeze'))->where('coid = ?', $coid));
                } else {
                    $g = '//q.qlogo.cn/g?b=qq&nk=' . $f . '&s=100';
                }
            } else {
                $g = tx($c, 1);
            }
        }
        $r = array('url' => $g);
        echo json_encode($r);
        exit;
    }
    include("lib/api.php");
}

//随便看看
function randomPost($type = 'echo')
{
    $db = Typecho_Db::get();
    $result = $db->fetchRow($db->select()->from('table.contents')->where('type=?', 'post')->where('status=?', 'publish')->limit(1)->order('RAND()'));
    if ($result) {
        $f = Helper::widgetById('Contents', $result['cid']);
        $permalink = $f->permalink;
        if ($type == "return") {
            return $permalink;
        } else {
            echo $permalink;
        }
    } else {
        echo "没有文章可随机";
    }
}

function showThumbnail($widget, $type = 0, $rand = 0)
{
    $random = theurl . 'img/slt/' . rand(1, 99) . '.jpg'; //这里时默认缩略图
    $pattern = '/\<img.*?\ssrc\=\"(.*?)\"[^>]*>/i';
    $attach = $widget->widget('Widget_Contents_Attachment_Related@' . $widget->cid . '-' . uniqid(), array(
        'parentId'  => $widget->cid, 'limit'     => 1, 'offset'    => 0
    ))->attachment;
    $t = preg_match_all($pattern, $widget->content, $thumbUrl);
    if (!$t) {
        $pattern = '/\<a.*?data\-xurl\=\"(.*?)\"[^>]*>/i';
        $t = preg_match_all($pattern, $widget->content, $thumbUrl);
    }
    $img = $random;

    if ($widget->fields->img) {
        $img = $widget->fields->img;
    } elseif ($t && strpos($thumbUrl[1][0], 'icon.png') == false && strpos($thumbUrl[1][0], 'alipay') == false && strpos($thumbUrl[1][0], 'wechat') == false) {
        $img = $thumbUrl[1][0];
    } //从文章中获取封面
    elseif ($widget->fields->thumb) {
        $img = $widget->fields->thumb;
    } //自定义字段设置封面
    elseif (@$attach->isImage) {
        $img = $attach->url;
    } //从附件中获取封面
    //$img= str_replace("https://","",$img);
    //$img= str_replace("http://","",$img);
    //$img='https://i2.wp.com/'.$img;
    if ($type == 0) {
        if ($img == $random) {
            echo $img;
        } else {
            echo $img . Helper::options()->thumbnail;
        } //输出封面图
    } else {
        if ($img == $random) {
            return $img;
        } else {
            return $img . Helper::options()->thumbnail;
        } //输出封面图     
    }
}
//自定义缩略内容
function excerpt($obj, int $length = 100, string $trim = '...', $type = 'echo')
{
    $text = $obj->excerpt;
    $text = preg_replace('#\{video(.*?)?}(.*?){\/video}#', '', $text);
    $text = preg_replace('#\{login}(.*?){\/login}#', '', $text);
    $text = preg_replace('#\{(.*?)\}#', '', $text);
    $text = preg_replace('#　#', '', $text);

    if ($type == 'echo') {
        echo Typecho_Common::subStr(strip_tags($text), 0, $length, $trim);
    } else {
        return Typecho_Common::subStr(strip_tags($text), 0, $length, $trim);
    }
}

function tx($mail, $re = 0, $type = "blank")
{
    if (defined('__TYPECHO_GRAVATAR_PREFIX__')) {
        $b = __TYPECHO_GRAVATAR_PREFIX__;
    } else {
        $b = Helper::options()->gravatars;
    }
    $mail = strtolower($mail);
    $qq = str_replace('@qq.com', '', $mail);
    if (strstr($mail, "qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4) {
        $g = '//q.qlogo.cn/g?b=qq&nk=' . $qq . '&s=100';
    } else {
        $d = md5($mail);
        $g = $b . $d . '?d=' . $type;
    }
    if ($re == 1) {
        return $g;
    } else {
        echo $g;
    }
}

function commenttx($mail, $id = 0)
{
    $mail = strtolower($mail);
    $qq = str_replace('@qq.com', '', $mail);
    if (strstr($mail, "qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4) {
        $g['url'] = Helper::options()->rootUrl . '?id=' . $id;
        $g['type'] = 'qq';
    } else {
        $g['url'] = tx($mail, 1);
        $g['type'] = 'gravatar';
    }
    return $g;
}

function get_post_view($archive, $r = 0)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')->page(1, 1)))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        if ($r == 0) {
            echo 1;
        }
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
        if (empty($views)) {
            $views = array();
        } else {
            $views = explode(',', $views);
        }
        if (!in_array($cid, $views)) {
            $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
            $views = implode(',', $views);
            Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
        }
    }
    if ($r == 0) {
        echo $row['views'];
    } else {
        return $row['views'];
    }
}

/**
 * ajaxComment
 * 实现Ajax评论的方法(实现feedback中的comment功能)
 * @param Widget_Archive $archive
 * @return void
 */
function ajaxComment($archive)
{
    $options = Helper::options();
    $user = \Typecho\Widget::widget('\Widget\User');
    $db = Typecho_Db::get();
    // Security 验证不通过时会直接跳转，所以需要自己进行判断
    // 需要开启反垃圾保护，此时将不验证来源
    //if($archive->request->get('_') != Helper::security()->getToken($archive->request->getReferer())){
    //   $archive->response->throwJson(array('status'=>0,'msg'=>_t('请求出现问题，请刷新重试！')));
    //}
    /** 评论关闭 */
    if (!$archive->allow('comment')) {
        $archive->response->throwJson(array('status' => 0, 'msg' => _t('评论已关闭')));
    }

    /** 检查ip评论间隔 */
    if (
        !$user->pass('editor', true) && $archive->authorId != $user->uid &&
        $options->commentsPostIntervalEnable
    ) {
        $latestComment = $db->fetchRow($db->select('created')->from('table.comments')
            ->where('cid = ?', $archive->cid)
            ->where('ip = ?', $archive->request->getIp())
            ->order('created', Typecho_Db::SORT_DESC)
            ->limit(1));

        if ($latestComment && ($options->gmtTime - $latestComment['created'] > 0 &&
            $options->gmtTime - $latestComment['created'] < $options->commentsPostInterval)) {
            $archive->response->throwJson(array('status' => 0, 'msg' => _t('对不起, 您的发言过于频繁, 请稍侯再次发布')));
        }
    }

    $getAgent = $archive->request->getAgent();
    if (isset($_COOKIE['win11'])) {
        $getAgent = str_replace("Windows NT 10.0", "Windows NT 11.0", $archive->request->getAgent());
    }

    $comment = array(
        'cid'       =>  $archive->cid,
        'created'   =>  $options->gmtTime,
        'agent'     =>  $getAgent,
        'ip'        =>  $archive->request->getIp(),
        'ownerId'   =>  $archive->author->uid,
        'type'      =>  'comment',
        'status'    =>  !$archive->allow('edit') && $options->commentsRequireModeration ? 'waiting' : 'approved'
    );

    /** 判断父节点 */
    if ($parentId = $archive->request->filter('int')->get('parent')) {
        if ($options->commentsThreaded && ($parent = $db->fetchRow($db->select('coid', 'cid')->from('table.comments')
            ->where('coid = ?', $parentId))) && $archive->cid == $parent['cid']) {
            $comment['parent'] = $parentId;
        } else {
            $archive->response->throwJson(array('status' => 0, 'msg' => _t('父级评论不存在')));
        }
    }
    $feedback = \Typecho\Widget::widget('\Widget\Feedback');
    //检验格式
    $validator = new Typecho_Validate();
    $validator->addRule('author', 'required', _t('必须填写用户名'));
    $validator->addRule('author', 'xssCheck', _t('请不要在用户名中使用特殊字符'));
    $validator->addRule('author', array($feedback, 'requireUserLogin'), _t('您所使用的用户名已经被注册,请登录或更换昵称再次提交'));
    $validator->addRule('author', 'maxLength', _t('用户名最多包含200个字符'), 200);

    if ($options->commentsRequireMail && !$user->hasLogin()) {
        $validator->addRule('mail', 'required', _t('必须填写电子邮箱地址'));
    }

    $validator->addRule('mail', 'email', _t('邮箱地址不合法'));
    $validator->addRule('mail', 'maxLength', _t('电子邮箱最多包含200个字符'), 200);

    if ($options->commentsRequireUrl && !$user->hasLogin()) {
        $validator->addRule('url', 'required', _t('必须填写个人主页'));
    }
    $validator->addRule('url', 'url', _t('个人主页地址格式错误'));
    $validator->addRule('url', 'maxLength', _t('个人主页地址最多包含200个字符'), 200);

    $validator->addRule('text', 'required', _t('必须填写评论内容'));


    if (strpos($archive->request->text, 'script>') !== false) {
        $archive->response->throwJson(array('status' => 0, 'msg' => _t('请不要输入js相关代码！')));
    }


    $comment['text'] = $archive->request->text;


    if (!empty(Helper::options()->tools) && in_array('spam', Helper::options()->tools) && !$user->hasLogin()) {
        if ($archive->request->sum) {
            if ($archive->request->sum != ($archive->request->num1 + $archive->request->num2)) {
                $archive->response->throwJson(array('status' => 0, 'msg' => _t('验证码输入错误，请您重新输入！')));
            }
        } else {
            $archive->response->throwJson(array('status' => 0, 'msg' => _t('检测到您没有输入验证码，请您输入验证码！')));
        }
    }

    /** 对一般匿名访问者,将用户数据保存一个月 */
    if (!$user->hasLogin()) {
        /** Anti-XSS */
        $comment['author'] = $archive->request->filter('trim')->author;
        $comment['mail'] = $archive->request->filter('trim')->mail;
        $comment['url'] = $archive->request->filter('trim', 'url')->url;

        /** 修正用户提交的url */
        if (!empty($comment['url'])) {
            $urlParams = parse_url($comment['url']);
            if (!isset($urlParams['scheme'])) {
                $comment['url'] = 'http://' . $comment['url'];
            }
        }

        $expire = $options->gmtTime + $options->timezone + 30 * 24 * 3600;
        Typecho_Cookie::set('__typecho_remember_author', $comment['author'], $expire);
        Typecho_Cookie::set('__typecho_remember_mail', $comment['mail'], $expire);
        Typecho_Cookie::set('__typecho_remember_url', $comment['url'], $expire);
    } else {
        $comment['author'] = $user->screenName;
        $comment['mail'] = $user->mail;
        $comment['url'] = $user->url;

        /** 记录登录用户的id */
        $comment['authorId'] = $user->uid;
    }

    /** 评论者之前须有评论通过了审核 */
    if (!$options->commentsRequireModeration && $options->commentsWhitelist) {
        if ($feedback->size($feedback->select()->where('author = ? AND mail = ? AND status = ?', $comment['author'], $comment['mail'], 'approved'))) {
            $comment['status'] = 'approved';
        } else {
            $comment['status'] = 'waiting';
        }
    }

    if ($error = $validator->run($comment)) {
        $archive->response->throwJson(array('status' => 0, 'msg' => implode(';', $error)));
    }


    if ($archive->hidden) {
        $archive->response->throwJson(array('status' => 0, 'msg' => _t('加密文章！输入正确密码后方可进行评论！')));
    }

    /** 生成过滤器 */
    try {
        $comment = $feedback->pluginHandle()->comment($comment, $feedback->_content);
    } catch (Typecho_Exception $e) {
        Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
        $archive->response->throwJson(array('status' => 0, 'msg' => _t($e->getMessage())));
        throw $e;
    }


    $status = "";
    if ('waiting' == $comment['status']) {
        $status = '您的评论需管理员审核后才能显示！';
    }

    $sf = "";
    $shenfen = 0;
    if ($user->uid > 0) {
        if ($user->uid == $archive->authorId) {
            $sf = '<svg class="w-5 h-5 ml-0.5" aria-hidden="true"><use xlink:href="#lanv"></use></svg>';
            $shenfen = 1;
        }
    }

    if ($archive->template == 'say.php') {
        if ($shenfen == 0 && $parentId == 0) {
            $archive->response->throwJson(array('status' => 0, 'msg' => _t('非管理员无法发布说说！')));
        }
    }

    /** 添加评论 */
    $commentId = $feedback->insert($comment);

    Typecho_Cookie::delete('__typecho_remember_text');
    $db->fetchRow($feedback->select()->where('coid = ?', $commentId)
        ->limit(1), array($feedback, 'push'));

    $feedback->text = parseBiaoQing($feedback->text); //尝试让表情进入邮件

    $feedback->pluginHandle()->finishComment($feedback);

    if ($archive->template == 'say.php') {
        $cos = $feedback->content;
        $cos = preg_replace(
            '#<a(.*?) href="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#',
            '<a$1 href="$2$3"$5 class="text-sky-500" target="_blank" rel="nofollow" data-ajax="false">',
            $cos
        );
        if ($parentId == 0) {
            $cos = preg_replace('#<p>#', '<p class="mb-3">', $cos);
            $cos = preg_replace('#<img(.*?)>#', '<img$1 referrerpolicy="no-referrer">', $cos);
            $cos = buju($cos);
            $cos = setshortcode($cos);
        } else {
            $cos = preg_replace('#<img src="(.*?)"(.*?)>#', '<a class="mx-0.5 text-sky-500 view-image" href="$1" nopjax>图片</a>', $cos);
            $cos = preg_replace('#<p>#', '', $cos);
            $cos = preg_replace('#<\/p>#', '', $cos);
            $cos = preg_replace('#<br\s*/?>#', '', $cos);
        }
        $feedback->content = $cos;
    }

    // 返回评论数据
    $data = array(
        'cid' => $feedback->cid,
        'coid' => $feedback->coid,
        'parent' => $feedback->parent,
        'mail' => $feedback->mail,
        'url' => $feedback->url,
        'ip' => $feedback->ip,
        'agent' => $feedback->agent,
        'author' => $feedback->author,
        'authorId' => $feedback->authorId,
        'permalink' => $feedback->permalink,
        'created' => timesince($feedback->created),
        'datetime' => $feedback->date->format('Y-m-d H:i:s'),
        'content' => $feedback->content,
        'status' => $status,
        'sf' => $sf,
    );
    $data['avatar'] = tx($data['mail'], 1, 'mm');
    $archive->response->throwJson(array('status' => 1, 'comment' => $data));
}

function timesince($time, $type = false)
{
    if (!empty(Helper::options()->tools) && in_array('dateformat', Helper::options()->tools)) {
        return date('Y年m月d日', $time);
    } else {
        $text = '';
        $time = $time === NULL || $time > time() ? time() : intval($time);
        $t = time() - $time; //时间差 （秒）
        $y = date('Y', $time) - date('Y', time()); //是否跨年
        if ($type == "day") {
            switch ($t) {
                case $t == 0:
                    $text = '刚刚';
                    break;
                case $t < 60:
                    $text = $t . '秒前'; // 一分钟内
                    break;
                case $t < 60 * 60:
                    $text = floor($t / 60) . '分钟前'; //一小时内
                    break;
                case $t < 60 * 60 * 24:
                    $text = floor($t / (60 * 60)) . '小时前'; // 一天内
                    break;
                case $t < 60 * 60 * 24 * 3:
                    $text = floor($time / (60 * 60 * 24)) == 1 ? '昨天 ' : '前天 '; //昨天和前天
                    break;
                default:
                    $text = floor($t / (60 * 60 * 24)) . '天前'; //一个月内
                    break;
            }
        } else {
            switch ($t) {
                case $t == 0:
                    $text = '刚刚';
                    break;
                case $t < 60:
                    $text = $t . '秒前'; // 一分钟内
                    break;
                case $t < 60 * 60:
                    $text = floor($t / 60) . '分钟前'; //一小时内
                    break;
                case $t < 60 * 60 * 24:
                    $text = floor($t / (60 * 60)) . '小时前'; // 一天内
                    break;
                case $t < 60 * 60 * 24 * 3:
                    $text = floor($time / (60 * 60 * 24)) == 1 ? '昨天 ' : '前天 '; //昨天和前天
                    break;
                case $t < 60 * 60 * 24 * 30:
                    $text = floor($t / (60 * 60 * 24)) . '天前'; //一个月内
                    break;
                case $t < 60 * 60 * 24 * 365 && $y == 0:
                    $text = date('m月d日', $time); //一年内
                    break;
                default:
                    $text = date('Y年m月d日', $time); //一年以前
                    break;
            }
        }
        return $text;
    }
}

function get_comment_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')
        ->where('coid = ?', $coid));
    $parent = $prow['parent'];
    if (!empty($parent)) {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')
            ->where('coid = ? AND status = ?', $parent, 'approved'));
        if (!empty($arow['author'])) {
            $author = $arow['author'];
            $href   = '<a class="text-sky-500 mr-0.5" href="#comment-' . $parent . '">@' . $author . '</a>';
            echo $href;
        } else {
            echo '';
        }
    } else {
        echo '';
    }
}

function parsePaopaoBiaoqingCallback($match)
{
    return '<img class="biaoqing" no-view src="' . theurl . '/assets/owo/paopao/' . str_replace('%', '', urlencode($match[1])) . '_2x.png">';
}

function parseAruBiaoqingCallback($match)
{
    return '<img class="biaoqing" no-view src="' . theurl . '/assets/owo/aru/' . str_replace('%', '', urlencode($match[1])) . '_2x.png">';
}

function parseBiaoqingCallback($match)
{
    if (file_exists(__TYPECHO_ROOT_DIR__ . '/Plain/biaoqing/' . $match[1] . '.png')) {
        return '<img class="biaoqing" no-view alt="' . $match[1] . '" src="' . rooturl . 'Plain/biaoqing/' . urlencode($match[1]) . '.png">';
    } else {
        return ':(' . $match[1] . ')';
    }
}

function parseBiaoQing($content)
{
    $content = preg_replace_callback(
        '/\:\:\(\s*(呵呵|哈哈|吐舌|太开心|笑眼|花心|小乖|乖|捂嘴笑|滑稽|你懂的|不高兴|怒|汗|黑线|泪|真棒|喷|惊哭|阴险|鄙视|酷|啊|狂汗|what|疑问|酸爽|呀咩爹|委屈|惊讶|睡觉|笑尿|挖鼻|吐|犀利|小红脸|懒得理|勉强|爱心|心碎|玫瑰|礼物|彩虹|太阳|星星月亮|钱币|茶杯|蛋糕|大拇指|胜利|haha|OK|沙发|手纸|香蕉|便便|药丸|红领巾|蜡烛|音乐|灯泡|开心|钱|咦|呼|冷|生气|弱|吐血|狗头)\s*\)/is',
        'parsePaopaoBiaoqingCallback',
        $content
    );
    $content = preg_replace_callback(
        '/\:\@\(\s*(高兴|小怒|脸红|内伤|装大款|赞一个|害羞|汗|吐血倒地|深思|不高兴|无语|亲亲|口水|尴尬|中指|想一想|哭泣|便便|献花|皱眉|傻笑|狂汗|吐|喷水|看不见|鼓掌|阴暗|长草|献黄瓜|邪恶|期待|得意|吐舌|喷血|无所谓|观察|暗地观察|肿包|中枪|大囧|呲牙|抠鼻|不说话|咽气|欢呼|锁眉|蜡烛|坐等|击掌|惊喜|喜极而泣|抽烟|不出所料|愤怒|无奈|黑线|投降|看热闹|扇耳光|小眼睛|中刀)\s*\)/is',
        'parseAruBiaoqingCallback',
        $content
    );
    $content = preg_replace_callback('/\:\((.*?)\)/', 'parseBiaoqingCallback', $content);
    return $content;
}

//下一篇
function theNext($widget)
{
    $t = \Typecho\Widget::widget('Widget_Archive@next'); //@的作用我之前也有讲过，就是用来区分的，这里的$t就是定义的$this
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where(
            'table.contents.created > ? AND table.contents.created < ?',
            $widget->created,
            time()
        )
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where("table.contents.password IS NULL OR table.contents.password = ''")
        ->order('table.contents.created', Typecho_Db::SORT_ASC)
        ->limit(1); //sql查询下一篇文章
    $db->fetchAll($sql, array($t, 'push')); //这个代码就是如何将查询结果封到$this里的
    return $t; //返回变量
}

//上一篇 
function thePrev($widget)
{
    $t = \Typecho\Widget::widget('Widget_Archive@prev'); //@的作用我之前也有讲过，就是用来区分的，@后面参数随便只要和上边的不一样就行
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created < ?', $widget->created)
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where("table.contents.password IS NULL OR table.contents.password = ''")
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit(1); //sql查询上一篇文章
    $db->fetchAll($sql, array($t, 'push'));
    return $t; //返回变量
}

//归档函数
function archives($widget, $excerpt = false)
{
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select()
        ->from('table.contents')
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->where('table.contents.type = ?', 'post')
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.created < ?', time()));
    $stat = array();
    foreach ($rows as $row) {
        $row = $widget->filter($row);
        $arr = array(
            'title' => $row['title'],
            'permalink' => $row['permalink'],
            'commentsNum' => $row['commentsNum'],
            'views' => $row['views'],
        );
        if ($excerpt) {
            $arr['excerpt'] = substr($row['content'], 30);
        }
        $stat[date('Y', $row['created'])][$row['created']] = $arr;
    }
    return $stat;
}
/**
 * 首字母头像
 * @param $text
 * @return string
 */
function letter_avatarx($text)
{
    $total = unpack('L', hash('adler32', $text, true))[1];
    $hue = $total % 360;
    list($r, $g, $b) = hsv2rgbx($hue / 360, 0.3, 0.9);
    $bg = "rgb({$r},{$g},{$b})";
    $color = "#ffffff";
    $first = mb_strtoupper(mb_substr($text, 0, 1));
    $src = base64_encode('<svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="100" width="100"><rect fill="' . $bg . '" x="0" y="0" width="100" height="100"></rect><text x="50" y="50" font-size="50" text-copy="fast" fill="' . $color . '" text-anchor="middle" text-rights="admin" alignment-baseline="central">' . $first . '</text></svg>');
    return 'data:image/svg+xml;base64,' . $src;
}
function hsv2rgbx($h, $s, $v)
{
    $r = $g = $b = 0;
    $i = floor($h * 6);
    $f = $h * 6 - $i;
    $p = $v * (1 - $s);
    $q = $v * (1 - $f * $s);
    $t = $v * (1 - (1 - $f) * $s);
    switch ($i % 6) {
        case 0:
            $r = $v;
            $g = $t;
            $b = $p;
            break;
        case 1:
            $r = $q;
            $g = $v;
            $b = $p;
            break;
        case 2:
            $r = $p;
            $g = $v;
            $b = $t;
            break;
        case 3:
            $r = $p;
            $g = $q;
            $b = $v;
            break;
        case 4:
            $r = $t;
            $g = $p;
            $b = $v;
            break;
        case 5:
            $r = $v;
            $g = $p;
            $b = $q;
            break;
    }
    return [
        floor($r * 255),
        floor($g * 255),
        floor($b * 255)
    ];
}

// 判断是否搜索引擎机器人访问
function isRobot()
{
    $crawler_agents = array(
        "Googlebot", "Bingbot", "Yahoo! Slurp",
        "DuckDuckBot", "YandexBot", "Sogou",
        "Exabot", "Facebot", "ia_archiver",
        "AdsBot-Google-Mobile", "AdsBot-Google",
        "TwengaBot", "ZIBB", "Sosospider+",
        "Safari/10600.5.1.11 CFNetwork/720.5.7 Darwin/14.5.0",
        "facebookexternalhit/1.1",
        "Baiduspider", "Baiduspider-image", "Baiduspider-video",
        "Yeti/1.0", "HaosouSpider", "360spider", "360Spider"
    );
    foreach ($crawler_agents as $agent) {
        if (stripos($_SERVER['HTTP_USER_AGENT'], $agent) !== false) {
            return true;
        }
    }
    return false;
}

function get_theme_version()
{
    $info = Typecho_Plugin::parseInfo(__DIR__ . '/index.php');
    return $info['version'];
}


function gengxin($new)
{
    if ($new->fields->mp4) {
        $num = 0;
        $spurl = $new->fields->mp4;
        if (strpos($new->fields->mp4, '$') == false) {
            $spurl = '全集$' . $spurl;
        }
        $string_arr = array_filter(explode("\r\n", $spurl));
        $num = count($string_arr); //视频参数段落数，可作为粗略的集数进行显示
        $numx = $num; //全集时的集数显示
        $jiend = array_filter(explode('$', $string_arr[$num - 1]))[0]; //获取视频参数最后一段的集数文字信息
        preg_match_all("/[a-zA-Z0-9]+/", $jiend, $x);
        $end = join("", $x[0]); //提取集数信息中的字母与数字
        if (!empty($end)) {
            if (preg_match('/[a-zA-Z]/', $end)) {
                $num = $end;
            } else {
                $num = intval($end);
            }
        } //如果提取到了就将它作为最新集数进行显示

        if ($new->fields->zhuangtai > 0) {

            echo '更新至' . $num . '集';
        } elseif ($new->fields->zhuangtai == -1) {
            echo '预告';
        } elseif (strlen($new->fields->mp4) < 10) {
            $new->category(',', false);
        } else {
            echo $numx . '集全';
        }
    } else {
        echo '未更新';
    }
}

class Widget_Post_cat extends Widget_Abstract_Metas
{
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
    }
    public function execute()
    {
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();
        $select  = $this->select()->from($prefix . 'metas')
            ->where('table.metas.parent = ?', $this->parameter->mid) //从所有分类中找到爸爸是这个mid的
            ->where('table.metas.type = ?', 'category')
            ->order('table.metas.order', Typecho_Db::SORT_ASC);
        $this->db->fetchAll($select, array($this, 'push'));
    }
}

class Widget_Post_ct extends Widget_Abstract_Contents
{
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
    }
    public function execute()
    {
        $select  = $this->select()->from('table.contents')
            ->join('table.relationships', 'table.contents.cid = table.relationships.cid');

        $select->where('table.relationships.mid = ?', $this->parameter->mid)
            ->where("table.contents.status = 'publish'")
            ->where('table.contents.type = ?', 'post')
            ->limit($this->parameter->pageSize)
            ->order('table.contents.modified', Typecho_Db::SORT_DESC);
        $this->db->fetchAll($select, [$this, 'push']);
    }
}


class Widget_Post_News extends Widget_Abstract_Contents
{
    public function execute()
    {
        $select = $this->select()->where('table.contents.type = ?', 'post')
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.password IS NULL')
            ->where('table.contents.created < ?', $this->options->time);

        $this->countSql = clone $select;

        if (false === $this->total) {
            $this->total = $this->size($this->countSql);
        }

        $select->order('table.contents.created', \Typecho\Db::SORT_DESC)
            ->page($this->parameter->currentPage, $this->parameter->pageSize);
        $this->query($select);

        $this->db->fetchAll($select, [$this, 'push']);
    }
}

\Typecho\Plugin::factory('admin/footer.php')->end = array('plgl', 'mbupdate');
\Typecho\Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('plgl', 'one');
\Typecho\Plugin::factory('Widget_Abstract_Contents')->contentEx = array('plgl', 'one');
class plgl
{
    public static function one($con, $obj, $text)
    {
        $text = empty($text) ? $con : $text;
        if (!$obj->is('single')) {
            $text = preg_replace('#\{login\}(.*?)\{\/login\}#', '(抱歉，隐藏内容登陆后可见)', $text);
            $text = preg_replace('#(<p>)?\{center\}(.*?)\{\/center\}(<\/p>)?#', '<center class="mb-3">$2</center>', $text);
            $text = preg_replace('#(\{grid(.*?)?\})#', '', $text);
            $text = preg_replace('#(\{\/grid\})#', '', $text);
            $text = preg_replace('#(\{card\})#', '', $text);
            $text = preg_replace('#(\{\/card\})#', '', $text);
            $text = preg_replace('#\{div(.*?)\}#', '<div$1>', $text);
            $text = preg_replace('#\{\/div\}#', '</div>', $text);
            $text = preg_replace('#\{br\}#', '<br>', $text);
        }
        return $text;
    }

    public static function mbupdate()
    {
    ?>
        <script>
            $(document).ready(function() {
                if ($("#theme-Plain").length > 0) {
                    var sinnertwonum = $("#theme-Plain cite").text();
                    var sinnertwoupurl = $("#theme-Plain cite a").attr("href");
                    sinnertwonum = sinnertwonum.replace(/[^0-9]/ig, "");
                    $.ajax({
                        type: "get", //必须是get请求
                        url: "https://blog.zezeshe.com/sq",
                        data: {
                            site: 'update',
                            name: 'Plain'
                        },
                        success: function(response) {
                            var sinnertwonewver = response;
                            var sinnertwonnum = sinnertwonewver.replace(/[^0-9]/ig, "");
                            if (sinnertwonnum > sinnertwonum) {
                                $("#theme-Plain .updata").append('<span style="background: #ff3f3f;display: inherit;padding: 3px 5px;border-radius: 3px;"><a href="' + sinnertwoupurl + '" target="_blank" rel="noopener noreferrer" style="color:#fff;text-decoration: none;">发现新版本' + sinnertwonewver + '，点我前去更新</a></span>');
                            }
                        }
                    });
                }
            });
        </script>
<?php
    }
}