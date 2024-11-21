<?php

namespace Framework\Views;

use Framework\Framework;

class View {
	public function render(string $template, array $data = []) {
		// Construct the full path to the template file
		$templatePath =
			Framework::$ROOTDIR . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $template);

		if (!file_exists($templatePath)) {
			throw new \RuntimeException('Template file not found: ' . $templatePath);
		}

		$e = function ($value) {
			return $this->escape($value);
		};

		extract($data);

		ob_start();
		include $templatePath;
		$content = ob_get_clean();

		//echo $content;
		return $content;
	}

	public function escape($value): string {
		return htmlspecialchars($value);
	}
}
