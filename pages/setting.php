<div class="break-all">
    <?php $this->need('pages/back.php'); ?>
    <div class="container mx-auto p-3">
        <!-- 主题模式切换 -->
        <div x-data="{mode:0}" x-init="if(localStorage.theme=='dark'){mode=1;}if(localStorage.theme=='light'){mode=2;}" class="bg-white dark:bg-gray-900 shadow rounded-md p-4 mb-5 dark:text-white">
            <h2 class="flex items-center font-black mb-3">
                <span class="bg-1 w-2 h-2 rounded-full mr-1"></span>模式选择
            </h2>
            <div class="grid grid-cols-3 gap-2 sm:gap-4 text-sm">
                <button @click="darkmode('auto');mode=0;" class="w-full p-3 flex flex-col items-center justify-center rounded-lg border-2 border-transparent hover:border-color-4" :class="{'text-white bg-4':mode==0,'text-4 bg-gray-100 dark:bg-gray-600':mode!=0}">
                    <?php echo icons('computer-desktop', 'w-6 h-6'); ?>
                    <p class="mt-0.5">跟随系统</p>
                </button>
                <button @click="darkmode('dark');mode=1;" class="w-full p-3 flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-600 rounded-lg border-2 border-transparent hover:border-color-2" :class="{'text-white bg-2':mode==1,'text-2 bg-gray-100 dark:bg-gray-600':mode!=1}">
                    <?php echo icons('moon', 'w-6 h-6'); ?>

                    <p class="mt-0.5">深色模式</p>
                </button>
                <button @click="darkmode('light');mode=2;" class="w-full p-3 flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-600 rounded-lg border-2 border-transparent hover:border-color-3" :class="{'text-white bg-3':mode==2,'text-3 bg-gray-100 dark:bg-gray-600':mode!=2}">
                    <?php echo icons('sun', 'w-6 h-6'); ?>
                    <p class="mt-0.5">浅色模式</p>
                </button>
            </div>
        </div>
        <!-- 主题布局切换 -->
        <div x-data="{mode:0}" x-init="if(layout=='box'){mode=1;}if(layout=='mini'){mode=2;}" class="bg-white dark:bg-gray-900 shadow rounded-md p-4 mb-5 dark:text-white">
            <h2 class="flex items-center font-black mb-3">
                <span class="bg-1 w-2 h-2 rounded-full mr-1"></span>电脑端布局
            </h2>
            <div class="grid grid-cols-3 gap-2 sm:gap-4 text-sm">
                <button @click="layout='full';localStorage.layout= layout;mode=0" class="w-full p-3 flex items-center justify-center rounded-lg border-2 border-transparent hover:border-color-2" :class="{'text-white bg-1':mode==0,'bg-gray-100 dark:bg-gray-600':mode!=0,}">
                    <p class="mt-0.5">平铺布局</p>
                </button>
                <button @click="layout='box';localStorage.layout = layout;mode=1" class="w-full p-3 flex items-center justify-center rounded-lg border-2 border-transparent hover:border-color-2" :class="{'text-white bg-1':mode==1,'bg-gray-100 dark:bg-gray-600':mode!=1,}">
                    <p class="mt-0.5">盒子布局</p>
                </button>
                <button @click="layout='mini';localStorage.layout = layout;mode=2" class="w-full p-3 flex items-center justify-center rounded-lg border-2 border-transparent hover:border-color-2" :class="{'text-white bg-1':mode==2,'bg-gray-100 dark:bg-gray-600':mode!=2,}">
                    <p class="mt-0.5">简约布局</p>
                </button>
            </div>
        </div>

        <div class="flex flex-col bg-white dark:bg-gray-900 shadow rounded-md p-4 mb-5 dark:text-white">
            <h2 class="flex items-center font-black mb-3"><span class="bg-1 w-2 h-2 rounded-full mr-1"></span>登录 / 登出
            </h2>
            <?php if ($this->user->hasLogin()) : ?>
                <a href="<?php $this->options->adminUrl(); ?>" data-ajax="false" class="shadow-sm text-center mt-3 p-3 text-gray-100 bg-2 dark:bg-teal-600 rounded-lg" target="_blank">进入后台
                </a>

                <a href="<?php $this->options->logoutUrl(); ?>" class="shadow-sm text-center mt-3 p-3 text-gray-100 bg-red-500 rounded-lg" nopjax>登出账号
                </a>
            <?php else : ?>
                <a href="<?php if (array_key_exists('TePass', Typecho_Plugin::export()['activated'])) {
                                echo tepasssignin;
                            } else {
                                $this->options->adminUrl('login.php');
                            } ?>" data-ajax="false" class="shadow-sm text-center mt-3 p-3 text-gray-100 bg-1 rounded-lg" target="_blank">登录
                </a>
                <?php if ($this->options->allowRegister) : ?>
                    <a href="<?php if (array_key_exists('TePass', Typecho_Plugin::export()['activated'])) {
                                    echo tepasssignup;
                                } else {
                                    $this->options->registerUrl();
                                } ?>" data-ajax="false" class="shadow-sm text-center mt-3 p-3 text-gray-100 bg-4 rounded-lg" target="_blank">注册
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>