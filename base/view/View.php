<?php
namespace base\view;

class View {
	public function renderBaseHml() {
		echo '<!DOCTYPE html>
		    <head>
		        <meta charset="utf-8">
		        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		        <title>Bildblogg</title>
		        <meta name="description" content="">
		        <meta name="viewport" content="width=device-width, initial-scale=1">
		        <link rel="stylesheet" href="style/reset.css">
		        <link rel="stylesheet" href="style/style.css">
		    </head>
		    <body>
		    	<div id="main">
		    		<div id="header">
		    			<div id="logo">
		    				Bildblogg
		    			</div>		    			
		    		</div>
		    		<div id="content">
		    		content
		    		</div>
		    		<div id="footer">
		    		footer
		    		</div>
		    	</div>
		    </body>
		</html>';
	}
}