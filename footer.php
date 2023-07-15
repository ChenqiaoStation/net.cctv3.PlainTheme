<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
</div><?php if (!$this->request->isAjax()) : ?>
    <loader class="page bg-gray-50 dark:bg-gray-800 dark:text-white">
        <div class="text-center text-sm">
            <img class="dark:hidden mb-1" src="<?php $this->options->themeUrl('img/loading.gif'); ?>">
            <img class="hidden dark:block mb-1" src="<?php $this->options->themeUrl('img/loading-dark.gif'); ?>">
            <p x-text="'Loading...'"></p>
        </div>
    </loader>
    <div id="cate" class="page" data-title="分类" x-show="open=='cate'" x-transition x-cloak>
        <?php $this->need('pages/cate.php'); ?>
    </div>
    <div id="page" class="page" data-title="页面" x-show="open=='page'" x-transition x-cloak>
        <?php $this->need('pages/pages.php'); ?>
    </div>

    <div id="searchpage" class="page" data-title="检索" x-show="open=='searchpage'" x-transition x-cloak>
        <?php $this->need('pages/search.php'); ?>
    </div>

    <div id="setting" class="page" data-title="设置" x-show="open=='setting'" x-transition x-cloak>
        <?php $this->need('pages/setting.php'); ?>
    </div>
    <!--pages -->
    </div>
    </div>
    </div>
    </div>
    <button class="hidden" id="open" @click="open='con'"></button>
    <button class="hidden" id="openx" @click="open='false'"></button>
    <button class="hidden" id="anchorx" x-init="$dispatch('anchorx')" @click="$dispatch('anchorx')"></button>

    <div class="z-40 fixed right-0 bottom-0 mb-14 md:mb-3 mr-3">

        <button id="widget-top" aria-label="返回顶部" @click="main.anchor('main')" class="bg-1 hover:bg-indigo-500 p-3 rounded-md text-white transform transition ease-out duration-150 scale-0">
            <?php echo icons('arrow-up', 'w-3 h-3 md:w-4 md:h-4'); ?>
        </button>
    </div>
    </main>
    <script src="https://cdn.staticfile.org/pjax/0.2.8/pjax.min.js"></script>
    <script src="<?php $this->options->themeUrl('assets/OwO.min.js?202307'); ?>"></script>
    <script src="https://cdn.staticfile.org/alpinejs/3.12.0/cdn.min.js" defer></script>
    <script src="<?php $this->options->themeUrl('cssjs/svg.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('cssjs/view-image.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('cssjs/chrome.js?202306'); ?>"></script>
    <script src="https://cdn.staticfile.org/clipboard.js/2.0.10/clipboard.min.js"></script>

    <?php if (!empty($this->options->code) && in_array('on', $this->options->code)) : ?>
        <script src="https://cdn.staticfile.org/highlight.js/10.7.2/highlight.min.js"></script>
    <?php endif; ?>

    <?php if (!empty($this->options->code) && in_array('lines', $this->options->code)) : ?>
        <script src="<?php $this->options->themeUrl('assets/code/lines.js'); ?>"></script>
    <?php endif; ?>

    <script src="<?php $this->options->themeUrl('main.js?202307'); ?>"></script>
    <script src="<?php $this->options->themeUrl('develop.js?20230703'); ?>"></script>

    <?php if ($this->options->js) : ?>
        <script>
            <?php $this->options->js(); ?>
        </script>
    <?php endif; ?>

    <script>
        var pjax = new Pjax({
            elements: 'a[href]:not([target="_blank"]):not([nopjax]),form[data-ajax]',
            selectors: ["title", ".the-content"],
            cacheBust: false,
            /*是否显示时间戳*/
        });

        /* 开始 PJAX 执行的函数*/
        document.addEventListener('pjax:send', function() {
            document.querySelector('#openx').click(); /*主屏显示*/
            document.querySelector("loader").classList.add("active");
        });

        /* PJAX 完成之后执行的函数，可以和上面的重载放在一起*/
        document.addEventListener('pjax:complete', function() {
            setTimeout(function() {
                /*让子弹飞一会*/
                document.querySelector('#open').click(); /*主屏显示*/
                document.querySelector('#anchorx').click(); /*重新检测锚点*/
                Alpine.store('ze').searchtext = ''; /*搜索词清空*/
                document.querySelector("loader").classList.remove("active");
                main.all();
                setTimeout(function() {
                    <?php $this->options->rejs(); ?>
                }, 50);
            }, sitedata.offset);

            if (typeof ga !== 'undefined') {
                /*兼容谷歌统计*/
                ga('send', 'pageview', location.pathname + location.search);
            }
            if (typeof _hmt !== 'undefined') {
                /*兼容百度统计*/
                _hmt.push(['_trackPageview', location.pathname + location.search]);
            }
        });
    </script>
    <?php $this->footer(); ?>
    </body>
<?php endif; ?>
</html>