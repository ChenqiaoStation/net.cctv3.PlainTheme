<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div class="absolute inset-0 lg:p-2 z-50 bg-white dark:bg-black">

    <div class="py-24 text-l text-sm text-center dark:text-gray-200">
        <div class="svg-empty w-24 h-24 mx-auto"></div>
        <p class="mb-5">很抱歉，您访问的页面不存在！<br>请仔细检查您输入的网址是否正确。</p>
        <div>
            <a href='<?php $this->options->siteUrl(); ?>' data-ajax="false" class='text-white px-3 py-2 bg-1 hover:bg-sky-600 rounded duration-150'>返回首页</a>
        </div>
    </div>
</div>
<?php
$this->need('footer.php');
?>