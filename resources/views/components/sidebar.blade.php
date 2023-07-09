<aside id="side-overlay">
    <div class="content-header content-header-fullrow">
        <div class="content-header-section align-parent">
            <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout"
                data-action="side_overlay_close">
                <i class="fa fa-times text-danger"></i>
            </button>
            <div class="content-header-item">
                <a class="img-link mr-5" href="be_pages_generic_profile.html">
                    <img class="img-avatar img-avatar32" src="{{ asset('/') }}public/assets/images/logo-simetri.png"
                        alt="">
                </a>
                <a class="align-middle link-effect text-primary-dark font-w600"
                    href="be_pages_generic_profile.html">SimetriAR</a>
            </div>
        </div>
    </div>
</aside>

<nav id="sidebar">
    <div class="sidebar-content">
        <div class="content-header content-header-fullrow px-15">
            <div class="content-header-section sidebar-mini-visible-b">
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">A</span><span class="text-primary">R</span>
                </span>
            </div>
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                    data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                {{-- <div class="content-header-item">
                    <a class="link-effect font-w700" href="index.html">
                        <span class="font-size-xl text-dual-primary-dark">Simetri</span><span
                            class="font-size-xl text-primary">AR</span>
                    </a>
                </div> --}}
            </div>
        </div>
        <div class="content-side content-side-full content-side-user px-10 align-parent">
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <img class="img-avatar img-avatar32" src="{{ asset('/') }}public/assets/images/logo-simetri.png"
                    alt="">
            </div>
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="be_pages_generic_profile.html">
                    <img class="img-avatar" src="{{ asset('/') }}public/assets/images/logo-simetri.png"
                        alt="">
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <a class="link-effect font-w700" href="index.html">
                            <span class="font-size-xl text-dual-primary-dark">Simetri </span><span
                                class="font-size-xl text-primary">AR</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-side content-side-full">
            @if (Auth()->user()->role_id == 1)
                <ul class="nav-main">
                    <li>
                        <a class="{{ request()->route()->getName() == 'dashboard'? 'active': '' }}"
                            href="{{ route('dashboard') }}"><i class="si si-home"></i><span
                                class="sidebar-mini-hide">Dashboard</span></a>
                    </li>
                    <li>
                        <a class="{{ request()->route()->getName() == 'monitoring.index'? 'active': '' }}"
                            href="{{ route('monitoring.index') }}"><i class="fa fa-clipboard"></i><span
                                class="sidebar-mini-hide">Monitoring</span></a>
                    </li>
                    <li class="nav-main-heading"><span class="sidebar-mini-visible">UI</span><span
                            class="sidebar-mini-hidden">Menu Utama</span></li>
                    <li>
                        <a class="nav-submenu {{ request()->route()->getName() == 'proyek.create' ||request()->route()->getName() == 'proyek.index'? 'active': '' }}"
                            data-toggle="nav-submenu" href="#">
                            <i class="fa-solid fa-bolt-lightning"></i>
                            <span class="sidebar-mini-hide">Proyek</span>
                        </a>
                        <ul>
                            <li>
                                <a class="{{ request()->route()->getName() == 'proyek.create'? 'active': '' }}"
                                    href="{{ route('proyek.create') }}">
                                    Proyek Baru
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->route()->getName() == 'proyek.index'? 'active': '' }}"
                                    href="{{ route('proyek.index') }}">
                                    List Proyek
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu {{ request()->route()->getName() == 'invoice.create' ||request()->route()->getName() == 'invoice.index'? 'active': '' }}"
                            data-toggle="nav-submenu" href="#">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            <span class="sidebar-mini-hide">Invoice</span>
                        </a>
                        <ul>
                            <li>
                                <a class="{{ request()->route()->getName() == 'invoice.create'? 'active': '' }}"
                                    href="{{ route('invoice.create') }}">
                                    Buat Invoice
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->route()->getName() == 'invoice.index'? 'active': '' }}"
                                    href="{{ route('invoice.index') }}">
                                    List Invoice
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu {{ request()->route()->getName() == 'transaksi.create' ||request()->route()->getName() == 'transaksi.index'? 'active': '' }}"
                            data-toggle="nav-submenu" href="#">
                            <i class="fa-solid
                            fa-money-bill-transfer"></i>
                            <span class="sidebar-mini-hide">Transaksi</span>
                        </a>
                        <ul>
                            <li>
                                <a class="{{ request()->route()->getName() == 'transaksi.create'? 'active': '' }}"
                                    href="{{ route('transaksi.create') }}">
                                    Buat Transaksi
                                </a>
                            </li>
                            <li>
                                <a class="{{ request()->route()->getName() == 'transaksi.index'? 'active': '' }}"
                                    href="{{ route('transaksi.index') }}">
                                    Rekap Penerimaan
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu {{ request()->route()->getName() == 'sales-volume.index' ||request()->route()->getName() == 'sales-target.index'? 'active': '' }}"
                            data-toggle="nav-submenu" href="#">
                            <i class="fa fa-bar-chart"></i>
                            <span class="sidebar-mini-hide">Laporan Sales</span>
                        </a>
                        <ul>
                            <li>
                                <a class="{{ request()->route()->getName() == 'sales-volume.index'? 'active': '' }}"
                                    href="{{ route('sales-volume.index') }}"><span class="sidebar-mini-hide">Sales
                                        Volume</span></a>
                            </li>
                            <li>
                                <a class="{{ request()->route()->getName() == 'sales-target.index'? 'active': '' }}"
                                    href="{{ route('sales-target.index') }}"><span class="sidebar-mini-hide">Sales
                                        Target</span></a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-main-heading"><span class="sidebar-mini-visible">BD</span><span
                            class="sidebar-mini-hidden">Pengaturan</span></li>
                    <li>
                        <a class="{{ request()->route()->getName() == 'sales.index'? 'active': '' }}"
                            href="{{ route('sales.index') }}"><i class="fa fa-users"></i><span
                                class="sidebar-mini-hide">Sales</span></a>
                    </li>
                    <li>
                        <a class="{{ request()->route()->getName() == 'customer.index'? 'active': '' }}"
                            href="{{ route('customer.index') }}"><i class="fa fa-user"></i><span
                                class="sidebar-mini-hide">Customer</span></a>
                    </li>
                    <li>
                        <a class="{{ request()->route()->getName() == 'payment-terms.index'? 'active': '' }}"
                            href="{{ route('payment-terms.index') }}"><i class="fa-regular fa-clock"></i><span
                                class="sidebar-mini-hide">Payment
                                Terms</span></a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
