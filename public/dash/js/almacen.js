function hola() {
    var codigo = document.getElementById('codigo').value;
    var wo = document.getElementById('wo').value;
    var pn = document.getElementById('pn').value; // Get the pn value

    // Get CSRF token from the meta tag
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Create the data object to send as JSON
    var data = {
        codigo: codigo,
        wo: wo,
        pn: pn
    };

    $.ajax({
        method: 'POST', // Change to POST
        url: urlitem, // Ensure urlitem is correctly defined
        data: JSON.stringify(data), // Send data as a JSON string
        contentType: 'application/json', // Set content type to JSON
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request header
        },
        success: function(response) {
            console.log(response);
            if (response.status === 200) { // Check for correct status code
               var item = response.data.item;
               var qty = response.data.qty;
               var saldo = response.data.sumaMov;
                if(qty >= saldo){
                    var diff = saldo;
                }else{
                    var diff = qty;
                }
                let registrado;
                do {
                  registrado = prompt("Del Item " + item + " escaneado tu puedes registrar : " + diff + " ¿Cuantos desea registrar?");
                } while (isNaN(registrado) || registrado === "" || registrado < 1 || registrado > diff);


            } else {
                alert(response.message); // Display error message from server
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error al registrar la cantidad: ' + error);
        }
    });
}
