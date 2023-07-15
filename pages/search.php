<div class="flex w-full h-full flex-col">
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
	</div>
</div>