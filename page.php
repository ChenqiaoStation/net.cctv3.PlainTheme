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
                                <div class="flex items-center"><?php $this->commentsNum(); ?> 条讨论 <?php if ($this->user->uid == $this->authorId) : ?><a href="<?php $this->options->adminUrl(); ?>write-page.php?cid=<?php $this->cid(); ?>" class="flex items-center text-2" target="_blank" data-ajax="false"><?php echo icons('pencil-square', 'w-3 h-3 ml-1'); ?>编辑</a><?php endif; ?>
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
                    <?php
                    if ($this->fields->dashang) {
                        if (array_key_exists('TePass', Typecho_Plugin::export()['activated'])) {
                            echo TePass_Plugin::getReward();
                        }
                    }
                    ?>
                </article><!-- end #article-->
                <div class="guanggaowei mx-3 my-5 shadow rounded-lg overflow-hidden">
                    <?php $this->options->ad(); ?>
                </div>
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