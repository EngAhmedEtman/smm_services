<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=u783616692_Etman_smm', 'root', '');
    echo "Connected successfully to u783616692_Etman_smm\n";

    $stmt = $pdo->query("SHOW COLUMNS FROM whatsapp_random_texts");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Columns in whatsapp_random_texts:\n";
    foreach ($columns as $col) {
        echo "- " . $col['Field'] . " (" . $col['Type'] . ")\n";
    }
} catch (\Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
