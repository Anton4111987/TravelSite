<?
    include_once("functions.php");
    $link = connect();
    $id=$_GET["id"];
    $selhotel = "select * from hotels where id=$id";
    $reshotel = $link->query($selhotel);
    $rowhotel;
    foreach ($reshotel as $row) 
    {
        $rowhotel=$row["hotel"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <br/>
    <h1 style='text-align:center;'> Отель "<? echo $rowhotel?>" </h1>
    <br/>
    <table class='table table-striped table-hover text-center align-middle my-3'>
    <thead class='table-danger'>
        <th>Отель</th>
        <th>Город</th>
        <th>Страна</th>
        <th>Звезды</th>
        <th>Рейтинг</th>
        <th>Цена</th>
        <th>Описание</th>
    </thead>
    <?

            
        
            foreach ($reshotel as $row) 
            {
                echo "<tr>";
                    echo "<td>
                            <a> " . $row["hotel"] . "</a>
                        </td>";
                    $cityid=$row["cityid"];
                    $selcity = "select * from cities where id=$cityid";
                    $rescity = $link->query($selcity);
                    $countryid;
                    foreach($rescity as $r)
                    {
                        echo "<td>" . $r["city"] . "</td>"; 
                        $countryid=$r["countryid"];
                    }                    
                    $selcountry = "select * from countries where id=$countryid";
                    $rescountry = $link->query($selcountry);
                    foreach($rescountry as $co)
                    {
                        echo "<td>" . $co["country"] . "</td>"; 
                    }
                    echo "<td>" . $row["stars"] . "</td>";
                    echo "<td>" . $row["rate"] . "</td>";
                    echo "<td>" . $row["cost"] . "</td>";
                    echo "<td>" . $row["info"] . "</td>";
                    
                echo "</tr>";
            
            }

    ?>
    </table>

    <?

        $selimage = "select * from images where hotelid=$id";
        $resimage = $link->query($selimage);

        foreach($resimage as $row)
        {    
            $rowpath="../" . $row['imagepath'];
            echo "<div> 
                    <a href='$rowpath' target='_blank'>
                        <img src='$rowpath' width='1300' height='750px' border='0' />    
                    </a>
                </div>";
        }
        echo "<br/><br/><br/>";


    ?>

    </div>
    <?
        if(!isset($_POST["exitbtn"])) 
        {
    ?>
    <form action="" method="post">
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <button type="submit" class="btn btn-secondary" name="exitbtn">На главную</button>
        </div>
        <?
            }
            else
            {
                header('Location: ../index.php');
            }
            
        ?>
    </form>

    
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
