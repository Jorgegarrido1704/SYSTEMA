var medicamentosDisponibles =[];


const personal=[
    ['2001','Jesus  Zamarripa Rodriguez','Lider Producción','Ensamble','DVillalpando'],
['2002','Rosario Hernandez Lopez','Inspector Calidad','','EVillegas'],
['2003','Andrea Pacheco','Supervisor Almacen','','JGUILLEN'],
['2004','Fabiola  Alonso','Inspector Calidad','','EVillegas'],
['2005','Martha Carpio','Operador C','Liberación','AGonzalez'],
['2006','Maria Alejandra Gaona Alvarado','Operador A','Ensamble','SGalvan'],
['2007','Adan Bravo Martinez','Operador A','Liberación','AGonzalez'],
['2008','Lidia Susana Rico Hernadez','Operador D','Ensamble','JSanchez'],
['2009','Ma Estela Gaona Alvarado','Planeador Producción','','MVALADEZ'],
['2010','Leonardo Rafael Mireles','Supervisor de embarque','','FGOMEZ'],
['2013','Fernando Martin Segovia','Aux Lider','Corte','COlvera'],
['2014','Salvador Galvan Davila','Lider Producción','Ensamble','DVillalpando'],
['2015','Maria Esther Mandujano ','Aux Lider','Ensamble','JSanchez'],
['2016','Jose Manuel Zacarias Jimenez','Operador A','Ensamble','JZamarripa'],
['2017','Jennifer Alejandra Gomez','Operador C','Liberación','AGonzalez'],
['2018','David Salvador Rodriguez','Operador D','Ensamble','JZamarripa'],
['2019','Efrain Vera Villegas','Supervisor de calidad','','EMedina'],
['2020','Laura Alejandra Contreras','Operador A','Ensamble','JZamarripa'],
['2021','Rosalba Ramirez Oliva','Operador C','Liberación','AGonzalez'],
['2022','Maria Berenice Serrano ','Operador C','Liberación','AGonzalez'],
['2023','Didier Maldonado Lopez','Aux Almacen B','','APacheco'],
['2024','Aury Cecilia Aguilar Castillo','Tec Pruebas','','EMedina'],
['2025','Maria Magdalena Villanueva','Operador C','Ensamble','JSanchez'],
['2026','Samantha Montserrat Aranda','Operador D','Ensamble','JSanchez'],
['2030','Jose Luis Ruiz Valdivia','Tec Pruebas','','EMedina'],
['2031','Jessica Lizbeth Sanchez','Lider Producción','Ensamble','DVillalpando'],
['2032','Martha Aranda Palacios','Operador A','Ensamble','SGalvan'],
['2033','Alma Delia Perez Martin','Operador B','Ensamble','JSanchez'],
['2034','Jessica Sarahi Torres P','Operador C','Ensamble','JSanchez'],
['2035','Neri Leticia Cervantes ','Operador B','Ensamble','JSanchez'],
['2037','Christian De Jesus Olvera','Lider Producción','Corte','JOlaes'],
['2038','Beatriz Elena Regalado ','Operador B','Ensamble','JZamarripa'],
['2041','Edward Medina Flores','Ing Calidad','','LRAMOS'],
['2042','Martha Evelia Trujillo ','Operador C','Ensamble','JZamarripa'],
['2043','Mayra Daniela Montes P','Operador C','Liberación','AGonzalez'],
['2044','Sanjuana Estela Mosqueda','Operador C','Ensamble','SCastro'],
['2046','Ma. De los Angeles   Flores Ortiz','Operador C','Ensamble','JSanchez'],
['2047','Maricela Alferes Montes','Intendencia B','','PAGUILAR'],
['2049','Jessica Estefania Galvan','Operador C','Ensamble','JSanchez'],
['2051','Sergio Vera Castillo','Inspector Calidad','','EVillegas'],
['2052','Erick Nuñez Vazquez','Aux Almacén A','','APacheco'],
['2054','Cristina Jacquelin Godinez Ortiz','Operador C','Ensamble','JZamarripa'],
['2056','Sobeida Amaya Mercado','Operador D','Ensamble','SCastro'],
['2057','Daniela Goretti Rocha C','Aux Calidad','','EMedina'],
['2058','Maria Barbara Castillo ','Operador C','Ensamble','JSanchez'],
['2060','Marisol Anahi Perez M','Aux Almacen B','','APacheco'],
['2062','Alejandro Daniel Robledo','Operador C','Corte','COlvera'],
['2065','Brenda Cecilia Galvan S','Operador D','Ensamble','SCastro'],
['2066','Patricia Castro Gomez','Operador C','Ensamble','SGalvan'],
['2067','Mariana Alferes Montes','Intendencia A','','PAGUILAR'],
['2068','Noemi Guadalupe Rangel ','Operador D','Liberación','AGonzalez'],
['2071','Luis  Segoviano','Tec Mantinimiento D','','JCERVANTES'],
['2073','Cinthya Veronica Galvan','Operador D','Ensamble','SGalvan'],
['2074','Yahir Alejandro Chacon ','Operador C','Ensamble','JZamarripa'],
['2075','Fatima De La Luz Garcia','Operador D','Ensamble','SGalvan'],
['2077','Marcos Enrique Delgado ','Operador D','Liberación','AGonzalez'],
['2079','Jesus Ernesto Castro R','Inspector Calidad','','EVillegas'],
['2080','Francisco Javier Melend','Operador C','Liberación','AGonzalez'],
['2081','Claudia Ivett Gonzalez ','Operador D','Liberación','AGonzalez'],
['2082','Annel Ivonne Castro E','Operador D','Ensamble','SCastro'],
['2085','Maria Guadalupe Valdes ','Operador C','Ensamble','JSanchez'],
['2087','Maria Teresa Jimenez R','Operador D','Liberación','AGonzalez'],
['2089','Silvia Edith Negrete M','Operador D','Ensamble','SCastro'],
['2090','Milagros Jazmin Sanchez','Operador D','Ensamble','JSanchez'],
['2091','Jhoana Jocelyn Lopez J','Tec procesos Calidad','','EMedina'],
['2098','Fernando Moises Barajas','Operador C','Corte','COlvera'],
['2101','Jorge Arturo Garrido M','Ingeniero','','JCERVERA'],
['2106','Luis Adrian Rodriguez A','Operador D','Corte','COlvera'],
['2108','Carmen Patricia Vera C','Operador D','Liberación','AGonzalez'],
['2111','Esteban Marajim Vazquez','Operador D','Corte','COlvera'],
['2112','Karla Jacqueline Martin','Operador D','Liberación','AGonzalez'],
['2113','Martin Baez Aguilar','Seguridad B','','JCERVANTES'],
['2114','Ma  Del Rosario','Operador D','Ensamble','JSanchez'],
['2116','Mario Alberto Delgado C','Seguridad B','','JCERVANTES'],
['2117','Gerardo Calvillo Martin','Seguridad B','','JCERVANTES'],
['2118','Daniela Karen Elizabeth Ojeda Ramirez','Inspector Calidad','','Evillegas'],
['2119','Sofia Sanchez Amezquita','Operador D','Ensamble','SCastro'],
['2120','Ana Ivette Lira Perez','Operador D','Ensamble','JSanchez'],
['2123','Saul Castro Ordaz','Lider Producción','Ensamble','DVillalpando'],
['2125','Fatima Yaireth Suarez Flores','Aux Comercio','','RFANDIÑO'],
['2127','Jonathan Ismael Falcon ','Tec Mantinimiento D','','AGonzalez'],
['2128','Jared Alejandro Moreno ','Tec OP B','','JGUILLEN'],
['2130','Indihra Paulina Martine','Aux Comercio','','RFANDIÑO'],
['2132','Maricruz Alonso Torres','Operador A','Ensamble','SGalvan'],
['2133','Sofia Alonso Torres','Operador D','Liberación','AGonzalez'],
['2134','Cecilia Del Rocio Rangel B','Operador C','Ensamble','JZamarripa'],
['2136','Cassandra Elizabeth Monjaraz Reyna','Operador C','Ensamble','JSanchez'],
['2137','Graciela Lopez Cervera','Operador C','Liberación','AGonzalez'],
['2138','Blanca Esthela Carpio R','Operador C','Ensamble','JZamarripa'],
['2139','Lizbeth Natali Sanchez ','Operador C','Ensamble','SGalvan'],
['2142','Marintia Fernanda Lugo ','Operador D','Liberación','AGonzalez'],
['2144','Nancy Noelia Aldana Rios','Ingeniero','','JCERVERA'],
['2145','Martin Aléman Gutierrez','Coordinador de sist de calidad','','LRAMOS'],
['2146','Javier Santos Cervantes','Supervisor Mantenimiento','','JGUILLEN'],
['2147','Jose de Jesus Cervera Lopez','Sup Ingeniería','','JGUILLEN'],
['2150','Rocio Fandiño','Coordinadora de immex','','JGUILLEN'],
['2152','Francisco  Gomez','Supervisor de embarque','','RFANDIÑO'],
['2153','Angel Gonzalez','Lider de producción','Liberación','JOlaes'],
['2157','Juan  Olaes','Sup de producción','Corte y Liberación','Jguillén'],
['2158','Edwin  Ortega','Contralor financiero','','APotter'],
['2159','Jesus Pereida Ordaz','Ingeniero','','JCERVANTES'],
['2160','Valeria Fernanda Pichardo','Compras','','JGUILLEN'],
['2161','Luis Alberto Ramos Cedeño','Gte Calidad','','GUmhoefer'],
['2162','Miriam Vanessa Reyes Araujo','Ctas por pagar','','EORTEGA'],
['2164','Jose Carlos Rodriguez G','Ingeniero','','JCERVERA'],
['2165','Paola Valeria Silva Vega','Ingeniero','','JCERVERA'],
['2166','Juliet Marlenne Torres ','Enfermera','','PAGUILAR'],
['2167','Mario Enrique Valadez V','Servicio al cliente','','JGUILLEN'],
['2169','David Villalpando Rodriguez','Sup de producción','Ensamble','Jguillén'],
['2170','Ana Paola Aguilar Hernandez','Gte RH','','JSchmit'],
['2171','Robert Melvin Smith','Dir de negocios','','JElliot'],
['2172','Jose Roberto Olivares A','Operador C','Liberación','AGonzalez'],
['2174','Maria De Los Angeles Bañuelos','Analista RH','','PAGUILAR'],
['2175','Juan Jose Guillen Miranda','Gte Operaciones','Operaciones','JElliot'],
['2181','Rodrigo  Ponce A','Practicante','','JCervantes'],
['2177','Juan Antonio ','Operador D','Ensamble','SGalvan'],
['2178','Juan Francisco ','Operador D','Liberación','AGonzalez'],
['2143','Carlos Samuel ','Operador D','Ensamble','JZamarripa'],
['2184','Yair ','Operador D','Corte','COlvera'],
['2183','Jonathan Ismael ','Operador D','Ensamble','SGalvan'],
['2185','Valeria ','Operador D','Ensamble','SGalvan'],
['2186','SanJuana ','Operador D','Ensamble','SGalvan'],
['2187','Sebastian ','Lider Mantenimiento','','JCervantes'],
['2188','Dafne ','Practicante','','VPichardo'],
['2180','Brandon ','Practicante','','JCervera'],
['2182','Christian Alejandro ','Practicante','','JCervera'],
];


window.onload = function() {
   document.getElementById("fecha").value = new Date().toISOString().substring(0, 10);
   console.log("fecha", document.getElementById("fecha").value);
}


function buscarempleado() {

    nom=cargo=area=supervisor="";

    var empleado = document.getElementById("nomEmp").value;
    console.log("empleado", empleado);
    for (var i = 0; i < personal.length; i++) {
        if (empleado == personal[i][0]) {
            var nom = document.getElementById('nombreEmp').value = personal[i][1];
            var cargo = document.getElementById('cargo').value = personal[i][2];
            var area = document.getElementById('area').value = personal[i][3];
            var supervisor = document.getElementById('supervisor').value = personal[i][4];
            console.log(nom, cargo, area, supervisor);

            break;
        }
    }
}
medicamentosDisponibles =[
    'paracetamol',
    'ibuprofeno',
    'acetaminofen',
    'dipirona',
    'aspirina',
];
function agregarMedicamento() {
    // Generar un ID único para los nuevos elementos
    var id = 'medicamento_' + new Date().getTime();

    // Crear el contenedor para el select y la cantidad
    var div = document.createElement('div');
    div.classList.add('medicamento-entry');

    // Crear el select para los medicamentos
    var select = document.createElement('select');
    select.setAttribute('id', id + '_medicamento');
    select.setAttribute('name', 'medicamentos[' + id + '][medicamento]');
    select.classList.add('form-control');

    // Crear las opciones del select (medicamentos disponibles)
    medicamentosDisponibles.forEach(function(medicamento) {
        var option = document.createElement('option');
        option.setAttribute('value', medicamento); // El valor es el nombre del medicamento
        option.innerText = medicamento; // El texto visible es el nombre del medicamento
        select.appendChild(option);
    });

    // Crear el label para la cantidad
    var label = document.createElement('label');
    label.setAttribute('for', id + '_cantidad');
    label.classList.add('form-label');
    label.innerText = 'Cantidad';

    // Crear el input para la cantidad
    var input = document.createElement('input');
    input.setAttribute('type', 'number');
    input.setAttribute('id', id + '_cantidad');
    input.setAttribute('name', 'medicamentos[' + id + '][cantidad]');
    input.classList.add('form-control');

    // Agregar el select y el input al contenedor
    div.appendChild(select);
    div.appendChild(label);
    div.appendChild(input);

    // Agregar el contenedor de medicamento al contenedor principal
    document.getElementById('medicamentos').appendChild(div);
}
