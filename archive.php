<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>


<div class="break-all text-gray-900 dark:text-gray-100">

    <?php if (!$this->is('index')) : ?>
        <div class="sticky shadow z-20 top-0 bg-white dark:bg-black border-b dark:border-gray-600">
            <div class="flex items-center p-2">
                <button id="backBtn" class="font-black mr-1"><?php echo icons('arrow-small-left', 'w-6 h-6 stroke-2'); ?></button>
                <div class="flex-grow pl-1">

                    <div class="font-black"><?php $this->archiveTitle([
                                                'category' => _t('%s'),
                                                'search'   => _t('包含关键字 %s 的文章'),
                                                'tag'      => _t('%s'),
                                                'author'   => _t('%s 发布的文章')
                                            ], '', ''); ?></div>
                    <div class="justify-between text-gray-500 dark:text-gray-200 text-xs flex">
                        <div>共有 <?php echo $this->getTotal(); ?> 条内容</div>

                        <div><?php if ($this->currentPage > 1) echo $this->currentPage;
                                else echo 1; ?>/<?php echo $this->getTotalPage(); ?></div>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container mx-auto">
        <?php if ($this->have()) : ?>
            <?php while ($this->next()) : ?>
                <?php $img = showThumbnail($this, '1', '1') ?>
                <?php if (Helper::options()->liststyle == "text") : ?>
                    <article class="relative shadow-sm mx-3 my-5 bg-white dark:text-white dark:bg-gray-900 p-3 rounded overflow-hidden">
                        <a href="<?php $this->permalink() ?>" itemprop="url" class="flex w-full relative z-10" data-container="container">
                            <div class="flex-grow flex flex-col">

                                <div class="flex-1 mb-3">
                                    <h2 class="text-center text-xl font-semibold line-2 mb-3" itemprop="name headline"><?php $this->title() ?>
                                    </h2>
                                    <div class="hidden md:block">
                                        <div class="text-center text-sm line-2 dark:text-gray-100"><?php excerpt($this, '150', '...', 'echo'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between font-mono text-xs text-gray-700 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <span><?php $this->date('Y年m月d日') ?></span>
                                        <span class="hidden sm:inline-block bg-1 w-1.5 h-1.5 rounded-full mx-2"></span>
                                        <span class="hidden sm:inline-block"><?php get_post_view($this); ?>阅读</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-0.5" aria-hidden="true">
                                            <use xlink:href="#color-tag"></use>
                                        </svg>
                                        <span><?php $this->category(',', false); ?></span>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </article>
                <?php elseif (Helper::options()->liststyle == "img") : ?>
                    <article class="group relative shadow-sm mx-3 my-5 bg-white dark:text-white dark:bg-gray-900 p-3 rounded overflow-hidden">
                        <a href="<?php $this->permalink() ?>" itemprop="url" class="flex w-full relative z-10" data-container="container">
                            <div class="mr-3 flex-none media media-3x2 w-1/3 sm:w-48 rounded shadow-md overflow-hidden">
                                <img referrerpolicy="no-referrer" src="<?php echo theurl; ?>img/load.gif" data-xurl="<?php echo $img; ?>" alt="<?php $this->title() ?>" class="media-content h-full w-full object-cover transition-all ease-in-out group-hover:scale-125">
                            </div>
                            <div class="flex-grow flex flex-col">

                                <div class="flex-1 mb-1">
                                    <h2 class="text-xl font-semibold line-2 mb-2" itemprop="name headline"><?php $this->title() ?>
                                    </h2>
                                    <div class="hidden md:block">
                                        <div class="text-sm line-2 dark:text-gray-100"><?php excerpt($this, '150', '...', 'echo'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between font-mono text-xs text-gray-700 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <span><?php $this->date('Y年m月d日') ?></span>
                                        <span class="hidden sm:inline-block bg-1 w-1.5 h-1.5 rounded-full mx-2"></span>
                                        <span class="hidden sm:inline-block"><?php get_post_view($this); ?>阅读</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-0.5" aria-hidden="true">
                                            <use xlink:href="#color-tag"></use>
                                        </svg>
                                        <span><?php $this->category(',', false); ?></span>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </article>
                <?php else : ?>
                    <article class="group relative shadow-sm mx-3 my-5 text-white bg-black p-3 rounded overflow-hidden">
                        <a href="<?php $this->permalink() ?>" itemprop="url" class="flex w-full relative z-10" data-container="container">

                            <div class="mr-3 flex-none media media-3x2 w-1/3 sm:w-48 rounded shadow-md overflow-hidden">
                                <img referrerpolicy="no-referrer" src="<?php echo $img; ?>" alt="<?php $this->title() ?>" class="listimg media-content h-full w-full object-cover transition-all ease-in-out group-hover:scale-125">
                            </div>
                            <div class="flex-grow flex flex-col">

                                <div class="flex-1 mb-1">
                                    <h2 class="text-xl font-semibold line-2 mb-2" itemprop="name headline"><?php $this->title() ?>
                                    </h2>
                                    <div class="hidden md:block">
                                        <div class="text-sm line-2 text-gray-100"><?php excerpt($this, '150', '...', 'echo'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between font-mono text-xs text-gray-200">
                                    <div class="flex items-center">
                                        <span><?php $this->date('Y年m月d日') ?></span>
                                        <span class="hidden sm:inline-block bg-1 w-1.5 h-1.5 rounded-full mx-2"></span>
                                        <span class="hidden sm:inline-block"><?php get_post_view($this); ?>阅读</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-0.5" aria-hidden="true">
                                            <use xlink:href="#color-tag"></use>
                                        </svg>
                                        <span><?php $this->category(',', false); ?></span>
                                    </div>
                                </div>

                            </div>
                        </a>
                        <div referrerpolicy="no-referrer" class="absolute inset-0 bg-cover bg-no-repeat opacity-60" style="background-image:url(<?php showThumbnail($this, '0', '1') ?>);background-size: 20000%;background-position: center 10%;"></div>
                    </article>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="py-24 text-center">
                <div class="svg-empty w-24 h-24 mx-auto"></div>
                <p class="text-gray-500 text-sm">看起来这里没有任何东西…</p>
            </div>
        <?php endif; ?>

        <div class="flex items-center justify-between mx-3 my-5">

            <?php
            $pattern = '/\<a.*?\shref\=\"(.*?)\"[^>]*>/i';
            ob_start();
            $this->pageLink('下一页', 'next');
            $nextlink = ob_get_clean();
            $t = preg_match_all($pattern, $nextlink, $nextlink);
            if ($t) {
                $nextlink = '" href="' . $nextlink[1][0] . '"';
            } else {
                $nextlink = ' opacity-0" disabled="disabled"';
            }
            ?>
            <?php
            ob_start();
            $this->pageLink('上一页');
            $prevlink = ob_get_clean();
            $t = preg_match_all($pattern, $prevlink, $prevlink);
            if ($t) {
                $prevlink = '" href="' . $prevlink[1][0] . '"';
            } else {
                $prevlink = ' opacity-0" disabled="disabled"';
            }
            ?>

            <a class="flex items-center text-xs px-4 py-2 mx-1 text-white bg-1 duration-150 hover:bg-indigo-500 shadow-md sm:shadow-lg rounded-md<?php echo $prevlink; ?> data-container=" container">
                <?php icons('chevron-right', 'stroke-2 w-4 h-4 rotate-180'); ?>上一页
            </a>
            <a class="flex items-center text-xs px-4 py-2 mx-1 text-white bg-1 duration-150 hover:bg-indigo-500 shadow-md sm:shadow-lg rounded-md<?php echo $nextlink; ?> data-container=" container">
                下一页<?php icons('chevron-right', 'stroke-2 w-4 h-4'); ?>
            </a>

        </div>
        <?php $this->need('pages/Copyright.php'); ?>
    </div>
</div>

<?php
$this->need('footer.php');
?>