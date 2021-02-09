<html>

<head>
    <?php include_once 'Estaticos/meta.php'; ?>
    <title>Inventory</title>
</head>

<body>
    <main>
        <section class="loginFormContainer">
            <form id="loginForm" action="../Controlador/cLogin.php">
                <div class="logoContainer">
                    <svg style="width: 80px; height:80px" i:rulerOrigin="0 0" overflow="visible" i:viewOrigin="129.9341 392.8721" i:pageBounds="0 595.2764 841.8896 0" enable-background="new 0 0 188.873 223.338" xml:space="preserve" viewBox="0 0 188.873 223.338">
                        <polygon id="box-right" fill="rgb(83, 165, 212)" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off" />
                        <polygon fill="rgba(0,0,0,.45)" points="188.87 54.608 188.55 168.73 94.582 223.34 94.905 109.22" i:knockout="Off" />
                        <polygon id="box-left" fill="rgb(83, 165, 212)" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off" />
                        <polygon fill="rgba(0,0,0,.3)" points="94.905 109.22 94.582 223.34 0 168.73 0.323 54.608" i:knockout="Off" />
                        <polygon id="box-top" fill="rgb(83, 165, 212)" points="188.87 54.608 94.905 109.22 0.323 54.608 94.291 0" i:knockout="Off" />
                        <line y2="82.781" x1="47.769" i:knockout="Off" x2="141.84" stroke="#72512F" y1="27.226" stroke-width="2" fill="none" />
                        <polygon fill="rgb(225, 137, 78)" points="146.65 79.052 129.72 89.216 35.138 34.608 52.068 24.445" i:knockout="Off" />
                        <polygon fill="rgb(225, 137, 78)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off" />
                        <polygon fill="rgba(0,0,0,.3)" points="146.76 78.939 146.75 109.15 129.52 119.46 129.53 89.252" i:knockout="Off" />
                    </svg>
                    <h2 class="logoName">Inventory</h2>
                </div>
                <div class="formGroup">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control" aria-label="Username" aria-describedby="basic-addon1" autocomplete="nope">
                </div>
                <div class="formGroup">
                    <label for="" class="form-label">Contraseña</label>
                    <div class="passwordContainer">
                        <input type="password" id="password" class="form-control" autocomplete="nope">
                        <span id="eye-visibility" value="visible" onclick="visibilidadPass(this)"><i class="fas fa-eye-slash"></i></span>
                    </div>
                </div>
                <button class="btn btn-c1" type="button" onclick="checkLogin()">Iniciar Sesion</button>
            </form>

        </section>
    </main>
    <?php include_once 'Estaticos/scripts.php' ?>
</body>

</html>