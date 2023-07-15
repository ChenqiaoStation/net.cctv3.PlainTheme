<div class="flex flex-col h-full">
    <div class="sticky top-0 bg-white dark:bg-gray-900 z-20">
        <form id="searchhome" data-ajax="true" class="search relative p-3" method="get" action="<?php $this->options->siteUrl(); ?>" role="search">
            <label for="s" class="sr-only"><?php _e('搜索关键字'); ?></label>
            <input type="text" name="s" class="w-full bg-gray-100 dark:bg-gray-600 rounded py-2 px-1.5 text-base text" x-model="$store.ze.searchtext" placeholder="<?php _e('搜索'); ?>" required />
        </form>
    </div>

    <div x-data="{menu:1}" class="flex flex-col h-full">
        <div class="text-gray-400 mb-3 border-b-2 dark:border-gray-500">
            <div class="flex mx-3">
                <button class="w-full pb-3 border-b-2 -mb-0.5" :class="{'text-1 border-color-1':menu==1,'border-transparent':menu!=1}" @click="menu=1" aria-label="分类">
                    <?php echo icons('squares-2x2', 'w-6 h-6 mx-auto'); ?>
                </button>
                <button class="w-full pb-3 border-b-2 -mb-0.5" :class="{'text-1 border-color-1':menu==2,'border-transparent':menu!=2}" @click="menu=2" aria-label="最近评论">
                    <?php echo icons('chat-bubble-left-right', 'w-6 h-6 mx-auto'); ?>

                </button>
            </div>
        </div>

        <div class="link max-h-full h-full overflow-y-auto scroll-smooth">
            <div x-show="menu==1" class="h-full pb-3">

                <template x-if="!cate"><template x-for="1 in 5">
                        <div class="mx-3 mt-3 animate-pulse p-3 bg-gray-200 dark:bg-gray-800 rounded-lg text-lg">
                            <div class="flex w-full justify-between">
                                <h2 class="h-6 w-1/3 bg-gray-300 dark:bg-gray-600"></h2>
                                <span class="h-6 w-1/5 bg-gray-300 dark:bg-gray-600"></span>
                            </div>
                        </div>
                    </template></template>

                <div class="flex flex-col h-full">
                    <div class="flex-1">
                        <template x-if="cate">
                            <template x-for="(item,i) in cate">
                                <a :href="item.url" itemprop="url" class="mx-3 mt-3 flex justify-between items-center cursor-pointer p-3 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-800 rounded-lg text-lg duration-300 border-2 border-transparent hover:border-color-4">
                                    <div>
                                        <h2 class="line-1" itemprop="name headline" x-text="item.name">
                                        </h2>
                                        <div class="hidden text-sm line-1 text-gray-500 dark:text-gray-300" x-text="item.description"></div>
                                    </div>
                                    <div x-text="item.count" class="text-xl font-black text-gray-300 dark:text-gray-500"></div>
                                </a>

                            </template>
                        </template>
                    </div>

                    <div class="flex-none shadow mx-3 mt-3 rounded-lg overflow-hidden">
                        <?php $this->options->ad2(); ?>
                    </div>
                </div>
            </div>

            <div x-show="menu==2" class="h-full pb-3" x-cloak>
                <template x-if="comments">
                    <template x-for="(item,i) in comments">
                        <a :href="item.url" class="flex px-3 py-2 text-left w-full select-none duration-300 hover:bg-gray-200 hover:dark:bg-gray-700" itemprop="url" x-init="setTimeout(function () {pjax.refresh();}, 50);" x-data="{k:item.k,imgurl:item.tx,}">
                            <div class="flex-none" x-init="
    if(k.type=='qq'){
    fetch(k.url).then(data => data.json()).then(data => {
    imgurl=data.url;});
    }else{imgurl=k.url;}
    $nextTick(() => {setTimeout(function () {Limg(); },500);});
    ">
                                <div class="relative">
                                    <img class="relative z-10 w-12 h-12 object-cover border-2 border-gray-200 rounded-full scrollLoading mr-1" src="<?php echo theurl; ?>img/load.gif" :data-xurl="imgurl" :alt="item.author" x-cloak>
                                    <img class="absolute top-0 left-0 w-12 h-12 object-cover border-2 border-gray-200 rounded-full scrollLoading mr-1" :src="item.tx" :alt="item.author" x-cloak>
                                </div>
                            </div>
                            <div class="flex-grow flex flex-col pl-2 dark:text-gray-100">
                                <div class="flex justify-between"><span x-text="item.author"></span><time class="text-xs text-gray-400 dark:text-gray-500" x-text="item.date"></time></div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 line-1" x-html="item.text"></div>
                            </div>
                        </a>
                    </template>
                </template>
            </div>
        </div>
    </div>
</div>