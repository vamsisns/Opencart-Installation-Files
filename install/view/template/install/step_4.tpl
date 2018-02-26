<?php echo $header; ?>
<div class="container">
  <header>
    <div class="row">
      <div class="col-sm-6">
        <h1 class="pull-left">4<small>/4</small></h1>
        <h3><?php echo $heading_title; ?><br>
          <small><?php echo $text_step_4; ?></small></h3>
      </div>
      <div class="col-sm-6">
        <div id="logo" class="pull-right hidden-xs"><img src="view/image/logo.png" alt="OpenCart" title="OpenCart" /></div>
      </div>
    </div>
  </header>
  <?php if ($success) { ?>
  <div class="alert alert-success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <div class="visit">
    <div class="row">
        <div class="col-sm-12 text-center">
        <p><i class="fa fa-info fa-5x white"></i></p>
        <a href="../vqmod/install" class="btn btn-secondary">Install Vqmod</a></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript"><!--
$(document).ready(function() {
	$.ajax({
		url: '<?php echo $extension; ?>',
		type: 'post',
		dataType: 'json',
		success: function(json) {
			if (json['extensions']) {
				html  = '';

				for (i = 0; i < json['extensions'].length; i++) {
					extension = json['extensions'][i];

					html += '<div class="col-sm-6 module">';
					html += '  <a class="thumbnail pull-left" href="' + extension['href'] + '"><img src="' + extension['image'] + '" alt="' + extension['name'] + '" /></a>';
					html += '  <h5>' + extension['name'] + '</h5>';
					html += '  <p>' + extension['price'] + ' <a target="_BLANK" href="' + extension['href'] + '"><?php echo $text_view; ?></a></p>';
					html += '  <div class="clearfix"></div>';
					html += '</div>';

					i++;
				}

				$('#extension').html(html);
			} else {
				$('#extension').fadeOut();
			}
		}
	});
});
//--></script>
