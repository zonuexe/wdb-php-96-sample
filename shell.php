#!/usr/bin/env php
<?php

// ↓名前空間を利用するプロジェクトでは記述しておく
namespace WebDB96\Sample;

use Psy\Readline\GNUReadline;
use Psy\Readline\Libedit;
use zonuexe\Psy\Readline\HoaConsoleAdapter;

require __DIR__ . '/inc/bootstrap.php';

$sh = new \Psy\Shell();

// 起動直後にプロジェクトのnamespaceを設定する
// 名前空間を利用しないプロジェクトでは↓の行は不要
$sh->addCode(sprintf('namespace %s;', __NAMESPACE__));

$sh->run();

echo PHP_EOL, '◆WDB◆', PHP_EOL;
