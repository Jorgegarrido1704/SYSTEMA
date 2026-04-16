<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">

        </div>
        <div class="sidebar-brand-text mx-3">CTVS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @if (!empty($cat))

        @if ($cat == 'Admin')
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span class="PO" id="PO">Order register</span></a>
                <ul class="submenu" id="submenu">
                    <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('po') }}">Set Po</a>
                    </li>
                    <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('label') }}">Print
                            Labels</a></li>
                </ul>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Requirements</span></a>
                <ul class="submenu" id="submenu">
                    <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('po') }}">Set Po</a>
                    </li>
                    <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('po') }}">Set Po</a>
                    </li>
                    <li class="submenu" id="submenu">Print Barcode</li>
                    <li class="submenu" id="submenu">Print Labels</li>
                </ul>
            </li>
        @endif


        <li class="nav-item active">
            @if ($cat == 'junta')
                <a class="nav-link" href="/juntas">
                @elseif($cat == 'RRHH')
                    <a class="nav-link" href="/RRHH">
                    @elseif($cat == 'plan')
                        <a class="nav-link" href="/planing">
                        @elseif($cat == 'cali')
                            <a class="nav-link" href="/calidad">
                            @elseif($cat == 'nurse')
                                <a class="nav-link" href="/salud">
                                @elseif($cat == 'inge')
                                    <a class="nav-link" href="/ing">
                                    @elseif($cat == 'SupAdmin')
                                        <a class="nav-link" href="/SupAdmin">
                                            @elseif($cat == 'mante')
                                                 <a class="nav-link" href="/mantainence">
                                        @else
                                            <a class="nav-link" href="/general">
            @endif
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{__('Home')}}</span></a>
            <ul class="submenu" id="submenu">
                <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('index_junta') }}">{{ __('Sales') }}</a>
                </li>
                <li class="submenu" id="submenu"><a style="color:white;"
                        href="{{ route('calidad_junta') }}">{{ __('Quality') }}</a></li>
                <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('ing_junta') }}"
                        onmouseover=showEng();>{{ __('engineering') }}</a>
                        @if($cat=='inge' || $value=='Admin')
                    <ul class="submenu" id="engsub" style="display:none;">
                        <li class="submenu" id="engsub"><a style="color:white;" href="{{ route('workState') }}">{{ __('Work Scheduled') }}</a></li>
                        <li class="submenu" id="engsub"><a style="color:white;" href="{{ route('ganttGraph') }}">{{ __('Gantt Work Graph') }}</a></li>
                        <li class="submenu" id="engsub"><a style="color:white;" href="{{ route('pruebasElecticas') }}">{{ __('Electrical Tests') }}</a></li>
                        <li class="submenu" id="engsub"><a style="color:white;" href="#">{{ __('Engineer Scheduleeng') }}</a>
                        </li>
                    </ul>
                        @endif
                </li>
                <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('rhDashBoard') }}"
                    onmouseover=showRRHH();>{{ __('HR') }}</a></li>
                     <ul class="submenu" id="RRHH" style="display:none;">
                        @if($value=='Admin' || $cat=='RRHH')
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('rrhhDashBoard') }}">{{ __('Assistance') }}</a></li>
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('relogChecador') }}">{{ __('Log check') }}</a></li>
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('datosPersonal') }}">{{ __('Personal Data') }}</a></li>
                        @endif
                         @if($value=='Admin' || $cat=='RRHH' || $value=='Juan O' || $value=='David V' || $value=='Jesus_C' || $value=='Andrea P' || $value=='Javier C')
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('personalShift') }}">{{ __('Personal Shift') }}</a></li>
                        @endif
                    </ul>

                <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('seguimientos') }}"
                    onmouseover=showProduction();>{{ __('Production States') }}</a>
                    <ul class="submenu" id="production" style="display:none;">
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('litas_reg') }}">{{ __('Search Info') }}</a></li>
                        @if($value=='Admin')
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('cutAndTerm') }}">{{ __('Cut & Terminals') }}</a></li>
                        <li class="submenu" id="submenu"><a style="color:white;" href="#">{{ __('Assembly & Looming') }}</a></li>
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('corte.indexCorte') }}">{{ __('Terminals Info') }}</a></li>
                        @endif
                    </ul>
                </li>
                @if($value=='Admin')
                 <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('vsm_schedule') }}"
                    onmouseover=showSchedule();>{{ __('Value Stream Mapping') }}</a>
                    <ul class="submenu" id="schedule" style="display:none;">
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('timeLine') }}">{{ __('Time Study') }}</a></li>
                    </ul>
                </li>
                @endif
                @if($value=='Admin' || $cat=='herra')
                 <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('herramentales.index') }}"
                    onmouseover=showHerramentales();>{{ __('Toolings') }}</a>
                    <ul class="submenu" id="herramentales" style="display:none;">
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('toolingMaintenance') }}">{{ __('Toolings Maintenance') }}</a></li>
                        <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('toolingAnalysis') }}">{{ __('Toolings Analysis') }}</a></li>

                    </ul>
                </li>
                @endif
                <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('rrhhDashBoard') }}">{{ __('Assistance') }}</a></li>
                <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('Pendings.index') }}">{{ __('Pendings') }}</a></li>
                 <li class="submenu" id="engsub"><a style="color:white;" href="{{ route('vacations') }}">{{ __('Vacations') }}</a></li>
                 <li class="submenu" id="engsub"><a style="color:white;" href="{{ route('juntas.npi') }}">{{ __('NPI') }}</a></li>
                  <li class="submenu" id="submenu"><a style="color:white;" href="{{ route('accionesCorrectivas.index') }}">{{ __('Corrective Actions') }}</a></li>
                @if($value=='Valeria P' || $value=='Admin' || $value=='Jose Luis' || $value=='Jesus_C' )
                <li class="submenu" id="engsub"><a style="color:white;" href="{{ route('testingMaterialRequeriment') }}">{{ __('Requeriment Materials Testing') }}</a></li>
                @endif
            </ul>
        </li>



    @endif

</ul>
<script>
    function showProduction() {
        var productionMenu = document.getElementById("production");
        if (productionMenu.style.display === "none" || productionMenu.style.display === "") {
            productionMenu.style.display = "block";
        } else {
            productionMenu.style.display = "none";
        }
    }
    function showEng() {
        var engMenu = document.getElementById("engsub");
        if (engMenu.style.display === "none" || engMenu.style.display === "") {
            engMenu.style.display = "block";
        } else {
            engMenu.style.display = "none";
        }
    }
    function showSchedule() {
        var engMenu = document.getElementById("schedule");
        if (engMenu.style.display === "none" || engMenu.style.display === "") {
            engMenu.style.display = "block";
        } else {
            engMenu.style.display = "none";
        }
    }
    function showHerramentales() {
          var engMenu = document.getElementById("herramentales");
        if (engMenu.style.display === "none" || engMenu.style.display === "") {
            engMenu.style.display = "block";
        } else {
            engMenu.style.display = "none";
        }
    }
    function showRRHH() {
          var engMenu = document.getElementById("RRHH");
        if (engMenu.style.display === "none" || engMenu.style.display === "") {
            engMenu.style.display = "block";
        } else {
            engMenu.style.display = "none";
        }
    }
</script>
