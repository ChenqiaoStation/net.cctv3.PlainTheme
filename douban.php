<?php

/**
 * 豆瓣影单书单
 * 
 * @package custom 
 * 
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div id="xpost">
    <div class="post text-gray-900 dark:text-gray-100">
        <div class="sticky shadow z-20 top-0 bg-white dark:bg-black border-b dark:border-gray-600">
            <div class="flex items-center p-2">
                <div class="flex-1 flex items-center pl-1">
                    <button id="backBtn" class="font-black mr-1"><?php echo icons('arrow-small-left', 'w-6 h-6 stroke-2'); ?></button>
                    <h1 class="font-black"><?php $this->title() ?></h1>
                </div>
                <button data-clipboard-action="copy" data-clipboard-text="<?php echo $this->title . "\n" . $this->permalink; ?>" class="flex-none copyurl" aria-label="分享"><?php echo icons('share', 'w-6 h-6 p-1'); ?></button>
            </div>
        </div>
        <div x-data="{type:'movie'}" class="container mx-auto">

            <div class="text-center">
                <div class="mx-auto inline-block mt-5 text-gray-100 bg-4 border-4 border-color-4 rounded-full overflow-hidden">
                    <button class="px-3 py-2" @click="type='movie'" :class="{'text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-100':type=='movie'}">观影</button>
                    <button class="px-3 py-2" @click="type='book'" :class="{'text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-100':type=='book'}">读书</button>
                </div>
                <div x-show="type=='movie'" x-transition x-cloak>
                    <div x-data="{all:[],page:0,more:true,total:0,load:false}" @douban="page++;load=true;
fetch('<?php echo rooturl; ?>?douban=true&type=movie&page='+page).then(data => data.json()).then(data=>{
all=[...all, ...data.interests];
total=data.total;if(total<=page*20){more=false}
load=false;
setTimeout(function () {Limg(); },500);
});
">
                        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4 p-5">
                            <template x-for="(item,i) in all">
                                <div x-init="
         if(!item.subject.is_released){
         fetch('https://zezeshe.com/api/douban/?id='+item.subject
.id).then(data => data.json()).then(data=>{
         item.subject.title=data.title;
         })}else{
         imgurl=item.subject.cover_url;
         }
         item.subject.cover_url='https://zezeshe.com/api/douban/fm.php?type=movie&id='+item.subject
.id;
         " class="group text-center">

                                    <a target="_blank" class="media media-10x14 duration-200 group-hover:shadow-xl rounded overflow-hidden" :href="item.subject.url">
                                        <img src="<?php echo theurl; ?>img/load.gif" :data-xurl="item.subject.cover_url" class="media-content shadow-md h-full w-full object-cover" referrerpolicy="no-referrer">
                                    </a>
                                    <div class="mt-1 text-sm line-1" x-text="item.subject.title"></div>
                                </div>
                            </template>
                        </div>


                        <template x-if="more">
                            <div class="text-center">
                                <button class="rounded-full px-10 py-2 shadow-sm rounded mx-3 mb-3 text-center bg-1 duration-150 hover:bg-indigo-500 text-white" x-init="$dispatch('douban')" @click="$dispatch('douban')">
                                    <span x-show="load" class="inline-flex items-center">
                                        <?php icons('load', 'animate-spin -ml-1 mr-2 h-5 w-5'); ?>加载中...
                                    </span>
                                    <span x-show="!load">加载更多</span>
                                </button>
                            </div>
                        </template>
                        <template x-if="!more">
                            <div class="w-full text-center py-2 px-3">已经没有啦😋</div>
                        </template>
                    </div>
                </div>
                <div x-show="type=='book'" x-transition x-cloak>
                    <div x-data="{all:[],page:0,more:true,total:0,load:false}" @douban="page++;load=true;
fetch('<?php echo rooturl; ?>?douban=true&type=book&page='+page).then(data => data.json()).then(data=>{
all=[...all, ...data.interests];
total=data.total;if(total<=page*20){more=false}
load=false;
});
">
                        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-4 p-5">
                            <template x-for="(item,i) in all">
                                <div class="group text-center" x-init="
         imgurl=item.subject.cover_url;
         item.subject.cover_url=imgurl.replace(/(img)(\d+)/,'$11');
         item.subject.cover_url='https://zezeshe.com/api/douban/fm.php?type=book&id='+item.subject
.id;
         ">

                                    <a target="_blank" class="media media-10x14 duration-200 group-hover:shadow-xl rounded overflow-hidden" :href="item.subject.url">
                                        <img src="<?php echo theurl; ?>img/load.gif" :data-xurl="item.subject.cover_url" class="media-content shadow-md h-full w-full object-cover" referrerpolicy="no-referrer">
                                    </a>
                                    <div class="mt-1 text-sm line-1" x-text="item.subject.title"></div>
                                </div>
                            </template>
                        </div>


                        <template x-if="more">
                            <div class="text-center">
                                <button class="rounded-full px-10 py-2 shadow-sm rounded mx-3 mb-3 text-center bg-1 duration-150 hover:bg-indigo-500 text-white" x-init="$dispatch('douban')" @click="$dispatch('douban')">
                                    <span x-show="load" class="inline-flex items-center">
                                        <?php icons('load', 'animate-spin -ml-1 mr-2 h-5 w-5'); ?>加载中...
                                    </span>
                                    <span x-show="!load">加载更多</span>
                                </button>
                            </div>
                        </template>
                        <template x-if="!more">
                            <div class="w-full text-center py-2 px-3">已经没有啦😋</div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="shadow mx-3 my-5 rounded-lg overflow-hidden">
                <?php $this->need('comments.php'); ?>
            </div>
        </div>
        <?php $this->need('pages/Copyright.php'); ?>
    </div>
</div>
<?php
$this->need('footer.php');
?>