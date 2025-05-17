<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$host = '127.0.0.1';
$db   = 'portfolio_linux_db';
$user = 'portfolio_user';
$port = 3306;
$pass = 'Mugabo@1983';
$charset = 'utf8mb4';

//$dsn = "pgsql:host=$host;dbname=$db"; 
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
	PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$userId = 1;

// Fetch user profile
$stmt = $pdo->prepare("SELECT * FROM user_profile WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    http_response_code(404);
    echo json_encode(['error' => 'User not found']);
    exit;
}

// Fetch contact
$stmt = $pdo->prepare("SELECT email, phone FROM contact WHERE user_id = ?");
$stmt->execute([$userId]);
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch socials
$stmt = $pdo->prepare("SELECT github, linkedin, twitter, dribbble FROM socials WHERE user_id = ?");
$stmt->execute([$userId]);
$socials = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch skills (grouped by category)
$stmt = $pdo->prepare("
    SELECT s.category, si.skill_name
    FROM skills s
    JOIN skills_items si ON s.id = si.skill_id
    WHERE s.user_id = ?
    ORDER BY s.category
");
$stmt->execute([$userId]);
$skillsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

$skills = [];
foreach ($skillsRaw as $row) {
    $skills[$row['category']][] = $row['skill_name'];
}

// Fetch experience
$stmt = $pdo->prepare("
    SELECT role, company, duration, details
    FROM experience
    WHERE user_id = ?
    ORDER BY user_id  ASC
");
$stmt->execute([$userId]);
$experience = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Final JSON structure
$response = [
    'name' => $user['name'],
    'picture' => $user['picture'],
    'title' => $user['title'],
    'about' => $user['about'],
    'location' => $user['location'],
    'availability' => $user['availability'],
    'contact' => $contact,
    'socials' => $socials,
    'skills' => $skills,
    'experience' => $experience
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>
