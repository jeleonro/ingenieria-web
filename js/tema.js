import { validarPseudocodigo } from './validarPseudocodigo.js';

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal-leccion");
    const titulo = document.getElementById("titulo-leccion");
    const teoria = document.getElementById("teoria-leccion");
    const ejercicio = document.getElementById("ejercicio-leccion");
    const salida = document.getElementById("salida");
    const editor = document.getElementById("editor");

    let leccionActual = null;

    document.querySelectorAll(".btn-ver").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            leccionActual = id;
            const data = lecciones[id];
            titulo.textContent = data.titulo;
            teoria.textContent = data.teoria;
            ejercicio.textContent = "Ejercicio: " + data.ejercicio;
            salida.textContent = "";
            editor.value = "";
            modal.style.display = "flex";
        });
    });

    document.getElementById("cerrar-modal").addEventListener("click", () => {
        modal.style.display = "none";
    });

    document.getElementById("btn-ejecutar").addEventListener("click", () => {
        const codigo = document.getElementById("editor").value;
        const salida = document.getElementById("salida");
        const resultado = validarPseudocodigo(codigo);

        if (resultado.valido) {
            salida.textContent = resultado.mensaje;
            salida.style.color = "green";
        } else {
            salida.textContent = resultado.errores.join("\n");
            salida.style.color = "red";
        }
    });

    document.getElementById("btn-completar").addEventListener("click", () => {
        const codigo = editor.value.trim().toLowerCase();
        const esperado = lecciones[leccionActual].solucion_esperada.trim().toLowerCase();

        if (codigo.replace(/\s+/g, "") !== esperado.replace(/\s+/g, "")) {
            salida.textContent = "❌ No puedes marcar como completado sin resolver correctamente.";
            return;
        }

        fetch("actualiza_progreso.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id_leccion=${leccionActual}&id_usuario=${idUsuario}`
        }).then(() => {
            salida.textContent = "✅ Lección completada.";
            modal.style.display = "none";
            location.reload();
        });
    });
});
