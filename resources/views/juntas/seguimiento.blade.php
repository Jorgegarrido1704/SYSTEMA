@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<link rel="stylesheet" href="{{ asset('/dash/css/seguimientos.css') }}">


        <div class="row">
            <div class="col-lg-12 col-lx-12 col-md-12 mb-4">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-1 font-weight-bold text-primary">{{__("Color Identification")}}</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <input type="text" name="excelentWork" id="excelentWork" value="{{ __('Excelent Work') }}"  style="width: 120px; height: 30px;"  readonly>
                        <input type="text" name="onTime" id="onTime" value="{{ __('On Time') }}"  style="width:70px;  height: 30px;"  readonly>
                        <input type="text" name="onWorking" id="onWorking" value="{{ __('On precess') }}" style="width:85px;  height: 30px;"  readonly>
                        <input type="text" name="closeToexpiring" id="closeToexpiring" value="{{ __('close to expiring') }}"  style="width:135px; height: 30px;"  readonly>
                        <input type="text" name="delayedOnTime" id="delayedOnTime" value="{{ __('Delayed') }} & {{ __('On Time') }}"  style="width: 170px; height: 30px;"  readonly>
                        <input type="text" name="delayed" id="delayed" value="{{ __('Delayed') }}"  style="width: 80px; height: 30px;"  readonly>
                        <input type="text" name="delayedandclosedtoexpiring" id="delayedandclosedtoexpiring" value="{{ __('Delayed') }} & {{ __('close to expiring') }}"  style="width:225px;  height: 30px;"  readonly>
                        <input type="text" name="late" id="late" value="{{ __('Late') }}" style="width: 50px; height: 30px;"  readonly>
                        <input type="text" name="onHold" id="onHold" value="{{ __('On Hold') }}"  style="width: 70px; height: 30px;"  readonly>

                    </div>
                </div>
            </div>
           <div class="col-lg-12 col-lx-12 col-md-12 mb-4">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h4 class="m-1 font-weight-bold text-primary">{{ __('Order Status') }} </h4>
                        <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center flex-wrap">


                        <div class="d-flex align-items-center me-3">
                            <label class="mb-0 me-1" for="tooling">{{ __('Filter By PN') }}</label>
                            <input type="text" name="tooling" id="tooling" class="form-control form-control-sm ml-2 mr-2"  style="width: 85px;" onchange="filtroDeorndenes(this.value)">
                        </div>
                    </h6>
                    </div>
                    <div class="card-body" style="overflow-y: auto; ">

                        <div style="overflow-y: auto; height: 800px;" >
                            <table class="table table-bordered"  width="100%" cellspacing="0">
                                <thead style=" position: sticky; z-index: 0.1; top: 0; text-align: center; background-color: rgba(238, 136, 136, 0.95); color: white; ">
                                    <tr>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('Part Number') }}</th>
                                        <th>{{ __('Work Order') }}</th>
                                        <th>{{ __('Start Date') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Cut') }} & {{ __('Terminals') }}</th>
                                        <th>{{ __('Assembly') }}</th>
                                        <th>{{ __('Looming') }}</th>
                                        <th>{{ __('Quality') }}</th>
                                        <th>{{ __('Packing') }}</th>
                                    </tr>
                                </thead>
                              

                                        <tbody id="SeguimientoDeOrdenesDeTrabajo">
                                            
                                        </tbody>
                                    

                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
<script>
    function filtroDeorndenes(valores) {
    const url = "{{ route('jsonSeguimientos') }}";

    // Fix: Re-assign the uppercase value
    if (valores && valores.length > 0) {
        valores = valores.toUpperCase();
    } else {
        valores = 'all';
    }

    fetch(url, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ valores: valores }),
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
       // console.log("Data received:", data);
        
        const $container = $('#SeguimientoDeOrdenesDeTrabajo');
        $container.empty(); // Safer way to clear content in jQuery

        data.forEach((cut) => {
          //  console.log(cut);
            let detailUrl = `{{ url('juntas/seguimiento') }}/${cut[15]}`;

            $container.append(`
                <tr onclick="window.location.href='${detailUrl}'" style="cursor: pointer;">
                    <td id="${cut[16]}"><b>${cut[0]}</b></td>
                    <td id="${cut[16]}"><b>${cut[1]}</b></td>
                    <td id="${cut[16]}"><b>${cut[2]}</b></td>
                    <td ><b>${cut[3]}</b></td>
                    <td ><b>${cut[4]}</b></td>
                    <td id="${cut[10]}"><b>${cut[5]}</b></td>
                    <td id="${cut[11]}"><b>${cut[6]}</b></td>
                    <td id="${cut[12]}"><b>${cut[7]}</b></td>
                    <td id="${cut[13]}"><b>${cut[8]}</b></td>
                    <td id="${cut[14]}"><b>${cut[9]}</b></td>
                </tr>
            `);
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
}
    
onload= filtroDeorndenes(''); ;

</script>
    @endsection
