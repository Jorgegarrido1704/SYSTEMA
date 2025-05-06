
        function changework(action) {
            var areaToChange = document.getElementById('work');
            var TableChange = document.getElementById('tableChange');
            // Clear existing content
            areaToChange.innerHTML = '';
            TableChange.innerHTML = '';


            // Depending on the selected action, update the area content
            switch (action) {
                case 'desviation':
                    areaToChange.innerHTML = `
            <div class="desv" align="center">
                            <form  id="formula" action="{{ route('desviation') }}" method="POST">
                                @csrf
                    <div class="form-group">
                        <label for="modelo">Modelo Afectado:</label>
                        <input type="text" class="form-control" name="modelo" id="modelo" placeholder="B222930" required>
                    </div>
                    <div class="form-group">
                        <label for="numPartOrg">No° de parte original:</label>
                        <input type="text" class="form-control" name="numPartOrg" id="numPartOrg" placeholder="TT2-171" required>
                    </div>
                    <div class="form-group">
                        <label for="numPartSus">No° parte sustituto:</label>
                        <input type="text" class="form-control" name="numPartSus" id="numPartSus" placeholder="DT1-17" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Periodo de la desviacion:</label>
                        <input type="text" class="form-control" name="time" id="time" placeholder="12-12-2023" required>
                    </div>
                    <div class="form-group">
                        <label for="cant">Cantidad limitada de piezas a sustituir:</label>
                        <input type="number" class="form-control" name="cant" id="cant" placeholder="1200" required>
                    </div>
                    <div class="form-group">
                        <label for="text">Causa de desviacion:</label>
                        <input class="form-control" name="text" id="text" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="acc">Accion preventiva:</label>
                        <input class="form-control" name="acc" id="acc" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="evi">Evidencia:</label>
                        <input class="form-control" name="evi" id="evi" rows="3" required></textarea>
                    </div>


                    <input type="submit" class="btn btn-primary" name="enviar" id="enviar" value="Save">
                </form>            </div>

            `;
                    TableChange.innerHTML = `
            <div class="row" >
                                                    <table>
                                                        <thead>
                                                            <th>Folio</th>
                                                            <th>Modelo</th>
                                                            <th>Parte Original</th>
                                                            <th>Parte Sustituto</th>
                                                            <th>Cliente</th>
                                                            <th>Firma Compras</th>
                                                            <th>Firma ingenieria</th>
                                                            <th>Firma Calidad</th>
                                                            <th>Firma Produccion</th>
                                                            <th>Firma Imex</th>
                                                            <th>Fecha</th>
                                                            </thead>
                                                        <tbody>
                                                            @if (!empty($desviations))
                                                    @foreach ($desviations as $desviation)
                                                            <tr>
                                                                <td>{{ $desviation[0] }}</td>
                                                                <td>{{ $desviation[1] }}</td>
                                                                <td>{{ $desviation[2] }}</td>
                                                                <td>{{ $desviation[3] }}</td>
                                                                <td>{{ $desviation[4] }}</td>
                                                                <td>{{ $desviation[5] }}</td>
                                                                <td>{{ $desviation[6] }}</td>
                                                                <td>{{ $desviation[7] }}</td>
                                                                <td>{{ $desviation[8] }}</td>
                                                                <td>{{ $desviation[9] }}</td>
                                                                <td>{{ $desviation[10] }}</td>

                                                                </tr>
                                                    @endforeach
                                                    @endif
                                                        </tbody>
                                                    </table>

                                                </div>
            `;
                    break;
                case 'Materials':
                    // Default case: Show default table content
                    areaToChange.innerHTML = `
                        <div align="center">
                        <form id="formula" action="{{ route('material') }}" method="POST">
                            @csrf
            <div style="margin-bottom: 10px;">
                <label for="cant1" style="margin-right: 10px;">Cantidad</label>
                <input type="number" style="width: 60px; margin-right: 10px;" name="cant1" id="cant1" min="0" required>
                <label for="articulo1" style="margin-right: 10px;">Artículo</label>
                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo1" id="articulo1" required>
                <label for="notas_adicionales1" style="margin-right: 10px;">Notas adicionales</label>
                <input type="text" style="width: 200px;" name="notas_adicionales1" id="notas_adicionales1" required>
            </div>

            <div style="margin-bottom: 10px;">
                <label for="cant2" style="margin-right: 10px;">Cantidad</label>
                <input type="number" style="width: 60px; margin-right: 10px;" name="cant2" id="cant2" min="0" >
                <label for="articulo2" style="margin-right: 10px;">Artículo</label>
                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo2" id="articulo2">
                <label for="notas_adicionales2" style="margin-right: 10px;">Notas adicionales</label>
                <input type="text" style="width: 200px;" name="notas_adicionales2" id="notas_adicionales2" >
            </div>

            <div style="margin-bottom: 10px;">
                <label for="cant3" style="margin-right: 10px;">Cantidad</label>
                <input type="number" style="width: 60px; margin-right: 10px;" name="cant3" id="cant3" min="0" >
                <label for="articulo3" style="margin-right: 10px;">Artículo</label>
                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo3" id="articulo3">
                <label for="notas_adicionales3" style="margin-right: 10px;">Notas adicionales</label>
                <input type="text" style="width: 200px;" name="notas_adicionales3" id="notas_adicionales3" >
            </div>

            <div style="margin-bottom: 10px;">
                <label for="cant4" style="margin-right: 10px;">Cantidad</label>
                <input type="number" style="width: 60px; margin-right: 10px;" name="cant4" id="cant4" min="0" >
                <label for="articulo4" style="margin-right: 10px;">Artículo</label>
                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo4" id="articulo4">
                <label for="notas_adicionales4" style="margin-right: 10px;">Notas adicionales</label>
                <input type="text" style="width: 200px;" name="notas_adicionales4" id="notas_adicionales4" >
            </div>

            <div style="margin-bottom: 10px;">
                <label for="cant5" style="margin-right: 10px;">Cantidad</label>
                <input type="number" style="width: 60px; margin-right: 10px;" name="cant5" id="cant5" min="0" >
                <label for="articulo5" style="margin-right: 10px;">Artículo</label>
                <input type="text" style="width: 200px; margin-right: 10px;" name="articulo5" id="articulo5">
                <label for="notas_adicionales5" style="margin-right: 10px;">Notas adicionales</label>
                <input type="text" style="width: 200px;" name="notas_adicionales5" id="notas_adicionales5" >
            </div>
            <div ><input type="submit" id="submit" value="Send"></div>
            </form>
            </div>

                        `;
                    TableChange.innerHTML = `
                        <div class="row" >
                                                    <table>
                                                        <thead>
                                                            <th>Folio</th>
                                                            <th>Descripcion</th>
                                                            <th>Notas</th>
                                                            <th>Cantidad</th>
                                                            <th>Status</th>
                                                        </thead>
                                                        <tbody>
                                                            @if (!empty($materials))
                                                    @foreach ($materials as $material)
                                                            <tr>
                                                                <td>{{ $material[0] }}</td>
                                                                <td>{{ $material[1] }}</td>
                                                                <td>{{ $material[2] }}</td>
                                                                <td>{{ $material[3] }}</td>
                                                                <td>{{ $material[4] }}</td>

                                                            </tr>
                                                    @endforeach
                                                    @endif

                                                        </tbody>
                                                    </table>

                                                </div>
                        `;
                    break;
                case 'Maintanience':
                    // Default case: Show default table content
                    areaToChange.innerHTML = `
                        <div class="row" >
                                            <form  action="{{ route('maintananceGen') }}" method="POST">
                                                    @csrf
                                                        <div class="form-group">
                                                    <label for="nom_equipo">Equipo:</label>
                                                <select id="nom_equipo" name="nom_equipo" class="form-control" required>
                                                    <option value=""></option>
                                                        <option value="S/N">S/N</option>
                                                        </select>
                                                        </div>
                                                        <div class="form-group">
                                                    <label for="dano">Daño del equipo</label>
                                                    <input type="text" id="dano" name="dano" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="quien">Quien solicita</label>
                                                    <input type="text" id="quien" name="quien" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="area">Area que solicita</label>
                                                    <input type="text" id="area" name="area" class="form-control"  required>
                                                    </div>
                                                    </form>
                                        </div>`;
                    TableChange.innerHTML = `
                        <div class="row" >
                                                    <table>
                                                        <thead>
                                                            <th>Fecha</th>
                                                            <th>Team</th>
                                                            <th>trabajo</th>
                                                            <th>Tipo de reparacion</th>
                                                            <th>Status</th>
                                                        </thead>
                                                        <tbody>
                                                    @if (!empty($paros))
                                                    @foreach ($paros as $paro)
                                                            <tr>
                                                                <td>{{ $paro[0] }}</td>
                                                                <td>{{ $paro[1] }}</td>
                                                                <td>{{ $paro[2] }}</td>
                                                                <td>{{ $paro[3] }}</td>
                                                                <td>{{ $paro[4] }}</td>
                                                            </tr>
                                                    @endforeach
                                                    @endif
                                                        </tbody>
                                                    </table>

                                                </div>
                        `;
                case ('full'):
                    // Default case: Show default table content
                    areaToChange.innerHTML = `
                                                    <form  action="{{ route('regfull') }}" method="POST">
                                                    @csrf
                                                        <div class="form-group">
                                                    <label for="cliente">Cliente:</label>
                                                <select id="cliente" name="cliente" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="BROWN">BROWN</option>
                                                        <option value="DUR-A-LIFT">DUR-A-LIFT</option>
                                                        <option value="BERSTROMG">BERGSTROM</option>
                                                        <option value="BLUE BIRD">BLUE BIRD</option>
                                                            <option value="ATLAS">ATLAS</option>
                                                            <option value="UTILIMASTER">UTILIMASTER</option>
                                                            <option value="CALIFORNIA">CALIFORNIA</option>
                                                            <option value="TICO MANUFACTURING">TICO MANUFACTURING</option>
                                                            <option value="SPARTAN">SPARTAN</option>
                                                            <option value="PHOENIX">PHOENIX</option>
                                                            <option value="FOREST RIVER">FOREST RIVER</option>
                                                            <option value="SHYFT">SHYFT</option>
                                                            <option value="KALMAR">KALMAR</option>
                                                            <option value="MODINE">MODINE</option>
                                                            <option value="NILFISK">NILFISK</option>
                                                            <option value="PLASTIC OMNIUM">PLASTIC OMNIUM</option>
                                                            <option value="ZOELLER">ZOELLER</option>
                                                            <option value="COLLINS">COLLINS</option>
                                                        </select>
                                                        </div>
                                                        <div class="form-group">
                                                    <label for="parte">Numero de Parte</label>
                                                    <input type="text" id="parte" name="parte" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="rev">Revision</label>
                                                    <input type="text" id="rev" name="rev" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="cant">Cantidad</label>
                                                    <input type="number" id="cant" name="cant" class="form-control" min="1" required>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="tablero">Tablero</label>
                                                    <input type="text" id="tablero" name="tablero" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                    <input type="submit" id="submit" class="btn btn-primary" value="solicitar">
                                                    </div>
                                                </tr>
                                                    </form>


                                                        `;
                    TableChange.innerHTML = `
                        <div class="row" >
                                                    <table>
                                                        <thead>
                                                            <th>Fecha de solicitud</th>
                                                            <th>Cliente</th>
                                                            <th>Numero de Parte</th>
                                                            <th>Revision</th>
                                                            <th>Cantidad</th>
                                                            <th>Status</th>
                                                        </thead>
                                                        <tbody>
                                                    @if (!empty($fulls))
                                                    @foreach ($fulls as $full)
                                                            <style>
                                                    @if ($full[5] == 'Pendiente')
                                                        #est{ background-color='ligthblue';}
                                                    @elseif ($full[5] == 'En proceso')
                                                            <tr style="background-color='ligthgreen'">
                                                    @elseif ($full[5] == 'Pausado')
                                                            <tr style="background-color='red';">
                                                            @endif
                                                            </style>
                                                            <tr>
                                                                <td id="est" style="background-color=red;">{{ $full[0] }}</td>
                                                                <td id="est">{{ $full[3] }}</td>
                                                                <td id="est">{{ $full[1] }}</td>
                                                                <td id="est">{{ $full[2] }}</td>
                                                                <td id="est">{{ $full[4] }}</td>
                                                                <td id="est">{{ $full[5] }}</td>
                                                            </tr>
                                                    @endforeach
                                                    @endif

                                                        </tbody>
                                                    </table>

                                                </div>
                        `;
                    break;
                case ('help'):
                    // Default case: Show default table content
                    areaToChange.innerHTML = `
                                                <form class="row g-3" action="{{ route('problemas_general') }}" method="POST">
                                                @csrf
                                                    <div class="col-md-6">
                                                    <label for="pnIs" class="form-label">Part Number</label>
                                                    <input type="text" class="form-control" name="pnIs" id="pnIs" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label for="workIs" class="form-label">Work Order</label>
                                                    <input type="text" class="form-control" name="workIs" id="workIs"  minlength="6" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label for="revIs" class="form-label">Revision</label>
                                                    <input type="text" class="form-control" name="revIs" id="revIs" minlength="1" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                    <label for="probIs" class="form-label">Problem</label>
                                                    <select id="probIs"  name="probIs" class="form-select" required>
                                                        <option selected>...</option>
                                                        <option value = "Prosses Error">Prosses Error</option>
                                                        <option value = "Paper work">Paper work</option>
                                                        <option value = "Both(Prosses Error and Paper work)">Both(Prosses Error and Paper work)</option>
                                                        <option value = "Other">Other</option>
                                                    </select>
                                                    </div>
                                                    <div class="col-md-9">
                                                    <label for="descIs" class="form-label">Description</label>
                                                    <textarea class="form-control"  name="descIs" id="descIs" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label for="answer" class="form-label">Was the problem fixed it</label>
                                                    <select id="answer" name="answer" class="form-select" required>
                                                        <option selected>...</option>
                                                        <option value = "Yes">Yes</option>
                                                        <option value = "No">No</option>
                                                        <option value = 'No yet'>No yet</option>
                                                    </select>

                                                    <div class="col-md-12">
                                                        <label for="val" class="form-label">Validation By</label>

                                                    </div>
                                                    </div>
                                                    <div class="col-12">
                                                    <button type="submit" class="btn btn-primary">Send Info</button>
                                                    </div>
                                                </form>
                                                        `;
                    TableChange.innerHTML = `
                        <div class="row" >
                                                    <table>
                                                        <thead>
                                                            <th>Fecha de solicitud</th>
                                                            <th>Cliente</th>
                                                            <th>Numero de Parte</th>
                                                            <th>Revision</th>
                                                            <th>Cantidad</th>
                                                            <th>Status</th>
                                                        </thead>
                                                        <tbody>
                                                    @if (!empty($fulls))
                                                    @foreach ($fulls as $full)
                                                            <style>
                                                    @if ($full[5] == 'Pendiente')
                                                        #est{ background-color='ligthblue';}
                                                    @elseif ($full[5] == 'En proceso')
                                                            <tr style="background-color='ligthgreen'">
                                                    @elseif ($full[5] == 'Pausado')
                                                            <tr style="background-color='red';">
                                                            @endif
                                                            </style>
                                                            <tr>
                                                                <td id="est" style="background-color=red;">{{ $full[0] }}</td>
                                                                <td id="est">{{ $full[3] }}</td>
                                                                <td id="est">{{ $full[1] }}</td>
                                                                <td id="est">{{ $full[2] }}</td>
                                                                <td id="est">{{ $full[4] }}</td>
                                                                <td id="est">{{ $full[5] }}</td>
                                                            </tr>
                                                    @endforeach
                                                    @endif

                                                        </tbody>
                                                    </table>

                                                </div>
                        `;
                    break;


            }
        }

        document.forms["formula"].onsubmit = function() {
            var peri = document.getElementById('time').value;
            var cantsus = document.getElementById('cant').value
            var text = document.getElementById('texthidden').value = document.getElementById('text').innerHTML;
            var model = document.getElementById('modelo').value;
            var numPartOrg = document.getElementById('numPartOrg').value;
            var numPartSus = document.getElementById('numPartSus').value;
            var evi = document.getElementById('evihidden').value = document.getElementById('evi').innerHTML;
            var acc = document.getElementById('acchidden').value = document.getElementById('acc').innerHTML;
            var client = document.getElementById('cliente').value;
            if (model == '' || text == '' || numPartOrg == '' || numPartSus == '' || client == '' || acc == "") {
                alert('Falta de por ingresar alguen dato, por favor verifiquelo');
                return false;
            }
        }

        // Populate second select based on the selected option from the first select
        function updateSecondSelect() {
            var firstSelect = document.getElementById("equipo");
            var secondSelect = document.getElementById("dano");

            // Clear existing options
            secondSelect.innerHTML = "";

            // Populate second select based on the selected option from the first select
            if (firstSelect.value === "Mantenimiento") {

                var nulo = new Option("Maquina de corte", "Maquina de corte");
                var option1 = new Option("Impresora maquina corte", "Impresora maquina corte");
                var option2 = new Option("Banda maquina de corte", "Banda maquina de corte");
                var option_3 = new Option("Falla electrica corte", "Falla electrica corte");
                var option3 = new Option("Cambio de aplicador", "Cambio de aplicador");
                var option4 = new Option("Falla electrica aplicador", "Falla electrica aplicador");
                var option_a = new Option("Ajuste de aplicador", "Ajuste de aplicador");
                var option_b = new Option("Ajuste de presión", "Ajuste de presión");
                var option_c = new Option("Colocacion de pernos", "Colocacion de pernos")
                var option_d = new Option("Quitar pernos", "Quitar pernos");
                var option_e = new Option("Empalmadora", "Empalmadora");
                var option_f = new Option("Banco ajuste de presion", "Banco ajuste de presion");
                var option_g = new Option("Banco colocacion de herramental", "Banco colocacion de herramental")
                var option_h = new Option("Equipo de computo", "Equipo de computo");

                secondSelect.appendChild(nulo);
                secondSelect.appendChild(option1);
                secondSelect.appendChild(option2);
                secondSelect.appendChild(option_3);
                secondSelect.appendChild(option4);
                secondSelect.appendChild(option3);
                secondSelect.appendChild(option_a);
                secondSelect.appendChild(option_b);
                secondSelect.appendChild(option_c);
                secondSelect.appendChild(option_d);
                secondSelect.appendChild(option_e);
                secondSelect.appendChild(option_f);
                secondSelect.appendChild(option_g);
                secondSelect.appendChild(option_h);
            } else if (firstSelect.value === "Ingenieria") {

                var option5 = new Option("Soporte ", "Soporte");
                var option6 = new Option("Colocacion FULL size", "Colocacion FULL size");
                var option5_1 = new Option("Seguimiento de nuevo producto", "Seguimiento de nuevo producto");

                secondSelect.appendChild(option5);
                secondSelect.appendChild(option6);
                secondSelect.appendChild(option5_1);
            } else if (firstSelect.value === "Calidad") {

                var option7 = new Option("Validacion de medidas", "Validacion de medidas");
                var option8 = new Option("Liberacion de terminales", "Liberacion de terminales");
                var option9 = new Option("Pull Test", "Pull Test");;
                secondSelect.appendChild(option7);
                secondSelect.appendChild(option8);
                secondSelect.appendChild(option9);

            } else if (firstSelect.value === "Almacen") {
                var option_1a = new Option("Entrega de Kits", "Entrega de Kits");
                secondSelect.appendChild(option_1a);

            }
        }
        updateSecondSelect();
