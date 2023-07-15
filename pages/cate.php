<div>
    <?php $this->need('pages/back.php'); ?>
    <div class="container mx-auto">


        <form id="search" data-ajax="true" class="search dark:text-white p-3" method="get" action="<?php $this->options->siteUrl(); ?>" role="search">
            <div class="shadow relative flex bg-white dark:bg-gray-700 rounded overflow-hidden">
                <input id="searchx" type="text" class="form-control border-0 flex-1 bg-transparent py-2 px-1.5 focus:outline-none dark:focus:placeholder-gray-600 dark:focus:bg-gray-700" name="s" x-model="$store.ze.searchtext" placeholder="<?php _e('输入关键字搜索'); ?>" required>
                <button type="submit" class="flex-none border-0 py-2 px-4 text-gray-600 hover:text-red-500 dark:text-gray-200 focus:outline-none" aria-label="提交搜索">
                    <?php echo icons('search-outline', 'w-5 h-5'); ?>
                </button>
            </div>
        </form>

        <template x-if="tag">
            <div class="block px-3">
                <div class="flex flex-col bg-white dark:bg-gray-900 shadow rounded-md p-4 mb-5 dark:text-white">
                    <h2 class="flex items-center mb-3">
                        <span class="bg-1 w-3 h-3 rounded-full mr-1"></span>标签
                    </h2>
                    <div class="-mx-2 text-xs">
                        <template x-for="(item,i) in tag">
                            <a :href="item.url" itemprop="url" x-init="setTimeout(function () {pjax.refresh();}, 50);" class="inline-block shadow m-2 px-2 py-1 text-gray-100 bg-2 rounded-lg" x-text="'#'+item.name">
                            </a>

                        </template>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="cate">
            <div class="grid grid-cols-2 gap-4 m-3">
                <template x-for="(item,i) in cate">
                    <a :href="item.url" itemprop="url" class="flex justify-between items-center cursor-pointer shadow w-full p-3 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 rounded-lg text-lg">
                        <div>
                            <h2 class="font-black text-gray-900 dark:text-gray-200 line-1" itemprop="name headline" x-text="item.name">
                            </h2>
                            <div class="text-sm line-1 text-gray-700 dark:text-gray-400" x-text="item.description"></div>
                        </div>
                        <div x-text="item.count" class="text-xl font-black text-gray-300 dark:text-gray-500"></div>
                    </a>

                </template>
            </div>
        </template>

        <template x-if="!cate">
            <div class="w-full text-gray-900 text-center p-3 dark:bg-gray-900 dark:text-gray-100">
                <span class="inline-flex items-center">
                    <?php icons('load', 'animate-spin -ml-1 mr-2 h-5 w-5'); ?>加载中...
                </span>
            </div>
        </template>
    </div>
</div>