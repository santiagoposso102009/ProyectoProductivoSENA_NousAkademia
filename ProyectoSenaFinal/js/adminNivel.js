/* =====================================================
   EDITOR DE PREGUNTAS (administrador)
   - Vista previa en vivo de la tarjeta
   - Aviso si hay opciones repetidas antes de enviar
===================================================== */

(function () {

    "use strict";

    var form = document.getElementById("form-pregunta");

    if (!form) {
        return;
    }

    var LETRAS = ["A", "B", "C", "D"];

    var pregunta = document.getElementById("f-pregunta");
    var pista = document.getElementById("f-pista");
    var explicacion = document.getElementById("f-explicacion");
    var opciones = form.querySelectorAll(".f-opcion");
    var radios = form.querySelectorAll('input[name="correcta"]');
    var errorEl = document.getElementById("f-error");

    var vpPregunta = document.getElementById("vp-pregunta");
    var vpPista = document.getElementById("vp-pista");
    var vpOpciones = document.getElementById("vp-opciones");
    var vpFeedback = document.getElementById("vp-feedback");
    var vpExplicacion = document.getElementById("vp-explicacion");


    /* ---------- VISTA PREVIA ---------- */

    function actualizar() {

        var texto = pregunta.value.trim();

        vpPregunta.textContent =
            texto || "Escribe aquí la pregunta…";

        vpPregunta.classList.toggle("vacio", texto === "");

        var textoPista = pista.value.trim();

        vpPista.hidden = (textoPista === "");

        vpPista.textContent = "💡 " + textoPista;

        vpOpciones.innerHTML = "";

        for (var i = 0; i < opciones.length; i++) {

            var fila = document.createElement("div");

            fila.className = "pr-opcion estatica";

            if (radios[i].checked) {
                fila.classList.add("correcta");
            }

            var letra = document.createElement("span");

            letra.className = "pr-letra";

            letra.textContent = LETRAS[i];

            var contenido = document.createElement("span");

            contenido.className = "pr-texto";

            contenido.textContent =
                opciones[i].value.trim() || "Opción " + LETRAS[i];

            fila.appendChild(letra);

            fila.appendChild(contenido);

            vpOpciones.appendChild(fila);

        }

        var textoExplicacion = explicacion.value.trim();

        vpFeedback.hidden = (textoExplicacion === "");

        vpExplicacion.textContent = textoExplicacion;

    }


    /* ---------- VALIDAR ANTES DE ENVIAR ---------- */

    function mostrarError(mensaje) {

        errorEl.textContent = mensaje;

        errorEl.hidden = false;

    }

    form.addEventListener("submit", function (e) {

        errorEl.hidden = true;

        var vistas = [];

        for (var i = 0; i < opciones.length; i++) {

            var valor = opciones[i].value.trim().toLowerCase();

            if (valor === "") {

                e.preventDefault();

                mostrarError("Completa las cuatro opciones.");

                opciones[i].focus();

                return;

            }

            if (vistas.indexOf(valor) !== -1) {

                e.preventDefault();

                mostrarError("Las cuatro opciones deben ser distintas entre sí.");

                opciones[i].focus();

                return;

            }

            vistas.push(valor);

        }

    });

    form.addEventListener("input", actualizar);

    form.addEventListener("change", actualizar);

    pregunta.focus();

    actualizar();

})();
