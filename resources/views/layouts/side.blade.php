    <ul class="nav">
        <li class="nav-header">Navigation</li>
        
            <li class="has-sub ">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fa fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <ul class="sub-menu" style="display: @if($side=='home') block @endif;">
                    <li><a href="{{url('DashboardStia')}}">Dashboard STIA [1,2,3]</a></li>
                    <li><a href="{{url('DashboardKodifikasi')}}">Dashboard Kodifikasi</a></li>
                    <li><a href="{{url('home')}}">Dashboard v3</a></li>
                </ul>
            </li>
            @if(Auth::user()->role_id==4)
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-th-large"></i>
                        <span>Master Data</span>
                    </a>
                    <ul class="sub-menu" style="display: @if($side=='master') block @endif;">
                        <li><a href="{{url('Pengguna')}}">Pengguna Aplikasi</a></li>
                        <li><a href="{{url('Unitkerja')}}">Unit Kerja</a></li>
                    </ul>
                </li>
            @endif

            <!-----Menu GL Untuk Tiket---->
            @if(Auth::user()->posisi_id==12)
                <li><a href="{{url('TiketGL')}}">{!! notif_sumber_gl()!!}<i class="fa fa-bullhorn"></i><span>Kelola Sumber Informasi</span></a></li>
                <li><a href="{{url('TiketNew')}}">{!! notif_tiket_gl() !!}<i class="fa fa-ticket-alt"></i><span>Daftar Tiket</span></a></li>
            @endif

            <!-----Menu Anggota Untuk Tiket---->
            @if(Auth::user()->posisi_id==3 || Auth::user()->posisi_id==11 || Auth::user()->posisi_id==4 || Auth::user()->posisi_id==5 || Auth::user()->posisi_id==6 || Auth::user()->posisi_id==10)
                <li><a href="{{url('Tiket')}}"><i class="fa fa-bullhorn"></i><span>Kelola Sumber Informasi</span></a></li>
                @if(akses_tiket_anggota()>0)
                <li><a href="{{url('TiketAnggota')}}"><i class="fa fa-ticket-alt"></i><span>Tiket Anggota</span></a></li>
                
                @endif
            @endif

            
            <!-----Menu Head Untuk Tiket---->
            @if(Auth::user()->posisi_id==1 || Auth::user()->posisi_id==13)
                @if(Auth::user()->posisi_id==1)
                <li><a href="{{url('TiketHD')}}">{!! notif_sumber_head()!!}<i class="fa fa-bullhorn"></i><span>Kelola Sumber Informasi</span></a></li>
                <li><a href="{{url('TiketNewHead')}}">{!! notif_tiket_head() !!}<i class="fa fa-ticket-alt"></i><span>Daftar Tiket</span></a></li>
                @endif
                @if(akses_tiket_head()>0)
                <li><a href="{{url('AccTiketHead')}}"><i class="fa fa-gavel"></i><span>Approve Penyelesaian Tiket</span></a></li>
                <li class="has-sub lilinya">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-gavel"></i>
                        <span>Persetujuan Audit </span>
                    </a>
                    <ul class="sub-menu" style="display: @if($side=='audithead') block @endif;">
                        <li><a href="{{url('/AccAuditplan')}}">{!! notif_auditplan_head() !!} Audit Plan </a></li>
                        <li class="has-sub expand">
                            <a href="javascript:;">
                                <b class="caret"></b>
                                DeskAudit
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li><a href="{{url('/Deskaudit')}}">Program</a></li>
                                <li><a href="javascript:;">Catatan</a></li>
                            </ul>
                        </li>
                        <li><a href="{{url('/ListKaryawan')}}">Compliance</a></li>
                        <li><a href="{{url('/ListKaryawan')}}">Substantive</a></li>
                        
                    </ul>
                </li>
                @endif
            @endif

            <!-----Menu Pengawas Untuk Tiket---->
            @if(Auth::user()->posisi_id==12 || Auth::user()->posisi_id==2 || Auth::user()->posisi_id==7 || Auth::user()->posisi_id==1)
                @if(akses_tiket_pengawas()>0)
                    <li><a href="{{url('AccTiketPengawas')}}"><i class="fa fa-gavel"></i><span>Penyelesaian Tiket</span></a></li>
                    <li class="has-sub lilinya">
                        <a href="javascript:;">
                            <b class="caret"></b>
                            <i class="fa fa-clipboard"></i>
                            <span>Audit Pengawas</span>
                        </a>
                        <ul class="sub-menu" style="display: @if($side=='deskauditpengawas' || $side=='auditpengawas') block @endif;" >
                            <li><a href="{{url('/Auditplan')}}">{!! notif_auditplan_pengawas() !!} Audit Plan</a></li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    DeskAudit
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Deskauditpengawas')}}">{!! notif_deskaudit_program_pengawas() !!} Program</a></li>
                                    <li><a href="{{url('/Deskauditcatatanpengawas')}}">Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    Compliance
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Compliancepengawas')}}">Program</a></li>
                                    <li><a href="{{url('/Compliancecatatanpengawas')}}">Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    Substantive Test
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Lha')}}">Program</a></li>
                                    <li><a href="{{url('/Substantivecatatanpengawas')}}">Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    LHA
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Lha')}}">Program</a></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </li>
                @endif
            @endif

            @if(akses_tiket_ketua()>0)
                <li class="has-sub lilinya">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-clipboard"></i>
                        <span>Audit Ketua</span>
                    </a>
                    <ul class="sub-menu" style="display: @if($side=='auditketua') block @endif;">
                        <li class="has-sub expand">
                            <a href="javascript:;">
                                <b class="caret"></b>
                                DeskAudit
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li><a href="{{url('/Deskaudit')}}">{!! notif_deskaudit_program_ketua() !!} Program</a></li>
                                <li><a href="{{url('/Deskauditcatatan')}}">{!! notif_deskaudit_catatan_ketua() !!} Catatan</a></li>
                            </ul>
                        </li>
                        <li class="has-sub expand">
                            <a href="javascript:;">
                                <b class="caret"></b>
                                Compliance
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li><a href="{{url('/Compliance')}}">Program</a></li>
                                <li><a href="{{url('/Compliancecatatan')}}">Catatan</a></li>
                            </ul>
                        </li>
                        <li class="has-sub expand">
                            <a href="javascript:;">
                                <b class="caret"></b>
                                Substantive Test
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li><a href="{{url('/Substantive')}}">Program</a></li>
                                <li><a href="{{url('/Substantivecatatan')}}">Catatan</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
            @endif
            
            @if(akses_tiket_anggota()>0)
                <li class="has-sub lilinya">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-clipboard"></i>
                        <span>Audit Anggota</span>
                    </a>
                    <ul class="sub-menu" style="display: @if($side=='auditanggota') block @endif;">
                        <li class="has-sub expand">
                            <a href="javascript:;">
                                <b class="caret"></b>
                                DeskAudit
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li><a href="{{url('/Deskauditanggota')}}">Catatan</a></li>
                            </ul>
                        </li>
                        <li class="has-sub expand">
                            <a href="javascript:;">
                                <b class="caret"></b>
                                Compliance
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li><a href="{{url('/Complianceanggota')}}">Catatan</a></li>
                            </ul>
                        </li>
                        <li class="has-sub expand">
                            <a href="javascript:;">
                                <b class="caret"></b>
                                Substantive Test
                            </a>
                            <ul class="sub-menu" style="display: block;">
                                <li><a href="{{url('/Substantiveanggota')}}">Catatan</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </li>
            @endif
        
        <!-- end sidebar minify button -->
    </ul>