document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal-leccion");
    const cerrar = document.getElementById("cerrar-modal");
    const titulo = document.getElementById("titulo-leccion");
    const teoria = document.getElementById("teoria-leccion");
    const editor = document.getElementById("editor");
    const salida = document.getElementById("salida");
    const btnCompletar = document.getElementById("btn-completar");

    document.querySelectorAll(".btn-ver").forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.getAttribute("data-id");
            const res = await fetch(`includes/get_leccion.php?id=${id}`);
            const data = await res.json();

            titulo.textContent = data.titulo;
            teoria.textContent = data.teoria;
            editor.value = "";
            salida.textContent = "";
            btnCompletar.dataset.id = id;

            modal.style.display = "flex";
        });
    });

    cerrar.addEventListener("click", () => {
        modal.style.display = "none";
    });

    document.getElementById("btn-ejecutar").addEventListener("click", () => {
        const code = editor.value.trim();
        salida.textContent = code ? "✅ Código ejecutado correctamente" : "⚠️ Escribe algo primero";
    });

    btnCompletar.addEventListener("click", async () => {
        const id = btnCompletar.dataset.id;
        const res = await fetch("includes/completar/completar_leccion.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`
        });
        if (await res.text() === "OK") {
            alert("Lección completada 🎉");
            location.reload();
        }
    });
});
