<?php
include("conn.php");
session_start();

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>TodoList</title>
</head>

<body>

    <div class="container">
        <div class="header">
            <h3>TODOLIST</h3>
            <div class="nav" id="nav">
                <?php $check = query("SELECT * FROM table_task WHERE status = 1") ?>
                <?php if (count($check) > 0) { ?>
                    <div class="notif" id="notif"></div>
                <?php } ?>
                <ion-icon name="grid-outline" class="nav-btn" id="btn-nav"></ion-icon>
            </div>
        </div>
        <form action="task.php" method="POST">
            <div class="wrapper">
                <input type="text" name="task" id="task">
                <button type="submit" class="btn-add" name="add">
                    <ion-icon name="add-outline" class="icon-add"></ion-icon>
                </button>
            </div>
        </form>
        <?php if (isset($_SESSION['failed'])) : ?>
            <p style="text-align: center; color: red"><?= $_SESSION['failed'] ?></p>
        <?php
            session_destroy();
        endif; ?>



        <div class="flex">
            <div class="listContainer">
                <?php $rows = query("SELECT * FROM table_task WHERE status = 0 ORDER BY id_task DESC"); ?>
                <?php if (count($rows) == 0) : ?>
                    <p style="text-align: center;">Tugas kosong</p>
                <?php else : ?>
                    <!-- while -->
                    <?php foreach ($rows as $task) : ?>
                        <!-- ListTask -->
                        <div class="listTask">
                            <div class="task"><?= $task['task'] ?></div>
                            <!-- ACTION -->
                            <form action="task.php" method="POST" class="action">
                                <button type="submit" class="btn-delete" name="delete"><ion-icon name="trash-outline" class="icon-delete"></ion-icon></button>
                                <button type="submit" name="succeed" class="btn-succeed"><ion-icon name="checkmark-outline"></ion-icon></button>
                                <input type="hidden" name="id" value="<?= $task['id_task'] ?>">
                                <input type="hidden" name="status" value="<?= $task['status'] ?>">
                            </form>
                            <!-- ACTION -->
                        </div>
                        <!-- ListTask -->
                <?php endforeach;
                endif; ?>
                <!-- end while -->
            </div>
        </div>
    </div>

    <!-- Side Component -->
    <div class="sideContainer" id="navSide">
        <div class="sideHeader">
            <div class="text">
                <h2>Tugas Selesai</h2>
                <form action="task.php" method="post">
                    <button type="submit" class="btn" name="deleteAll">Hapus Semua</button>
                </form>
            </div>
            <div class="btn-close" id="close">
                <ion-icon name="close-outline"></ion-icon>
            </div>
        </div>
        <div class="side">
            <?php $rows = query("SELECT * FROM table_task WHERE status = 1 ORDER BY id_task") ?>
            <?php foreach ($rows as $task) : ?>
                <!-- SideListTask -->
                <div class="listTask sideList">
                    <div class="task" style="color: white; text-decoration: line-through;"><?= $task['task'] ?></div>
                    <!-- ACTION -->
                    <form action="task.php" method="POST" class="action">
                        <button type="submit" class="btn-delete" name="delete">
                            <ion-icon style="color:salmon;" name="trash-outline" class="icon-delete"></ion-icon>
                        </button>
                        <input type="hidden" name="id" value="<?= $task['id_task'] ?>">
                        <input type="hidden" name="status" value="<?= $task['status'] ?>">
                    </form>
                    <!-- ACTION -->
                </div>
                <!-- SideListTask -->
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Side Component -->

    <footer class="footer">
        <p>Copyright &copy; 2023 rhn.kz</p>
    </footer>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        const btnNav = document.getElementById('btn-nav');
        const navSide = document.getElementById('navSide');
        const nav = document.getElementById('nav');
        const close = document.getElementById('close')
        let notif = document.getElementById('notif')

        // close.style.display = 'none';
        btnNav.addEventListener('click', () => {
            navSide.classList.toggle('show');
            btnNav.style.display = 'none';
            if (notif.style.display != 'none') {
                notif.style.display = 'none';
            }
            close.style.display = 'block';
        });

        close.addEventListener('click', () => {
            navSide.classList.toggle('show');
            btnNav.style.display = 'block';
            notif.style.display = 'block';
            close.style.display = 'none';
        });
    </script>


</body>

</html>