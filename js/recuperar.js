// --- Modal recuperar contraseña ---
document.addEventListener("DOMContentLoaded", () => {
	const openModal = document.getElementById("openModal");
	const modal = document.getElementById("modal-reset");
	const closeModal = document.getElementById("closeModal");
	const backdrop = document.getElementById("modal-backdrop");

	const formBuscar = document.getElementById("modal-form-buscar");
	const formReset = document.getElementById("modal-form-reset");
	const inputEmail = document.getElementById("modal-email");
	const inputPass = document.getElementById("modal-pass");
	const inputPassConfirm = document.getElementById("modal-pass-confirm");
	const msg = document.getElementById("modal-msg");
	const msg2 = document.getElementById("modal-msg-2");

	function open() {
		modal.classList.add("active");
		msg.textContent = "";
		msg2.textContent = "";
		formBuscar.style.display = "block";
		formReset.style.display = "none";
		inputEmail.focus();
	}
	function close() {
		modal.classList.remove("active");
		formBuscar.reset();
		formReset.reset();
	}

	if (openModal)
		openModal.addEventListener("click", (e) => {
			e.preventDefault();
			open();
		});

	if (closeModal) closeModal.addEventListener("click", close);
	if (backdrop) backdrop.addEventListener("click", close);

	// Paso 1: Buscar correo (envía form-urlencoded a recuperar.php)
	formBuscar.addEventListener("submit", async (e) => {
		e.preventDefault();
		const email = inputEmail.value.trim();
		if (!email) {
			msg.textContent = "Ingresa un correo válido.";
			return;
		}
		msg.textContent = "Buscando...";

		try {
			const body = new URLSearchParams();
			body.append("accion", "buscar");
			body.append("email_reset", email);

			const res = await fetch("recuperar.php", {
				method: "POST",
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
				body: body.toString(),
			});
			const text = (await res.text()).trim();

			if (text === "OK") {
				msg.textContent = "";
				formBuscar.style.display = "none";
				formReset.style.display = "block";
				inputPass.focus();
			} else {
				msg.textContent = "No existe una cuenta con ese correo.";
			}
		} catch (err) {
			console.error(err);
			msg.textContent = "Error al conectar con el servidor.";
		}
	});

	// Paso 2: Actualizar contraseña
	formReset.addEventListener("submit", async (e) => {
		e.preventDefault();
		const pass = inputPass.value.trim();
		const confirm = inputPassConfirm.value.trim();
		if (!pass || !confirm) {
			msg2.textContent = "Completa ambos campos.";
			return;
		}
		if (pass !== confirm) {
			msg2.textContent = "Las contraseñas no coinciden.";
			return;
		}
		msg2.textContent = "Actualizando...";

		try {
			const body = new URLSearchParams();
			body.append("accion", "actualizar");
			body.append("email", inputEmail.value.trim());
			body.append("nueva_pass", pass);

			const res = await fetch("recuperar.php", {
				method: "POST",
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
				body: body.toString(),
			});
			const text = (await res.text()).trim();

			if (text === "OK") {
				msg2.style.color = "green";
				msg2.textContent =
					"Contraseña actualizada correctamente. Puedes iniciar sesión.";
				setTimeout(() => close(), 1500);
			} else {
				msg2.style.color = "red";
				msg2.textContent = "No se pudo actualizar la contraseña.";
			}
		} catch (err) {
			console.error(err);
			msg2.textContent = "Error al conectar con el servidor.";
		}
	});
});
