#!/usr/bin/env php
<?php

#
# to avoid adding a static default system.php to your vcs, (you should not)
# you can use this script to create the config file dynamically
# and integrate it into you deployment workflow or installation scripts.
#
# the script takes three optional arguments:
#
# username - the database user
# password - the database users password
# dbname   - the name of the database
#
# example: ./create-default-config.php --username=foo --password=bar dbname=baz
#
# since the arguments are optional, for non provided options an empty string is used
#
# the script has a dependency to 'pimcore/config/startup_cli.php' and therefore autoloader,
# so you have to make sure to call 'composer install' first, otherwise the script won't work.
#
# if you like, you can extend the $arrConfig array and/or its api, to set more options
#

namespace faustregel;

require_once __DIR__ . '/pimcore/config/startup_cli.php';

use Pimcore\Install\SystemConfig\ConfigWriter;

$arrCliArguments = \getopt('', [ 'username::', 'password::', 'dbname::' ]);

$strDatabaseUser     = \array_key_exists('username', $arrCliArguments) ? $arrCliArguments['username'] : '';
$strDatabasePassword = \array_key_exists('password', $arrCliArguments) ? $arrCliArguments['password'] : '';
$strDatabaseName     = \array_key_exists('dbname',   $arrCliArguments) ? $arrCliArguments['dbname']   : '';

$arrConfig = [

  'database' => [
    'params' => [
      'username' => $strDatabaseUser,
      'password' => $strDatabasePassword,
      'dbname'   => $strDatabaseName
    ]
  ]

];

$objConfigWriter = new ConfigWriter();
$objConfigWriter->writeSystemConfig($arrConfig);
