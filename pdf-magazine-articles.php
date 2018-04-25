<?php
/*
Plugin Name: PDF Magazine Articles
Description: Add custom post type for PDF Magazine Articles.
Version: 1.0
Author: AHAPX
License: GPL2
*/

require_once("pma_issue.php");
require_once("pma_options.php");
require_once("pma_posts_wp.php");

$issue = new Issue();
$options = new Options();
$posts_wp = new Posts_wp();

?>