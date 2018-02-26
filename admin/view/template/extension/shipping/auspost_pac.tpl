<?php
/*****************************************************************************
 *
 * ---------------------------------------------------------------
 * Australia Post: Postage Assesment Calculator for Opencart 2.3+
 *    (c) 2017 WWWShop, unauthorized reproduction is prohibited
 * ---------------------------------------------------------------
 *
 * Developer: WWWShop (opencart@wwwshop.com.au)
 * Date: 2017-11-21
 * Website: http://wwwshop.com.au/
 *
 *****************************************************************************/
 echo $header; ?>
<style type="text/css">
.auspost-options { margin-left: 20px; }
.auspost-row .checkbox { padding-top: 4px; }
.scrollbox div.auspost-input { margin: 5px 0 0 17px; }
.scrollbox div.auspost-input input { padding: 2px; width: 100px; }
.auspost-note { font-style: italic; }
#service-select { margin-top: 10px; }
#service-add { margin-top: 10px; }
</style>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-auspost" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) : ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>
      <?php if ($error_currency) : ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_currency; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
      <?php endif; ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-auspost" class="form-horizontal">
        
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-services" data-toggle="tab"><?php echo $tab_services; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-api-key"><?php echo $entry_api_key; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="auspost_pac_api_key" value="<?php echo $auspost_pac_api_key; ?>" placeholder="<?php echo $entry_api_key; ?>" id="input-api-key" class="form-control" />
                  <?php if ($error_api_key) { ?>
                  <div class="text-danger"><?php echo $error_api_key; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-origin-postcode"><span data-toggle="tooltip" title="<?php echo $help_origin_postcode; ?>"><?php echo $entry_origin_postcode; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="auspost_pac_origin_postcode" value="<?php echo $auspost_pac_origin_postcode; ?>" placeholder="<?php echo $entry_origin_postcode; ?>" id="input-origin-postcode" class="form-control" />
                  <?php if ($error_origin_postcode) { ?>
                  <div class="text-danger"><?php echo $error_origin_postcode; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-show-delivery-time"><span data-toggle="tooltip" title="<?php echo $help_show_delivery_time; ?>"><?php echo $entry_show_delivery_time; ?></span></label>
                <div class="col-sm-10">
                  <select name="auspost_pac_show_delivery_time" id="input-show-delivery-time" class="form-control">
                    <option value="0"<?php echo (!$auspost_pac_show_delivery_time ? ' selected="selected"' : ''); ?>><?php echo $text_disabled; ?></option>
                    <option value="1"<?php echo ( $auspost_pac_show_delivery_time ? ' selected="selected"' : ''); ?>><?php echo $text_enabled; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-multiple-packages"><span data-toggle="tooltip" title="<?php echo $help_multiple_packages; ?>"><?php echo $entry_multiple_packages; ?></span></label>
                <div class="col-sm-10">
                  <select name="auspost_pac_multiple_packages" id="input-multiple-packages" class="form-control">
                    <option value="0"<?php echo (!$auspost_pac_multiple_packages ? ' selected="selected"' : ''); ?>><?php echo $text_disabled; ?></option>
                    <option value="1"<?php echo ( $auspost_pac_multiple_packages ? ' selected="selected"' : ''); ?>><?php echo $text_enabled; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-handling-fee"><span data-toggle="tooltip" title="<?php echo $help_handling_fee; ?>"><?php echo $entry_handling_fee; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="auspost_pac_handling_fee" value="<?php echo $auspost_pac_handling_fee; ?>" placeholder="<?php //echo $entry_handling_fee; ?>" id="input-handling-fee" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-min-weight"><span data-toggle="tooltip" title="<?php echo $help_min_weight; ?>"><?php echo $entry_min_weight; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="auspost_pac_min_weight" value="<?php echo $auspost_pac_min_weight; ?>" placeholder="<?php //echo $entry_min_weight; ?>" id="input-min-weight" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-max-weight"><span data-toggle="tooltip" title="<?php echo $help_max_weight; ?>"><?php echo $entry_max_weight; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="auspost_pac_max_weight" value="<?php echo $auspost_pac_max_weight; ?>" placeholder="<?php //echo $entry_max_weight; ?>" id="input-max-weight" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-one-item-per-parcel"><?php echo $entry_one_item_per_parcel; ?></label>
                <div class="col-sm-10">
                  <select name="auspost_pac_one_item_per_parcel" id="input-one-item-per-parcel" class="form-control">
                    <option value="0"<?php echo (!$auspost_pac_one_item_per_parcel ? ' selected="selected"' : ''); ?>><?php echo $text_disabled; ?></option>
                    <option value="1"<?php echo ( $auspost_pac_one_item_per_parcel ? ' selected="selected"' : ''); ?>><?php echo $text_enabled; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
                <div class="col-sm-10">
                  <select name="auspost_pac_tax_class_id" id="input-tax-class" class="form-control">
                    <option value="0"><?php echo $text_none; ?></option>
                    <?php foreach ($tax_classes as $tax_class) { ?>
                    <option value="<?php echo $tax_class['tax_class_id']; ?>"<?php echo ($tax_class['tax_class_id'] == $auspost_pac_tax_class_id ? ' selected="selected"' : ''); ?>><?php echo $tax_class['title']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-remove-gst-from-price"><span data-toggle="tooltip" title="<?php echo $help_remove_gst_from_price; ?>"><?php echo $entry_remove_gst_from_price; ?></span></label>
                <div class="col-sm-10">
                  <select name="auspost_pac_remove_gst_from_price" id="input-remove-gst-from-price" class="form-control">
                    <option value="0"<?php echo (!$auspost_pac_remove_gst_from_price ? ' selected="selected"' : ''); ?>><?php echo $text_disabled; ?></option>
                    <option value="1"<?php echo ( $auspost_pac_remove_gst_from_price ? ' selected="selected"' : ''); ?>><?php echo $text_enabled; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="auspost_pac_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"<?php echo ($geo_zone['geo_zone_id'] == $auspost_pac_geo_zone_id ? ' selected="selected"' : ''); ?>><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="auspost_pac_status" id="input-status" class="form-control">
                    <option value="0"<?php echo (!$auspost_pac_status ? ' selected="selected"' : ''); ?>><?php echo $text_disabled; ?></option>
                    <option value="1"<?php echo ( $auspost_pac_status ? ' selected="selected"' : ''); ?>><?php echo $text_enabled; ?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="auspost_pac_sort_order" value="<?php echo $auspost_pac_sort_order; ?>" placeholder="<?php //echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>

            <div class="tab-pane" id="tab-services">
              <div class="table-responsive">
                <table id="service" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_service; ?></td>
                      <td class="text-left"><?php echo $entry_region; ?></td>
                      <td class="text-left"><?php echo $entry_options; ?></td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>

                    <?php $service_row = 0; ?>
                    <?php foreach ($auspost_pac_services as $auspost_pac_service) { ?>
                    <?php $service = isset($auspost_pac_service['code']) && isset($services[$auspost_pac_service['code']]) ? $services[$auspost_pac_service['code']] : false; ?>
                    <?php if ($service) { ?>
                    <tr id="service-row<?php echo $service_row; ?>" data-row-id="<?php echo $service_row; ?>">
                      <td class="text-left" style="width: 30%;">
                        <select name="auspost_pac_service[<?php echo $service_row; ?>][code]" class="form-control auspost-service-select">
                          <option value=""><?php echo $text_select_service; ?></option>
                          <optgroup label="Domestic">
                            <?php foreach ($services as $code => $option) { if ($option['region'] == 'Domestic') { ?>
                            <option value="<?php echo $code; ?>"<?php echo ($code == $service['code'] ? ' selected' : ''); ?>><?php echo $option['name']; ?></option>
                            <?php } } ?>
                          </optgroup>
                          <optgroup label="International">
                            <?php foreach ($services as $code => $option) { if ($option['region'] == 'International') { ?>
                            <option value="<?php echo $code; ?>"<?php echo ($code == $service['code'] ? ' selected' : ''); ?>><?php echo $option['name']; ?></option>
                            <?php } } ?>
                          </optgroup>
                        </select>
                      </td>
                      <td class="text-left auspost-service-region">
                        <input type="hidden" name="auspost_pac_service[<?php echo $service_row; ?>][is_domestic]" value="<?php echo $service['region'] == 'Domestic' ? 1 : 0; ?>" />
                        <?php echo $service['region']; ?>
                      </td>
                      <td class="text-left auspost-service-options">
                        <?php if (isset($service['options'])) : ?>
                        <div class="auspost-expand auspost-options">
                          <?php foreach ($service['options'] as $option) : ?>
                          <div class="auspost-row">
                            <div class="checkbox"><label>

                            <input type="checkbox" name="auspost_pac_service[<?php echo $service_row; ?>][option][<?php echo $option['code']; ?>][status]" value="1"<?php echo (isset($auspost_pac_service['option'][$option['code']]['status']) || isset($option['checked']) ? ' checked="checked"' : ''); ?> />

                            <?php echo $option['name']; ?>
                            <?php if (isset($option['type'])) : ?>
                              <div class="auspost-expand auspost-input">
                                <input type="text" name="auspost_pac_service[<?php echo $service_row; ?>][option][<?php echo $option['code']; ?>][value]" value="<?php echo (isset($auspost_pac_service['option'][$option['code']]['status']) && isset($auspost_pac_service['option'][$option['code']]['value']) ? $auspost_pac_service['option'][$option['code']]['value'] : ''); ?>" />
                              </div>
                            <?php endif; ?>
                            <?php if (isset($option['note'])) : ?>
                              <span class="auspost-note">(<?php echo $option['note']; ?>)</span>
                            <?php endif; ?>

                            </label></div>

                            <?php if (isset($option['suboptions'])) : ?>
                            <div class="auspost-expand auspost-options">
                              <?php foreach ($option['suboptions'] as $suboption) : ?>
                              <div class="auspost-row">
                                <div class="checkbox"><label>

                                <?php if (!isset($suboption['disabled'])) : ?>
                                <input type="checkbox" name="auspost_pac_service[<?php echo $service_row; ?>][option][<?php echo $option['code']; ?>][suboption][<?php echo $suboption['code']; ?>][status]" value="1"<?php echo (isset($auspost_pac_service['option'][$option['code']]['suboption'][$suboption['code']]['status']) || isset($suboption['checked']) ? ' checked="checked"' : ''); ?> />
                                <?php else : ?>
                                <input type="hidden" name="auspost_pac_service[<?php echo $service_row; ?>][option][<?php echo $option['code']; ?>][suboption][<?php echo $suboption['code']; ?>][status]" value="<?php echo (isset($auspost_pac_service['option'][$option['code']]['suboption'][$suboption['code']]['status']) || isset($suboption['checked']) ? '1' : ''); ?>" />
                                <input type="checkbox" disabled="disabled"<?php echo (isset($auspost_pac_service['option'][$option['code']]['suboption'][$suboption['code']]['status']) || isset($suboption['checked']) ? ' checked="checked"' : ''); ?> />
                                <?php endif; ?>

                                <?php echo $suboption['name']; ?>
                                <?php if (isset($suboption['type'])) : ?>
                                  <div class="auspost-expand auspost-input">
                                    <input type="text" name="auspost_pac_service[<?php echo $service_row; ?>][option][<?php echo $option['code']; ?>][suboption][<?php echo $suboption['code']; ?>][value]" value="<?php echo (isset($auspost_pac_service['option'][$option['code']]['suboption'][$suboption['code']]['status']) && isset($auspost_pac_service['option'][$option['code']]['suboption'][$suboption['code']]['value']) ? $auspost_pac_service['option'][$option['code']]['suboption'][$suboption['code']]['value'] : ''); ?>" />
                                  </div>
                                <?php endif; ?>
                                <?php if (isset($suboption['note'])) : ?>
                                  <span class="auspost-note">(<?php echo $suboption['note']; ?>)</span>
                                <?php endif; ?>

                                </label></div>
                              </div>
                              <?php endforeach; ?>
                            </div>
                            <?php endif; ?>


                          </div>
                          <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                      </td>
                      <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger auspost-pac-btn-remove-service"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
                    <?php $service_row++; ?>
                    <?php } ?>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"></td>
                      <td class="text-left"><button type="button" onclick="addService();" data-toggle="tooltip" title="<?php echo $button_service_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
var service_row = <?php echo (int)$service_row; ?>;

var addService;

(function($){
    var SERVICES = <?php echo json_encode($services); ?>;

    $('#service .auspost-expand').each(function(){
        var options = $(this),
            input = options.parent().find('> .checkbox input[type=checkbox]');

        if (input.length && !input.is(':checked')) {
            options.hide();
        }

        input.bind('change', function(){
            var $this = $(this),
                fn = (input.is(':checked') ? 'slideDown' : 'slideUp');

            options[fn]();
        });
    });

    $('#service').on('change', "input[type=checkbox][name^='auspost_pac_service['][name$='][status]']", function(e, ignore){
        var $this = $(this),
            cellEl = $this.closest('td'),
            isChecked = $this.is(':checked');

        if (!ignore) {
            var els,
                isInt = cellEl.prev().text().indexOf('International') != -1;

            if ($this.is("[name*='[suboption]']")) {
                els = cellEl.find("[name*='[suboption]']").not($this);
            } else {
                els = cellEl.find("[name*='[option]']").not("[name*='[suboption]']").not($this);
            }

            if (!isInt || els.filter(':checked').length > 0) {
                els.prop('checked' , !isChecked);
            }

            els.trigger('change', [true]);
        }
    });

    $('#service').on('change', 'select.auspost-service-select', function(e){
        e.preventDefault();

        var $this = $(this),
            row = $this.closest('tr'),
            service_row = row.data('rowId');

        var selectedOption = $('option:selected', $this),
            service = getService($this.val()),
            html = '',
            regionHtml = '',
            region = '';

        if (service) {
            region = service.region;

            regionHtml = '<input type="hidden" name="auspost_pac_service[' + service_row + '][is_domestic]" value="' + (region == 'Domestic' ? 1 : 0) + '" />' + region;

            if (service.options) {
                html += '<div class="auspost-expand auspost-options">';

                for (var i in service.options) {
                    var option = service.options[i];

                    html += '<div class="auspost-row">';

                    html += '<div class="checkbox"><label>';

                    html += '<input type="checkbox" name="auspost_pac_service[' + service_row + '][option][' + option.code + '][status]" value="1"' + (typeof option.checked != 'undefined' ? ' checked' : '') + ' />';

                    html += ' ' + option.name;

                    if (typeof option.type != 'undefined') {
                        html += '<div class="auspost-expand auspost-input">';
                        html += '<input type="text" name="auspost_pac_service[' + service_row + '][option][' + option.code + '][value]" value="' + (typeof option.value != 'undefined' ? option['value'] : '') + '" />';
                        html += '</div>';
                    }

                    if (typeof option.note != 'undefined') {
                        html += '<span class="auspost-note">(' + option.note + ')</span>';
                    }

                    html += '</label></div>';

                    if (typeof option.suboptions != 'undefined') {
                        html += '<div class="auspost-expand auspost-options">';

                        for (var j in option.suboptions) {
                            var suboption = option.suboptions[j];

                            html += '<div class="auspost-row">';

                            html += '<div class="checkbox"><label>';

                            if (typeof suboption.disabled == 'undefined') {
                                html += '<input type="checkbox" name="auspost_pac_service[' + service_row + '][option][' + option.code + '][suboption][' + suboption.code + '][status]" value="1"' + (typeof suboption.checked != 'undefined' ? ' checked' : '') + ' />';
                            } else {
                                html += '<input type="hidden" name="auspost_pac_service[' + service_row + '][option][' + option.code + '][suboption][' + suboption.code + '][status]" value="1"' + (typeof suboption.checked != 'undefined' ? ' 1' : '') + ' />';
                                html += '<input type="checkbox" name="" value="" disabled' + (suboption['status'] || suboption['checked'] ? ' checked' : '') + ' />';
                            }

                            html += ' ' + suboption.name;

                            if (typeof suboption.type != 'undefined') {
                                html += '<div class="auspost-expand auspost-input">';
                                html += '<input type="text" name="auspost_pac_service[' + service_row + '][option][' + option.code + '][suboption][' + suboption.code + '][value]" value="' + (typeof suboption.value != 'undefined' ? suboption['value'] : '') + '" />';
                                html += '</div>';
                            }

                            if (typeof suboption.note != 'undefined') {
                                html += '<span class="auspost-note">(' + suboption.note + ')</span>';
                            }

                            html += '</label></div>';

                            html += '</div>';
                        }

                        html += '</div>';
                    }

                    html += '</div>';
                }

                html += '</div>';
            }

            service_row++;
        }

        row.find('.auspost-service-region').html(regionHtml);
        row.find('.auspost-service-options').html(html);
    });

    $('#service').on('click', '.auspost-pac-btn-remove-service', function(e){
        $(this).closest('tr').remove();
    });

    function getServices() {
        if (!SERVICES) {
            SERVICES = {};
        }

        return SERVICES;
    }

    function getService(code) {
        if (SERVICES[code]) {
            var service = SERVICES[code];

            if (typeof service.options == 'undefined') {
                service.options = [];
            }

            return service;
        }
    }

    function getServicesSelectOptions() {
        var services = getServices();

        var html = '';

        html += '<option value=""><?php echo $text_select_service; ?></option>';

        html += '<optgroup label="Domestic">';

        for (var i in services) {
            if (services[i].region == 'Domestic') {
                html += '<option value="' + i + '">' + services[i].name + '</option>';
            }
        }

        html += '</optgroup>';
        html += '<optgroup label="International">';

        for (var i in services) {
            if (services[i].region == 'International') {
                html += '<option value="' + i + '">' + services[i].name + '</option>';
            }
        }

        html += '</optgroup>';

        return html;
    }

    addService = function() {
        var selectOptions = getServicesSelectOptions();

        html  = '<tr id="service-row' + service_row + '" data-row-id="' + service_row + '">';
        html += '  <td class="text-left" style="width: 30%;"><select name="auspost_pac_service[' + service_row + '][code]" class="form-control auspost-service-select">' + selectOptions + '</select></td>';
        html += '  <td class="text-left auspost-service-region"></td>';
        html += '  <td class="text-left auspost-service-options"></td>';
        html += '  <td class="text-left"><button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger auspost-pac-btn-remove-service"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#service tbody').append(html);

        service_row++;
    }
})(jQuery);
</script>
<?php echo $footer; ?>