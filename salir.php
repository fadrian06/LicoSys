<?php

declare(strict_types=1);

use Leaf\Http\Session;

require_once __DIR__ . '/vendor/autoload.php';

Session::destroy();

header('location: ./');
