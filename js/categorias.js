function creaCategoria() {

	let nombre = document.getElementById('tituloCat').value;
	let descrip = document.getElementById('descCat').value;	

	insertaCategoria(nombre, descrip);
	
}
function insertaCategoria(nom, desc) {

	const llamada = new XMLHttpRequest();

	llamada.onload = function(){

		if(this.responseText != -1){
			let tabla = document.getElementById("tabCat");

			let fila = document.createElement("tr");

			let celda = document.createElement("td");

			let enlace = document.createElement("a");

			enlace.setAttribute("href","http://basededatos.razvan/registrousuariosajaxBD/temas.php?cate="+this.responseText);

			let texto = document.createTextNode(nom + " - " + desc);

			enlace.appendChild(texto);

			celda.appendChild(enlace);

			fila.appendChild(celda);

			tabla.appendChild(fila);
		}else{
			alert("error al crear categoria");
		}
	}

	llamada.open("GET","registraCategoria.php?nombre="+nom+"&descrip="+desc,true);
	llamada.send();
}
