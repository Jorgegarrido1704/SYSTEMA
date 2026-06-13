@extends('layouts.main')

@section('contenido')

<!-- Page Heading -->
    
 <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
    <div class="row">
        <div class="col-lg-12 col-lx-12">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Buscar WO</h5>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="WO" aria-label="WO" aria-describedby="basic-addon2" onchange="buscarWO(this.value)">
                           
                        </div>
                    </div>
                    <div class="card-body" style="overflow-y: auto; height: 360px;" >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>PN</th>
                                    <th>WO</th>
                                    <th>ITEM</th>
                                    <th>QTY</th>
                                    <th>FirstCount</th>
                                    <th>SecondCount</th>
                                </tr>
                            </thead>
                            <tbody id="workOrders">
                              <!--
                             
                            -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
             <div class="col-lg-12 col-lx-12">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Listas de Corte</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; height: 360px;"  >

                    </div>
                </div>
            </div>

    </div>

    <script>
        function buscarWO(WO){
            fetch('/getDatosInventarioWork?workOrder='+WO)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                var workOrders = document.getElementById('workOrders');
                workOrders.innerHTML = '';
                datos = data.data;
               datos.forEach(item => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${item.pn}</td>
                                        <td>${item.wo}</td>
                                        <td>${item.item}</td>
                                        <td>${item.qty}</td>
                                        <td><input type="number" value="0" step="0.01" min="0"></td>
                                        <td><input type="number" value="0" step="0.01" min="0"></td>
                                       
                                    `;
                                    workOrders.appendChild(row);
                                });
                
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        </script>
@endsection
