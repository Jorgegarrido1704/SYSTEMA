function mostrarAccionesCorrectivas(valor) {
    const cincoPorque = document.getElementById('5porque');
    const Ishikawa = document.getElementById('ishikawa');

    if(valor == 1){
        cincoPorque.style.display = 'block';
        Ishikawa.style.display = 'none';
        alert('Cinco por que');
    }else if (valor == 2){
        cincoPorque.style.display = 'none';
        Ishikawa.style.display = 'block';
        alert('Ishikawa');
    }

    

}
