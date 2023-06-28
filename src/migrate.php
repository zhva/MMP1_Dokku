<?php

$host = 'database';
$db = 'hsdeckbuilder_db';
$user = 'postgres';
$password = 'postgres';

$statements = [
    'CREATE TABLE IF NOT EXISTS visits (
        visit timestamp
    )'
];

try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
    // make a database connection
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($pdo) {
        foreach ($statements as $statement) {
            $pdo->exec($statement);
        }
    }
} catch (PDOException $e) {
    die($e->getMessage());
} finally {
    if ($pdo) {
        $pdo = null;
    }
}
?>
