<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html x-data="data" :class="{ 'dark' : $store.ze.dark }" lang="zh-CN" x-init="darkmode();
        if('layout' in localStorage){
            layout=localStorage.layout;
        }else{
            layout='<?php if ($this->options->layout) {
                        $this->options->layout();
                    } else {
                        echo 'full';
                    } ?>';
        }
" x-cloak x-show="layout">

<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <title><?php if ($this->_currentPage > 1) echo '第' . $this->_currentPage . '页 - '; ?>
        <?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ' - '); ?><?php $this->options->title(); ?><?php if ($this->options->subtitle && $this->is('index')) {
                                                                echo ' - ' . $this->options->subtitle;
                                                            } ?></title>
    <link rel="dns-prefetch" href="//cdn.staticfile.org" />
    <link rel="dns-prefetch" href="//sdk.51.la" />
    <meta name="theme-color" content="#fff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#101827" media="(prefers-color-scheme: dark)">
    <link rel="manifest" href="<?php $this->options->siteUrl(); ?>?manifest=json" />
    <link rel="apple-touch-icon" href="<?php echo logo; ?>">
    <link rel="icon" href="<?php echo logo; ?>">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?php $this->options->title(); ?>">
    <meta name="format-detection" content="telephone=no,email=no" />
    <meta name="viewport" content="width=device-width,user-scalable=no,viewport-fit=cover,initial-scale=1, maximum-scale=1">
    <?php if (!$this->request->isAjax()) : ?>
        <!-- 使用url函数转换相关路径 -->
        <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css?20230712'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('cssjs/tailwind.min.css?202307111'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('skin.css'); ?>">

        <?php if (!empty($this->options->code) && in_array('on', $this->options->code)) : ?>
            <link rel="stylesheet" href="<?php echo theurl; ?>assets/code/sinner-code.css?202306">
        <?php endif; ?>

        <script type='text/javascript'>
            /* <![CDATA[ */
            var sitedata = {
                "ajax_url": "<?php $this->options->siteUrl(); ?>",
                "url": "<?php $this->options->siteUrl(); ?>",
                "theme_url": "<?php echo theurl; ?>",
                "te": "<?php Helper::options()->version(); ?>",
                "version": "<?php $info = Typecho_Plugin::parseInfo(__DIR__ . '/index.php');
                            echo $info['version']; ?>",
                "biaoqing": "<?php if (!empty($this->options->tools) && in_array('biaoqing', $this->options->tools)) {
                                    echo $this->options->rootUrl . '/Plain/biaoqing/info.json';
                                } ?>",
                "hljs": "<?php if (!empty($this->options->code) && in_array('on', $this->options->code)) {
                                echo 'on';
                            } else {
                                echo 'off';
                            } ?>",
                "lines": "<?php if (!empty($this->options->code) && in_array('lines', $this->options->code)) {
                                echo 'on';
                            } else {
                                echo 'off';
                            } ?>",
                "copycode": "<?php if (!empty($this->options->code) && in_array('copy', $this->options->code)) {
                                    echo 'on';
                                } else {
                                    echo 'off';
                                } ?>",
                "offset": "<?php echo offset; ?>"
            };
            var __ = {
                "load_more": "\u52a0\u8f7d\u66f4\u591a",
                "reached_the_end": "- \u6ca1\u6709\u66f4\u591a\u5185\u5bb9 -",
                "success": "\u64cd\u4f5c\u6210\u529f",
            };
            /* ]]> */
        </script>
        <?php if (!$this->request->isAjax()) : ?><?php endif; ?>

        <meta property="og:type" content="blog" />
        <meta property="og:release_date" content="<?php if ($this->is('single')) {
                                                        $this->date('Y年m月d日');
                                                    } else {
                                                        echo '2015年6月6日';
                                                    } ?>" />
        <meta property="og:author" content="sinner" />
        <meta name="apple-mobile-web-app-title" content="<?php $this->options->title(); ?>">
        <link rel="apple-touch-icon" href="<?php echo logo; ?>">
        <link rel="icon" href="<?php echo logo; ?>">

        <!-- Primary Meta Tags -->
        <meta name="title" content="<?php if ($this->is('index')) {
                                        $this->options->title();
                                    } else {
                                        $this->archiveTitle('', '', '');
                                    } ?>">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php $this->options->SiteUrl(); ?>">
        <meta property="og:title" content="<?php if ($this->is('index')) {
                                                $this->options->title();
                                            } else {
                                                $this->archiveTitle('', '', '');
                                            } ?>" />
        <meta property="og:description" content="<?php echo $this->getDescription(); ?>" />
        <meta property="og:image" content="<?php echo logo; ?>" />

        <!-- Twitter -->
        <meta property="twitter:card" content="summary">
        <meta property="twitter:url" content="<?php $this->options->SiteUrl(); ?>">
        <meta property="twitter:title" content="<?php if ($this->is('index')) {
                                                    $this->options->title();
                                                } else {
                                                    $this->archiveTitle('', '', '');
                                                } ?>">
        <meta property="twitter:description" content="<?php echo $this->getDescription(); ?>">
        <meta property="twitter:image" content="<?php echo logo; ?>">

        <?php $this->header('generator=&template=&commentReply='); ?>


        <?php $this->options->header(); ?>
</head>

<body class="bg-gray-200 dark:bg-gray-900<?php if (!empty($this->options->code) && in_array('br', $this->options->code)) {
                                                echo ' codebr';
                                            } ?>" x-data="{siteurl:'<?php Helper::options()->siteUrl(); ?>',anchorx:false,k:'<?php echo $this->request->getRequestUrl(); ?>'}" @anchorx="anchorx=location.hash.substring(1);
        anchorx=anchorx.replace('&','');
        console.log(anchorx);
        if(anchorx=='cate'||anchorx=='searchpage'||anchorx=='page'||anchorx=='setting'){
            open=anchorx;k=open;
        }
">

    <main id="main" x-data="{linkurl:false}" class="h-full" :class="{'container max-w-[1170px] mx-auto shadow-lg':(layout=='box'||layout=='mini')}">
        <div class="h-full flex">
            <div class="z-50 fixed left-0 bottom-0 w-full md:relative md:left-auto md:bottom-auto flex-none md:w-16 xl:w-20 text-xs xl:text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-black border-t dark:border-gray-800 lg:border-0 lg:border-r">
                <!-- sidebar -->
                <?php $this->need('sidebar.php'); ?>
            </div>

            <div class="flex flex-grow">

                <div class="flex-none w-72 hidden lg:block text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900" x-cloak x-show="layout!='mini'">
                    <!-- link -->
                    <?php $this->need('pages/RecentComments.php'); ?>
                    <!-- link-->
                </div>

                <div id="ze" class="relative flex-grow bg-gray-50 dark:bg-gray-800">
                    <div id="container" class="absolute w-full overflow-y-auto scroll-smooth h-full max-h-full">
                    <?php endif; ?>
                    <div class="the-content page" x-show="open=='con'" x-init="k='<?php echo $this->request->getRequestUrl(); ?>'" x-transition x-cloak>