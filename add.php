<?php
require 'connect.php';
$genners = $conn->query("SELECT * FROM genners")->fetchAll();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $overview = $_POST['overview'];
    $release_date = $_POST['release_date'];
    $genner_id = $_POST['genner_id'];

    $file = $_FILES['poster'];
    $poster = $file['name'];
    //upload file
    move_uploaded_file($file['tmp_name'], "image/" . $poster);

    //thêm dữ liệu
    $sql = "INSERT INTO movies(title, poster, overview, release_date, genner_id) VALUES('$title', '$poster', '$overview', '$release_date', '$genner_id')";
    $conn->exec($sql);
    setcookie("message", "Thêm dữ liệu thành công", time() + 1);
    header("location: index.php");
    die;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="" rel="stylesheet" />
    <title></title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        Tiêu đề: <input type="text" name="title" id="">
        <br><br>
        Áp phích: <input type="file" name="poster" id="">
        <br><br>
        Tổng quản:
        <textarea name="overview" id="" cols="100" rows="10"></textarea>
        <br><br>
        Ngày phát hành: <input type="date" name="release_date" id="">
        <br><br>
        Thể loại:
        <select name="genner_id" id="">
            <?php foreach ($genners as $gen) { ?>
                <option value="<?= $gen['genner_id'] ?>"> <?= $gen['genner_name'] ?></option>
            <?php } ?>
        </select>
        <br><br>
        <button type="submit">Thêm</button>
        <a href="index.php">Danh sách</a>
    </form>
</body>

</html>