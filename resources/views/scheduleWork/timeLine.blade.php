@extends('layouts.main')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
    <script>
   function updateTimes() {
    const qty = parseInt(document.getElementById("qty").value) || 1;
    const rows = document.querySelectorAll("tbody tr");
    let finalTotalTime = 0;

    rows.forEach((row, index) => {
        const timePerProcess = parseFloat(document.getElementById(`timePerProcess_${index}`).value) || 0;
        const setupTime = parseFloat(document.getElementById(`setup_${index}`).value) || 0;
        const qtyTimes = parseFloat(document.getElementById(`QtyTimes${index}`).value) || 0;

        const totalTime = (qty*qtyTimes) * timePerProcess;
        const sumTime = setupTime + totalTime;
        const finalTime =  qtyTimes;


        document.getElementById(`total_${index}`).value = totalTime.toFixed(3);
        document.getElementById(`sum_${index}`).value = sumTime.toFixed(3);
        document.getElementById(`QtyTimes${index}`).value = finalTime.toFixed(0);

        finalTotalTime += totalTime+setupTime;
        minutes = (finalTotalTime / 60).toFixed(0) +" : "+ (finalTotalTime % 60).toFixed(0);
        hours= (finalTotalTime / 3600).toFixed(0) +" : "+ ((finalTotalTime % 3600) / 60).toFixed(0) +" : "+ ((finalTotalTime % 3600) % 60).toFixed(0);
       // console.log("time per process por qty :"+(timePerProcess * qty)+" + setupTime: " +setupTime+ " total: "+finalTotalTime);
    });
    document.getElementById("totalTime").value = finalTotalTime.toFixed(0);
    document.getElementById("timesInMinutes").value = minutes;
    document.getElementById("timesInHours").value = hours;
}


    </script>
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4 text-center">Time Line</h2>
            <div class="vsm-container">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
            <div class="card shadow mb-6">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Total Time in seconds </h5>
                    </div>
                    <!-- table Body -->
                    <div class="card-body" style="overflow-y: auto; ">
                        <div class='row'>
                        <div class="col-md-6 ">
                            <form action="{{ route('timeLine') }}" method="GET">
                            <label for="np" class="form-label">Part Number: </label>
                            <input type="text" class="form-input" id="np" name="np" stytle="width: 50px;">
                            <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                                <div class="form-group " style="margin-left: 20px;">
                            <label for="qty" class="form-label">Quanty: </label>
                            <input type="text" class="form-input" id="qty" name="qty" value="0" onchange="updateTimes();">
                                 </div>
                             </div>
                             <div class="col-md-6 ">
                                <h5>Seconds <input type="text" id="totalTime" name="totalTime" readonly style="width: 150px;"></h5>
                                 <h5>Minutes <input type="text" id="timesInMinutes" name="timesInMinutes" readonly style="width: 150px;"></h5>
                                  <h5>Hours  <input type="text" id="timesInHours" name="timesInHours" disabled style="width: 150px;"></h5>
                             </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
            <div class="card shadow mb-6">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Routing   NP: @if (!empty($_GET['np']))
                        {{ $_GET['np'] }}
                    @else
                        {{ '1001489409' }}

                    @endif</h5>
                </div>

                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th> Operation Number / Step </th>
                                    <th> Description </th>
                                    <th> Machine/Tool Required </th>
                                    <th> Setup Time </th>
                                    <th>Times Per Proccess </th>
                                    <th> Cycle Time </th>
                                    <th> Total Cycle Time </th>
                                    <th> Total Time </th>

                                </tr>
                            </thead>
                           <tbody>
                                @foreach ($registros as $registro)
                                    <tr>
                                        <td><input type="text" value="{{ $registro->work_routing }}" readonly></td>
                                        <td><input type="text" value="{{ $registro->work_description }}" readonly></td>
                                        <td><input type="text" value="{{ $registro->posible_stations }}" readonly></td>

                                        <td><input type="text" id="setup_{{ $loop->index }}" value="{{ $registro->setUp_routing }}" readonly></td>
                                         <td><input type="text" id="QtyTimes{{ $loop->index }}" value="{{ $registro->QtyTimes }}" readonly></td>
                                        <td><input type="text" id="timePerProcess_{{ $loop->index }}" value="{{ $registro->timePerProcess }}" readonly></td>

                                        <td><input type="text" id="total_{{ $loop->index }}" readonly></td>
                                        <td><input type="text" id="sum_{{ $loop->index }}" readonly></td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
