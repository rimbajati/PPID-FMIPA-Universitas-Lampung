<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto Setup Database Iterasi 2 & Pembersihan Iterasi 1 (Hanya jalan 1 kali)
$lockFile = __DIR__.'/../storage/framework/cache/iterasi2_db_setup.lock';
if (!file_exists($lockFile)) {
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;port=3306", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]);
        if ($pdo) {
            // 1. Buat database ppid_fmipa_unila_v2 jika belum ada
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `ppid_fmipa_unila_v2` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            
            // 2. Salin seluruh struktur & data dari ppid_fmipa_unila ke ppid_fmipa_unila_v2
            $tablesStmt = $pdo->query("SHOW TABLES FROM `ppid_fmipa_unila`");
            if ($tablesStmt) {
                while ($row = $tablesStmt->fetch(PDO::FETCH_NUM)) {
                    $tbl = $row[0];
                    $pdo->exec("CREATE TABLE IF NOT EXISTS `ppid_fmipa_unila_v2`.`{$tbl}` LIKE `ppid_fmipa_unila`.`{$tbl}`");
                    $chk = $pdo->query("SELECT COUNT(*) FROM `ppid_fmipa_unila_v2`.`{$tbl}`");
                    if ($chk && (int)$chk->fetchColumn() === 0) {
                        $pdo->exec("INSERT INTO `ppid_fmipa_unila_v2`.`{$tbl}` SELECT * FROM `ppid_fmipa_unila`.`{$tbl}`");
                    }
                }
            }

            // 3. Bersihkan tabel informasi_dikecualikans dari database ppid_fmipa_unila (Iterasi 1)
            $pdo->exec("DROP TABLE IF EXISTS `ppid_fmipa_unila`.`informasi_dikecualikans`");
            $pdo->exec("DELETE FROM `ppid_fmipa_unila`.`migrations` WHERE `migration` LIKE '%informasi_dikecualikans%'");

            // Kunci agar tidak berjalan berulang
            @touch($lockFile);
        }
    } catch (\Throwable $e) {}
}

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
