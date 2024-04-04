<h1> Страница добавления комментариев для отелей! </h1>
<?
include_once("functions.php");
$link = connect();
$userid;

/////////////////////////////////////////////////////////////////// получение id user 
$login=(isset($_SESSION["admin"])) ? $_SESSION["admin"] : $_SESSION["user"];
$seluserid="select * from users where login=$login";
$resuserid = $link->query($seluserid);
foreach ($resuserid as $row) 
{
    $userid=$row["id"];
}
////////////////////////////////////////////////////////////////////////////////////////////

if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
    echo "<h3><span style='color: red;'>Комментарии доступны только для зарегистрированных пользователей, пожалуйста авторизуйтесь!</span></h3>";
    exit();
}



echo "<form action='index.php?page=2' method='post' class='form-group'>";
    // выбор страны
    echo "<select class='form-select col-sm-4 col-md-4 col-lg-4' name='countryid'>";
            $rescounties = $link->query("select * from countries order by country");
            foreach ($rescounties as $row) 
            {
                echo "<option value='" . $row["id"] . "'>" . $row["country"] . "</option>";
            }
    echo "</select>";
    // кнопка выбора страны
    echo "<input type='submit' name='selcountry' class='btn btn-outline-primary my-2' value='Выбрать страну'/>";
    if (isset($_POST["selcountry"])) 
    {
        $countryid = $_POST["countryid"];
        if ($countryid != 0) 
        {            
            $rescities = $link->query("select * from cities where countryid=$countryid order by city");
            // выбор страны
            echo "<select class='form-select col-sm-4 col-md-4 col-lg-4' name='cityid'>";
                foreach ($rescities as $row) 
                {
                    echo "<option value='" . $row["id"] . "'>" . $row["city"] . "</option>";
                }
            echo "</select>";
            echo "<input type='submit' name='selcity' class='btn btn-outline-primary my-2' value='Выбрать город'/>";
        }
    }
    if (isset($_POST["selcity"])) 
    {   
        $cityid = $_POST["cityid"];
        if ($cityid != 0) 
        { 
             //echo "11111111111111111111111111111";
            $sel = "select * from hotels where cityid=$cityid
                    order by hotel";
            $reshotels = $link->query($sel);
                echo "<select class='form-select col-sm-4 col-md-4 col-lg-4' name='hotelid'>";
                    foreach ($reshotels as $row) 
                    {
                        echo "<option value='" . $row["id"] . "'>" . $row["hotel"] . "</option>";
                        //$hotelname=$row["hotel"];
                    }
                    
                echo "</select>";
                echo "<input type='submit' name='selhotel' class='btn btn-outline-primary my-2' value='Выбрать отель'/>";
                //echo "22222222222222222222222222";
               
        }   
    }
echo "</form>";

        if (isset($_POST["selhotel"])) 
        {      
            $hotelname;    
            $hotelid = $_POST["hotelid"];
            $sel = "select * from hotels where id=$hotelid;";
            $res = $link->query($sel);
            foreach ($res as $row) 
            {
                $hotelname=$row["hotel"];
            }


            if ($hotelid != 0) 
            {              
                
                echo " Вы выбрали отель - " . $hotelname . " ' для добавления комментария!";
                //if (!isset($_POST["addcomment"])) 
                //{  
                    echo "<form action='index.php?page=2' method='post' id='formcomment'>";
                        echo "<div class='form-group mt-2'>
                                    <textarea name='comment' placeholder='Введите комментарий для отеля' rows='7' class='form-control'></textarea>
                                </div>";
                        echo "<input type='submit' name='addcomment' class='btn btn-outline-primary mt-2' value='Сохранить комментарий'  />";
                        echo "<input type='submit' name='add' class='btn btn-outline-primary mt-2' value='Сохранить'  />";
                    echo "</form>"; 
                /*}
                
                else
                {*/
                    echo "22222222222222222222222222";
                    if (isset($_POST["add"])) 
                    {
                        
                        echo "333";
                        createtablecomments();    
                        $comment = trim(htmlspecialchars($_POST["comment"]));
                        $s= $_POST["comment"];
                        echo $s;
                        echo $comment;                 
                        if ($comment == null) exit();
                            
                            //$cityid = $_POST["hotelcity"];
                            //////////////////////////////////////////////////////////////////проверка есть таблица комментариев или нет
                            
                        $insertcomment = "insert into comments(comment, hotelid, userid) values('$comment','$hotelid', '$userid')";
                        $link->query($insertcomment);
                        echo "данные добавлены";
                            //перезагрузка страницы
                        // echo "<script>window.location=document.URL</script>";
                    }
                    //else{
                     //   echo "yt зашел "; 
                   // }
                } 
            }
              
           
                
                
            //}
                
        //}
                        
        


        
        

    

    ?>