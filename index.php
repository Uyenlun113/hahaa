<?php
//phần session
// session_start(); //bat dau session

// if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
//     header('location: login.php');
// }

require 'connect.php';
//phần cookie
if (!isset($_COOKIE['username'])) {
    header("location: login.php");
    die;
}
//câu lệnh sql
$movies = $conn->query("SELECT movie_id, title, poster, overview, release_date, genner_name FROM movies as m JOIN genners as g ON m.genner_id=g.genner_id")->fetchAll();
//chuẩn bị

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
    <?php if (isset($_COOKIE['username'])): ?>
        WELCOME <b>
            <?= $_COOKIE['username'] ?>
        </b>
    <?php endif ?> <br> <br>
    <button> <a href="./add.php">Thêm dữ liệu</a></button>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Poster</th>
            <th>Overview</th>
            <th>Release date</th>
            <th>Genner name</th>
            <th>Action</th>
        </tr>
        <?php foreach ($movies as $m): ?>
            <tr>
                <td>
                    <?= $m['movie_id'] ?>
                </td>
                <td>
                    <?= $m['title'] ?>
                </td>
                <td>
                    <img src="./image/<?= $m['poster'] ?>" width="100" alt="">
                </td>
                <td>
                    <?= $m['overview'] ?>
                </td>
                <td>
                    <?= $m['release_date'] ?>
                </td>
                <td>
                    <?= $m['genner_name'] ?>
                </td>
                <td>
                    <a href="edit.php?movie_id=<?= $m['movie_id'] ?>">Sửa</a>
                    <a onclick="return confirm('Bạn có muốn xóa không?')"
                        href="delete.php?movie_id=<?= $m['movie_id'] ?>">Xóa</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</body>

</html>