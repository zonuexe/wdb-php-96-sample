<?php

namespace WebDB96\Sample;

require_once __DIR__ . '/../inc/bootstrap.php';

$greeting = get_greeting(new \DateTimeImmutable());

?>
<!DOCTYPE html>
<title>WEB+DB PRESS Vol.96 PHP大規模開発入門 第17回 サンプルコード - PsySHデバッグ</title>
<link rel="stylesheet" href="/style/sample.css">
<h1>PHP大規模開発入門 第17回 サンプルコード</h1>
<h2>PsySHを使ったデバッグ</h2>
<section class="greeting">
    <p><var><?= htmlspecialchars($greeting) ?></var></p>
</section>
<hr>
<?php if (PHP_SAPI === 'cli-server'): ?>
    <p><code class="file">inc/functions.php</code>の<code>eval(\Psy\sh());</code>のコメントを外すとデバッグ実行ができます。変数を確認できるほか、書き換えることも可能です。</p>
    <p>たとえば、<code>$greeting = "さよなら";</code>と打ち込んでみてください。気が済んだら<code>die()</code>と入力してください。</p>
<?php endif; ?>
