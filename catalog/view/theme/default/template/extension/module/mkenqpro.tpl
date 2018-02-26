<style type="text/css">
.w3-yellow,.w3-hover-yellow:hover{color:#000!important;background-color:#ffeb3b!important}
.w3-border{border:1px solid #ccc!important}
.w3-border-yellow,.w3-hover-border-yellow:hover{border-color:#ffeb3b!important}

.w3-btn,.w3-button{border:none;display:inline-block;outline:0;padding:8px 50px;vertical-align:middle;overflow:hidden;text-decoration:none;color:inherit;background-color:inherit;text-align:center;cursor:pointer;white-space:nowrap;margin-bottom:5px;}
.w3-btn:hover{box-shadow:0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19)}
.w3-btn,.w3-button{-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}   
.w3-disabled,.w3-btn:disabled,.w3-button:disabled{cursor:not-allowed;opacity:0.3}.w3-disabled *,:disabled *{pointer-events:none}
.w3-btn.w3-disabled:hover,.w3-btn:disabled:hover{box-shadow:none}

/*for popup css*/
.opencarttools_mkenqprobody {overflow:hidden} 
.overlayopencarttools_mkenqpro{position:fixed;top:0;bottom:0;left:0;right:0;background:rgba(0,0,0,0.7);transition:opacity 500ms;display:none;opacity:0;z-index:9999;overflow:auto;}
.overlayopencarttools_mkenqpro:target{visibility:visible;opacity:1}
.opencarttools_mkenqpro{margin:40px auto;padding:20px;background:#fff;border-radius:5px;width:80%;position:relative;transition:all 5s ease-in-out}
.opencarttools_mkenqpro h2{margin-top:0;color:#333;font-family:Tahoma,Arial,sans-serif}
.opencarttools_mkenqpro .closeopencarttools_mkenqpro{position:absolute;top:0;right:0;transition:all 200ms;font-size:40px;font-weight:700;text-decoration:none;color:red;cursor:pointer;font-family:sans-serif;font-weight:bold}
.opencarttools_mkenqpro .closeopencarttools_mkenqpro:hover{color:#06D85F}
.opencarttools_mkenqpro .opencarttools_content_div{overflow:auto;font-family:Verdana,Arial,Helvetica,sans-serif}
@media screen and (max-width: 700px) {
.opencarttools_mkenqpro{width:70%}
}
</style>
<script language="javascript">
function addtomkenqpro(product_id) {
	$.ajax({
		url: 'index.php?route=<?php echo $modpathcart;?>/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=1',
		dataType: 'json',
		success: function(json) { 
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				if(json['popenquiry'] == 1) { 
					 opencarttools_mkenqpro();
				} else {
					if (json['redirectenquiry']) {
						location = json['redirectenquiry'];
					} else {
					
						$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('html, body').animate({ scrollTop: 0 }, 'slow');
						
					}
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	}); 
}
function addtomkenqproprodpage() {	
	$.ajax({
		url: 'index.php?route=<?php echo $modpathcart;?>/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		success: function(json) { 
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));
	
						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}
	
				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}
	
				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}
		
			if (json['success']) {
				if(json['popenquiry'] == 1) { 
					 opencarttools_mkenqpro();
				} else {
					
					if (json['redirectenquiry']) {
						location = json['redirectenquiry'];
					} else {
					
						$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						$('html, body').animate({ scrollTop: 0 }, 'slow');
						
					}
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	}); 
} 
function opencarttools_mkenqpro() {
	document.getElementById("opencarttools_mkenqpro").style.display = 'block';
	document.getElementById("opencarttools_mkenqpro").style.opacity = '1';
	document.body.className = document.body.className + ' opencarttools_mkenqprobody';
	
	$.ajax({
		url: 'index.php?route=<?php echo $modpathcart;?>/getpopup',
 		success: function(response) { 
 			$('#opencarttools_mkenqpro div.opencarttools_content_div').html(response);
		}
	}); 
}
function closeopencarttools_mkenqpro() {
	document.getElementById("opencarttools_mkenqpro").style.display = 'none';
	document.getElementById("opencarttools_mkenqpro").style.opacity = '0';
	document.body.className = document.body.className.replace(" opencarttools_mkenqprobody","");
} 
</script> 

<div id="opencarttools_mkenqpro" class="overlayopencarttools_mkenqpro">
	<div class="opencarttools_mkenqpro">
 		<a class="closeopencarttools_mkenqpro" onclick="closeopencarttools_mkenqpro();">&times;</a>
		<div class="opencarttools_content_div"></div>
	</div>
</div>