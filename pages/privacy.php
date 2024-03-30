
<?
$link = connect();
 
echo "<form action='index.php?page=5' method='post' class='w-100' enctype='multipart/form-data'>";
echo "<select name='userid' class='form-select w-100 mt-4'>";
$sel = "select * from users where roleid=2 order by login";
$res = $link->query($sel);
foreach($res as $row) {
    echo "<option value='" .$row["id"]. "'>" .$row['login']. "</option>";
}
echo "</select>";
echo "<input type='file' name='file' accept='image/*' class='form-control mt-3' />";
echo "<input type='submit' name='addadmin' value='Сделать администратором' class='btn btn-outline-info mt-3'/>";

echo "</form>";
echo "<br/>";
if(isset($_POST["addadmin"])) {
    $userid = $_POST["userid"];
 
    //получаем изображение из временной директории
    $fn = $_FILES["file"]["tmp_name"];
    $file = fopen($fn, "rb");
    $img = fread($file, filesize($fn));
    fclose($file);
    $img = addslashes($img);//валидные слэши
 
    $upd = "update users set avatar='$img', roleid=1 where id=$userid";
    $link->query($upd);
}
 
$sel = "select * from users where roleid=1 order by login";
$res = $link->query($sel);
 
echo "<table class='table table-striped table-hover'>";
echo "<thead><tr class='table-info'><td>ID</td><td>Avatar</td><td>Login</td><td>Email</td></tr></thead>";
echo "<tbody>";
foreach($res as $row) {
    echo "<tr>";
    echo "<td>" .$row['id']. "</td>";
    $img = base64_encode($row["avatar"]);//раскодирование картинки
    echo "<td><img width='100px' src='data:image/jpeg; base64, $img'></td>";
    echo "<td>" .$row['login']. "</td>";
    echo "<td>" .$row['email']. "</td>";
}
echo "</tbody>";
echo "</table>";
?>