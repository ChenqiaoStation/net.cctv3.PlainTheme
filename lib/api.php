<?php
if ($archive->request->api) {
    //分页设定
    $pagesize = $archive->request->filter('int')->pagesize ?? Helper::options()->pageSize; //每页文章数量
    $p = $archive->request->filter('int')->page ?? 1; //当前页面
    $allpage = $archive->request->filter('int')->allpage ?? 1; //总页码

    //置顶文章
    $sticky_cid  = Helper::options()->sticky_cids;
    $sticky_cids = $sticky_cid ? explode(',', strtr($sticky_cid, ' ', ',')) : '';
    if ($sticky_cids && $p == 1) {
        foreach ($sticky_cids as $cid) {
            $ji = Helper::widgetById('Contents', $cid);
            $a[] = array(
                "cid" => $ji->cid,
                "title" => $ji->title,
                "url" => $ji->permalink,
                "date" => date('Y年m月d日', $ji->created),
                "img" => showThumbnail($ji, '1', '1'),
            );
        }
    } else {
        $a = false;
    }

    \Widget\Post\News::alloc('currentPage=' . $p . '&pageSize=' . $pagesize)->to($ji);
    if ($ji->have()) {
        while ($ji->next()) {
            $catename = '无分类';
            if (!empty($ji->categories)) {
                $catename = $ji->categories[0]['name'];
            }
            $b[] = array(
                "cid" => $ji->cid,
                "title" => $ji->title,
                "url" => $ji->permalink,
                "date" => date('Y年m月d日', $ji->created),
                "description" => excerpt($ji, '150', '...', 'return'),
                "category" => $catename,
                "img" => showThumbnail($ji, '1', '1'),
                "view" => get_post_view($ji, '1'),
            );
        }

        $items['items'] = array(
            'status' => '200',
            'currentPage' => $p,
            'pageCount' => $allpage,
            "sticky" => $a,
            'page' => $p,
            'data' => $b
        );
        $archive->response->throwJson($items);
    } else {
        $archive->response->throwJson(["info" => "没有文章了"]);
    }
}

if ($archive->request->cate) {
    \Widget\Metas\Category\Rows::alloc()->to($pages);
    while ($pages->next()) {
        $cate[] = array(
            "mid" => $pages->mid,
            "name" => $pages->name,
            "url" => $pages->permalink,
            "description" => $pages->description,
            "count" => $pages->count,
        );
    }
    $archive->response->throwJson(array(
        'status' => '200',
        'data' => $cate
    ));
}

if ($archive->request->tags) {
    $num = $archive->request->filter('int')->tags ?? 30;
    \Widget\Metas\Tag\Cloud::alloc('ignoreZeroCount=1&desc=1&limit=' . $num)->to($pages);
    if ($pages->have()) {
        while ($pages->next()) {
            $page[] = array(
                "mid" => $pages->mid,
                "name" => $pages->name,
                "url" => $pages->permalink,
            );
        }
        $archive->response->throwJson(array(
            'status' => '200',
            'data' => $page
        ));
    } else {
        $archive->response->throwJson(array(
            'status' => '404',
        ));
    }
}


if ($archive->request->pages) {
    \Widget\Contents\Page\Rows::alloc()->to($pages);
    while ($pages->next()) {
        //if($pages->template!='bizhi.php'){}
        $page[] = array(
            "cid" => $pages->cid,
            "title" => $pages->title,
            "url" => $pages->permalink,
            "description" => $pages->description,
            "template" => $pages->template,
        );
    }
    $archive->response->throwJson(array(
        'status' => '200',
        'data' => $page
    ));
}

if ($archive->request->comments) {
    \Widget\Comments\Recent::alloc('pageSize=18&ignoreAuthor=true&parentId=')->to($pages);
    while ($pages->next()) {
        //$a=str_replace('#comment-'.$pages->coid, '', $pages->permalink);
        $a = $pages->permalink;
        $text = \Typecho\Common::subStr(strip_tags($pages->content), 0, 100, '...');
        $text = parseBiaoQing($text);
        if (strpos($pages->text, '$私密$') !== false) {
            $text = '该评论为私密评论，仅文章作者与评论发起者可见！';
        }
        $page[] = array(
            "coid" => $pages->coid,
            "author" => $pages->author,
            "date" => timesince($pages->created),
            "text" => $text,
            "url" => $a,
            "k" => commenttx($pages->mail, $pages->coid),
            "tx" => letter_avatarx($pages->author),
        );
    }
    $archive->response->throwJson(array(
        'status' => '200',
        'data' => $page
    ));
}


if ($archive->request->attachment) {
    $select = $db->select()->from('table.contents')->where('table.contents.type = ?', 'attachment');
    /** 提交查询 */
    $select = $db->fetchAll($select->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->page(1, 30));
    $lon = count($select);
    //print_r($select);
    if ($lon > 0) {
        for ($i = 0; $i < $lon; $i++) {
            $info = unserialize($select[$i]['text']);

            $b[] = array(
                "title" => $select[$i]['title'],
                "date" => date('Y/m/d', $select[$i]['created']),
                'mime' => $info['mime'],
                'type' => $info['type'],
                'size' => $info['size'],
            );
        }

        $archive->response->throwJson(array(
            'status' => '200',
            'data' => $b,
        ));
    } else {
        $archive->response->throwJson(array(
            'status' => '404',
        ));
    }
}

if ($archive->request->get('douban') && $archive->request->get('type')) {
    header("Access-Control-Allow-Origin: *"); //允许外部调用该数据
    echo douban(Helper::options()->douid, $archive->request->get('type'), $archive->request->get('page'));
    exit;
}
if ($archive->request->get('icons')) {
    header("Access-Control-Allow-Origin: *"); //允许外部调用该数据
    $archive->need('pages/iconlist.php');
    exit;
}
if ($archive->request->get('say')) {
    $user = \Typecho\Widget::widget('Widget_User');
    if ($user->pass('administrator', true)) {
        $coid = $archive->request->get('say');
        $text = $archive->request->get('text');
        $update = $db->update('table.comments')->rows(array('text' => $text))->where('coid=?', $coid);
        $updateRows = $db->query($update);
        $text = $archive->markdown($text);
        $cos = $text;
        $cos = parseBiaoQing($cos);
        $cos = preg_replace(
            '#<a(.*?) href="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#',
            '<a$1 href="$2$3"$5 class="text-sky-500" target="_blank" rel="nofollow" data-ajax="false">',
            $cos
        );
        $cos = preg_replace('#<img(.*?)>#', '<img$1 referrerpolicy="no-referrer">', $cos);
        $cos = buju($cos);
        $cos = setshortcode($cos);
        $cos = preg_replace('#<p>#', '<p class="mb-3">', $cos);
        echo $cos;
        exit;
    } else {
        echo '非法请求！';
        exit;
    }
}
if ($archive->request->isGet() && $archive->request->get('random')) {
    header('Location: ' . randomPost('return'));
    exit;
}

if ($archive->request->manifest) {
    $file_path = __TYPECHO_ROOT_DIR__ . '/Plain/img/512.png';
    $icons = array();
    if (file_exists($file_path)) {
        $icons = array(
            array(
                "src" => "Plain/img/512.png",
                "sizes" => "512x512",
                "type" => "image/png"
            ),
        );
    }
    $archive->response->throwJson(array(
        'name' => Helper::options()->title,
        'short_name' => Helper::options()->title,
        'display' => 'standalone',
        'scope' => '/',
        'start_url' => '/',
        'icons' => $icons
    ));
}
