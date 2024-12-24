
      function buscarcodigo1() {
                const codigoValue = document.getElementById('codigo1').value;
                const url = modificacionsCali;
                fetch(url, { method: 'POST',
                    headers: {   'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                    body: JSON.stringify({ codigo1: codigoValue }),   })
                .then(response => response.json())
                .then(data => {  console.log(data);
                    const defecto = data && data.defecto ? data.defecto : '';
                    document.getElementById('1').value = 1;
                    var Nok=parseInt(document.getElementById('nok').value);
                    document.getElementById('nok').value = Nok+1;
                    if(defecto!=""){
                    document.getElementById('rest_code1').value = defecto;
                    }else{
                    document.getElementById('rest_code1').value = data;
                    }
                })
                .catch(error => { console.error('Error:', error);  });}
                function buscarcodigo2() {
                const codigoValue = document.getElementById('codigo2').value;

                const url = modificacionsCali;
                fetch(url, { method: 'POST',
                    headers: {   'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                    body: JSON.stringify({ codigo1: codigoValue }),   })
                .then(response => response.json())
                .then(data => {  console.log(data);
                    const defecto = data && data.defecto ? data.defecto : '';

                    document.getElementById('2').value = 1;
                    var Nok=parseInt(document.getElementById('nok').value);
                    document.getElementById('nok').value = Nok+1;
                    if(defecto!=""){
                    document.getElementById('rest_code2').value = defecto;
                    }else{
                    document.getElementById('rest_code2').value = data;
                    }   })
                .catch(error => { console.error('Error:', error);  });}
                function buscarcodigo3() {
                const codigoValue = document.getElementById('codigo3').value;
                const url = modificacionsCali;
                fetch(url, { method: 'POST',
                    headers: {   'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                    body: JSON.stringify({ codigo1: codigoValue }),   })
                .then(response => response.json())
                .then(data => {  console.log(data);
                    const defecto = data && data.defecto ? data.defecto : '';
                    document.getElementById('3').value = 1;
                    var Nok=parseInt(document.getElementById('nok').value);
                    document.getElementById('nok').value = Nok+1;
                    if(defecto!=""){
                    document.getElementById('rest_code3').value = defecto;
                    }else{
                    document.getElementById('rest_code3').value = data;
                    }   })
                .catch(error => { console.error('Error:', error);  });}
                function buscarcodigo4() {
                const codigoValue = document.getElementById('codigo4').value;
                const url = modificacionsCali;
                fetch(url, { method: 'POST',
                    headers: {   'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                    body: JSON.stringify({ codigo1: codigoValue }),   })
                .then(response => response.json())
                .then(data => {  console.log(data);
                    const defecto = data && data.defecto ? data.defecto : '';
                    document.getElementById('4').value = 1;
                    var Nok=parseInt(document.getElementById('nok').value);
                    document.getElementById('nok').value = Nok+1;
                    if(defecto!=""){
                    document.getElementById('rest_code4').value = defecto;
                    }else{
                    document.getElementById('rest_code4').value = data;
                    } })
                .catch(error => { console.error('Error:', error);  });}
                function buscarcodigo5() {
                const codigoValue = document.getElementById('codigo5').value;
                const url = modificacionsCali;
                fetch(url, { method: 'POST',
                    headers: {   'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                    body: JSON.stringify({ codigo1: codigoValue }),   })
                .then(response => response.json())
                .then(data => {  console.log(data);
                    const defecto = data && data.defecto ? data.defecto : '';
                    document.getElementById('5').value = 1;
                    var Nok=parseInt(document.getElementById('nok').value);
                    document.getElementById('nok').value = Nok+1;
                    if(defecto!=""){
                    document.getElementById('rest_code5').value = defecto;
                    }else{
                    document.getElementById('rest_code5').value = data;
                    }   })
                .catch(error => { console.error('Error:', error);    });}

