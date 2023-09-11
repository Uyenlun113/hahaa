<?php
require 'connect.php';
// session_start(); //bat dau session

// if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
//     header('location: login.php');
// }
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['movie_id'];
    $title = $_POST['title'];
    $overview = $_POST['overview'];
    $release_date = $_POST['release_date'];
    $genner_id = $_POST['genner_id'];

    // Process the uploaded file
    $poster = $_FILES['poster'];
    $poster_filename = $poster['name'];
    if ($poster['size'] > 0) {
        $poster_path = "images/" . $poster_filename;
        move_uploaded_file($poster['tmp_name'], $poster_path);
    }

    // Update data in the database
    $sql = "UPDATE movies SET title=?, poster=?, overview=?, release_date=?, genner_id=? WHERE movie_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$title, $poster_filename, $overview, $release_date, $genner_id, $id]);

    // Redirect and display a success message
    setcookie("message", "Cập nhật dữ liệu thành công", time() + 1);
    header("location: index.php");
    die;
}

// If not submitting, fetch data to populate the form
$id = $_GET['movie_id']; // Assuming you pass the movie ID via query parameter
$movie = $conn->query("SELECT * FROM movies WHERE movie_id = $id")->fetch();
$genner = $conn->query("SELECT * FROM genners")->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chỉnh sửa phim</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">
        Tiêu đề: <input type="text" name="title" value="<?= $movie['title'] ?>">
        <br><br>
        Áp phích: <input type="file" name="poster">
        <br>
        <img src="./image/<?= $movie['poster'] ?>" width="110">
        <br><br>
        Tổng quan:
        <textarea name="overview" cols="100" rows="10"><?= $movie['overview'] ?></textarea>
        <br><br>
        Ngày phát hành: <input type="date" name="release_date" value="<?= $movie['release_date'] ?>">
        <br><br>
        Thể loại:
        <select name="genner_id">
            <?php foreach ($genner as $gen): ?>
                <option value="<?= $gen['genner_id'] ?>" <?= ($gen['genner_id'] == $movie['genner_id']) ? 'selected' : '' ?>>
                    <?= $gen['genner_name'] ?>
                </option>
            <?php endforeach ?>
        </select>
        <br><br>
        <button type="submit">Cập nhật</button>
        <a href="index.php">Danh sách</a>
    </form>
</body>

</html>