/* =====================================================
   PRÁCTICA DE FLASHCARDS (opción múltiple)
   NOUS AKADEMIA

   El navegador NO conoce la respuesta correcta: cada
   respuesta se envía a comprobarRespuesta.php, que la
   verifica y la guarda en la sesión del servidor.
===================================================== */

(function () {

    "use strict";

    var contenedorDatos = document.getElementById("datos-practica");

    if (!contenedorDatos) {
        return;
    }

    var datos = JSON.parse(contenedorDatos.textContent);

    var tarjetas = barajar(datos.tarjetas.slice());

    var LETRAS = ["A", "B", "C", "D"];

    var indice = 0;

    var seleccion = null;

    var bloqueado = false;

    var resultados = [];

    var aciertos = 0;


    /* ---------- ELEMENTOS ---------- */

    function el(id) {
        return document.getElementById(id);
    }

    var zonaPractica = el("zona-practica");
    var zonaResultado = el("zona-resultado");
    var puntos = el("pr-puntos");
    var tarjeta = el("pr-tarjeta");
    var etiqueta = el("pr-etiqueta");
    var preguntaEl = el("pr-pregunta");
    var botonPista = el("btn-pista");
    var pistaEl = el("pr-pista");
    var opcionesEl = el("pr-opciones");
    var feedback = el("pr-feedback");
    var feedbackTitulo = el("pr-feedback-titulo");
    var feedbackTexto = el("pr-feedback-texto");
    var errorEl = el("pr-error");
    var botonComprobar = el("btn-comprobar");
    var botonSiguiente = el("btn-siguiente");


    /* ---------- UTILIDADES ---------- */

    /* Fisher-Yates */

    function barajar(lista) {

        for (var i = lista.length - 1; i > 0; i--) {

            var j = Math.floor(Math.random() * (i + 1));

            var temporal = lista[i];

            lista[i] = lista[j];

            lista[j] = temporal;

        }

        return lista;

    }

    function botonesOpcion() {
        return opcionesEl.querySelectorAll(".pr-opcion");
    }


    /* ---------- PUNTOS DE PROGRESO ---------- */

    function pintarPuntos() {

        puntos.innerHTML = "";

        tarjetas.forEach(function (t, i) {

            var punto = document.createElement("span");

            punto.className = "pr-punto";

            if (resultados[i] === true) {
                punto.classList.add("ok");
            } else if (resultados[i] === false) {
                punto.classList.add("no");
            } else if (i === indice) {
                punto.classList.add("actual");
            }

            puntos.appendChild(punto);

        });

    }


    /* ---------- MOSTRAR UNA TARJETA ---------- */

    function pintar() {

        var actual = tarjetas[indice];

        seleccion = null;

        bloqueado = false;

        /* Reinicia la animación de entrada */

        tarjeta.classList.remove("entrada");

        void tarjeta.offsetWidth;

        tarjeta.classList.add("entrada");

        etiqueta.textContent =
            "Pregunta " + (indice + 1) + " de " + tarjetas.length;

        preguntaEl.textContent = actual.pregunta;

        /* Pista */

        pistaEl.hidden = true;

        pistaEl.textContent = actual.pista;

        botonPista.hidden = (actual.pista === "");

        /* Opciones */

        opcionesEl.innerHTML = "";

        actual.opciones.forEach(function (texto, i) {

            var boton = document.createElement("button");

            boton.type = "button";

            boton.className = "pr-opcion";

            boton.dataset.valor = texto;

            var letra = document.createElement("span");

            letra.className = "pr-letra";

            letra.textContent = LETRAS[i];

            var contenido = document.createElement("span");

            contenido.className = "pr-texto";

            contenido.textContent = texto;

            boton.appendChild(letra);

            boton.appendChild(contenido);

            boton.addEventListener("click", function () {
                elegir(boton);
            });

            opcionesEl.appendChild(boton);

        });

        feedback.hidden = true;

        feedback.className = "pr-feedback";

        errorEl.hidden = true;

        botonComprobar.hidden = false;

        botonComprobar.disabled = true;

        botonSiguiente.hidden = true;

        pintarPuntos();

    }


    /* ---------- ELEGIR UNA OPCIÓN ---------- */

    function elegir(boton) {

        if (bloqueado) {
            return;
        }

        botonesOpcion().forEach(function (b) {
            b.classList.remove("seleccionada");
        });

        boton.classList.add("seleccionada");

        seleccion = boton.dataset.valor;

        botonComprobar.disabled = false;

    }


    /* ---------- COMPROBAR EN EL SERVIDOR ---------- */

    function comprobar() {

        if (seleccion === null || bloqueado) {
            return;
        }

        bloqueado = true;

        botonComprobar.disabled = true;

        errorEl.hidden = true;

        var cuerpo = new URLSearchParams();

        cuerpo.append("id_nivel", datos.idNivel);

        cuerpo.append("id_flashcard", tarjetas[indice].id_flashcard);

        cuerpo.append("respuesta", seleccion);

        fetch(datos.urlComprobar, {

            method: "POST",

            credentials: "same-origin",

            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },

            body: cuerpo.toString()

        })
        .then(function (respuesta) {

            return respuesta.json().then(function (json) {
                return { ok: respuesta.ok, json: json };
            });

        })
        .then(function (r) {

            if (!r.ok) {
                throw new Error(r.json.error || "Error al comprobar.");
            }

            mostrarResultado(r.json);

        })
        .catch(function (error) {

            bloqueado = false;

            botonComprobar.disabled = false;

            errorEl.textContent =
                error.message || "No se pudo comprobar la respuesta.";

            errorEl.hidden = false;

        });

    }


    function mostrarResultado(r) {

        var correcta = (r.correcta === true);

        resultados[indice] = correcta;

        if (correcta) {
            aciertos++;
        }

        botonesOpcion().forEach(function (b) {

            b.disabled = true;

            if (b.dataset.valor === r.respuesta_correcta) {
                b.classList.add("correcta");
            } else if (b.classList.contains("seleccionada")) {
                b.classList.add("incorrecta");
            }

            b.classList.remove("seleccionada");

        });

        feedback.hidden = false;

        feedback.className =
            "pr-feedback " + (correcta ? "ok" : "no");

        feedbackTitulo.textContent =
            correcta ? "¡Correcto!" : "Incorrecto";

        var texto = "";

        if (!correcta) {
            texto = "La respuesta correcta es: " + r.respuesta_correcta + ". ";
        }

        if (r.explicacion) {
            texto += r.explicacion;
        } else if (correcta) {
            texto = "¡Muy bien!";
        }

        feedbackTexto.textContent = texto;

        botonComprobar.hidden = true;

        botonSiguiente.hidden = false;

        botonSiguiente.textContent =
            (indice === tarjetas.length - 1)
                ? "Ver resultado"
                : "Siguiente →";

        pintarPuntos();

    }


    /* ---------- AVANZAR ---------- */

    function siguiente() {

        if (!bloqueado || resultados[indice] === undefined) {
            return;
        }

        indice++;

        if (indice >= tarjetas.length) {
            terminar();
        } else {
            pintar();
        }

    }


    /* ---------- RESULTADO FINAL ---------- */

    function terminar() {

        var porcentaje =
            Math.round(aciertos / tarjetas.length * 100);

        zonaPractica.hidden = true;

        zonaResultado.hidden = false;

        el("res-porcentaje").textContent = porcentaje + "%";

        el("res-detalle").textContent =
            "Acertaste " + aciertos +
            " de " + tarjetas.length + " preguntas.";

        el("res-mensaje").textContent =
            (porcentaje >= datos.umbral)
                ? "Con este resultado superas el nivel. Guárdalo para registrar tu avance."
                : "Necesitas al menos " + datos.umbral +
                  " % para avanzar. Guarda este intento y vuelve a practicar.";

    }


    /* ---------- EVENTOS ---------- */

    botonComprobar.addEventListener("click", comprobar);

    botonSiguiente.addEventListener("click", siguiente);

    botonPista.addEventListener("click", function () {

        pistaEl.hidden = !pistaEl.hidden;

        botonPista.textContent =
            pistaEl.hidden ? "💡 Ver pista" : "💡 Ocultar pista";

    });

    document.addEventListener("keydown", function (e) {

        if (zonaPractica.hidden) {
            return;
        }

        if (e.key >= "1" && e.key <= "4") {

            var botones = botonesOpcion();

            var boton = botones[parseInt(e.key, 10) - 1];

            if (boton) {
                elegir(boton);
            }

        } else if (e.key === "Enter") {

            e.preventDefault();

            if (!botonSiguiente.hidden) {
                siguiente();
            } else {
                comprobar();
            }

        }

    });


    /* ---------- INICIO ---------- */

    if (tarjetas.length === 0) {

        zonaPractica.innerHTML =
            "<p>Este nivel todavía no tiene preguntas.</p>";

    } else {

        pintar();

    }

})();
