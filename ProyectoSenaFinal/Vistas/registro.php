
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Crear cuenta | Nous Akademia</title>

    <link rel="stylesheet"
        href="../CSS/estilos.css">

</head>


<body>


<header class="navbar">

    <a href="../index.php"
       class="logo">

        Nous Akademia

        <small>
            Estudio y progreso académico
        </small>

    </a>


    <a href="login.php"
       class="login-btn">

        Iniciar sesión

    </a>

</header>



<main class="auth-page">


    <section class="auth-card">


        <h1>
            Crea tu cuenta.
        </h1>


        <p>

            Regístrate en Nous Akademia
            para comenzar a realizar
            tu seguimiento académico.

        </p>



        <form action="../Procesos/registrarUsuario.php"
              method="POST">


            <label for="nombre">
                Nombre completo
            </label>


            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Tu nombre"
                required
            >



            <label for="correo">
                Correo electrónico
            </label>


            <input
                type="email"
                id="correo"
                name="correo"
                placeholder="correo@ejemplo.com"
                required
            >



            <label for="password">
                Contraseña
            </label>


            <input
                type="password"
                id="password"
                name="password"
                placeholder="Crea una contraseña"
                required
            >



            <label for="confirmar">
                Confirmar contraseña
            </label>


            <input
                type="password"
                id="confirmar"
                name="confirmar"
                placeholder="Repite tu contraseña"
                required
            >



            <button
                type="submit"
                class="form-btn">

                Crear cuenta

            </button>


        </form>



        <p class="form-link">

            ¿Ya tienes una cuenta?

            <a href="login.php">
                Inicia sesión
            </a>

        </p>


    </section>


</main>


</body>

</html>
