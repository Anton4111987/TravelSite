<?
//если есть активный пользователь - выводим приветствие и кнопку выхода
if (isset($_SESSION["user"])) {
    echo "<form action='index.php";
    if (isset($_GET["page"])) echo "?page=" . $_GET['page'] . "'";
    echo " method='post' class='my-4'>";
 
    echo "<div class='d-flex justify-content-between w-25 ms-auto'>";
    echo "<h4 class='fw-bold '>Привет, <span>" . $_SESSION["user"] . "</span>!</h4>";
    echo "<input type='submit' value='Выйти' id='exit' name='exit' class='btn btn-danger' />";
    echo "</div></form>";
 
    //если нажата кнопка Выйти
    if (isset($_POST["exit"])) {
        //сбрасываем пользователя в сессии
        unset($_SESSION["user"]);
        unset($_SESSION["admin"]);
        echo "<script>window.location.reload()</script>"; //перезагрузка страницы
    }
} else {
    if (isset($_POST["enter"])) {
        if (login($_POST["login"], $_POST["pass"])) {
            echo "<script>window.location.reload()</script>"; //перезагрузка страницы
        }
    } else {
        echo "<form action='index.php";
        if (isset($_GET["page"])) echo "?page=" . $_GET['page'] . "'";
        echo " method='post' class='my-4'>";
 
        echo "<div class='d-flex justify-content-between w-50 ms-auto'>";
        echo "<input type='text' name='login' class='form-control' placeholder='Логин'/>";
        echo "<input type='password' name='pass' class='form-control' placeholder='Пароль'/>";
        echo "<input type='submit' value='Войти' name='enter' class='btn btn-outline-primary'/>";
        echo "</div></form>";
    }

}
 
?>
 
