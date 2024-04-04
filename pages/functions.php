
<?
function connect(
    $host = "localhost",
    $user = "root",
    $pass = "laant312",
    $dbname = "travels_agency"
) {
    $link = new mysqli($host, $user, $pass, $dbname);
    if ($link->connect_error) {
        die("Ошибка: " . $link->connect_error);
    }
    return $link;
}

function register($login, $pass, $email)
{
    $login = trim(htmlspecialchars($login));
    $pass = trim(htmlspecialchars($pass));
    $email = trim(htmlspecialchars($email));
 
    if ($login == "" || $pass == "" || $email == "") {
        echo "<h3><span style='color: red;'>Заполните все поля!</span></h3>";
        return false;
    }
    if (strlen($login) < 2 || strlen($login) > 30) {
        echo "<h3><span style='color: red;'>Длина логина должна быть от 2 до 30 символов!</span></h3>";
        return false;
    }
    if (strlen($pass) < 5 || strlen($pass) > 30) {
        echo "<h3><span style='color: red;'>Длина пароля должна быть от 5 до 30 символов!</span></h3>";
        return false;
    }
 
    $hashpass= md5($pass);
    $ins = "insert into users(login, pass, email, roleid) values('$login', '$hashpass', '$email', 2)";
    $link = connect();
    $link->query($ins);
    $link->close();
    return true;
}

function login($login, $pass)
{
    $login = trim(htmlspecialchars($login));
    $pass = trim(htmlspecialchars($pass));
 
    if ($login == "" || $pass == "") {
        echo "<h3><span style='color: red;'>Заполните все поля!</span></h3>";
        return false;
    }
    if (strlen($login) < 2 || strlen($login) > 30) {
        echo "<h3><span style='color: red;'>Длина логина должна быть от 2 до 30 символов!</span></h3>";
        return false;
    }
    if (strlen($pass) < 5 || strlen($pass) > 30) {
        echo "<h3><span style='color: red;'>Длина пароля должна быть от 5 до 30 символов!</span></h3>";
        return false;
    }
 
    //хэшированный пароль
    $hash_pass = md5($pass);
 
    $link = connect();
    $sel = "select * from users where login='$login' and pass='$hash_pass'";
    //query возвращает объект, который кроме данных хранит служебную информацию о выполнении запроса(кол-во обработанных строк, нумерацию строк и т.д.)
    //чтобы извлечь данные, необходимо использовать метод fetch_assoc, который возвращает данные в виде ассоциативного масива
    $res = $link->query($sel);
    if ($row = $res->fetch_assoc()) {
        $_SESSION["user"] = $login;
        // echo $row["id"];
        $_SESSION["id"]= $row["id"];
        //если у пользователя роль админа
        if ($row["roleid"] == 1) {
            $_SESSION["admin"] = $login;
        }
        return true;
    } else {
        echo "<h3><span style='color: red;'>Пользователь не найден!</span></h3>";
        return false;
    }
}

function createtablecomments()
{
    $link=connect();
    $resultcomments = $link->query("SHOW TABLES LIKE 'comments'");
                    if ($resultcomments) 
                    {
                        if($resultcomments->num_rows == 1) 
                        {
                            echo "Таблицы имеются в базе данных";
                        } 
                        else
                        {
                            $create = "create table comments( 
                                id int not null auto_increment primary key,
                                comment VARCHAR(65535),
                                hotelid int,
                                foreign key(hotelid) references hotels(id) on delete cascade,
                                userid int,
                                foreign key(userid) references users(id) on delete cascade         
                            )";
                            if ($link->query($create)) {
                                echo "Таблица Comments(комментариев) успешно создана";
                            } 
                            else 
                            {
                                echo "Ошибка: " . $link->error;
                            }
                        }
                    //перезагрузка страницы
                    // echo "<script>window.location=document.URL</script>";
                    }                
}

?>
 