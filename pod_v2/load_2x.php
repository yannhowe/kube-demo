<?php
  //place this before any script you want to calculate time
  $time_start = microtime(true);

  date_default_timezone_set('America/Los_Angeles');
  $x = 0.0001;
  for ($i = 0; $i <= 1000000; $i++) {
    $x += sqrt($x);
  }
  date_default_timezone_set('America/Los_Angeles');
  $x = 0.0001;
  for ($i = 0; $i <= 1000000; $i++) {
    $x += sqrt($x);
  }

  // Display Script End time
  $time_end = microtime(true);

  //dividing with 60 will give the execution time in minutes other wise seconds
  $execution_time = number_format((float)($time_end - $time_start), 2, '.', '');
  echo "v2 - calculated sqrt in $execution_time seconds";
?>