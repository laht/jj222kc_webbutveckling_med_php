<?php

namespace common\view;

class View {

	public function assemblePage(\common\view\Page $page) {
		$title = $page->title;
		$header = $page->header;
		$body = $page->body;
		$footer = $page->footer;

		$html = 
		"<!DOCTYPE html>
		    <head>
		        <meta charset='utf-8'>
		        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
		        <title>$title</title>
		        <meta name='description' content='>
		        <meta name='viewport' content='width=device-width, initial-scale=1'>
		        <link rel='stylesheet' href='style/reset.css'>
		        <link rel='stylesheet' href='style/style.css'>
		    </head>
		    <body>
		    	<div id='main'>
		    		<div id='header'>
		    			<h1 id='logo'><a href='http://www.laht.eu5.org/'>Bildblogg</a></h1>
		    			<div id='menu'>
		    				$header
		    			</div>
		    		</div>
		    		<div id='content'>
		    			$body
		    		</div>
		    		<div id='footer'>
		    			$footer
		    			© Joakim Jonsson 2014
		    		</div>
		    	</div>
		    </body>
		</html>";

		return $html;
	}
}