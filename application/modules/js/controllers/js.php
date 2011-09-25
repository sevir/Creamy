<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Js extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->config('js_module_config');

		//check js cache folder
		if(!file_exists($this->config->item('cache_dir')) && $this->config->item('enable_cache'))
			mkdir($this->config->item('cache_dir'));
	}

	function run($params){
		$params = substr($params, strlen($this->config->item('public_js_folder')));
		if($this->config->item('enable_cache')){
			$cache_file = md5($params);
		}
		if ($this->config->item('minify_js')){
			$this->load->driver('minify');
		}
		$params = explode($this->config->item('file_separator'), $params);

		header('Content-type: text/javascript');

		if ($this->config->item('enable_cache')){
			$this->load->helper('file');
			$modified_md5 = '';
			foreach ($params as $param) {
				$info=array('date');
				$d = get_file_info( $this->config->item('public_js_folder').$param, $info);
				$modified_md5 .= $d['date'];
			}
			$cache_file = md5($cache_file.'_'.$modified_md5);

			if (!file_exists($this->config->item('cache_dir').'/'.$cache_file)){
				$cache_full_file_path = $this->config->item('cache_dir').'/'.$cache_file;
				foreach ($params as $param) {
					if ($this->config->item('minify_js')){
						$content = $this->minify->js->min($this->config->item('public_js_folder').$param);
					}else{
						$content = file_get_contents( $this->config->item('public_js_folder').$param)."\n";
					}
					write_file(
						$cache_full_file_path,
						$content,
						'a'
					);
				}
			}

			$this->output->set_output( file_get_contents($this->config->item('cache_dir').'/'.$cache_file));
		}else{
			$output = '';
			foreach ($params as $param) {
				$output .= file_get_contents( $this->config->item('public_js_folder').$param)."\n";
			}
			$this->output->set_output($output);
		}
	}

	function _remap($method, $params){
		//remap function similar to route config file
		$this->run($this->uri->uri_string());
	}
}

/* eof file application/controllers/js.php */