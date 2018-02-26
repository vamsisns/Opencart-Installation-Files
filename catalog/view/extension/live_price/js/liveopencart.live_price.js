(function ($) {
	$.fn.liveopencart_LivePrice = function(p_params){
		
		$this = this;
		
		var params = $.extend( {
			'lp_settings' 				: {},
			'theme_name'					: 'default',
			'request_url'					: 'index.php?route=module/liveprice/get_price',
			'product_id'					: 0,
			'non_standard_theme' 	: '',
			'get_custom_methods'	: '',
		}, p_params);
		
		
		var extension = {
			
			$container : $this,
			params : params,
			custom_methods : {},
			timer_update_price : 0,
			timer_init : 0,
			update_price_call_id : 0,
			option_prefix : 'option',
			initialized : false,
			
			setCustomMethods : function() {
				if ( typeof(extension.params.get_custom_methods) == 'function' ) {
					extension.custom_methods = extension.params.get_custom_methods(extension);
				}
			},
			
			setCustomContainer : function($container) {
				extension.$container = $container;
			},
			
			containerExists : function() {
				// document.body.contains - fix for IE11
				return ( extension.$container && extension.$container.length
									&& ( (document.contains && document.contains(extension.$container[0])) || (document.body.contains && document.body.contains(extension.$container[0])) ) );
			},
			
			getElement : function(selector) {
				if ( typeof(selector) != 'object' && selector.substr(0,1) == '#' && extension.$container.is(selector) ) {
					return extension.$container;
				} else { // find children
					return extension.$container.find(selector);
				}
			},
			
			getOptionElements : function(){
				return extension.getElement('select[name^="'+extension.option_prefix+'["], input[name^="'+extension.option_prefix+'["], textarea[name^="'+extension.option_prefix+'["]');
			},
			
			getQuantityElement : function() {
				
				if ( typeof(extension.custom_methods.getQuantityElement) != 'undefined' ) {
					var $quantity_element = extension.custom_methods.getQuantityElement();
					if ( $quantity_element && $quantity_element.length ) {
						return $quantity_element;
					}
				}
				
				return extension.getElement('input#input-quantity, input#qty-input, input#qty[name="quantity"], #product input[name="quantity"], .ajax-quickview-cont .quantity [name="quantity"], #quantity_wanted, select#quantity, .product-info .cart input[name=quantity], .product-info .pokupka input[name=quantity], #popup-order-okno input[name=quantity], #quantity-set, .product-info .quantity-control input[name=quantity], select[name="quantity"], .quantity input[name=quantity]');
			},
			
			getQuantity : function() {
				return extension.getQuantityElement().val();
			},
			
			getContainer : function() { // is needed only for some specific themes uses detailed selectors for containers (usually only for options), for the main container access use extension.$container
				var $container = extension.$container;
				if ( typeof(extension.custom_methods.getContainer) == 'function' ) {
					$custom_container = extension.custom_methods.getContainer();
					if ( $custom_container ) {
						$container = $custom_container;
					}
				}
				return $container;
			},
			
			getRequestURL : function() {
				var request_url = extension.params.request_url;
				if ( typeof(extension.custom_methods.getRequestURL) == 'function' ) {
					var custom_request_url = extension.custom_methods.getRequestURL();
					if ( custom_request_url ) {
						request_url = custom_request_url;
					}
				}
				return request_url;
			},
			
			getElementsToAnimateOnPriceUpdate : function() { // returns array
				var elements_to_anim = [];
				var custom_elements_to_anim = false;
				if ( typeof(extension.custom_methods.getElementsToAnimateOnPriceUpdate) == 'function' ) {
					custom_elements_to_anim = extension.custom_methods.getElementsToAnimateOnPriceUpdate();
				}
				if ( custom_elements_to_anim ) {
					if ( Array.isArray(custom_elements_to_anim) ) {
						elements_to_anim = custom_elements_to_anim;
					} else {
						elements_to_anim.push(custom_elements_to_anim);
					}
				} else { // default
					var lp_infos = $('#product').parent().find('.list-unstyled');
					if (lp_infos.length >= 2 ) {
						elements_to_anim.push( $(lp_infos[1]) );
					}
				}
				return elements_to_anim;
			},
			
			init : function(call_for_no_options) {
				
				extension.setCustomMethods();
				if ( typeof(extension.custom_methods.useCustomMainContainer) == 'function' ) {
					extension.custom_methods.useCustomMainContainer();
				}
				
				if ($('#mijoshop').length && extension.getElement('[name^="option_oc["]').length) { // 
					extension.option_prefix = "option_oc";
				}
				
				// for some themes. options may be not available on this stage, so lets call for init on document.ready
				if ( !call_for_no_options ) {
					if ( !extension.getElement('input[name^="'+extension.option_prefix+'["],select[name^="'+extension.option_prefix+'["],textarea[name^="'+extension.option_prefix+'["]').length ) {
						$(document).ready(function(){
							extension.init(true);
						});
						return;
					}
				}
				
				//extension.setCustomMethods();
				
				var $option_elements = extension.getOptionElements();
				$option_elements.on('change', function(){
					extension.updatePrice(10);
				});
				
				$option_elements.each(function(){
					var $option_element = $(this);
					if ( $option_element.is(':radio:checked, :checkbox:checked') ) {
						extension.updatePrice(10);
						return false;
					} else {
						if ( $option_element.val() ) {
							extension.updatePrice(10);
							return false;
						}
					}
				});
					
				var $quantity_elements = extension.getQuantityElement();
				$quantity_elements.on('input propertychange change paste', function(){
					extension.updatePrice(10);
				});
				
				if ( $quantity_elements.filter('select').length ) {
					extension.updatePrice(10);
				}
				
				extension.getElement('[name^="quantity_per_option["]').on('input propertychange change paste', function(){
					extension.updatePrice(10);
				});
				
				if ( typeof(extension.custom_methods.getSelectorForElementsToUpdatePriceOnClick) == 'function' ) { // this way is needed for some specific themes
					var selector_to_update_price_on_click = extension.custom_methods.getSelectorForElementsToUpdatePriceOnClick();
					if ( selector_to_update_price_on_click ) {
						extension.getContainer().on('click', selector_to_update_price_on_click, function(){
							extension.updatePrice(100);
						});
					}
				}
				
				if ( typeof(extension.custom_methods.getElementsToUpdatePriceOnClick) == 'function' ) {
					var $custom_elements_to_update_price_on_click = extension.custom_methods.getElementsToUpdatePriceOnClick();
					if ( $custom_elements_to_update_price_on_click ) {
						$custom_elements_to_update_price_on_click.click(function(){
							extension.updatePrice(100);
						});
					}
				}
				
				if ( extension.getElement('input[name^="quantity_per_option["][value]:not([value="0"])').length ) {
					extension.updatePrice(10); // initial recalc for default values of quantity per option inputs
				}
				
				// << compatibility Option Price by Char Pro
				if ( extension.getElement('input[name^="'+extension.option_prefix+'["][ppc_current_price], textarea[name^="'+extension.option_prefix+'["][ppc_current_price]').length) {
					extension.getElement('input[name^="'+extension.option_prefix+'["][ppc_current_price], textarea[name^="'+extension.option_prefix+'["][ppc_current_price]').on('input propertychange change paste', function(){
						extension.updatePrice(500);
					});
				}
				// >> compatibility Option Price by Char Pro
				
				
				if ( typeof(extension.params.non_standard_theme) != 'undefined' && extension.params.non_standard_theme == 'mstore' ) {
					extension.getElement('#qty').siblings('.qty').click(function() {
						extension.updatePrice(50);
					});
				}
				
				// Product Size Option
				// replace function
				var fix_updatePriceBySize = function(){
					if ( typeof(updatePriceBySize) == 'function') {
						updatePriceBySize = function(){
							extension.updatePrice(100);
						};
						extension.updatePrice(100);
					}
				}
				if ( typeof(updatePriceBySize) == 'function' ) {
					fix_updatePriceBySize();
				} else {
					$(document).load( fix_updatePriceBySize );
				}
				
				// quantity_list_pro compatibility
				$(document).on('mouseup', 'body #qty_list', function(){
					setTimeout(function () {
						$('#input-quantity').change();
					}, 50);
				});
				
				if ( typeof(extension.custom_methods.init) == 'function' ) {
					extension.custom_methods.init();
				}
				
				
				// << unknown custom themes
				
				extension.getElement('#button-cart').on('click', function(){
					extension.updatePrice(500);
				});
				
				if ( extension.getElement('#input-quantity').length && extension.getElement('#input-quantity').val() && extension.getElement('#input-quantity').val() > 1) {
					extension.updatePrice(50);
				}
				
				extension.getElement('.product-info .cart').find('#superplus, #superminus').click(function() {
					extension.updatePrice(50);
				});
				
				extension.getElement('#product .btn-number--plus, #product .btn-number--minus').click(function() {
					extension.updatePrice(50);
				});
				// >> unknown custom themes
				
				if ( extension.getQuantity() != 1 ) {
					extension.updatePrice(10);
				}
				
				// for Yandex sync module by Toporchillo 
				var hash = window.location.hash;
				if (hash) {
					var hashpart = hash.split('#');
					var hashvals = hashpart[1].split('-');
					for (var hashvals_i=0; hashvals_i<hashvals.length; hashvals_i++) {
						var hashval = hashvals[hashvals_i];
						
						if ( hashval ) {
							extension.getElement('select[name^="'+extension.option_prefix+'["] option[value="'+hashval+'"]:first').each(function(){
								$(this).parent().val($(this).attr('value'));
								$(this).parent().change();
							});
							
							extension.getElement('input[name^="'+extension.option_prefix+'["][value="'+hashval+'"]').each( function(){
								$(this).prop('checked', true);
								$(this).change();
							});
						}
					}
				}
				
				extension.$container.data('liveopencart.live_price', extension);
				if ( !window.liveopencart ) {
					window.liveopencart = {};
				}
				if ( !window.liveopencart.live_price_instances ) {
					window.liveopencart.live_price_instances = [];
				}
				window.liveopencart.live_price_instances.push(extension);
				
				extension.initialized = true;
			},
			
			animateElements : function(fadeTo) {
				
				if ( extension.params.lp_settings['animation'] ) {
				
					var elements_to_animate = extension.getElementsToAnimateOnPriceUpdate(); // array
					
					if ( elements_to_animate.length ) {
						for ( var i_elements_to_animate in elements_to_animate ) {
							if ( !elements_to_animate.hasOwnProperty(i_elements_to_animate) ) continue;
							var element_to_animate = elements_to_animate[i_elements_to_animate];
							element_to_animate.fadeTo('fast', fadeTo);
						}
					}
				}
				
			},
			
			updatePrice : function(liveprice_delay) {
				
				if ( !extension.containerExists() ) {
					return;
				}
				
				if ( typeof(extension.custom_methods.updatePrice_before) == 'function' ) {
					extension.custom_methods.updatePrice_before();
				}
				
				clearTimeout(extension.timer_update_price);
				
				if ( !extension.initialized ) {
					extension.timer_update_price = setTimeout(function(){
						extension.updatePrice(liveprice_delay);
					}, 10);
					return;
				}
				
				if ( liveprice_delay ) {
					extension.timer_update_price = setTimeout(function(){
						extension.updatePrice(0);
					}, liveprice_delay);
					return;
				}
				
				extension.update_price_call_id = (new Date()).getTime();
				var current_update_price_call_id = extension.update_price_call_id;
				var request_url = extension.getRequestURL();
				/*
				if ( lp_theme_name == 'BurnEngine_shoppica' ) {
					var request_url = 'index.php?route=product/product&get_liveprice=1';
				} else {
					var request_url = 'index.php?route=module/liveprice/get_price';
				}
				*/
				/*
				<?php if ( $lp_theme_name=='themeXXX' && empty($product_id) && !empty($product['product_id']) ) { ?>
					request_url += '&product_id=<?php echo $product['product_id']; ?>';
				<?php } else { ?>
					request_url += '&product_id=<?php echo $product_id; ?>';
				<?php } ?>
				*/
				
				request_url += '&product_id='+extension.params.product_id;
				
				request_url += '&quantity='+extension.getQuantity();
				//request_url += '&rnd='+liveprice_last_request;
				if ( extension.params.non_standard_theme ) {
					request_url += '&non_standard_theme='+extension.params.non_standard_theme;
				}
				
				var $container_of_options = extension.getContainer();
				
				options_data = $container_of_options.find('select[name^="'+extension.option_prefix+'["], input[name^="'+extension.option_prefix+'["][type=\'radio\']:checked, input[name^="'+extension.option_prefix+'["][type=\'checkbox\']:checked, textarea[name^="'+extension.option_prefix+'["], input[name^="'+extension.option_prefix+'["][type="text"], [name^="quantity_per_option["]');
				
				$.ajax({
					type: 'POST',
					url: request_url,
					data: options_data,
					dataType: 'json',
					beforeSend: function() {
						extension.animateElements(0.1);
					},
					complete: function() {},
					success: function(json) {
						
						if (json && current_update_price_call_id == extension.update_price_call_id) {
							if ( extension.params.non_standard_theme == 'mstore' ) {
								extension.getElement('#lp_price').html(json.htmls.html);
							} else if ( extension.params.non_standard_theme == 'FntProductDesign') {
								if ( extension.getElement('#product .price').next().is('.price-tax') ) {
									extension.getElement('#product .price').next().remove();
								}
								if ( extension.getElement('#product .price').next().is('ul.list-unstyled') ) {
									extension.getElement('#product .price').next().remove();
								}
								extension.getElement('#product .price').replaceWith(json.htmls.html);
								
							} else if ( typeof(extension.custom_methods.setPriceHTML) == 'function' ) {
								
								extension.custom_methods.setPriceHTML(json);
								
							}	else { // default theme
							
								var lp_infos = extension.getElement('#product').parent().find('.list-unstyled');
								if (lp_infos.length >= 2 ) {
									$(lp_infos[1]).html(json.htmls.html);
									//$(lp_infos[1]).replaceWith(json.htmls.html);
								} else if ( lp_infos.length == 1 ) {
									lp_infos.html(json.htmls.html);
								}
							}
							
							extension.animateElements(1);
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
				
			},
			
		};
		
		extension.init();
		
		return extension;
		
	}
})(jQuery)