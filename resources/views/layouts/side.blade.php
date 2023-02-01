<ul class="nav">
        <li class="nav-header">Navigation</li>
            @if(Auth::user()->role_id==8)
                <li class="has-sub ">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                    <ul class="sub-menu" style="display: @if($side=='home') block @endif;">
                        <li><a href="{{url('home')}}"><span>Progress Konsultasi </span></a></li>
                        <li><a href="{{url('DashboardStia02')}}"><span>Temuan</span></a></li>
                        @if(Auth::user()->jabatan==1)
                            <li><a href="{{url('Dashboardall')}}"><span>Temuan Direktorat</span></a></li>
                        
                        @endif
                        @if(Auth::user()->jabatan==2)
                            <li><a href="{{url('Dashboardall')}}"><span>Temuan Corporate</span></a></li>
                        
                        @endif
                    </ul>
                </li>
                
                <li><a href="{{url('Tiket')}}"><i class="fa fa-bullhorn"></i><span>Input Konsultasi</span></a></li>
               
            @else
            <li class="has-sub ">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fa fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <ul class="sub-menu" style="display: @if($side=='home') block @endif;">
                    <li><a href="{{url('DashboardStia')}}">Dashboard Non Audit</a></li>
                    <li><a href="{{url('Dashboardaudit')}}">Dashboard Audit</a></li>
                    <li><a href="{{url('DashboardKodifikasi')}}">Dashboard Kodifikasi</a></li>
                    <li><a href="{{url('Dashboardtemuan')}}">Dashboard Temuan</a></li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->role_id!=8)
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
                @if(akses_tiket_ketua()>0)
                    <li><a href="{{url('TiketKetua')}}"><i class="fa fa-ticket-alt"></i><span>Tiket Ketua</span></a></li>
                
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
                            <i class="fa fa-clipboard"></i>
                            <span>Audit </span>
                        </a>
                        <ul class="sub-menu" style="display: @if($side=='audithead') block @endif;">
                            <li><a href="{{url('/AccAuditplan')}}">{!! notif_auditplan_head() !!} Audit Plan </a></li>
                            <li><a href="{{url('/Deskaudithead')}}">Deskaudit</a></li>
                            <li><a href="{{url('/Compliancehead')}}">Compliance</a></li>
                            <li><a href="{{url('/Substantivehead')}}">Substantive</a></li>
                            <li><a href="{{url('/Lha')}}">{!! notif_lha_head() !!} Lha</a></li>
                            <li><a href="{{url('/Qchead')}}">{!! notif_qc_head() !!} Penerbitan</a></li>
                            
                        </ul>
                    </li>
                    <li><a href="{{url('Temuanhead')}}"><i class="fa fa-clipboard"></i><span>Temuan</span></a></li>
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
                                        <li><a href="{{url('/Deskauditcatatanpengawas')}}">{!! notif_deskaudit_catatan_pengawas() !!} Catatan</a></li>
                                    </ul>
                                </li>
                                <li class="has-sub expand">
                                    <a href="javascript:;">
                                        <b class="caret"></b>
                                        Compliance
                                    </a>
                                    <ul class="sub-menu" style="display: block;">
                                        <li><a href="{{url('/Compliancepengawas')}}">{!! notif_compliance_program_pengawas() !!} Program</a></li>
                                        <li><a href="{{url('/Compliancecatatanpengawas')}}">{!! notif_compliance_catatan_pengawas() !!} Catatan</a></li>
                                    </ul>
                                </li>
                                <li class="has-sub expand">
                                    <a href="javascript:;">
                                        <b class="caret"></b>
                                        Substantive Test
                                    </a>
                                    <ul class="sub-menu" style="display: block;">
                                        <li><a href="{{url('/Substantivepengawas')}}">{!! notif_substantive_program_pengawas() !!} Program</a></li>
                                        <li><a href="{{url('/Substantivecatatanpengawas')}}">{!! notif_substantive_catatan_pengawas() !!} Catatan</a></li>
                                    </ul>
                                </li>
                                <li class="has-sub expand">
                                    <a href="javascript:;">
                                        <b class="caret"></b>
                                        LHA
                                    </a>
                                    <ul class="sub-menu" style="display: block;">
                                        <li><a href="{{url('/Lha')}}">{!! notif_lha_pengawas() !!} Draft</a></li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </li>
                        <li><a href="{{url('Temuanpengawas')}}"><i class="fa fa-clipboard"></i><span>Temuan pengawas</span></a></li>
                    @endif
                @endif
                @if(Auth::user()->posisi_id==12)
                    <li><a href="{{url('Temuanrcd')}}"><i class="fa fa-clipboard"></i><span>Temuan Rcd</span></a></li>
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
                                    <li><a href="{{url('/Compliance')}}">{!! notif_compliance_program_ketua() !!} Program</a></li>
                                    <li><a href="{{url('/Compliancecatatan')}}">{!! notif_compliance_catatan_ketua() !!} Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    Substantive Test
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Substantive')}}">{!! notif_substantive_program_ketua() !!} Program</a></li>
                                    <li><a href="{{url('/Substantivecatatan')}}">{!! notif_substantive_catatan_ketua() !!} Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    LHA
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Lhaketua')}}">Draft</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{url('Temuanketua')}}"><i class="fa fa-clipboard"></i><span>Temuan ketua</span></a></li>
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
                                    <li><a href="{{url('/Deskauditanggota')}}">{!! notif_deskaudit_catatan_anggota() !!}Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    Compliance
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Complianceanggota')}}">{!! notif_compliance_catatan_anggota() !!} Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    Substantive Test
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Substantiveanggota')}}">{!! notif_substantive_catatan_anggota() !!} Catatan</a></li>
                                </ul>
                            </li>
                            <li class="has-sub expand">
                                <a href="javascript:;">
                                    <b class="caret"></b>
                                    LHA
                                </a>
                                <ul class="sub-menu" style="display: block;">
                                    <li><a href="{{url('/Lha')}}">Draft</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="has-sub lilinya">
                        <a href="{{url('Qcrevisi')}}">
                            <i class="fa fa-clipboard"></i>
                            <span>Draf Perbaikan</span>
                        </a>
                    </li>
                    <li><a href="{{url('Temuananggota')}}"><i class="fa fa-clipboard"></i><span>Temuan Anggota</span></a></li>
                @endif

                @if(Auth::user()->role_id==5 || Auth::user()->role_id==7)
                    <li><a href="{{url('/Qc')}}"><i class="fa fa-clipboard"></i>
                            <span>Draf Pemeriksaan</span>
                        </a>
                    </li>
                            
                @endif
            @endif
            @if(Auth::user()->role_id==8)
                <li><a href="{{url('/Temuan')}}"><i class="fa fa-clipboard"></i>
                        <span>Monitoring Temuan</span>
                    </a>
                </li>
                        
            @endif
        
        <!-- end sidebar minify button -->
    </ul>