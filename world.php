<?php
$host = 'localhost:3307'; // Had to specify port due to conflicts with existing databases on my host machine
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['country'])) {
        $country = filter_var($_GET['country'], FILTER_SANITIZE_STRING);
        $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<ul>
    <?php foreach ($results as $row): ?>
        <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
    <?php endforeach; ?>
</ul>
