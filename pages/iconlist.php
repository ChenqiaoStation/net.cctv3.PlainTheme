<?php $this->need('header.php'); ?>
<div id="iconlist" class="page content">
    <div class="grid grid-cols-5 lg:grid-cols-8 gap-4 p-5 mx-3">
        <?php foreach (icons as $key => $val) {
            $val = str_replace("{class}", 'w-6 h-6 mx-auto', $val);
        ?>
            <div class="text-center dark:text-gray-100">
                <div><?php echo $val; ?></div>
                <div><?php echo $key; ?></div>
            </div>
        <?php } ?>
    </div>
</div>
<?php $this->need('footer.php'); ?>