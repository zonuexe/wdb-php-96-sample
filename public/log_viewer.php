<?php

/**
 * @author  USAMI Kenta <tadsan@zonu.me>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WebDB96\Sample;

require_once __DIR__ . '/../inc/bootstrap.php';

$time = filter_input(INPUT_GET, 'time');
$log = get_error_log();
?>
<!DOCTYPE html>
<title>WEB+DB PRESS Vol.96 PHP大規模開発入門 第17回 ログビューア</title>
<link rel="stylesheet" href="/style/sample.css">
<h1>PHP大規模開発入門 第17回 サンプルコード</h1>
<h2>ログビューア</h2>
<?php if ($time === null): ?>
    <table border>
        <tr>
            <th>時間</th>
            <th>メッセージ</th>
        </tr>
        <?php foreach ($log as $row): ?>
            <tr>
                <td><?= h(date('Y-m-d H:i:s', $row['time'])) ?></td>
                <td><a href="?time=<?= h($row['time']) ?>"><?= h($row['message']) ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <?php foreach ($log as $row): ?>
        <?php if ($time === $row['time']): ?>
            <article class="error-log">
                <h3><?= h($row['message']) ?></h3>
                <table>
                    <?php foreach ($row as $key => $value) {
                        print_table($key, $value);
                    } ?>
                </table>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>
    <hr>
    <p><a href="?">ログ一覧に戻る</a></p>
<?php endif; ?>
<?php

function print_table($key, $value) { ?>
    <tr>
    <td><?= h($key) ?></td>
    <td>
        <?php if (is_array($value)): ?>
            <table>
                <?php foreach ($value as $k => $v) {
                    print_table($k, $v);
                } ?>
            </table>
        <?php else: ?>
            <code><?= h($value) ?></code>
        <?php endif; ?>
    </td>
    </tr>
<?php }
