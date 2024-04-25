
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
@if(!empty($cat))

@if($cat=="Admin")
<li class="nav-item active">
    <a class="nav-link" href="#">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span class="PO" id="PO">Order register</span></a>
    <ul class="submenu" id="submenu">
    <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('po')}}">Set Po</a></li>
    <li class="submenu" id="submenu"><a style="color:white;" href="{{route('label')}}">Print Labels</a></li>
    </ul>
</li>

<li class="nav-item active">
    <a class="nav-link" href="#">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Requirements</span></a>
        <ul class="submenu" id="submenu">
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('po')}}">Set Po</a></li>
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('po')}}">Set Po</a></li>
            <li class="submenu" id="submenu">Print Barcode</li>
            <li class="submenu" id="submenu">Print Labels</li>
            </ul>
</li>
@endif

@if($cat=='BCali')
<li class="nav-item active">
    <a class="nav-link" href="/BossCali">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Quality Reports by</span></a>
        <ul class="submenu" id="submenu">
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('reference',['date'=>'Today'])}}">Today</a></li>
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('reference',['date'=>'Yesterday'])}}">yesterday</a></li>
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('reference',['date'=>'Week'])}}">This week</a></li>
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('reference',['date'=>'Month'])}}">This month</a></li>
            </ul>
</li>
@endif
@endif

</ul>




