<?php

/**
 * 友情链接
 * 
 * @package custom 
 * 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (ajaxtype != 'comments') {
    $this->need('header.php');
?>
    <div id="xpost">
        <div class="post text-gray-900 dark:text-gray-100">
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

                <div class="grid grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4 mb-4 p-5">
                    <?php
                    echo Links_Plugin::output('<div class="flex items-center p-4 bg-black text-white shadow rounded-md transition-all duration-300 transform hover:shadow-xl hover:-translate-y-1 relative overflow-hidden">
<a href="{url}" title="{name}" target="_blank" rel="noopener" class="flex flex-shrink-0 z-10"><img src="' . theurl . 'img/load.gif" class="w-11 h-11 lg:w-14 lg:h-14 object-cover rounded-full scrollLoading" data-xurl="{image}"></a>
<div class="w-full mt-0 pl-2 z-10"><p class="text-base font-medium line-1 dark:text-gray-50"><a href="{url}" target="_blank" rel="noopener" title="{name}" class="block">{name}</a></p><p class="text-xs text-gray-100 line-1 mt-1">{description}</p>
</div>
<div class="rounded-md absolute inset-0 bg-cover bg-no-repeat opacity-70" style="background-image:url({image});background-size: 20000%;
background-position: center 30%;"></div>
</div>', '', '', '', 'HTML'); ?>

                </div>

                <?php if ($this->content) : ?>
                    <article class="post-content shadow mx-3 my-5 p-5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 rounded-lg">
                        <div id="post" class="post-content fancycon mb-4">
                            <?php
                            $this->content = buju($this->content);
                            $this->content = createCatalog($this->content);
                            $this->content = setshortcode($this->content);
                            $this->content();
                            ?>
                        </div>
                    </article>

                <?php endif; ?>
                <div class="shadow mx-3 my-5  rounded-lg overflow-hidden">
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