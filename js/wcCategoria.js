class FilaCategoria extends HTMLElement{

	constructor(){
		super();

		this.attachShadow({
			mode:"open"
		});
		this.atributoTit = "";
		this.atributoDesc = "";

		this.template = document.getElementById("plantFilaCat");
		this.plantilla = document.importNode(this.template.content, true);
	}

	render(){
		this.shadowRoot.appendChild(this.plantilla);
		this.shadowRoot.getElementById("Titulo").innerHTML = this.atributoTit;
		this.shadowRoot.getElementById("Descripcion").innerHTML = this.atributoDesc;
	}

	connectedCallback(){

		this.render();
	}

	attributeChangedCallback(nomAttrib, valViejo, valNuevo){
		if (nomAttrib === "titu") {
			this.atributoTit = valNuevo;
			this.render();
		}
		if (nomAttrib === "descr") {
			this.atributoDesc = valNuevo;
			this.render();
		}
	}

	static get observedAttributes(){
		return ['titu','descr'];
	}

}

window.customElements.define("foro-fila-categoria", FilaCategoria);