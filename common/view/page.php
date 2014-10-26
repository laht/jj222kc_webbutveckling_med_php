<?php

namespace common\view;
	
//class to represent the Page object used to build webpages
class Page {

	public $title = "";
	public $header = "";
	public $body = "";
	public $footer = "";

	public function __construct($title, $header, $body, $footer) {
		$this->title = $title;
		$this->header = $header;
		$this->body = $body;
		$this->footer = $footer;
	}
}