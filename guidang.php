<?php

/**
 * 文章归档
 * 
 * @package custom 
 * 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
Typecho_Widget::widget('Widget_Stat')->to($stat);
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
                            <div class="flex items-center">目前共计 <?php $stat->publishedPostsNum() ?> 篇文章 <?php if ($this->user->uid == $this->authorId) : ?><a href="<?php $this->options->adminUrl(); ?>write-page.php?cid=<?php $this->cid(); ?>" class="flex items-center text-2" target="_blank" data-ajax="false"><?php echo icons('pencil-square', 'w-3 h-3 ml-1'); ?>编辑</a><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <button data-clipboard-action="copy" data-clipboard-text="<?php echo $this->title . "\n" . $this->permalink; ?>" class="flex-none copyurl" aria-label="分享"><?php echo icons('share', 'w-6 h-6 p-1'); ?></button>

            </div>
        </div>

        <div class="container mx-auto">
            <article class="post-content shadow mx-3 mt-3 mb-5 p-5 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 rounded-lg space-y-5">
                <?php $archives = archives($this);
                $index = 0;
                foreach ($archives as $year => $posts) : ?>

                    <div class="border-2 border-gray-100 rounded-lg dark:border-gray-700" x-data="{faq:<?php if ($index == 0) {
                                                                                                            echo 'true';
                                                                                                        } else {
                                                                                                            echo 'false';
                                                                                                        } ?>}">
                        <button @click="faq=!faq" class="flex items-center justify-between w-full p-4">
                            <span class="font-semibold text-xl text-gray-900 dark:text-white"><?php echo $year;
                                                                                                $index++; ?>年</span>

                            <span class="text-gray-400 bg-gray-200 rounded-full" x-show="faq">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                                </svg>
                            </span>
                            <span class="text-white bg-4 rounded-full" x-show="!faq">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </span>
                        </button>

                        <hr class="border-gray-200 dark:border-gray-700" x-show="faq">

                        <div class="transition-all p-4 text-base space-y-2" :class="{'max-h-0 py-0 px-5 overflow-y-hidden':!faq,'p-4':faq}">
                            <?php foreach ($posts as $created => $post) : ?>
                                <div class="flex justify-between items-center">
                                    <div class="ml-5 flex items-center"><span class="bg-sky-500 w-2 h-2 rounded-full mr-2"></span><a class="line-1" href="<?php echo $post['permalink']; ?>"><?php echo $post['title']; ?></a>
                                    </div>
                                    <div class="text-sm hidden sm:block"><?php echo date('m月d日', $created); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </article>
        </div>
        <?php $this->need('pages/Copyright.php'); ?>
    </div>
</div>
<?php
$this->need('footer.php');
?>