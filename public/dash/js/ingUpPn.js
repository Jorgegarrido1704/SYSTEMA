function updateRev() {
    var rev = document.getElementById('Tipo').value;
    console.log(rev);
    if (rev == 'PRIM' || rev == 'PPAP') {
        document.getElementById('rev2').value = 'N/A';
        document.getElementById('cambios').value = 'N/A';
    } else if (rev == 'NO PPAP') {
        document.getElementById('rev2').value = 'SOLO REGISTRO';
        document.getElementById('cambios').value = 'SOLO REGISTRO';
    }

}

