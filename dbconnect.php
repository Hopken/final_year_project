<?php
// Database connection using environment variables to avoid hard-coded credentials.
// Set DB_HOST, DB_NAME, DB_USER and DB_PASS in your environment or in a local .env file
// (don't commit .env to git). A sample is provided in .env.example.

$host = getenv('DB_HOST') ?: 'localhost';
$db   = getenv('DB_NAME') ?: 'demo';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

try {
	$conn = new PDO("mysql:host={$host};dbname={$db}", $user, $pass, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]);
} catch (PDOException $e) {
	// In production, avoid echoing raw errors. Log them instead.
	echo "Cannot connect to the database: " . htmlspecialchars($e->getMessage());
	exit;
}