<?php $this->beginContent('//layouts/main_videoconference'); ?>
<div class="container" id="content">
        <!-- page label -->
        <div style="<?php echo (strlen($this->page_label)==0) ? 'display:none;':''; ?>" class="page-label-info col-xs-12">
            <div class="col-xs-3"></div>
            <div class="col-xs-6">
                    <div class="page-label text-center"><?php echo $this->page_label; ?></div>
            </div>
            <div class="col-xs-3">
            </div>
        </div>

        <!-- page content -->
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>