<?
if (!isset($_SESSION["admin"])) {
    echo "<h3><span style='color: red;'>Вход только для администраторов!</span></h3>";
    exit();
}
?>

<div class="row">
    <div class="col-sm-12 col-md-6 col-lg-6 left">
        <!-- секция для стран ---------------------------------------------------------------------------------------------------------->
        <?
            $link = connect();
            // получаем все страны с id 
            $sel = "select * from countries order by id";
            $res = $link->query($sel);
            // делаем форму для стран
            echo "<form action='index.php?page=4' method='post' class='input-group' id='formcountry'>";
                //создаем внутри формы таблицу 
                echo "<table class='table table-striped table-hover text-center align-middle my-3'>";
                    // создаем заголовок таблицы(голову)
                    echo "<thead class='table-info'>
                            <th>ID</th>
                            <th>Страна</th>
                            <th></th>
                        </thead>";
                    // затем каждую полученную строку раскидываем по столбцам
                    foreach ($res as $row) 
                    {
                        echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["country"] . "</td>";
                            echo "<td>
                                    <input type='checkbox' class='form-check-input' name='cb" . $row["id"] . "' />
                                </td>";
                        echo "</tr>";
                    }
                echo "</table>";
                echo "<input type='text' class='form-control mt-2' name='country' placeholder='Введите название страны' />";
                echo "<input type='submit' class='btn btn-outline-primary mt-2' value='Сохранить' name='addcountry' />";
                echo "<input type='submit' class='btn btn-outline-danger mt-2' value='Удалить' name='delcountry' />";
            echo "</form>";
            // обработчик кнопки добавления страны
            if (isset($_POST["addcountry"])) 
            {
                $country = trim(htmlspecialchars($_POST["country"]));
                if ($country == null) exit();
                $ins = "insert into countries(country) values('$country')";
                $link->query($ins);
                //перезагрузка страницы
                echo "<script>window.location=document.URL</script>";
            }
            // обработчик кнопки удаления страны
            if (isset($_POST["delcountry"])) {
                foreach ($_POST as $key => $value) {
                    //проверяем, содержится ли в строке ключи, начинающиеся с "cb"
                    if (substr($key, 0, 2) == "cb") {
                        //получаем из ключа значение id страны
                        $id = substr($key, 2);
                        $del = "delete from countries where id=$id";
                        $link->query($del);
                    }
                }
                //перезагрузка страницы
                echo "<script>window.location=document.URL</script>";
            }
        ?>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6 right">
        <!-- секция для городов ---------------------------------------------------------------------------------------------------------->
        <?
            $link = connect();
            $sel = "select ci.id as id, ci.city as сity, co.country as country from countries co, cities ci where ci.countryid=co.id order by ci.id";
            $res = $link->query($sel);
            // делаем форму для стран
            echo "<form action='index.php?page=4' method='post' class='input-group' id='formcity'>";
                //создаем внутри формы таблицу 
                echo "<table class='table table-striped table-hover text-center align-middle my-3'>";
                // создаем заголовок таблицы(голову)
                    echo "<thead class='table-warning'>
                            <th>ID</th>
                            <th>Город</th>
                            <th>Страна</th>
                            <th></th>
                        </thead>";
                    foreach ($res as $row) 
                    {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["сity"] . "</td>";
                        echo "<td>" . $row["country"] . "</td>";
                        echo "<td><input type='checkbox' class='form-check-input' name='ci" . $row["id"] . "' /></td>";
                        echo "</tr>";
                    }
                echo "</table>";
                $res = $link->query("select * from countries");
                echo "<select class='form-select mt-2' name='countryname'>";
                    foreach ($res as $row) 
                    {
                        echo "<option value='" . $row["id"] . "'>" . $row["country"] . "</option>";
                    }
                echo "</select>";
                echo "<input type='text' class='form-control mt-2' name='namecity' placeholder='Введите название города' /> ";
                echo "<input type='submit' class='btn btn-outline-primary mt-2' value='Сохранить' name='addcity' />";
                echo "<input type='submit' class='btn btn-outline-danger mt-2' value='Удалить' name='delcity' />";
            echo "</form>";
            // обработчик нажатия кнопки добавления города
            if (isset($_POST["addcity"])) 
            {
                $city = trim(htmlspecialchars($_POST["namecity"]));
                if ($city == null) exit();
                $countryid = $_POST["countryname"];
                $ins = "insert into cities(city, countryid) values('$city', '$countryid')";
                $link->query($ins);
                //перезагрузка страницы
                echo "<script>window.location=document.URL</script>";
            }
            // обработчик нажатия кнопки удаления города
            if (isset($_POST["delcity"])) 
            {
                foreach ($_POST as $key => $value) 
                {
                    //проверяем, содержится ли в строке ключи, начинающиеся с "ci"
                    if (substr($key, 0, 2) == "ci") {
                        //получаем из ключа значение id города
                        $idcity = substr($key, 2);
                        $del = "delete from cities where id=$idcity";
                        $link->query($del);
                    }
                }
                //перезагрузка страницы
                echo "<script>window.location=document.URL</script>";
            }
        ?>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 mt-5">
        <!-- секция для отелей ---------------------------------------------------------------------------------------------------------->
        <?
            $link = connect();
            $sel = "select ci.id, ci.city as сity, ci.countryid, ho.id as hotelid, ho.hotel, ho.cityid, ho.cost, ho.rate, ho.stars, ho.info, co.id, co.country from countries co, cities ci, hotels ho where ci.countryid=co.id and ho.cityid=ci.id order by hotelid";
            $res = $link->query($sel);
            echo "<form action='index.php?page=4' method='post' id='formhotel'>";
                echo "<table class='table table-striped table-hover text-center align-middle my-3'>";
                    echo "<thead class='table-danger'><th>ID</th><th>Отель</th><th>Город</th><th>Страна</th><th>Звезды</th><th>Рейтинг</th><th>Цена</th><th>Описание</th><th></th></thead>";
                    foreach ($res as $row) 
                    {
                        echo "<tr>";
                        echo "<td>" . $row["hotelid"] . "</td>";
                        echo "<td>" . $row["hotel"] . "</td>";
                        echo "<td>" . $row["сity"] . "</td>";
                        echo "<td>" . $row["country"] . "</td>";
                        echo "<td>" . $row["stars"] . "</td>";
                        echo "<td>" . $row["rate"] . "</td>";
                        echo "<td>" . $row["cost"] . "</td>";
                        echo "<td>" . $row["info"] . "</td>";
                        echo "<td><input type='checkbox' class='form-check-input' name='ht" . $row["id"] . "' /></td>";
                        echo "</tr>";
                    }
                echo "</table>";
                $res = $link->query("select ci.id as cityid, ci.city, co.id as countryid, co.country from countries co, cities ci where co.id=ci.countryid");
                echo "<div class='form-group d-flex'>
                        <select class='form-select mt-2 w-50' name='hotelcity'>";
                            foreach ($res as $row) 
                            {
                                echo "<option value='" . $row["cityid"] . "'>" . $row["city"] . ", " . $row["country"] . "</option>";
                            }
                        echo "</select>";
                        echo "<input type='text' class='form-control w-50 mt-2' name='hotelname' placeholder='Введите название отеля' />
                    </div>";
                    echo "<div class='form-group mt-2'><label class='form-label'>Цена в рублях: </label>";
                    echo "<input type='number' class='form-control' name='hotelcost' min='0' /></div>";
                    echo "<div class='form-group mt-2'><label class='form-label'>Звезды от 0 до 5: </label>";
                    echo "<input type='number' class='form-control' name='hotelstars' min='0' max='5' /></div>";
                    echo "<div class='form-group mt-2'><label class='form-label'>Рейтинг от 0 до 10: </label>";
                    echo "<input type='number' class='form-control' name='hotelrate' min='0' max='10' /></div>";
                    echo "<div class='form-group mt-2'><textarea name='hotelinfo' placeholder='Введите описание отеля' rows='3' class='form-control'></textarea></div>";
                    echo "<input type='submit' class='btn btn-outline-primary mt-2' value='Сохранить' name='addhotel' />";
                    echo "<input type='submit' class='btn btn-outline-danger mt-2' value='Удалить' name='delhotel' />";
            echo "</form>";
            // обработчик кнопки добавления отеля
            if (isset($_POST["addhotel"])) 
            {
                $hotel = trim(htmlspecialchars($_POST["hotelname"]));
                $cost = floatval(trim(htmlspecialchars($_POST["hotelcost"])));
                $stars = intval(trim(htmlspecialchars($_POST["hotelstars"])));
                $rate = intval(trim(htmlspecialchars($_POST["hotelrate"])));
                $info = trim(htmlspecialchars($_POST["hotelinfo"]));
                if ($hotel == null || $cost == null || $stars == null || $rate == null || $info == null) exit();
                $cityid = $_POST["hotelcity"];
                $ins = "insert into hotels(hotel, cityid, stars, cost, rate, info) values('$hotel','$cityid', '$stars', '$cost', '$rate', '$info')";
                $link->query($ins);
                //перезагрузка страницы
                echo "<script>window.location=document.URL</script>";
            }
            // обработчик кнопки удаления отеля
            if (isset($_POST["delhotel"])) 
            {
                foreach ($_POST as $key => $value) 
                {
                    //проверяем, содержится ли в строке ключи, начинающиеся с "ht"
                    if (substr($key, 0, 2) == "ht") 
                    {
                        //получаем из ключа значение id отеля
                        $idhotel = substr($key, 2);
                        $del = "delete from hotels where id=$idhotel";
                        $link->query($del);
                    }
                }
                //перезагрузка страницы
                echo "<script>window.location=document.URL</script>";
            }
        ?>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 mt-5">
        <!-- секция для загрузки фото отелей ---------------------------------------------------------------------------------------------------------->
        <?
            $link = connect();
            echo "<form action='index.php?page=4' method='post' id='formimages' enctype='multipart/form-data'>";
                $res = $link->query("select ci.id as cityid, ci.city, co.id as countryid, co.country, ho.id as hotelid, ho.hotel from countries co, cities ci, hotels ho where co.id=ci.countryid and ho.cityid=ci.id");
                echo "<select class='form-select mt-2' name='hotelcitycountry'>";
                    foreach ($res as $row) 
                    {
                        echo "<option value='" . $row["hotelid"] . "'>" . $row["hotel"] . ", " . $row["city"] . ", " . $row["country"] . "</option>";
                    }
                echo "</select>";
                echo "<input type='file' class='form-control mt-2' name='file[]' multiple accept='image/*' />";
                echo "<input type='submit' class='btn btn-outline-primary mt-2' value='Сохранить' name='addimage' />";
            echo "</form>";
            if (isset($_REQUEST["addimage"])) 
            {
                foreach ($_FILES["file"]["name"] as $key => $value) 
                {
                    if ($_FILES["file"]["error"][$key] != 0) 
                    {
                        echo "<script>alert('Ошибка загрузки файлов: $value.')</script>";
                        continue;
                    }
                    if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], "images/$value")) 
                    {
                        $ins = "insert into images(hotelid, imagepath) values('" . $_REQUEST["hotelcitycountry"] . "', 'images/$value')";
                        $link->query($ins);
                    }
                }
            }
        ?>
    </div>
</div>