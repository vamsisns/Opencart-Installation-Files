<?php  
class ControllerExtensionModuleNivoSlider extends Controller {
	public function index($setting) {
		static $module = 1;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/theme/default/stylesheet/resp_nivoslider/resp_nivoslider.css');
		$this->document->addScript('catalog/view/javascript/jquery/resp_nivoslider/jquery.nivo.slider.js');

		if (!isset($setting['nivoslider']['store_id']) || !in_array($this->config->get('config_store_id'), $setting['nivoslider']['store_id'])) {
			return;
		}

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (!isset($setting['nivoslider']['location']) && isset($this->request->get['path'])) {
			if (empty($setting['nivoslider']['fcid']) || !in_array((int)end($parts), $setting['nivoslider']['fcid'])) {
				return;
			}
		}

		$data['speed'] = !empty($setting['nivoslider']['speed']) ? $setting['nivoslider']['speed'] : '3000';
		$data['duration'] = !empty($setting['nivoslider']['duration']) ? $setting['nivoslider']['duration'] : '500';
		$data['slices'] = !empty($setting['nivoslider']['slices']) ? $setting['nivoslider']['slices'] : '15';
		$data['boxcols'] = !empty($setting['nivoslider']['boxcols']) ? $setting['nivoslider']['boxcols'] : '8';
		$data['boxrows'] = !empty($setting['nivoslider']['boxrows']) ? $setting['nivoslider']['boxrows'] : '4';
		$data['width'] = !empty($setting['nivoslider']['width']) ? $setting['nivoslider']['width'] : '1140';
		$data['height'] = !empty($setting['nivoslider']['height']) ? $setting['nivoslider']['height'] : '380';
		$data['start'] = !empty($setting['nivoslider']['start']) ? $setting['nivoslider']['start']-1 : '0';
		$data['thumb_width'] = !empty($setting['nivoslider']['thumb_width']) ? $setting['nivoslider']['thumb_width'] : '120';
		$data['thumb_height'] = $data['height']/($data['width'] / $data['thumb_width']);
		$data['caption'] = $setting['nivoslider']['caption'];
		$data['autoplay'] = $setting['nivoslider']['autoplay'];
		$data['style'] = $setting['nivoslider']['style'];
		$data['effect'] = $setting['nivoslider']['effect'];
		$data['pause'] = $setting['nivoslider']['pause'];
		$data['random'] = $setting['nivoslider']['random'];
		$data['directionnav'] = $setting['nivoslider']['directionnav'];
		$data['controlnav'] = $setting['nivoslider']['controlnav'];
		$data['controlnavthumbs'] = $setting['nivoslider']['controlnavthumbs'];
		$data['beforechange'] = isset($setting['nivoslider']['beforechange']) ? html_entity_decode($setting['nivoslider']['beforechange'], ENT_QUOTES, 'UTF-8') : '';
		$data['afterchange'] = isset($setting['nivoslider']['afterchange']) ? html_entity_decode($setting['nivoslider']['afterchange'], ENT_QUOTES, 'UTF-8') : '';
		$data['slideshowend'] = isset($setting['nivoslider']['slideshowend']) ? html_entity_decode($setting['nivoslider']['slideshowend'], ENT_QUOTES, 'UTF-8') : '';
		$data['lastslide'] = isset($setting['nivoslider']['lastslide']) ? html_entity_decode($setting['nivoslider']['lastslide'], ENT_QUOTES, 'UTF-8') : '';
		$data['afterload'] = isset($setting['nivoslider']['afterload']) ? html_entity_decode($setting['nivoslider']['afterload'], ENT_QUOTES, 'UTF-8') : '';

		$this->document->addStyle('catalog/view/theme/default/stylesheet/resp_nivoslider/themes/'. $data['style'] .'/'. $data['style'] .'.css');

		$data['banners'] = array();

		if (isset($setting['banner_id'])) {
			$results = $this->model_design_banner->getBanner($setting['banner_id']);

			foreach ($results as $result) {
				if (file_exists(DIR_IMAGE . $result['image'])) {
					$data['banners'][] = array(
						'title'       => $result['title'],
						'description' => $result['description'],
						'link'        => $result['link'],
						'image'       => $this->model_tool_image->resize($result['image'], $data['width'], $data['height']),
						'thumb'       => $this->model_tool_image->resize($result['image'], $data['thumb_width'], $data['thumb_height'])
						);
				}
			}
		}

		$data['module'] = $module++;
		return $this->load->view('extension/module/nivoslider', $data);
	}
}