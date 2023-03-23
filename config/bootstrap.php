<?php

/**
 * Set enviroments Variables
 *
 * @param String $dir
 * @return void
 */
function loadEnvironmentVariables(String $dir)
{
  $lines = file($dir . '/.env');
  foreach ($lines as $line) {
    putenv(trim($line));
  }
}
