function buscarcodigo1() {
    const codigoValue = document.getElementById("codigo1").value;
    const url = modificacionsCali;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
           //console.log(data);
            const defecto = data && data.defecto ? data.defecto : "";
            document.getElementById("1").value = 1;
            var Nok = parseInt(document.getElementById("nok").value);
            document.getElementById("nok").value = suma();
            if (defecto != "") {
                document.getElementById("rest_code1").value = defecto;
                document.getElementById("responsable1").minlenth = 4;

            }

        })
        .catch((error) => {
            console.error("Error:", error);
            alert('No existe el código');
            window.location.reload();

        });
}
function buscarcodigo2() {
    const codigoValue = document.getElementById("codigo2").value;

    const url = modificacionsCali;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const defecto = data && data.defecto ? data.defecto : "";

            document.getElementById("2").value = 1;
            var Nok = parseInt(document.getElementById("nok").value);
            document.getElementById("nok").value = suma();
            if (defecto != "") {
                document.getElementById("rest_code2").value = defecto;
                 document.getElementById("responsable2").minlenth = 4;
            } else {
                document.getElementById("rest_code2").value = data;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function buscarcodigo3() {
    const codigoValue = document.getElementById("codigo3").value;
    const url = modificacionsCali;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const defecto = data && data.defecto ? data.defecto : "";
            document.getElementById("3").value = 1;
            var Nok = parseInt(document.getElementById("nok").value);
            document.getElementById("nok").value = suma();
            if (defecto != "") {
                document.getElementById("rest_code3").value = defecto;
                 document.getElementById("responsable3").minlenth = 4;
            } else {
                document.getElementById("rest_code3").value = data;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function buscarcodigo4() {
    const codigoValue = document.getElementById("codigo4").value;
    const url = modificacionsCali;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const defecto = data && data.defecto ? data.defecto : "";
            document.getElementById("4").value = 1;
            var Nok = parseInt(document.getElementById("nok").value);
            document.getElementById("nok").value = suma();
            if (defecto != "") {
                document.getElementById("rest_code4").value = defecto;
                 document.getElementById("responsable4").minlenth = 4;
            } else {
                document.getElementById("rest_code4").value = data;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function buscarcodigo5() {
    const codigoValue = document.getElementById("codigo5").value;
    const url = modificacionsCali;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            const defecto = data && data.defecto ? data.defecto : "";
            document.getElementById("5").value = 1;
            var Nok = parseInt(document.getElementById("nok").value);
            document.getElementById("nok").value = suma();
            if (defecto != "") {
                document.getElementById("rest_code5").value = defecto;
                 document.getElementById("responsable5").minlenth = 4;
            } else {
                document.getElementById("rest_code5").value = data;
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function suma() {
    var checkNok = 0;

    checkNok = document.getElementById("codigo1").value !== "" ? checkNok+1 : checkNok ;
    checkNok = document.getElementById("codigo2").value !== "" ? checkNok + 1 : checkNok;
    checkNok = document.getElementById("codigo3").value !== "" ? checkNok + 1 : checkNok;
    checkNok = document.getElementById("codigo4").value !== "" ? checkNok + 1 : checkNok;
    checkNok = document.getElementById("codigo5").value !== "" ? checkNok + 1 : checkNok;

    return checkNok;}
function checkCant() {
    var checkNok = document.getElementById("nok").value;
    var checkNok = parseInt(checkNok);
    var check1 = document.getElementById("1").value;
    var check2 = document.getElementById("2").value;
    var check3 = document.getElementById("3").value;
    var check4 = document.getElementById("4").value;
    var check5 = document.getElementById("5").value;
    var total =
        parseInt(check1) +
        parseInt(check2) +
        parseInt(check3) +
        parseInt(check4) +
        parseInt(check5);

    if (total > checkNok) {
        document.getElementById("1").value = 0;
        document.getElementById("2").value = 0;
        document.getElementById("3").value = 0;
        document.getElementById("4").value = 0;
        document.getElementById("5").value = 0;
    }
}
function empleado1() {
    const codigoValue = document.getElementById("responsable1").value;
    const url = empleadosFallas;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
           // console.log(data);
          const personalDef=data.employeeName ? data.employeeName : "";
          if(personalDef == ""){
            alert("El empleado no existe");
             window.location.reload();
          }
          document.getElementById("resp1").value = personalDef;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function empleado2() {
    const codigoValue = document.getElementById("responsable2").value;
    const url = empleadosFallas;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
           // console.log(data);
          const personalDef=data.employeeName ? data.employeeName : "";
          if(personalDef == ""){
            alert("El empleado no existe");
             window.location.reload();
          }
          document.getElementById("resp2").value = personalDef;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function empleado3() {
    const codigoValue = document.getElementById("responsable3").value;
    const url = empleadosFallas;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
         //   console.log(data);
          const personalDef=data.employeeName ? data.employeeName : "";
          if(personalDef == ""){
            alert("El empleado no existe");
             window.location.reload();
          }
          document.getElementById("resp3").value = personalDef;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function empleado4() {
    const codigoValue = document.getElementById("responsable4").value;
    const url = empleadosFallas;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
           // console.log(data);
          const personalDef=data.employeeName ? data.employeeName : "";
          if(personalDef == ""){
            alert("El empleado no existe");
             window.location.reload();
          }
          document.getElementById("resp4").value = personalDef;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
function empleado5() {
    const codigoValue = document.getElementById("responsable5").value;
    const url = empleadosFallas;
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ codigo1: codigoValue }),
    })
        .then((response) => response.json())
        .then((data) => {
        //    console.log(data);
          const personalDef=data.employeeName ? data.employeeName : "";
          if(personalDef == ""){
            alert("El empleado no existe");
            window.location.reload();
          }
          document.getElementById("resp5").value = personalDef;
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}


