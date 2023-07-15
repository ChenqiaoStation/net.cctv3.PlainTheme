<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (ajaxtype != 'comments') {
    $this->need('header.php');
?>
    <div id="xpost">

        <script type='text/javascript'>
            /* <![CDATA[ */
            var globals = {
                "post_id": "<?php $this->cid(); ?>",
                "post_url": "<?php $this->permalink(); ?>"
            };
            /* ]]> */
        </script>

        <div class="post break-all text-gray-900 dark:text-gray-100">
            <div class="sticky shadow z-20 top-0 bg-white dark:bg-black border-b dark:border-gray-600">

                <div class="flex items-center p-2">

                    <div class="flex-1 flex items-center">
                        <button id="backBtn" aria-label="返回" class="font-black mr-1"><?php echo icons('arrow-small-left', 'w-6 h-6 stroke-2'); ?></button>
                        <div class="flex-1 pl-1">
                            <h1 class="font-black"><?php $this->title() ?></h1>

                            <div class="text-gray-500 text-xs hidden sm:flex">
                                <?php get_post_view($this, '1'); ?>
                                <div class="flex items-center"><?php $this->commentsNum(); ?>条讨论 <?php echo icons('calendar', 'w-3 h-3 ml-1'); ?><?php $this->date('Y日m月d日'); ?> <?php if ($this->user->uid == $this->authorId) : ?><a href="<?php $this->options->adminUrl(); ?>write-post.php?cid=<?php $this->cid(); ?>" class="flex items-center text-2" target="_blank" data-ajax="false"><?php echo icons('pencil-square', 'w-3 h-3 ml-1'); ?>编辑</a><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button data-clipboard-action="copy" data-clipboard-text="<?php echo $this->title . "\n" . $this->permalink; ?>" class="flex-none copyurl" aria-label="分享"><?php echo icons('share', 'w-6 h-6 p-1'); ?></button>
                </div>
            </div>

            <div class="container mx-auto">

                <article id="post" class="post-content shadow mx-3 mt-3 mb-5 p-5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 rounded-lg">
                    <?php
                    $this->content = buju($this->content);
                    $this->content = createCatalog($this->content);
                    $this->content = setshortcode($this->content);
                    $this->content();
                    ?>

                    <?php if (count($this->tags) != 0) : ?>
                        <div class="text-xs space-y-2 mt-3 -mx-1">
                            <?php
                            foreach ($this->tags as $val) {
                            ?>
                                <a href="<?php echo $val['url']; ?>" itemprop="url" class="inline-block shadow px-2 py-1 mx-1 text-gray-100 bg-2 rounded-lg"><?php echo '#' . $val['name']; ?></a>
                            <?php } ?>
                        </div>
                    <?php endif; ?>

                    <?php if (array_key_exists('TePass', Typecho_Plugin::export()['activated'])) {
                        echo TePass_Plugin::getTePass();
                    } ?>

                    <?php if (!empty($this->options->tools) && in_array('cc', $this->options->tools)) : ?>
                        <!--文章版权声明-->
                        <div class="mt-5 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 p-3.5 rounded-md text-sm">
                            <div>
                                <div class="mb-1"><?php icons('user-circle', 'flex-none inline align-text-bottom w-4 h-4'); ?><span class="ml-0.5 font-medium">版权属于：</span><?php $this->author->screenName(); ?></div>
                                <div class="mb-1"><?php icons('link', 'flex-none inline align-text-bottom w-4 h-4'); ?>
                                    <span class="ml-0.5 font-medium">本文链接：</span><?php $this->permalink() ?>
                                </div>

                                <div class=""><?php icons('information-circle', 'flex-none inline align-text-bottom w-4 h-4'); ?><span class="ml-0.5">本站未注明转载的文章均为原创，并采用 <a class="text-blue-500" target="_blank" href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh-Hans">
                                            CC BY-NC-SA 4.0</a> 授权协议，转载请注明来源，谢谢！</span></div>
                            </div>
                        </div>
                        <!--文章版权声明-->
                    <?php endif; ?>

                </article><!-- end #article-->

                <div class="guanggaowei mx-3 my-5 shadow rounded-lg overflow-hidden">
                    <?php $this->options->ad(); ?>
                </div>
                <?php $this->need('prevnext.php'); ?>
                <div class="shadow mx-3 my-5 rounded-lg overflow-hidden">
                <?php }
            $this->need('comments.php');
            if (ajaxtype != 'comments') { ?>
                </div>
            </div>
            <?php $this->need('pages/Copyright.php'); ?>
        </div>
    </div>

<?php
                $this->need('footer.php');
            }
?>