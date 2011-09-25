<?php
/**
 * Turbine CSS loader adapted for Creamy
 */
include('../tools/turbine/config.php');
//enable cache and compression
$config['debug_level'] = 0;
//set application cache
$config['cache_dir']= '../application/cache/turbine';
include('../tools/turbine/css.php');
