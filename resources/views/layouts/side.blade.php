    <ul class="nav">
        <li class="nav-header">Navigation</li>
        
        
            @if(Auth::user()->role_id==4)
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-th-large"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{url('Pengguna')}}">Pengguna Aplikasi</a></li>
                        <li><a href="{{url('Unitkerja')}}">Unit Kerja</a></li>
                    </ul>
                </li>
            @endif

            @if(Auth::user()->posisi_id==12)
                <li><a href="{{url('TiketGL')}}"><i class="fa fa-bullhorn"></i><span>Kelola Sumber Informasi</span></a></li>
            @endif

            @if(Auth::user()->posisi_id==3 || Auth::user()->posisi_id==11)
                <li><a href="{{url('Tiket')}}"><i class="fa fa-bullhorn"></i><span>Kelola Sumber Informasi</span></a></li>
                
            @endif

            @if(Auth::user()->posisi_id==12)
                <li><a href="{{url('TiketNew')}}"><i class="fa fa-ticket-alt"></i><span>Daftar Tiket</span></a></li>
            @endif

            @if(Auth::user()->posisi_id==1 || Auth::user()->posisi_id==13)
                <li><a href="{{url('TiketHD')}}"><i class="fa fa-bullhorn"></i><span>Kelola Sumber Informasi</span></a></li>
                <li><a href="{{url('TiketNewHead')}}"><i class="fa fa-ticket-alt"></i><span>Daftar Tiket</span></a></li>
                @if(Auth::user()->posisi_id==1)    
                    <li><a href="{{url('AccTiketHead')}}"><i class="fa fa-gavel"></i><span>Approve Penyelesaian Tiket</span></a></li>
                @endif
                <li class="has-sub lilinya">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-gavel"></i>
                        <span>Persetujuan Audit </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{url('/AccAuditplan')}}">Audit Plan </a></li>
                        <li><a href="{{url('/Deskaudit')}}">DeskAudit </a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Complaince</a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Substantive</a></li>
                        
                    </ul>
                </li>
            @endif

            @if(akses_tiket_pengawas()>0)
                <li><a href="{{url('AccTiketPengawas')}}"><i class="fa fa-gavel"></i><span>Penyelesaian Tiket</span></a></li>

            @endif
            @if(akses_tiket_anggota()>0)
                <li><a href="{{url('TiketAnggota')}}"><i class="fa fa-ticket-alt"></i><span>Tiket Anggota</span></a></li>
                <li class="has-sub lilinya">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-users"></i>
                        <span>Audit Anggota</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{url('/Deskaudit')}}">DeskAudit </a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Complaince</a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Substantive</a></li>
                        
                    </ul>
                </li>
            @endif
            @if(akses_tiket_ketua()>0)
                <li class="has-sub lilinya">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-clipboard"></i>
                        <span>Audit Ketua</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{url('/Deskaudit')}}">DeskAudit </a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Complaince</a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Substantive</a></li>
                        
                    </ul>
                </li>
            @endif
            @if(akses_tiket_pengawas()>0)
                <li class="has-sub lilinya">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-clipboard"></i>
                        <span>Audit Pengawas</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{url('/Auditplan')}}">Audit Plan </a></li>
                        <li><a href="{{url('/Deskaudit')}}">DeskAudit </a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Complaince</a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Substantive</a></li>
                        
                    </ul>
                </li>
            @endif
        
        <!-- end sidebar minify button -->
    </ul>