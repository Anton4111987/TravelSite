<h1> Registration Form </h1>

<form class="my-4" action="index.php?page=3" method="post">
        <div class="form-group my-2">
            <label for="login" class="form-label">Login: </label>
            <input type="text" name="login" id="login" class="form-control">
        </div>
        <div class="form-group my-2">
            <label for="email" class="form-label">Email: </label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group my-2">
            <label for="password1" class="form-label">Password: </label>
            <input type="password" name="password1" id="password1" class="form-control">
        </div>
        <div class="form-group my-2">
            <label for="password2" class="form-label">Confirm Password: </label>
            <input type="password" name="password2" id="password2" class="form-control">
        </div>
        <button type="submit" class="btn btn-outline-primary mt-3" name="regbtn">Register</button>
    </form>

    <?
    if(isset($_POST["login"]) && isset($_POST["password1"]) && isset($_POST["email"])) {
        if(register($_POST["login"], $_POST["password1"], $_POST["email"])) {
            echo "<h3><span style='color: green;'>Новый пользователь успешно добавлен!</span></h3>";
        }
    }
?>