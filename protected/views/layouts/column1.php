<?php $this->beginContent('//layouts/main'); ?>
<div class="container" id="content">
        <!-- page label -->
        <div style="<?php echo (strlen($this->page_label)==0) ? 'display:none;':''; ?>" class="col-xs-12 page-label-info">
                <?php if ($this->with_progressbar): ?>
                        <div class="col-xs-12 text-center">
                            <span class="page-label">
                                    <?php
                                    if ($this->id == 'cir'):
                                       echo "Customer Insurance Review";
                                    elseif ($this->id == 'needassessment'): 
                                        echo "Needs Assessment";
                                    else:
                                        echo "Agent Prep";
                                    endif;
                                    ?>
                                (<?php echo $this->page_label; ?>)
                            </span>
                        </div>
                        <div class="col-xs-push-2 col-xs-8 ">
                            <input id="top-progress-bar" type="text" style="display:none;" /><br>
                            <!--     
                            <div class="progress">
                              <div class="progress-bar progress-bar-warning" role="progressbar" style="width:<?php echo $this->progress_bar['start']; ?>%">
                              </div>
                              <div class="progress-bar progress-bar-primary" role="progressbar" style="width:<?php echo $this->progress_bar['end']; ?>%">
                              </div>
                            </div>
                            -->
                        </div>
                <?php else: ?>
                        <div class="col-xs-3"><?php echo $this->top_left_content; ?></div>
                        <div class="col-xs-6">
                                <div class="page-label text-center"><?php echo $this->page_label; ?></div>
                        </div>
                        <div class="col-xs-3">
                                <div class="text-right">
                                        <?php
                                                foreach ($this->action_buttons as $key => $value) {
                                                        echo $value;
                                                }
                                        ?>
                                </div>
                        </div>
                <?php endif; ?>
        </div>

        <!-- page content -->
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>