<?php

/**
 * 说说
 * 
 * @package custom 
 * 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
Helper::options()->commentsPageSize = '8';
if ($this->options->saypage) {
    Helper::options()->commentsPageSize = $this->options->saypage;
}

$cid = $this->cid;
\Widget\Contents\Attachment\Related::alloc(['parentId' => $cid])->to($attachment);
\Widget\Security::alloc()->to($security);
$shenfen = 0;
if ($this->user->uid == $this->authorId) {
    $shenfen = 1;
}
define("shenfen", $shenfen);
if (ajaxtype != 'comments') {
    $this->need('header.php');
}
?>

<script type='text/javascript'>
    /* <![CDATA[ */
    var globals = {
        "post_id": "<?php $this->cid(); ?>",
        "post_url": "<?php $this->permalink(); ?>"
        <?php if ($this->allow('comment') && $this->user->uid == $this->authorId) : ?>,
            "url": "<?php $security->index('/action/upload?cid=' . $this->cid); ?>",
            "delete": "<?php $security->index('/action/contents-attachment-edit'); ?>",
            "prefix": "<?php echo \Typecho\Cookie::getPrefix(); ?>",
            "domain": "<?php echo getDomain; ?>"
        <?php endif; ?>
    };
    /* ]]> */
</script>

<div id="say" x-data="{upload:false,k:1}" class="page content text-gray-900 dark:text-gray-100">
    <?php if (ajaxtype != 'comments') : ?>
        <div class="relative mb-14">
            <div class="media media-16x9 xl:h-64 2xl:h-80 after:bg-none after:bg-inherit">
                <img class="media-content object-cover w-full h-full" src="<?php
                                                                            if ($this->options->saytt) {
                                                                                $this->options->saytt();
                                                                            } else {
                                                                                $this->options->themeUrl('img/bg.jpeg');
                                                                            } ?>">
            </div>

            <div class="absolute w-full -bottom-10">
                <div class="max-w-3xl mx-auto">
                    <div class="text-right mr-5">
                        <div class="flex items-center justify-end">
                            <h1 class="text-xl font-semibold text-white text-shadow mr-2"><?php $this->options->sayname(); ?></h1>
                            <img class="w-16 h-16 rounded-lg object-cover" src="<?php $this->options->saytx(); ?>">
                        </div>
                        <div class="line-1 text-sm sm:text-base text-gray-700 dark:text-gray-300 mt-1"><?php $this->options->saydes(); ?></div>
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>
    <div class="max-w-3xl mx-auto">
        <div class="w-full text-gray-900 dark:text-gray-200">
            <?php function threadedComments($comments, $options)
            {
                $commentClass = '';
                if ($comments->authorId) {
                    if ($comments->authorId == $comments->ownerId) {
                        $commentClass .= '';  //如果是文章作者
                    } else {
                        $commentClass .= '';  //如果是评论作者

                    }
                }
                if ($comments->url) {
                    $author = '<a href="' . $comments->url . '" target="_blank" rel="external nofollow" class="' . $commentClass . '" data-ajax="false">' . $comments->author . '</a>';
                } else {
                    $author = '<span class="' . $commentClass . '">' . $comments->author . '</span>';
                }

                $commentLevelClass = $comments->levels > 0 ? ' comment-child children' : ' comment-parent';  //评论层数大于0为子级，否则是父级
                \Widget\Security::alloc()->to($security);
            ?>
                <?php if ($comments->parent == 0) : ?>
                    <!--说说样式-->
                    <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php echo $commentLevelClass; ?>  p-3 bg-white dark:bg-gray-900 my-6" data-comment="<?php
                                                                                                                                                                        if (shenfen == 1) {
                                                                                                                                                                            echo htmlspecialchars($comments->text);
                                                                                                                                                                        }
                                                                                                                                                                        ?>">
                        <div id="<?php $comments->theId(); ?>">
                            <article id="div-<?php $comments->theId(); ?>" class="flex comment-body my-2">
                                <div class="flex-none mr-3" x-data="{k:[],imgurl:'<?php echo letter_avatarx($comments->author); ?>',tx:'<?php echo letter_avatarx($comments->author); ?>'}" x-init="k.type='<?php $k = commenttx($comments->mail, $comments->coid);
                                                                                                                                                                                                            echo $k['type']; ?>';
  k.url='<?php echo $k['url']; ?>';
  if(k.type=='qq'){
    fetch(k.url).then(data => data.json()).then(data => {
    imgurl=data.url;});
    }else{imgurl=k.url;}">

                                    <div class="relative">
                                        <img no-view class="relative z-10 w-12 object-cover rounded-md" :src="imgurl" alt="<?php echo $comments->author; ?>" x-cloak>
                                        <img no-view class="absolute top-0 left-0 w-12 object-cover rounded-md" :src="tx" alt="<?php echo $comments->author; ?>" x-cloak>
                                    </div>

                                </div>
                                <!-- .comment-author -->
                                <div class="saycon flex-initial w-full text-sm">
                                    <div class="comment-author mb-1">
                                        <div class="flex items-center">
                                            <span class="text-md font-semibold"><?php echo $comments->author; ?></span><span class="mx-1"></span><?php if ('waiting' == $comments->status) { ?><span class="text-muted">您的评论需管理员审核后才能显示！</span><?php } ?>
                                        </div>
                                    </div>
                                    <div class="comment-content">
                                        <?php

                                        $cos = parseBiaoQing($comments->content);
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
                                        ?>
                                    </div><!-- .comment-content -->
                                    <div class="flex items-center comment-meta text-xs text-gray-500 mt-1" data-no-instant>
                                        <time class="mr-1"><?php echo timesince($comments->created); ?></time>
                                        <?php if (shenfen == 1) : ?>
                                            <button data-url="<?php echo rooturl; ?>?say=<?php $comments->coid(); ?>" class="operate-edit text-2 mr-1">编辑</button>
                                            <button class="text-4 operate-delete mr-1" data-url="<?php $security->index('/action/comments-edit?do=delete&coid=' . $comments->coid); ?>">删除</button>
                                        <?php endif; ?>

                                        <button class="flex items-center comment-reply cp-<?php $comments->theId(); ?> text-muted comment-reply-link hover:text-blue-500" onclick="return TypechoComment.reply('<?php $comments->theId(); ?>', <?php $comments->coid(); ?>);"><?php icons('comments', 'w-3.5 mr-0.5'); ?><span>回复</span></button>
                                        <button id="cancel-comment-reply" onclick="return TypechoComment.cancelReply();" class="flex items-center cancel-comment-reply cl-<?php $comments->theId(); ?> text-muted comment-reply-link text-red-500" style="display:none">
                                            <?php icons('x-mark', 'w-3.5 mr-0.5'); ?><span>取消</span></button>

                                    </div>
                                </div><!-- .comment-text -->
                                <div class="sayed flex-initial w-full text-sm" style="display:none">
                                </div>
                            </article><!-- .comment-body -->
                        </div>
                    <?php else : ?>
                        <!--子评论样式-->
                    <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php echo $commentLevelClass; ?>  bg-gray-50 dark:bg-gray-800 mb-2" data-comment="<?php if (shenfen == 1) {
                                                                                                                                                                        echo htmlspecialchars($comments->text);
                                                                                                                                                                    } ?>">
                        <div id="<?php $comments->theId(); ?>" class="px-2 py-1">
                            <article id="div-<?php $comments->theId(); ?>" class="comment-body mb-2">
                                <!-- .comment-author -->
                                <div class="saycon w-full text-sm">
                                    <div class="mb-1">
                                        <span class="font-semibold"><?php echo $author . ':'; ?></span><span class="mx-1"></span><?php if ('waiting' == $comments->status) { ?><span class="text-muted">您的评论需管理员审核后才能显示！</span><?php } ?>
                                        <span class="comment-content">
                                            <?php
                                            $cos = parseBiaoQing($comments->content);
                                            $cos = preg_replace(
                                                '#<a(.*?) href="([^"]*/)?(([^"/]*)\.[^"]*)"(.*?)>#',
                                                '<a$1 href="$2$3"$5 class="text-sky-500" target="_blank" rel="nofollow" data-ajax="false">',
                                                $cos
                                            );
                                            $cos = preg_replace('#<img src="(.*?)"(.*?)>#', '<a class="mx-0.5 text-sky-500 view-image" href="$1" nopjax>图片</a>', $cos);
                                            $cos = preg_replace('#<p>#', '', $cos);
                                            $cos = preg_replace('#<\/p>#', '', $cos);
                                            $cos = preg_replace('#<br\s*/?>#', '', $cos);
                                            echo get_comment_at($comments->coid) . $cos;
                                            ?>
                                        </span>
                                    </div><!-- .comment-content -->
                                    <div class="flex items-center comment-meta text-xs text-gray-500 mt-1" data-no-instant>
                                        <time class="mr-1"><?php echo timesince($comments->created); ?></time>
                                        <?php if (shenfen == 1) : ?>
                                            <!--封印<button data-url="<?php echo rooturl; ?>?say=<?php $comments->coid(); ?>" class="operate-edit text-2 mr-1">编辑</button>-->
                                            <button class="text-4 operate-delete mr-1" data-url="<?php $security->index('/action/comments-edit?do=delete&coid=' . $comments->coid); ?>">删除</button>
                                        <?php endif; ?>

                                        <button class="flex items-center comment-reply cp-<?php $comments->theId(); ?> text-muted comment-reply-link hover:text-blue-500" onclick="return TypechoComment.reply('<?php $comments->theId(); ?>', <?php $comments->coid(); ?>);"><?php icons('comments', 'w-3.5 mr-0.5'); ?><span>回复</span></button>
                                        <button id="cancel-comment-reply" onclick="return TypechoComment.cancelReply();" class="flex items-center cancel-comment-reply cl-<?php $comments->theId(); ?> text-muted comment-reply-link text-red-500" style="display:none">
                                            <?php icons('x-mark', 'w-3.5 mr-0.5'); ?><span>取消</span></button>

                                    </div>
                                </div><!-- .comment-text -->
                                <div class="sayed flex-initial w-full text-sm" style="display:none">
                                </div>
                            </article><!-- .comment-body -->
                        </div>
                    <?php endif; ?>
                    <?php if ($comments->children) { ?>
                        <?php $comments->threadedComments(); ?>
                    <?php } ?>
                    </li>
                <?php } ?>
                <div id="comments" class="post-comment mx-3">
                    <?php if ($this->allow('comment') && $this->user->uid == $this->authorId) : ?>
                        <div id="<?php $this->respondId(); ?>" class="comment-respond p-5 bg-white dark:bg-gray-900" data-no-instant>
                            <form method="post" action="<?php $this->commentUrl() ?>" id="commentform" class="comment-form" data-say="true">
                                <div class="flex text-sm">

                                    <div class="flex-initial w-full">
                                        <div class="comment-form-body flex align-items-center rounded relative bg-slate-100 dark:bg-gray-700 dark:text-gray-100">

                                            <textarea id="comment" name="text" class="resize-none py-2 px-1.5 OwO-textarea flex-1 w-full text-sm bg-transparent border-gray-600" rows="5" placeholder="说点什么吧" required><?php $this->remember('text'); ?></textarea>


                                            <div class="form-submit comment-form-action flex flex-none justify-center px-2.5">
                                                <button name="submit" type="submit" id="submit" class="flex items-center justify-center h-9 w-9 rounded-full m-auto py-2 text-xl text-white bg-2 border border-transparent transition duration-300 transform -rotate-45 hover:rotate-0 focus:outline-none" value="发布评论" aria-label="提交评论"><?php icons('paper-airplane'); ?></button>
                                            </div>

                                        </div>

                                        <div class="flex items-center mt-1 text-gray-600 dark:text-gray-400">
                                            <label class="inline-flex items-center">
                                                <?php
                                                $owo = array("ヾ(≧∇≦*)ゝ", "OωO", "(｡•ˇ‸ˇ•｡)", "(°∀°)ﾉ", "（/TДT)/", "Σ(ﾟдﾟ;)", "ヽ(`Д´)ﾉ");
                                                $owo = '<button type="button" class="OwO-logo mr-3" rel="external nofollow" data-no-instant><small class="text-xs">' . $owo[array_rand($owo, 1)] . '</small></button>';
                                                //$owo='<a href="javascript: void(0);" class="OwO-logo mr-3 border border-gray-100 rounded px-2 py-1"><small class="text-xs"><span class="sui-smile mr-1"></span>表情</small></a>';  
                                                echo $owo;
                                                ?>
                                            </label>
                                            <div class="px-1 py-0.5 text-sm bg-3 text-white rounded-md cursor-pointer" @click="upload=!upload;k=0;setTimeout(function() {k=1;},10);">上传附件</div>
                                        </div>
                                        <div class="OwO mt-2"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php else : ?>
                        <div id="<?php $this->respondId(); ?>" class="youke comment-respond">

                            <form method="post" action="<?php $this->commentUrl() ?>" id="commentform" class="comment-form">
                                <div class="flex text-sm">

                                    <div class="flex-initial w-full">
                                        <div class="comment-form-body flex align-items-center rounded relative bg-slate-100 dark:bg-gray-700 dark:text-gray-100">
                                            <textarea id="comment" name="text" class="resize-none py-2 px-1.5 OwO-textarea flex-1 w-full text-sm bg-transparent border-gray-600" rows="3" placeholder="说点什么吧" required><?php $this->remember('text'); ?></textarea>
                                            <div class="form-submit comment-form-action flex flex-none justify-center px-2.5">
                                                <button name="submit" type="submit" id="submit" class="flex items-center justify-center h-9 w-9 rounded-full m-auto py-2 text-xl text-white bg-2 border border-transparent transition duration-300 transform -rotate-45 hover:rotate-0 focus:outline-none" value="发布评论" aria-label="提交评论"><?php icons('paper-airplane'); ?></button>
                                            </div>

                                        </div>
                                        <?php if (!$this->user->hasLogin()) : ?>

                                            <div class="comment-form-info mt-3">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div class="relative">
                                                        <img src="<?php if ($this->remember('mail', true)) {
                                                                        tx($this->remember('mail', true));
                                                                    } else {
                                                                        $this->options->themeUrl('img/tx.png');
                                                                    } ?>" class="absolute left-1 bottom-1.5 w-5 h-5 rounded-full object-cover border-2 border-gray-200 " id="pltx" alt="头像" no-view>

                                                        <input class="w-full rounded py-1.5 pr-1 pl-7 text-sm comment-form-body text-gray-900 border-gray-100 bg-slate-100 dark:bg-gray-700 dark:text-gray-100" id="author" placeholder="昵称" name="author" type="text" value="<?php $this->remember('author'); ?>" required>
                                                    </div>
                                                    <div>
                                                        <input class="w-full rounded py-1.5 px-1 text-sm comment-form-body text-gray-900 border-gray-100 bg-slate-100 dark:bg-gray-700 dark:text-gray-100" id="mail" placeholder="Email" name="mail" type="email" value="<?php $this->remember('mail'); ?>" <?php if ($this->options->commentsRequireMail) : ?> required<?php endif; ?>>
                                                    </div>
                                                    <div>
                                                        <input class="w-full rounded py-1.5 px-1 text-sm comment-form-body text-gray-900 border-gray-100 bg-slate-100 dark:bg-gray-700 dark:text-gray-100" id="url" placeholder="站点" name="url" type="url" value="<?php $this->remember('url'); ?>">
                                                    </div>
                                                    <?php if (!empty($this->options->tools) && in_array('spam', $this->options->tools)) : ?>
                                                        <?php spam_protection_math(); ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="flex items-center mt-1 text-gray-600 dark:text-gray-400">
                                            <label class="inline-flex items-center">
                                                <?php
                                                $owo = array("ヾ(≧∇≦*)ゝ", "OωO", "(｡•ˇ‸ˇ•｡)", "(°∀°)ﾉ", "（/TДT)/", "Σ(ﾟдﾟ;)", "ヽ(`Д´)ﾉ");
                                                $owo = '<button type="button" class="OwO-logo mr-3" rel="external nofollow" data-no-instant><small class="text-xs">' . $owo[array_rand($owo, 1)] . '</small></button>';
                                                echo $owo;
                                                ?>
                                            </label>

                                        </div>
                                        <div class="OwO mt-2"></div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php $this->comments()->to($comments); ?>
                    <?php if ($comments->have()) : ?>
                        <?php $comments->listComments(); ?>

                        <?php
                        $npattern = '/\<li.*?class=\"next\"><a.*?\shref\=\"(.*?)\"[^>]*>/i';
                        ob_start();
                        $comments->pageNav();
                        $con = ob_get_clean();
                        $n = preg_match_all($npattern, $con, $nextlink);
                        if ($n) {
                            $nextlink = $nextlink[1][0];
                        } else {
                            $nextlink = false;
                        }
                        $nextlink = str_replace("#comments", "?type=comments", $nextlink);
                        ?>
                        <?php if ($nextlink) : ?>
                            <div class="flex items-center justify-center my-5">

                                <button id="loadMoreBtn" x-data="{load:false}" @click="load=true;LoadCommentList('<?php echo $nextlink; ?>');" class="rounded-full px-10 py-2 shadow-sm rounded mx-3 mb-3 text-center bg-1 duration-150 hover:bg-indigo-500 text-white">
                                    <span x-show="load" class="inline-flex items-center">
                                        <?php icons('load', 'animate-spin -ml-1 mr-2 h-5 w-5'); ?>加载中...
                                    </span>
                                    <span x-show="!load">加载更多</span>
                                </button>

                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="w-full flex justify-center text-gray-500 text-xs pt-2 pb-6">
                            暂无评论，快来抢沙发
                        </div>
                    <?php endif; ?>
                </div>
        </div>
    </div>

    <?php if (ajaxtype != 'comments') : ?>
        <div class="z-50 transition-all w-48 sm:w-64 fixed inset-y-0 right-0 bg-gray-50 translate-x-full shadow-md dark:bg-gray-800 dark:text-white z-40 break-all" :class="{'translate-x-full':!upload}" @click.outside="if(k=='1'){upload=false;}">
            <div class="overflow-y-auto h-full p-3">
                <div class="flex justify-between items-center mb-3">
                    <div class="font-semibold">图片列表</div>
                    <button @click="upload=false" class="bg-red-500 text-white rounded-full p-1">
                        <?php icons('x-mark', 'stroke-2 w-4 h-4'); ?></button>
                </div>

                <div id="upload-panel" class="pt-2">
                    <label class="block py-1 w-full text-center text-base rounded-md bg-4 text-white cursor-pointer" for="upload-file-btn">上传图片</label>
                    <input class="hidden" type="file" accept=".png, .jpg, .jpeg, .webp, .gif" multiple id="upload-file-btn">
                    <div id="upload-progress" class="duration-150 my-2 py-1 text-center text-xs text-white rounded bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90%" style="width:0">
                    </div>
                    <ul id="file-list">
                        <?php $reversed_items = array();
                        while ($attachment->next()) : ?>

                            <?php //只有图片附件
                            if ($attachment->attachment->isImage) : ?>
                                <?php $reversed_items[] = '
        <li class="mt-3" id="att' . $attachment->cid . '" data-image="1"/>
        <img class="rounded-md w-full object-contain bg-gray-600"  src="' . theurl . 'img/load.gif" data-xurl="' . $attachment->attachment->url . '">
        <div class="mt-1 flex">
           <button class="rounded-md w-full text-sm text-white py-1 bg-1 hover:bg-sky-600 insert-btn mr-1"
           data-txt="![' . $attachment->title . '](' . $attachment->attachment->url . ')">插入</button>
           <button class="rounded-md w-full text-sm text-white py-1 bg-4 hover:bg-sky-600 delete-btn" data-cid="' . $attachment->cid . '">删除</button>
        </div>
        </li>';
                                ?>

                            <?php else : ?>
                                <!--<li class="mt-3" id="att<?php $attachment->cid(); ?>" data-image="<?php echo $attachment->attachment->isImage ? 1 : 0; ?>"> />
        <a class="insert" title="<?php _e('点击插入文件'); ?>" href="###"><?php $attachment->title(); ?></a>
        <div class="mt-1">
           <button class="rounded-md w-full text-sm text-white py-1 bg-1 hover:bg-sky-600 insert-btn"
           data-txt="[<?php $attachment->title(); ?>](<?php echo $attachment->attachment->url; ?>)"
           >插入</button>
        </div>
        
        </li>-->
                            <?php endif; ?>
                        <?php endwhile; ?>
                        <?php $reversed_items = array_reverse($reversed_items);  // 翻转新数组
                        foreach ($reversed_items as $item) {
                            echo $item;  // 循环输出倒序的元素
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php $this->need('pages/Copyright.php'); ?>
    <?php endif; ?>
</div>

<script type="text/javascript">
    (function() {
        window.TypechoComment = {
            dom: function(id) {
                return document.getElementById(id)
            },
            pom: function(id) {
                return document.getElementsByClassName(id)[0]
            },
            iom: function(id, dis) {
                var alist = document.getElementsByClassName(id);
                if (alist) {
                    for (var idx = 0; idx < alist.length; idx++) {
                        var mya = alist[idx];
                        mya.style.display = dis
                    }
                }
            },
            create: function(tag, attr) {
                var el = document.createElement(tag);
                for (var key in attr) {
                    el.setAttribute(key, attr[key])
                }
                return el
            },
            reply: function(cid, coid) {
                var comment = this.dom(cid),
                    parent = comment.parentNode,
                    response = this.dom("<?php echo $this->respondId(); ?>"),
                    input = this.dom("comment-parent"),
                    form = "form" == response.tagName ? response : response.getElementsByTagName("form")[0],
                    textarea = response.getElementsByTagName("textarea")[0];
                if (null == input) {
                    input = this.create("input", {
                        "type": "hidden",
                        "name": "parent",
                        "id": "comment-parent"
                    });
                    form.appendChild(input)
                }
                input.setAttribute("value", coid);
                if (null == this.dom("comment-form-place-holder")) {
                    var holder = this.create("div", {
                        "id": "comment-form-place-holder"
                    });
                    response.parentNode.insertBefore(holder, response)
                }
                comment.appendChild(response);
                this.iom("comment-reply", "");
                this.pom("cp-" + cid).style.display = "none";
                this.iom("cancel-comment-reply", "none");
                this.pom("cl-" + cid).style.display = "";
                if (null != textarea && "text" == textarea.name) {
                    textarea.focus()
                }
                return false
            },
            cancelReply: function() {
                var response = this.dom("<?php echo $this->respondId(); ?>"),
                    holder = this.dom("comment-form-place-holder"),
                    input = this.dom("comment-parent");
                if (null != input) {
                    input.parentNode.removeChild(input)
                }
                if (null == holder) {
                    return true
                }
                this.iom("comment-reply", "");
                this.iom("cancel-comment-reply", "none");
                holder.parentNode.insertBefore(response, holder);
                return false
            }
        }
    })();
</script>

<?php
if (ajaxtype != 'comments') {
    $this->need('footer.php');
} ?>