<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=mvc', 'root', 'xxx');
} catch (PDOException $e) {
    echo $e->getMessage();
}

$sql = "insert into posts(title, content) values(:title,:content)";
$stmt = $db->prepare($sql);
$title = "Article 1";
$content = "That's nice.";
$stmt->bindParam(':title', $title);
$stmt->bindParam(':content', $content);
$stmt->execute();
