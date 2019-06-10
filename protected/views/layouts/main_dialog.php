<link rel="stylesheet" href="<?php echo $this->programURL(); ?>/node_modules/jquery-markdown/jquery-te-1.4.0.css">
<style>
    .text-control {
        padding: 8px;
        width: 88%;
        height: 34px;
        border-radius: 0px;
        border: 1px solid gray;
        margin-bottom: 8px;
    }

    a.md-control.md-control-fullscreen {
        display: none;
    }

    .md-fullscreen-controls {
        display: none;
    }
</style>

<div class="container">
	<?php echo $content; ?>
</div>