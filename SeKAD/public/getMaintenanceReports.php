<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=maintenance", "root", "");

    $query = $pdo->prepare("
        SELECT id, name, date_of_reporting, date_of_repair_completion, picture, description
        FROM maintenance_reports
        ORDER BY created_at DESC
        LIMIT 2
    ");
    $query->execute();

    $reports = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($reports);
} catch (Exception $e) {
    echo json_encode(['error' => 'Unable to fetch reports: ' . $e->getMessage()]);
}
