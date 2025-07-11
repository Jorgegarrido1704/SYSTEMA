function mostrarAccionesCorrectivas(valor) {
    const cincoPorque = document.getElementById("5porque");
    const Ishikawa = document.getElementById("ishikawa");

    if (valor == 1) {
        cincoPorque.style.display = "block";
        Ishikawa.style.display = "none";
        alert("Cinco por que");
    } else if (valor == 2) {
        cincoPorque.style.display = "none";
        Ishikawa.style.display = "block";
        alert("Ishikawa");
    }
}

function mostrarOtroOrigen() {
    const otroOrigen = document.getElementById("origenAccion");
    if (otroOrigen.value == "otro") {

        let datosOrigen = document.getElementById("origen");
        datosdiv = document.createElement("div");
        datosdiv.className = "row mt-3";
        divInside = document.createElement("div");
        divInside.className = "col-md-12";
        divInside.innerHTML = `<label for="otrosOrigen">Especifique</label>
                                <input type="text" class="form-control" name="origenAccionotro" id="origenAccionotro"  required>`;
        datosdiv.appendChild(divInside);
        datosOrigen.appendChild(datosdiv);


    }
}

document.querySelector('#origenAccion').addEventListener('onsubmit', datos);
