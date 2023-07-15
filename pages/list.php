<div x-data="{load:true,page:0,all:[],sticky:false,more:true,zhuangtai:'more',}" @addlist="zhuangtai='load';page++;fetch(siteurl+'?api=new&page='+page+'&allpage=<?php echo $this->getTotalPage(); ?>').then(data => data.json()).then(data=>{
    all=[...all, ...data.items.data];if(!sticky){sticky=data.items.sticky;}
    load=false;
    if(data.items.pageCount<=page){more=false;zhuangtai=false;}else{zhuangtai='more';}
    setTimeout(function () {pjax.refresh();}, 50);
    });" class="h-full dark:text-gray-200">

    <?php if ($this->options->gonggao) : ?>
        <div class="sticky shadow z-20 top-0 bg-white dark:bg-black border-b dark:border-gray-600">
            <div class="flex justify-between items-center py-2 px-3">
                <div class="line-1 mr-1"><span class="text-red-500">公告：</span><?php $this->options->gonggao() ?></div>
                <button aria-label="详情" @click="sinnertips('xs', '公告' ,'<?php
                                                                        $gg = htmlspecialchars($this->options->gonggao);
                                                                        $newline = array("\r\n", "\n", "\r");
                                                                        $gg = str_replace($newline, '&lt;br /&gt;', $gg);
                                                                        echo $gg;
                                                                        ?>')"><?php echo icons('ellipsis-vertical', 'w-6 h-6'); ?></button>

            </div>
        </div>
    <?php endif; ?>

    <div class="container mx-auto">
        <?php if ($this->options->lunbo) : ?>
            <div class="m-3 grid grid-cols-1 sm:grid-cols-5 gap-4">
                <!--轮播图-->
                <?php
                $tui = $this->options->lunbo;
                $lunbo = '';
                if (!empty($tui)) {
                    $string_tui = @explode("\r\n", $tui); //\r\n
                    $lon = count($string_tui);
                    for ($i = 0; $i < $lon; $i++) {
                        $a = @explode("$", $string_tui[$i])[0];
                        $tu = @explode("$", $string_tui[$i])[1];
                        $title = @explode("$", $string_tui[$i])[2];
                        $text = @explode("$", $string_tui[$i])[3];

                        $blank = '_blank';
                        if (strpos($a, rooturl) !== false || strpos($a, 'javascript:') !== false || strpos($a, '#') !== false) {
                            $blank = '';
                        }

                        $lunbo = $lunbo . "{img:'" . $tu . "',a:'" . $a . "',title:'" . $title . "',text:'" . $text . "',blank:'" . $blank . "'},";
                    }
                ?>
                    <div class="sm:col-span-3 relative overflow-x-hidden shadow-sm rounded" x-data="{ activeSlide: 1 , lunbos: [<?php echo $lunbo; ?>],last : null}" x-init="last=activeSlide;$flag=setInterval(function(){activeSlide = activeSlide === lunbos.length+1 ? 1 : activeSlide + 1;},3000);" @resetting="clearInterval($flag);$flag=setInterval(function(){activeSlide = activeSlide === lunbos.length+1 ? 1 : activeSlide + 1;},3000);">
                        <!--循环输出图片-->
                        <div class="relative min-w-full flex" :class="{'transition-transform':last!=activeSlide}" :style="`transform: translateX(${(activeSlide) * -100}%)`" @transitionend="if(activeSlide>lunbos.length){activeSlide=1;}if(activeSlide<1){activeSlide=lunbos.length;}" x-effect="if(activeSlide==0){last=lunbos.length}if(activeSlide==lunbos.length+1){last=1}if(1<activeSlide&&activeSlide<lunbos.length){last=-1}">
                            <template x-for="(lunbo,index) in [lunbos[lunbos.length -1], ...lunbos, lunbos[0]]" :key="index">
                                <a :href="lunbo.a" :target="lunbo.blank" class="relative w-full flex-shrink-0 w-full">
                                    <div class="media media-3x1">
                                        <img class="media-content w-full h-full object-center object-cover scrollLoading" :src="lunbo.img" alt="轮播图">
                                    </div>
                                    <div class="absolute inset-0 flex justify-center items-center flex-col text-white z-10 bg-black/10" x-show="lunbo.title">
                                        <div class="text-lg sm:text-2xl font-bold text-shadow text-center">
                                            <p x-text="lunbo.title" x-show="lunbo.title"></p>
                                            <p x-text="lunbo.text" x-show="lunbo.text" class="text-lg mt-1"></p>
                                        </div>
                                    </div>
                                </a>

                            </template>
                        </div>


                        <!--上一个-->
                        <button class="duration-300 absolute top-0 bottom-0 text-gray-200 hover:text-white left-0 px-2" @click="activeSlide = activeSlide === 0 ? lunbos.length+1 : activeSlide - 1;$dispatch('resetting')"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                            </svg></button>

                        <!--下一个-->
                        <button class="duration-300 absolute top-0 bottom-0 text-gray-200 hover:text-white right-0 px-2" @click="activeSlide = activeSlide === lunbos.length+1 ? 1 : activeSlide + 1;$dispatch('resetting')" x-ref="next"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg></button>

                        <!--循环输出指示标-->
                        <div class="carousel-indicators absolute bottom-0 left-0 right-0 flex justify-center p-3.5">
                            <template x-for="(lunbo,index) in lunbos" :key="index">
                                <button @click="last=-1;activeSlide=index+1 ;$dispatch('resetting')" :class="{'opacity-60':activeSlide!=index+1 }" class="w-2 h-2 rounded-full bg-white mx-0.5"></button>
                            </template>
                        </div>
                        <!--
<div class="flex flex-col text-white w-full"><span x-text="activeSlide"></span> / <span x-text="last"></span></div>
调试用-->
                    </div>

                <?php } ?>
                <!--轮播图结束-->

                <a href="<?php $this->options->siteUrl('?random=true'); ?>" class="group sm:col-span-2 bg-1 duration-100 hover:bg-indigo-500 rounded p-3 lg:p-4 text-white overflow-hidden flex justify-between items-center">

                    <div class="py-3 pattern-dots-md pl-12 w-24 flex items-center">

                        <div class="duration-200 group-hover:scale-125 text-3xl font-semibold">RANDOM POST</div>

                    </div>
                    <div class="">
                        <?php icons('arrow-right', 'duration-300 group-hover:scale-150 group-hover:opacity-40 opacity-90 stroke-2 w-12 h-12'); ?>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <template x-if="load">
            <template x-for="1 in 10">
                <div class="shadow-sm mx-3 my-5 p-3 bg-white dark:bg-black rounded overflow-hidden animate-pulse">
                    <div class="flex w-full cursor-pointer relative z-10" data-container="container">
                        <div class="flex-none mr-3 media media-3x2 w-1/3 sm:w-48 rounded scrollLoading mr-1">
                            <span class="bg-gray-200 dark:bg-gray-700 media-content"></span>
                        </div>
                        <div class="flex-grow flex flex-col">
                            <div class="flex-1 mb-1">
                                <h2 class="h-6 w-1/3 bg-gray-200 dark:bg-gray-700 text-xl font-semibold line-1 mb-3" itemprop="name headline">
                                </h2>
                                <div class="h-4 w-full bg-gray-200 dark:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 mb-1.5"></div>
                                <div class="h-4 w-4/5 bg-gray-200 dark:bg-gray-700 text-sm text-gray-600 dark:text-gray-300"></div>
                            </div>
                            <div class="flex justify-between">
                                <div class="h-4 w-1/3 bg-gray-200 dark:bg-gray-700 text-xs text-gray-400 dark:text-gray-300"></div>
                                <div class="h-4 w-1/5 bg-gray-200 dark:bg-gray-700 text-xs text-gray-400 dark:text-gray-300"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </template>

        <template x-if="sticky">
            <div class="relative mx-3 mb-3 mt-5 shadow-sm dark:text-white" x-data="{bgcolor:['bg-orange-500','bg-green-500','bg-sky-500','bg-indigo-500','bg-purple-500','bg-fuchsia-500','bg-pink-400'],k:0,n:-1}" x-init="k=bgcolor.length;">
                <span class="absolute -top-3 left-0 bg-red-500 text-white rounded-full p-1 mr-1 z-10">
                    <?php icons('thumbtack', '-rotate-45 h-4 w-4'); ?>
                </span>
                <div class="relative p-3 rounded bg-white dark:bg-gray-900 overflow-hidden">
                    <template x-for="(ding,i) in sticky">
                        <a :href="ding.url" itemprop="url" class="flex justify-between items-center w-full py-1" :class="{'border-t border-gray-300':i!=0}" data-container="container">
                            <div class="mb-0.5 flex items-center">
                                <span class="font-mono text-sm px-1 text-gray-100 rounded mr-0.5" :class="bgcolor[i%k]" x-text="i+1"></span>
                                <span itemprop="name headline" class="line-1" x-text="ding.title">
                                </span>
                            </div>
                            <div class="font-mono text-xs text-gray-700 dark:text-gray-200 hidden md:block" x-text="ding.date"></div>
                        </a>
                    </template>
                </div>
            </div>
        </template>

        <template x-for="(item,i) in all">

            <?php if (Helper::options()->liststyle == "text") : ?>
                <article class="relative shadow-sm mx-3 my-5 bg-white dark:text-white dark:bg-gray-900 p-3 rounded overflow-hidden">
                    <a :href="item.url" itemprop="url" class="flex w-full relative z-10" data-container="container">
                        <div class="flex-grow flex flex-col">

                            <div class="flex-1 mb-3">
                                <h2 class="text-center text-xl font-semibold line-2 mb-3" itemprop="name headline" x-text="item.title">
                                </h2>
                                <div class="hidden md:block">
                                    <div class="text-center text-sm line-2 dark:text-gray-100" x-html="item.description"></div>
                                </div>
                            </div>
                            <div class="flex justify-between font-mono text-xs text-gray-700 dark:text-gray-300">
                                <div class="flex items-center"><span x-text="item.date"></span>
                                    <span class="hidden sm:inline-block bg-1 w-1.5 h-1.5 rounded-full mx-2"></span>
                                    <span class="hidden sm:inline-block" x-text="item.view+'阅读'"></span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 mr-0.5" aria-hidden="true">
                                        <use xlink:href="#color-tag"></use>
                                    </svg>
                                    <span x-text="item.category"></span>
                                </div>
                            </div>

                        </div>
                    </a>
                </article>
            <?php elseif (Helper::options()->liststyle == "img") : ?>
                <article class="group relative shadow-sm mx-3 my-5 p-3 bg-white dark:text-white dark:bg-gray-900 rounded overflow-hidden">
                    <a :href="item.url" itemprop="url" class="flex w-full relative z-10" data-container="container">
                        <div class="mr-3 flex-none media media-3x2 w-1/3 sm:w-48 rounded shadow-md overflow-hidden">
                            <img referrerpolicy="no-referrer" :src="item.img" :alt="item.title" class="media-content h-full w-full object-cover transition-all ease-in-out group-hover:scale-125">
                        </div>
                        <div class="flex-grow flex flex-col">
                            <div class="flex-1 mb-1">
                                <h2 class="text-xl font-semibold line-2 mb-2" itemprop="name headline" x-text="item.title">
                                </h2>
                                <div class="hidden md:block">
                                    <div class="text-sm line-2 dark:text-gray-100" x-html="item.description"></div>
                                </div>
                            </div>
                            <div class="flex justify-between font-mono text-xs text-gray-700 dark:text-gray-300">
                                <div class="flex items-center"><span x-text="item.date"></span>
                                    <span class="hidden sm:inline-block bg-1 w-1.5 h-1.5 rounded-full mx-2"></span>
                                    <span class="hidden sm:inline-block" x-text="item.view+'阅读'"></span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 mr-0.5" aria-hidden="true">
                                        <use xlink:href="#color-tag"></use>
                                    </svg>
                                    <span x-text="item.category"></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            <?php else : ?>
                <article class="group relative shadow-sm mx-3 my-5 p-3 text-white bg-black rounded overflow-hidden">
                    <a :href="item.url" itemprop="url" class="flex w-full relative z-10" data-container="container">
                        <div class="mr-3 flex-none media media-3x2 w-1/3 sm:w-48 rounded shadow-md overflow-hidden">
                            <img referrerpolicy="no-referrer" :src="item.img" :alt="item.title" class="listimg media-content h-full w-full object-cover transition-all ease-in-out group-hover:scale-125">
                        </div>
                        <div class="flex-grow flex flex-col">
                            <div class="flex-1 mb-1">
                                <h2 class="text-xl font-semibold line-2 mb-2" itemprop="name headline" x-text="item.title">
                                </h2>
                                <div class="hidden md:block">
                                    <div class="text-sm line-2 text-gray-100" x-html="item.description"></div>
                                </div>
                            </div>
                            <div class="flex justify-between font-mono text-xs text-gray-200">
                                <div class="flex items-center"><span x-text="item.date"></span>
                                    <span class="hidden sm:inline-block bg-1 w-1.5 h-1.5 rounded-full mx-2"></span>
                                    <span class="hidden sm:inline-block" x-text="item.view+'阅读'"></span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 mr-0.5" aria-hidden="true">
                                        <use xlink:href="#color-tag"></use>
                                    </svg>
                                    <span x-text="item.category"></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div referrerpolicy="no-referrer" class="absolute inset-0 bg-no-repeat opacity-60" :style="'background-image:url('+item.img+');background-size: 20000%;background-position: center 10%;'"></div>
                </article>
            <?php endif; ?>
        </template>

        <template x-if="more">
            <div class="text-center">
                <button class="rounded-full px-10 py-2 shadow-sm rounded mx-3 mb-3 text-center bg-1 duration-150 hover:bg-indigo-500 text-white" x-init="$dispatch('addlist')" @click="$dispatch('addlist')">
                    <span x-show="zhuangtai=='load'" class="inline-flex items-center">
                        <?php icons('load', 'animate-spin -ml-1 mr-2 h-5 w-5'); ?>加载中...
                    </span>
                    <span x-show="zhuangtai=='more'">加载更多</span>
                </button>
            </div>
        </template>
        <template x-if="!more">
            <div class="w-full text-center py-2 px-3">已经没有啦😋</div>
        </template>

        <?php $all = Typecho_Plugin::export();
        if (array_key_exists('Links', $all['activated'])) : ?>
            <div class="mx-3 my-5 bg-white dark:bg-gray-900 shadow-sm rounded p-4 mb-5 dark:text-white">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="flex items-center font-black text-lg"><span class="bg-1 w-2 h-2 rounded-full mr-1"></span>友情链接
                    </h2>
                    <a :href="links" class="text-sm text-sky-500" title="更多链接" x-show="links" x-cloak>更多链接</a>
                </div>

                <div class="-mx-2 text-sm">
                    <?php
                    echo Links_Plugin::output('<a href="{url}" title="{title}" class="mx-2" target="_blank">{name}</a>', '', '首页', '', 'HTML'); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($this->options->ad3) : ?>
            <div class="guanggaowei mx-3 my-5 shadow rounded-lg overflow-hidden">
                <?php $this->options->ad3(); ?>
            </div>
        <?php endif; ?>
        <?php $this->need('pages/Copyright.php'); ?>
    </div>
</div>