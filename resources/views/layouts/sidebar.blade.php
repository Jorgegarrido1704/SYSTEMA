
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


<li class="nav-item active">
    @if($cat=="junta")
    <a class="nav-link" href="/juntas">
    @elseif($cat=="plan")
    <a class="nav-link" href="/planing">
    @elseif($cat=="cali")
    <a class="nav-link"  href="/calidad">
    @endif
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Home</span></a>
        <ul class="submenu" id="submenu">
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('index_junta')}}">Sales</a></li>
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('calidad_junta')}}">Quality</a></li>
            @if($cat=="cali")
            <li class="submenu" id="submenu"><a style="color:white;" href="{{ route ('accepted')}}">Accept orders</a></li>
            @endif
            <li class="submenu" id="submenu"><a style="color:white;" href="#"></a></li>
            <li class="submenu" id="submenu"><a style="color:white;" href="#"></a></li>
            </ul>
</li>



@endif

</ul>




