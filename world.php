<?php
$host = 'localhost:3307'; // Had to specify port due to conflicts with existing databases on my host machine
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['country'])) {
        $country = filter_var($_GET['country'], FILTER_SANITIZE_STRING);
        $lookup = isset($_GET['lookup']) ? filter_var($_GET['lookup'], FILTER_SANITIZE_STRING) : null;

        if ($lookup == 'cities')
            $stmt = $conn->query("SELECT cities.name, cities.district, cities.population FROM cities JOIN countries ON cities.country_code = countries.code WHERE countries.name LIKE '%$country%'");
        else
            $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>


<table>
    <tr>
        <?php if (isset($lookup) && $lookup == 'cities'): ?>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        <?php else : ?>
            <th>Name</th>
            <th>Continent</th>
            <th>Independence</th>
            <th>Head of State</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($results as $row): ?>
        <?php if (isset($lookup) && $lookup == 'cities'): ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['district']; ?></td>
                <td><?= $row['population']; ?></td>
            <tr>
        <?php else : ?>
            <td><?= $row['name']; ?></td>
            <td><?= $row['continent']; ?></td>
            <td><?= $row['independence_year']; ?></td>
            <td><?= $row['head_of_state']; ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
