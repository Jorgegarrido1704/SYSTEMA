@extends('layouts.mainWithoutsidebar')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Movimientos </h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <style>
                                            table {     width: 100%;                     }
                                            td {text-align: center; border-bottom: solid 2px lightblue; }
                                            thead{background-color: #FC4747; color:white; text-align: center; }
                                            a{text-decoration: none; color: whitesmoke;  }
                                            a:hover{ text-decoration: none; color: white; font:bold;}
                                            input[type="file"] { border-radius: 4px;   background-color: blue; color: white; }
                                            input[type="file"]:hover { border-radius: 4px;  background-color: rgb(4, 95, 252); color: rgb(233, 223, 223); }
                                            #guardar { margin-top: 10%;  border-radius: 4px;  background-color: blue; color: white; }
                                            #guardar:hover { border-radius: 4px;  background-color: rgb(4, 95, 252); color: rgb(233, 223, 223); }
                                        </style>
                                        <table id="table-harness" class="table-harness">
                                            <thead>
                                                <th>Fecha</th>
                                                <th>Articulo</th>
                                                <th>Cantidad</th>
                                                <th>Moviemiento</th>
                                                <th>Wo</th>


                                            </thead>
                                            <tbody>



                                            </tbody>
                                            <tbody>




                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                    <!-- Card scaneer -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Registro de entradas</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div align="center">
                                            <h1>Carga tu archivo .cvs</h1>

                                            <input type="file" id="file" name="file" accept=".csv" />

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">


                                <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary"> Carga tu archivo .cvs   </h5>

                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <div class="row" >
                                        <form id="uploadForm" action="{{route('savedataAlm')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" id="fileInput" name="fileInput" accept=".csv" />
                                            <input type="hidden" name="set_Data" id="set_Data">
                                            <input type="hidden" name="set_Qty" id="set_Qty">
                                            <input type="submit" name="enviar" id="enviar" value="Cargar">
                                        </form>

                                        <table id="dataTable" border="1">
                                          <thead>
                                            <tr>
                                              <th>Item</th>
                                              <th>Qty</th>
                                            </tr>
                                          </thead>
                                          <tbody>

                                          </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--table of works -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Entrada de Material </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">

                                </div>
                            </div>
                        </div>


                        <!-- Column 2 -->

                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary"> </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <th>Item</th>
                                                <th>Qty</th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Boms combiandos </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; max-height: 760px;">
                                    <div class="row" >

                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.getElementById('fileInput').addEventListener('change', function(event) {
                                    const file = event.target.files[0];
                                    const reader = new FileReader();

                                    reader.onload = function(e) {
                                        const content = e.target.result;
                                        const lines = content.split('\n');
                                        const data = [];
            const qty = [];
                                        const tableBody = document.querySelector('#dataTable tbody');
                                        tableBody.innerHTML = '';

                                        for (let i = 1; i < lines.length; i++) {
                                        const columns = lines[i].split(',');

                                        if (columns.length >= 2)  {
                                            const g2Value = columns[0].trim();
                                            const m2Value = columns[1].trim();

                                            const row = document.createElement('tr');
                                            const g2Cell = document.createElement('td');
                                            const m2Cell = document.createElement('td');

                                            g2Cell.textContent = g2Value;
                                            m2Cell.textContent = m2Value;

                                            data.push(g2Value);
                                            qty.push(m2Value);

                                            row.appendChild(g2Cell);
                                            row.appendChild(m2Cell);

                                            tableBody.appendChild(row);
                                        }
                                        }

                                        document.getElementById("set_Data").value = JSON.stringify(data);
                                          document.getElementById("set_Qty").value = JSON.stringify(qty);


                                        sendDataToServer(data);
                                        sendDataToServer(qty);

                                    };

                                    reader.readAsText(file);
                                    });

                                    function sendDataToServer(data) {
  // Aquí puedes realizar una petición AJAX para enviar los datos al servidor
  console.log('Datos a enviar al servidor:', data);
}
                        </script>
                    @endsection

