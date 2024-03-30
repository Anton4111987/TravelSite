<h2 class="text-center">Выбор отеля</h2>
<hr>
<?
    $link = connect();
    echo "<form action='index.php?page=1' method='post' class='form-group'>";
        echo "<select class='form-select col-sm-4 col-md-4 col-lg-4' name='countryid'>";
                $res = $link->query("select * from countries order by country");
                foreach ($res as $row) 
                {
                    echo "<option value='" . $row["id"] . "'>" . $row["country"] . "</option>";
                }
        echo "</select>";
        echo "<input type='submit' name='selcountry' class='btn btn-outline-primary my-2' value='Выбрать страну'/>";
        if (isset($_POST["selcountry"])) 
        {
            $countryid = $_POST["countryid"];
            if ($countryid != 0) 
            {
                $res = $link->query("select * from cities where countryid=$countryid order by city");
                echo "<select class='form-select col-sm-4 col-md-4 col-lg-4' name='cityid'>";
                    foreach ($res as $row) 
                    {
                        echo "<option value='" . $row["id"] . "'>" . $row["city"] . "</option>";
                    }
                echo "</select>";
            echo "<input type='submit' name='selcity' class='btn btn-outline-primary my-2' value='Выбрать город'/>";
            }
        }
    echo "</form>";
    if (isset($_POST["selcity"])) 
    {
        $cityid = $_POST["cityid"];
        $sel = "select ci.id, ci.city as сity, ci.countryid, ho.id as hotelid, ho.hotel, ho.cityid, ho.cost, ho.rate, ho.stars, ho.info, co.id, co.country 
                from countries co, cities ci, hotels ho 
                where ci.countryid=co.id and ho.cityid=ci.id and ci.id=$cityid
                order by hotelid";
        $res = $link->query($sel);
        echo "<table class='table table-striped table-hover text-center align-middle my-3'>";
            echo "<thead class='table-danger'>
                    <th>Отель</th>
                    <th>Город</th>
                    <th>Страна</th>
                    <th>Звезды</th>
                    <th>Рейтинг</th>
                    <th>Цена</th>
                    <th>Описание</th>
                </thead>";
        
            foreach ($res as $row) 
            {
                $hotelid=$row["hotelid"];            
                echo "<tr>";
                    echo "<td>
                            <a href='pages/hoteldetailedpage.php?id=$hotelid'> " . $row["hotel"] . "</a>
                        </td>";
                        
                    echo "<td>" . $row["сity"] . "</td>";
                    echo "<td>" . $row["country"] . "</td>";
                    echo "<td>" . $row["stars"] . "</td>";
                    echo "<td>" . $row["rate"] . "</td>";
                    echo "<td>" . $row["cost"] . "</td>";
                    echo "<td>" . $row["info"] . "</td>";

                echo "</tr>";
            }
            
           
    

        echo "</table>";
    }

?>