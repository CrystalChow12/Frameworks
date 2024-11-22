<?php

namespace Framework\Views;

use Framework\Framework;
use Framework\Views\TemplateEngine as TemplateEngine;

final class View {
	private TemplateEngine $templateEngine;

	public function __construct() {
		$this->templateEngine = new TemplateEngine();
	}

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

		$content = $this->templateEngine->parseData($templatePath, $data);

		//echo $content;
		return $content;
	}

	public function escape($value): string {
		return htmlspecialchars($value);
	}
}
