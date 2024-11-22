<?php 

namespace Framework\Views;

class TemplateEngine {
    public function parseData(string $template, array $data=[]){
        extract($data);

		ob_start();
		include $template;
		$content = ob_get_clean();

		//echo $content;
		return $content;
    }
}