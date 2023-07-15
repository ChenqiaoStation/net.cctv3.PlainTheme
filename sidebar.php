<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$active = "text-white dark:text-gray-200 bg-1 rounded-full";
?>
<aside class="side select-none md:h-full md:flex md:flex-col text-gray-500 dark:text-gray-400">
    <div class="flex-none elative z-10 px-1 py-1.5 hidden xl:block" x-show="!app">
        <div class="xiaoyuandian flex items-center">
            <span class="w-3 h-3 bg-gray-200 dark:bg-gray-800 rounded-full mx-1">
            </span>
            <span class="w-3 h-3 bg-gray-200 dark:bg-gray-800 rounded-full mx-1">
            </span>
            <span class="w-3 h-3 bg-gray-200 dark:bg-gray-800 rounded-full mx-1">
            </span>
        </div>
    </div>
    <div class="flex justify-around md:relative md:flex-1 md:block z-10 max-h-full overflow-y-auto py-1.5 md:py-2">
        <div class="hidden md:block mb-5"><img src="<?php echo logo; ?>" alt="LOGO" class="shadow md:mb-3 mx-auto w-9 h-9 xl:w-12 xl:h-12 object-cover rounded-full"></div>

        <?php

        $menu = "home\${index}\$false\r\ntag\${cate}\$false\r\nmore\${page}\$false";
        if (Helper::options()->menu) {
            $menu = Helper::options()->menu;
        }

        $hang = array_filter(explode("\r\n", $menu));
        foreach ($hang as $val) {
            $shuzu = array_filter(explode("$", $val));
            $icon = $shuzu[0];
            $url = $shuzu[1];
            $mobile = $shuzu[2];
            if (isset($shuzu[3])) {
                $blank = $shuzu[3];
            } else {
                $blank = 'false';
            }

            $open = false;
            if ($mobile == 'true') {
                $mobile = "hidden md:flex ";
            } else {
                $mobile = "";
            }
            if ($blank == 'true') {
                $blank = ' target="_blank"';
            } else {
                $blank = '';
            }


            if ($url == '{index}') {
                $k = Helper::options()->siteUrl;
                $url = '\'' . Helper::options()->siteUrl . '\'';
                $open = 'con';
            } elseif ($url == '{cate}') {
                $url = '\'#&cate\'';
                $open = 'cate';
                $k = 'cate';
            } elseif ($url == '{searchpage}') {
                $url = '\'#&searchpage\'';
                $open = 'searchpage';
                $k = 'searchpage';
            } elseif ($url == '{page}') {
                $url = '\'#&page\'';
                $open = 'page';
                $k = 'page';
            } else {
                $k = $url;
                $url = '\'' . $url . '\'';
            }
        ?>
            <a<?php echo $blank; ?> :href="<?php echo $url; ?>" @click="k='<?php echo $k; ?>';<?php if ($open) : ?>open='<?php echo $open; ?>';<?php endif; ?>" class="<?php echo $mobile; ?>w-full md:w-auto flex m-0 md:mb-3.5 justify-center items-center text-center">
                <i class="p-2" :class="{'<?php echo $active; ?>':k=='<?php echo $k; ?>'}">
                    <?php echo icons($icon, 'w-5 h-5 xl:w-7 xl:h-7'); ?>
                </i>
                </a>
            <?php } ?>
            <a nopjax href="#&setting" @click="open='setting';k=false" class="md:hidden w-full md:w-auto flex m-0 md:mb-3.5 justify-center items-center text-center">
                <i class="p-2" :class="{'<?php echo $active; ?>':open=='setting'}">
                    <?php echo icons('setting', 'w-5 h-5 xl:w-7 xl:h-7'); ?></i>
            </a>

    </div>

    <div class="hidden md:block">
        <a nopjax href="#&setting" @click="open='setting';k=false" class="md:flex-shrink-0 w-full md:w-auto flex m-0 md:m-2 justify-center items-center text-center">
            <i class="p-2" :class="{'<?php echo $active; ?>':open=='setting'}">
                <?php echo icons('setting', 'w-5 h-5 xl:w-7 xl:h-7'); ?></i>
        </a>
    </div>

</aside>