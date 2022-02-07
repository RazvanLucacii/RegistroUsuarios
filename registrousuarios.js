function registrar() {

	let usuario = {};


	usuario.nom = document.getElementById("nom").value;
	usuario.ape = document.getElementById("ape").value;
	usuario.cor = document.getElementById("cor").value;
	usuario.usu = document.getElementById("usu").value;
	usuario.contra = document.getElementById("contra").value;

	const elJSON = JSON.stringify(usuario);

	if (usuario.usu != "" && usuario.contra != "" && usuario.cor !="") {
		regUsu(elJSON);
	}else{
		window.location.replace("error.html");
	}
}

function regUsu(p) {

	const llamada = new XMLHttpRequest();

	llamada.onload = function () {
		let resp = JSON.parse(this.responseText);

		if (resp) {
			document.getElementById("salida").innerHTML="Usuario Registrado";
		}else{
			window.location.replace("error.html");
		}
	}
			

		llamada.open("POST", "registrousuarios.php", true);
		llamada.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		llamada.send("x="+p);
}