<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<style>
input[type="radio"], input[type="checkbox"] {
    margin: 0 5px 3px 0;
}
.form-horizontal input {
    vertical-align: middle;
}
.form-horizontal .checkbox, .form-horizontal .radio {
    padding: 0;
    min-height: 22px;
}
.form-horizontal .well {
    background-color: #f7f7f7;
    min-height: 98px;
    overflow: auto;
    margin-bottom: 0;
}
.form-horizontal .well .checkbox, .form-horizontal .well .radio {
    margin-top: 4px;
}
.form-horizontal .well .fa {
    margin-right: 7px;
}
.radio label, .checkbox label {
    padding-left: 24px;
}
.control-label {
    font-weight: normal;
}
label.btn-default.active, label.btn-default.active:hover {
    color: #fff;
    background-color: #1e91cf;
    border-color: #1978ab;
}
label.btn-default:hover {
    color: #555;
    background-color: #f7f7f7;
    border-color: #ccc;
}
label.btn-default:active, label.btn-default:active:hover {
    color: #555;
    background-color: #f5f5f5;
    border-color: #ccc;
}
</style>
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <?php if ($apply_btn) { ?>
        <a onclick="$('#apply').val('1'); $('#ns-form').submit();" class="btn btn-success" data-toggle="tooltip" title="<?php echo $button_apply; ?>" role="button"><i class="fa fa-check"></i> <span class="hidden-sm"> <?php echo $button_apply; ?></span></a>
        <?php } ?>
        <button type="submit" form="ns-form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <span class="hidden-sm"> <?php echo $button_save; ?></span></button>
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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil-square-o"></i>
        <?php echo $text_edit; ?>
        <?php if (!empty($name)) { ?>
        <?php echo '"'. $name .'"'; ?>
        <?php } ?>
        </h3>
        <?php if ($success) { ?>
        <div class="ns-apply text-success pull-right"><i class="fa fa-check"></i> <?php echo $success; ?></div>
        <?php } ?>
        <?php if ($error_name) { ?>
        <div class="text-danger pull-right"><?php echo $error_name; ?></div>
        <?php } ?>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="ns-form" class="form-horizontal">
          <ul id="settingTab" class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#tab-setting" role="tab" data-toggle="tab"> <?php echo $tab_setting; ?></a></li>
            <li><a href="#tab-config" role="tab" data-toggle="tab"> <?php echo $tab_config; ?></a></li>
            <li><a href="#tab-triggers" role="tab" data-toggle="tab"> <?php echo $tab_triggers; ?></a></li>
          </ul>
          <div class="tab-content">
            <div id="tab-setting" class="tab-pane active">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group required">
                    <label class="col-sm-4 control-label"><?php echo $entry_module_name; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="name" value="<?php echo $name; ?>" class="form-control" />
                      <?php if ($error_name) { ?>
                      <div class="text-danger"><?php echo $error_name; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_status; ?></label>
                    <div class="col-sm-8">
                      <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-default">
                          <input type="radio" name="status" value="1" <?php echo isset($status) ? 'checked="checked"' : ''; ?> />
                          <?php echo $text_enabled; ?> </label>
                        <label class="btn btn-default">
                          <input type="radio" name="status" value="0" <?php echo empty($status) ? 'checked="checked"' : ''; ?> />
                          <?php echo $text_disabled; ?> </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_store; ?></label>
                    <div class="col-sm-8">
                      <div class="well well-sm">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="nivoslider[store_id][]" value="0" <?php echo isset($nivoslider['store_id']) && in_array(0, $nivoslider['store_id']) ? 'checked="checked" ' : ''; ?> />
                            <?php echo $default_store; ?>
                          </label>
                        </div>
                        <?php foreach ($stores as $store) { ?>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="nivoslider[store_id][]" value="<?php echo $store['store_id']; ?>" <?php echo isset($nivoslider['store_id']) && in_array($store['store_id'], $nivoslider['store_id']) ? 'checked="checked" ' : ''; ?> />
                            <?php echo $store['name']; ?>
                          </label>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span data-toggle="tooltip" title="<?php echo $help_categories; ?>"><?php echo $entry_categories; ?></span></label>
                    <div class="col-sm-8">
                      <input type="text" name="nivoslider[fcid]" value="" placeholder="<?php echo $text_autocomplete; ?>" class="form-control" />
                      <div id="nivoslider-location" class="well well-sm" style="max-height:230px;">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="nivoslider[location]" value="1" <?php echo isset($nivoslider['location']) ? 'checked="checked"' : ''; ?> />
                            <?php echo $text_allcat; ?> </label>
                        </div>
                        <?php foreach ($locations as $location) { ?>
                        <div id="nivoslider-location<?php echo $location['category_id']; ?>" style="margin: 2px 6px;"><i class="fa fa-minus-circle"></i> <?php echo $location['name']; ?>
                          <input type="hidden" name="nivoslider[fcid][]" value="<?php echo $location['category_id']; ?>" />
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="tab-config" class="tab-pane">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_banner; ?></label>
                    <div class="col-sm-8">
                      <select name="banner_id" class="form-control">
                      <?php foreach ($banners as $banner) { ?>
                      <?php if ($banner['banner_id'] == $banner_id) { ?>
                      <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                      <?php } ?>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_dimension; ?></label>
                    <div class="col-sm-4">
                      <input type="text" name="nivoslider[width]" value="<?php echo !empty($nivoslider['width']) ? $nivoslider['width'] : '1140'; ?>" class="form-control" />
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="nivoslider[height]" value="<?php echo !empty($nivoslider['height']) ? $nivoslider['height'] : '380'; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_style; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[style]" class="form-control">
                      <?php if (isset($nivoslider['style']) && $nivoslider['style'] == 'elegant') { ?>
                      <option value="elegant" selected="selected"><?php echo $text_elegant_style; ?></option>
                      <?php } else { ?>
                      <option value="elegant"><?php echo $text_elegant_style; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['style']) && $nivoslider['style'] == 'bar') { ?>
                      <option value="bar" selected="selected"><?php echo $text_bar_style; ?></option>
                      <?php } else { ?>
                      <option value="bar"><?php echo $text_bar_style; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['style']) && $nivoslider['style'] == 'light') { ?>
                      <option value="light" selected="selected"><?php echo $text_light_style; ?></option>
                      <?php } else { ?>
                      <option value="light"><?php echo $text_light_style; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['style']) && $nivoslider['style'] == 'dark') { ?>
                      <option value="dark" selected="selected"><?php echo $text_dark_style; ?></option>
                      <?php } else { ?>
                      <option value="dark"><?php echo $text_dark_style; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['style']) && $nivoslider['style'] == 'default') { ?>
                      <option value="default" selected="selected"><?php echo $text_default_style; ?></option>
                      <?php } else { ?>
                      <option value="default"><?php echo $text_default_style; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_effect; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[effect]" class="form-control">
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'random') { ?>
                      <option value="random" selected="selected">random</option>
                      <?php } else { ?>
                      <option value="random">random</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'fade') { ?>
                      <option value="fade" selected="selected">fade</option>
                      <?php } else { ?>
                      <option value="fade">fade</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'fold') { ?>
                      <option value="fold" selected="selected">fold</option>
                      <?php } else { ?>
                      <option value="fold">fold</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'sliceDown') { ?>
                      <option value="sliceDown" selected="selected">sliceDown</option>
                      <?php } else { ?>
                      <option value="sliceDown">sliceDown</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'sliceDownLeft') { ?>
                      <option value="sliceDownLeft" selected="selected">sliceDownLeft</option>
                      <?php } else { ?>
                      <option value="sliceDownLeft">sliceDownLeft</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'sliceUp') { ?>
                      <option value="sliceUp" selected="selected">sliceUp</option>
                      <?php } else { ?>
                      <option value="sliceUp">sliceUp</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'sliceUpLeft') { ?>
                      <option value="sliceUpLeft" selected="selected">sliceUpLeft</option>
                      <?php } else { ?>
                      <option value="sliceUpLeft">sliceUpLeft</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'sliceUpDown') { ?>
                      <option value="sliceUpDown" selected="selected">sliceUpDown</option>
                      <?php } else { ?>
                      <option value="sliceUpDown">sliceUpDown</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'sliceUpDownLeft') { ?>
                      <option value="sliceUpDownLeft" selected="selected">sliceUpDownLeft</option>
                      <?php } else { ?>
                      <option value="sliceUpDownLeft">sliceUpDownLeft</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'slideInRight') { ?>
                      <option value="slideInRight" selected="selected">slideInRight</option>
                      <?php } else { ?>
                      <option value="slideInRight">slideInRight</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'slideInLeft') { ?>
                      <option value="slideInLeft" selected="selected">slideInLeft</option>
                      <?php } else { ?>
                      <option value="slideInLeft">slideInLeft</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'boxRandom') { ?>
                      <option value="boxRandom" selected="selected">boxRandom</option>
                      <?php } else { ?>
                      <option value="boxRandom">boxRandom</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'boxRain') { ?>
                      <option value="boxRain" selected="selected">boxRain</option>
                      <?php } else { ?>
                      <option value="boxRain">boxRain</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'boxRainReverse') { ?>
                      <option value="boxRainReverse" selected="selected">boxRainReverse</option>
                      <?php } else { ?>
                      <option value="boxRainReverse">boxRainReverse</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'boxRainGrow') { ?>
                      <option value="boxRainGrow" selected="selected">boxRainGrow</option>
                      <?php } else { ?>
                      <option value="boxRainGrow">boxRainGrow</option>
                      <?php } ?>
                      <?php if (isset($nivoslider['effect']) && $nivoslider['effect'] == 'boxRainGrowReverse') { ?>
                      <option value="boxRainGrowReverse" selected="selected">boxRainGrowReverse</option>
                      <?php } else { ?>
                      <option value="boxRainGrowReverse">boxRainGrowReverse</option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_speed; ?></label>
                    <div class="col-sm-4">
                      <input type="text" name="nivoslider[speed]" value="<?php echo !empty($nivoslider['speed']) ? $nivoslider['speed'] : '3000'; ?>" class="form-control" />
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="nivoslider[duration]" value="<?php echo !empty($nivoslider['duration']) ? $nivoslider['duration'] : '500'; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span data-toggle="tooltip" title="<?php echo $help_boxes; ?>"><?php echo $entry_boxes; ?></span></label>
                    <div class="col-sm-4">
                      <input type="text" name="nivoslider[boxcols]" value="<?php echo !empty($nivoslider['boxcols']) ? $nivoslider['boxcols'] : '8'; ?>" class="form-control" />
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="nivoslider[boxrows]" value="<?php echo !empty($nivoslider['boxrows']) ? $nivoslider['boxrows'] : '4'; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span data-toggle="tooltip" title="<?php echo $help_slices; ?>"><?php echo $entry_slices; ?></span></label>
                    <div class="col-sm-8">
                      <input type="text" name="nivoslider[slices]" value="<?php echo !empty($nivoslider['slices']) ? $nivoslider['slices'] : '15'; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span data-toggle="tooltip" title="<?php echo $help_start; ?>"><?php echo $entry_start; ?></span></label>
                    <div class="col-sm-8">
                      <input type="text" name="nivoslider[start]" value="<?php echo !empty($nivoslider['start']) ? $nivoslider['start'] : '1'; ?>" class="form-control" />
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_autoplay; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[autoplay]" class="form-control">
                      <?php if (isset($nivoslider['autoplay']) && $nivoslider['autoplay'] == 'false') { ?>
                      <option value="false" selected="selected"><?php echo $text_enabled; ?></option>
                      <?php } else { ?>
                      <option value="false"><?php echo $text_enabled; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['autoplay']) && $nivoslider['autoplay'] == 'true') { ?>
                      <option value="true" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="true"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_pause; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[pause]" class="form-control">
                      <?php if (isset($nivoslider['pause']) && $nivoslider['pause'] == 'true') { ?>
                      <option value="true" selected="selected"><?php echo $text_enabled; ?></option>
                      <?php } else { ?>
                      <option value="true"><?php echo $text_enabled; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['pause']) && $nivoslider['pause'] == 'false') { ?>
                      <option value="false" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="false"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_random; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[random]" class="form-control">
                      <?php if (isset($nivoslider['random']) && $nivoslider['random'] == 'true') { ?>
                      <option value="true" selected="selected"><?php echo $text_enabled; ?></option>
                      <?php } else { ?>
                      <option value="true"><?php echo $text_enabled; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['random']) && $nivoslider['random'] == 'false') { ?>
                      <option value="false" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="false"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_directionnav; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[directionnav]" class="form-control">
                      <?php if (isset($nivoslider['directionnav']) && $nivoslider['directionnav'] == 'true') { ?>
                      <option value="true" selected="selected"><?php echo $text_enabled; ?></option>
                      <?php } else { ?>
                      <option value="true"><?php echo $text_enabled; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['directionnav']) && $nivoslider['directionnav'] == 'false') { ?>
                      <option value="false" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="false"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_controlnav; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[controlnav]" class="form-control">
                      <?php if (isset($nivoslider['controlnav']) && $nivoslider['controlnav'] == 'true') { ?>
                      <option value="true" selected="selected"><?php echo $text_enabled; ?></option>
                      <?php } else { ?>
                      <option value="true"><?php echo $text_enabled; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['controlnav']) && $nivoslider['controlnav'] == 'false') { ?>
                      <option value="false" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="false"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_caption; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[caption]" class="form-control">
                      <?php if (!empty($nivoslider['caption'])) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_thumbnails; ?></label>
                    <div class="col-sm-8">
                      <select name="nivoslider[controlnavthumbs]" class="form-control">
                      <?php if (isset($nivoslider['controlnavthumbs']) && $nivoslider['controlnavthumbs'] == 'true') { ?>
                      <option value="true" selected="selected"><?php echo $text_enabled; ?></option>
                      <?php } else { ?>
                      <option value="true"><?php echo $text_enabled; ?></option>
                      <?php } ?>
                      <?php if (isset($nivoslider['controlnavthumbs']) && $nivoslider['controlnavthumbs'] == 'false') { ?>
                      <option value="false" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="false"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_thumbwidth; ?></label>
                    <div class="col-sm-8">
                      <input type="text" name="nivoslider[thumb_width]" value="<?php echo !empty($nivoslider['thumb_width']) ? $nivoslider['thumb_width'] : '120'; ?>" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="tab-triggers" class="tab-pane">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_beforechange; ?></label>
                    <div class="col-sm-8">
                      <textarea name="nivoslider[beforechange]" class="form-control" rows="3" placeholder="function() { ... }"><?php echo isset($nivoslider['beforechange']) ? $nivoslider['beforechange'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_afterchange; ?></label>
                    <div class="col-sm-8">
                      <textarea name="nivoslider[afterchange]" class="form-control" rows="3" placeholder="function() { ... }"><?php echo isset($nivoslider['afterchange']) ? $nivoslider['afterchange'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_slideshowend; ?></label>
                    <div class="col-sm-8">
                      <textarea name="nivoslider[slideshowend]" class="form-control" rows="3" placeholder="function() { ... }"><?php echo isset($nivoslider['slideshowend']) ? $nivoslider['slideshowend'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_lastslide; ?></label>
                    <div class="col-sm-8">
                      <textarea name="nivoslider[lastslide]" class="form-control" rows="3" placeholder="function() { ... }"><?php echo isset($nivoslider['lastslide']) ? $nivoslider['lastslide'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $entry_afterload; ?></label>
                    <div class="col-sm-8">
                      <textarea name="nivoslider[afterload]" class="form-control" rows="3" placeholder="function() { ... }"><?php echo isset($nivoslider['afterload']) ? $nivoslider['afterload'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="apply" id="apply" value="0" />
        </form>
      </div>
    </div>
    <div class="footer">
      <ul class="list-inline pull-right">
        <li><a href="mailto:info@idiy.club"><?php echo $text_support; ?></a></li>
        <li><a href="<?php echo $text_author_link; ?>" onclick="return !window.open(this.href)"><?php echo $text_more; ?></a></li>
      </ul>
      <p><?php echo $text_author; ?> <a href="<?php echo $text_author_link; ?>" onclick="return !window.open(this.href)">iDiY</a>. <?php echo $heading_title; ?> <?php echo $version; ?></p>
    </div>
  </div>
<script type="text/javascript"><!--
$('.ns-apply').delay(5000).fadeOut(300);

$('input[name=\'nivoslider[fcid]\']').autocomplete({
  source: function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  select: function(item) {
    $('input[name=\'nivoslider[fcid]\']').val('');
    
    $('#nivoslider-location' + item['value']).remove();
    
    $('#nivoslider-location').append('<div id="nivoslider-location' + item['value'] + '" style="margin: 2px 6px;"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="nivoslider[fcid][]" value="' + item['value'] + '" /></div>');
  }
});

$('#nivoslider-location').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});

$('label.btn input').each(function() {
  if ($(this).prop('checked')) {
    $(this).parent('.btn').addClass('active');
  };
});
//--></script>
</div>
<?php echo $footer; ?>