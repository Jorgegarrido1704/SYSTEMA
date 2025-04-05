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

    // First AJAX request to fetch the item details
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

                if (saldo > 0) {
                    var diff = (qty >= saldo) ? saldo : qty; // Use conditional (ternary) operator to assign diff

                    let registrado;
                    do {
                        registrado = prompt("Del Item " + item + " escaneado tu puedes registrar : " + diff + " ¿Cuantos desea registrar?");

                        // Validation checks for the input
                        if (registrado === "" || registrado === null || registrado == 0) {
                            alert("No puedes registrar 0");
                            break;
                        } else if (registrado > diff) {
                            alert("No puedes registrar más de " + diff);
                        } else if (registrado < 1) {
                            alert("El valor debe ser mayor que 0.");
                        } else {
                            alert("Registrando " + registrado + " de " + diff);

                            // Send the registration data
                            var datos = {
                                item: item,
                                codUnic: codigo,
                                wo: wo,
                                registrado: registrado
                            };
                            console.log(datos);

                            // Second AJAX request to register the item
                            $.ajax({
                                type: 'POST',
                                url: altaReg, // Ensure altaReg is defined
                                data: JSON.stringify(datos),
                                contentType: 'application/json', // Set content type to JSON
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request header
                                },
                                success: function(response) {
                                    console.log(response);
                                    if (response.status === 200) {
                                        alert('Registro exitoso');
                                        location.reload(); // Refresh the page after success
                                    } else {
                                        alert('Error al registrar la cantidad');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error);
                                    alert('Error al registrar la cantidad: ' + error);
                                }
                            });
                        }
                    } while (isNaN(registrado) || registrado === "" || registrado < 1 || registrado > diff);
                } else {
                    alert('Item sin stock'); // Display error message if no stock
                }
            } else {
                alert('Error al obtener datos del item'); // Handle failure to fetch item details
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error al obtener datos del item: ' + error); // Handle failure to fetch item details
        }
    });
}
