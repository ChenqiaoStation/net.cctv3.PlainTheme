<?php

/**
 * <b>Plain</b> 朴素简约不简单的多短响应式Typecho主题<br>使用环境推荐：Typecho1.2.1及以上版本，PHP7.3~8.1版本<br><br>文档：<a href="https://blog.zezeshe.com/doc/Plain" target="_blank" rel="noopener noreferrer">https://blog.zezeshe.com/doc/Plain</a><br><br><cite class="updata"></cite>
 *
 * @package Plain
 * @author 泽泽社长
 * @version 1.6.5
 * @link https://blog.zezeshe.com/archives/typecho-plain.html
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

if ($this->_currentPage > 1) :
?>
    <?php $this->need('archive.php'); ?>
<?php else : ?>
    <?php $this->need('header.php'); ?>
    <!-- pages -->
    <div id="index">
        <?php $this->need('pages/list.php'); ?>
    </div>

    <?php $this->need('footer.php'); ?>
<?php endif; ?>