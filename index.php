<?php

define('DAEMON', 0);
define('WEB', 1);
define('MANIFEST', 'META-INF/MANIFEST.MF');
define('VERSION_MT_NAME', 'Specification-Version');

function get_version_from_manifest($path) {
  $lines = file($path);  

  foreach ($lines as $line) {
    list($k, $v) = explode(':', $line);

    if ($k == VERSION_MT_NAME) {
      return $v;
    }
  }
  
}

// Parse applications
$apps = parse_ini_file("heisenberg.ini", true);

$versions = array();
foreach ($apps as $name => $props) {
  
  $file = '';
  if ($props['type'] == DAEMON) {
    $file = $props['path'] . '/' . MANIFEST;
  } else if ($props['type'] == WEB) {
    $file = $props['path'] . '/classes/' . MANIFEST;
  } else {
    die ('Unable to read heisenberg.ini file');
  }
  $versions[$name] = get_version_from_manifest($file);
}

?>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Heiseinberg</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap-combined.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      h2 {
	font-family: 'Carrois Gothic SC', sans-serif;
      }
    </style>


  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Heisenberg</a>
        </div>
      </div>
    </div>

    <div class="container">
    
      <div class="row">
	<div class="span4"></div>
	<div class="span9">
	  <h2>Java Applications</h2>
	  <table class="table table-bordered table-striped responsive-utilities">
	    <thead>
	      <tr>
		<th>Name</th>
		<th>Version</th>
	      </tr>
	    </thead>
	    <tbody>
	      <? foreach ($versions as $name => $version) { ?>
		<tr class="success">
		  <td><strong><? echo $name; ?></strong></td>
		  <td class="success"><? echo $version; ?></td>
		</tr>
	      <? } ?>
	    </tbody>
	  </table>
            </div>
	</div>
      </div>

    </div> <!-- /container -->

  </body>
</html>
