@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
 @if(!empty(session('message')))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('message') }}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
 </div>
 @endif
 <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                    <h6 class="m-0 font-weight-bold text-primary">{{ ('CVTS Orders Audit') }}</h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; ">
                    <form action="{{route ('auditorias.safeData')}}" method="GET" >
                        <table class='table table-resposibe'> 
                            <thead>
                                <tr>
                                    <th>{{ __('Work Order') }}</th>
                                    <th>{{ __('Part Number') }}</th>
                                    <th>{{ __('Physically Located') }}</th>
                                    <th>{{ __('System Location') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Resposable') }}</th>
                                </tr>
                            </thead>
                            <tbody id="formato"> </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">{{ __('Save')}}</button>
                    </form>

                </div>
            </div>

        </div>
</div>

<script>
    window.addEventListener("load", cargando);
    
    function cargando(){
        const formato = document.getElementById('formato')
        var html='';
        
      for(i=1;i<=2;i++){
        html +=`  <tr>
                                            <td><input type="text" name="work_order[]" id="work_order${i}"  onchange="workInfo(this.value,${i})"></td>
                                            <td><input type="text" name="part_number[]" id="part_number${i}"  readonly></td>
                                            <td><select name="physically_located[]" id="physically_located${i}" required>
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="Plannig">Plannig</option>
                                                    <option value="Cutting">Cutting</option>
                                                    <option value="Assembly">Assembly</option>
                                                    <option value="Loom">Loom</option>
                                                    <option value="Testing">Testing</option>
                                                    <option value="Packing">Packing</option>
                                                </select></td>
                                            <td><select name="system_location[]" id="system_location${i}" required onchange="status(${i})"> </select></td>
                                            <td><input type="text" name="status[]"  id="status${i}" readonly></td>
                                           
                                            <td><select name="resposable[]" id="resposable${i}" required>
                                                <option value="" disabled selected>Select</option>
                                                @foreach($responsables as $responsable)
                                                    <option value="{{ $responsable->employeeLider }}">{{ $responsable->employeeLider }}</option>
                                                @endforeach
                                            </select></td>
                                        </tr>    `
        
      }
      formato.innerHTML=html;
    }
    function workInfo(wo,id){
        const url ='/auditoria/woinfo?wo='+wo;
       fetch(url)
        .then((response) => response.json())
        .then((data) => {
           console.log(data);
            document.getElementById('part_number'+id).value = data[0].pn;
           var cort = data[0].cortPar+data[0].libePar+data[0].precut+data[0].preterm+data[0].tobecut+data[0].tobeterm
            var ensa = data[0].ensaPar+data[0].preassembly+data[0].specialWire+data[0].tobeassembly
            var loom = data[0].loomPar+data[0].preloom+data[0].tobeloom
            var plan = data[0].planpar;
            var test = data[0].preCalidad+data[0].testPar;
            var options = '<option value="" disabled selected>Select</option>';
            if(plan >0){
                options +=  '<option value="Planning" >Planning</option>';
            }
            if(cort >0){
                options +=  '<option value="Cutting" >Cutting</option>';
            }if(ensa >0){
                options +=  '<option value="Assembly" >Assembly</option>';
            }if(loom >0){
                options +=  '<option value="Loom" >Loom</option>';
            }if (test > 0){
                options +=  '<option value="Testing" >Testing</option>';
            }
            document.getElementById('system_location'+id).innerHTML =options;

        })
        .catch((error) => {
            console.error("Error:", error);
            alert('No existe el código');
        });
    }
    function status(id){
            let system =document.getElementById('system_location'+id).value;
            let physical =document.getElementById('physically_located'+id).value;
            if(system == physical){
                document.getElementById('status'+id).value = "OK";
            }else{
                 document.getElementById('status'+id).value = "NOK";
            }
        }
  
</script>

 @endsection
