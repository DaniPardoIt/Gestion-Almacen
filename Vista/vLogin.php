
<html>
    <head>
        <?php include_once 'Estaticos/meta.php'; ?>
        <title>Inventory</title>
    </head>
    <body>
        <main>
          <section class="loginFormContainer">
            <form id="loginForm" action="">
                <div class="formGroup">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control" aria-label="Username" aria-describedby="basic-addon1" autocomplete="nope">
                </div>
                <div class="formGroup">
                    <label for="" class="form-label">Contraseña</label>
                    <input type="password" id="email" class="form-control" autocomplete="nope">
                    <span class=""><i class="fas fa-eye-slash"></i></span>
                    <button class="text-primary">Button</button>
                </div>
            </form>
          </section>
        </main>
        <?php include_once 'Estaticos/scripts.php' ?>
    </body>
</html>