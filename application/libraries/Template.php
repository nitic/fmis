<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
		var $template_data = array();
		
		function set($name, $value)
		{
			$this->template_data[$name] = $value;
		}
	
		function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
		{               
			$this->CI =& get_instance();
			$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));			
			return $this->CI->load->view($template, $this->template_data, $return);
		}

		function load_multiview($template = '', $view = array() , $view_data = array(), $return = FALSE)
		{               
			$this->CI =& get_instance();
			
			$return_value = '';
			if (is_array($view)){
			    foreach ($view as $current_index => $current_view){
				//$current_vars = $view_data;
				if (is_array($view_data)){
				   $result = $this->CI->load->view($current_view, $view_data[$current_index], TRUE);
				}
				if (is_string($result)) {
				    $return_value .= $result;
				}
			    }
			    $this->set('contents',$return_value);		
			    return $this->CI->load->view($template, $this->template_data, $return);
			} 
			else{
		            $this->set('contents', $this->CI->load->view($view, $vars, TRUE));
			    return $this->CI->load->view($template, $this->template_data, $return);	
			}

		}
}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */
