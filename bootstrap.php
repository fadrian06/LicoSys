<?php

declare(strict_types=1);

use Leaf\BareUI;
use Symfony\Component\Dotenv\Dotenv;

const BASE_DIR = __DIR__;

(new Dotenv)->load(BASE_DIR . '/.env.dist', BASE_DIR . '/.env');
BareUI::config('path', BASE_DIR . '/views');
