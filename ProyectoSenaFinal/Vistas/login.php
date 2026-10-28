
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | Nous Akademia</title>

    <link rel="stylesheet"
        href="../CSS/estilos.css">

</head>


<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

<header class="navbar">


    <a href="../index.php"
       class="logo">

        Nous Akademia

        <small>
            Estudio y progreso académico
        </small>

    </a>


    <a href="../index.php"
       class="login-btn">

        Volver al inicio

    </a>


</header>



<!-- =====================================================
     LOGIN
===================================================== -->

<main class="auth-page">


    <section class="auth-card">


        <span class="hero-label">
            NOUS AKADEMIA
        </span>


        <h1>
            Bienvenido.
        </h1>


        <p>

            Inicia sesión para comenzar
            a registrar y consultar
            tu progreso académico.

        </p>



        <form
            action="../Procesos/iniciarSesion.php"
            method="POST">


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
                placeholder="Tu contraseña"
                required
            >



            <button
                type="submit"
                class="form-btn">

                Iniciar sesión

            </button>


        </form>



        <p class="form-link">

            ¿Todavía no tienes una cuenta?

            <a href="registro.php">

                Regístrate

            </a>

        </p>


    </section>


</main>


</body>

</html>
