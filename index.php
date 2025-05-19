<?php
$pdo = new PDO('mysql:host=db;dbname=demo','root','secret');
$rows = $pdo->query('SELECT * FROM people');
echo "<h1>Demo Docker</h1><ul>";
foreach ($rows as $r) echo "<li>{$r['name']}</li>";
echo "</ul>";
?>