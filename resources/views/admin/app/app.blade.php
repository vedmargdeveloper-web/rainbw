<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="base_url" content="{{ url('/') }}">
    <meta name="page" content="{{ Request::segment(2) }}">
    <link rel="shortcut icon" href="img/fav.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Title -->
    <title> @yield('title') |  Rainbow   </title>

    <!-- *************
      ************ Common Css Files *************
    ************ -->
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('resources/css/bootstrap.min.css') }}">

    <!-- Icomoon Font Icons css -->
    <link rel="stylesheet" href="{{ asset('resources/fonts/style.css">') }}" ?>

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('resources/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/template.css?v='.time()) }}">

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
    <!-- *************
      ************ Vendor Css Files *************
    ************ -->
    <script src="{{ asset('resources/js/jquery.min.js') }}"></script>
    <!-- DateRange css -->
    <link rel="stylesheet" href="{{ asset('resources/vendor/daterange/daterange.css') }}" />

    <!-- jQcloud Keywords css -->
    <link rel="stylesheet" href="{{ asset('resources/vendor/jqcloud/jqcloud.css') }}" />

    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ asset('resources/vendor/datatables/dataTables.bs4.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/vendor/datatables/dataTables.bs4-custom.css') }}" />
    <link href="{{ asset('resources/vendor/datatables/buttons.bs.css') }}" rel="stylesheet" />

<!-- Bootstrap Select CSS -->
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <style type="text/css">
      @page {
        size: auto;
      }
      button.dt-button {
          padding: 2px;
          border: 1px solid #ccc;
      }
      input.form-control.form-control-sm.selectpicker {
          width: 109px;
      }
      .fixed .header-actions li a {
        padding: 0 20px;
      }
      .fixed .main-logo {
        width: 18%;
      }
      .fixed{
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 99;
      }

      @media print {
        table,th,td{
          border: 0 !important;
        }

      }
    </style>
  </head>
  <body>

    <!-- Loading starts -->
    <div id="loading-wrapper">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <!-- Navigation start -->
      <nav class="navbar navbar-expand-lg custom-navbar">
        <li> <a href="{{ url('/') }}" class="logo">
         {{-- <h4>RAINBOW</h4> --}}
          <img src="{{ asset('assets/logo-black.png') }}" class="main-logo" alt="Rainbow" />
        </a></li>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#WafiAdminNavbar" aria-controls="WafiAdminNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <i></i>
            <i></i>
            <i></i>
          </span>
        </button>
        <div class="collapse navbar-collapse" id="WafiAdminNavbar">
          <ul class="navbar-nav">
         
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-package nav-icon"></i>
                Admin
              </a>
              <ul class="dropdown-menu" aria-labelledby="appsDropdown">
                <li>
                  <a class="dropdown-item" href="{{ route('users.create') }}">Add User </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('users.index') }}">User Rights</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('master.create') }}">Create Master </a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('master.create') }}">Edit Record</a>
                </li>
                <li>
                   <a class="dropdown-item" href="{{ route('ajax.user.password') }}">Master Password</a>
                </li>
                {{-- 
                   <li>
                    <a class="dropdown-toggle sub-nav-link" href="#" id="calendarsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Item
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarsDropdown">
                        <li>
                          <a class="dropdown-item" href="{{ route('item.create') }}">Create</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{ route('item.index') }}">View</a>
                        </li>
                    </ul>
                  </li>
                  <li>
                    <a class="dropdown-toggle sub-nav-link" href="#" id="calendarsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Customers
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarsDropdown">
                        <li>
                          <a class="dropdown-item" href="{{ route('customers.create') }}">Create</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{ route('customers.index') }}">View</a>
                        </li>
                    </ul>
                  </li>
                 
                  <li>
                    <a class="dropdown-toggle sub-nav-link" href="#" id="calendarsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Delivery Address 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarsDropdown">
                        <li>
                          <a class="dropdown-item" href="{{ route('address.create') }}?type=delivery">Create</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{ route('address.index') }}?type=delivery">View</a>
                        </li>
                    </ul>
                  </li>
                  <li>
                    <a class="dropdown-toggle sub-nav-link" href="#" id="calendarsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Supply Address 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarsDropdown">
                        <li>
                          <a class="dropdown-item" href="{{ route('address.create') }}?type=supply">Create</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{ route('address.index') }}?type=supply">View</a>
                        </li>
                    </ul>
                  </li>
                   <li>
                    <a class="dropdown-toggle sub-nav-link" href="#" id="calendarsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Users
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarsDropdown">
                        <li>
                          <a class="dropdown-item" href="{{ route('users.create') }}  ">Create</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{ route('users.index') }}">View</a>
                        </li>
                    </ul>
                  </li>
                  <li class="d-none">
                    <a class="dropdown-toggle sub-nav-link" href="#" id="calendarsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      State
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarsDropdown">
                        <li>
                          <a class="dropdown-item" href="calendar.html">Create</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="calendar.html">View</a>
                        </li>
                    </ul>
                  </li>
                  <li class="d-none">
                      <a class="dropdown-toggle sub-nav-link" href="#" id="calendarsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        City
                      </a>
                      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="calendarsDropdown">
                          <li>
                            <a class="dropdown-item" href="calendar.html">Create</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="calendar.html">View</a>
                          </li>
                      </ul>
                    </li> --}}
              </ul>
            </li>
           <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-book-open nav-icon"></i>
                  Golf Carts
              </a>
              <ul class="dropdown-menu" aria-labelledby="pagesDropdown">
                <li>
                  <a class="dropdown-item" href="{{ URL::to('/') }}">Dashboard</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Inventory</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Marketing</a>
                </li>
                
                {{-- <li>
                  <a class="dropdown-item" href="{{ route('inquiry.create') }}">Inquiry</a>
                </li> --}}
                
                <li>
                  <a class="dropdown-toggle sub-nav-link" href="#" id="submenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Inquiry
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="submenuDropdown">
                    <li>
                      <a class="dropdown-item" href="{{ route('inquiry.create') }}">New</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('inquiry.index') }}">Edit</a>
                    </li>
                  </ul>
                </li>

                <li>
                  <a class="dropdown-toggle sub-nav-link" href="#" id="submenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Proforma Invoice
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="submenuDropdown">
                    <li>
                      <a class="dropdown-item" href="{{ route('ajax.last.enquries') }}">New</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('quotation.index') }}">Edit</a>
                    </li>
                    {{-- <li>
                      <a class="dropdown-item" href="{{ route('pitch.index') }}">All Pitch</a>
                    </li> --}}
                  </ul>
                </li>

                {{-- <li>
                  <a class="dropdown-toggle sub-nav-link" href="#" id="submenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pitch
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="submenuDropdown">
                    <li>
                      <a class="dropdown-item" href="{{ route('pitch.create') }}">New</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('pitch.index') }}">Edit</a>
                    </li>
                  </ul>
                </li> --}}

                <li>
                  <a class="dropdown-toggle sub-nav-link" href="#" id="submenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Booking
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="submenuDropdown">
                    <li>
                      <a class="dropdown-item" href="{{ route('ajax.last.booking') }}">New</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('booking.index') }}">Edit</a>
                    </li>
                  </ul>
                </li>
                {{-- <li>
                  <a class="dropdown-item" href="{{ route('inquiry.index') }}">All Inquiry</a>
                </li> --}}
               {{--  <li>
                  <a class="dropdown-item" href="{{ route('quotation.create') }}">Quotation</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('quotation.index') }}">All Quotation</a>
                </li> --}}
                {{-- <li>
                  <a class="dropdown-item" href="{{ route('pitch.create') }}">Create Pitch</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('pitch.index') }}">All Pitching</a>
                </li> --}}
                
                <li>
                  <a class="dropdown-item" href="{{ route('allocation.create') }}">Allocation</a>
                </li>
                 <li>
                  <a class="dropdown-item" href="{{ route('logistics.create') }}">Logistics</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('invoice.create') }}">Invoice</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('invoice.index') }}">All Invoices</a>
                </li>
                <li>
                  <a class="dropdown-toggle sub-nav-link" href="#" id="submenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Challan
                  </a>
                  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="submenuDropdown">
                    <li>
                      <a class="dropdown-item" href="{{ route('challan.create') }}">New</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('challan.index') }}" href="">Edit</a>
                    </li>
                  </ul>
                </li>

                <li>
                  <a class="dropdown-item" href="{{ route('invoice.challan') }}">All Challans</a>
                </li>
                 <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Payment Portal</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Maintenance</a>
                </li>
                
              </ul>
            </li>
             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-book-open nav-icon"></i>
                  Reports
              </a>
              <ul class="dropdown-menu" aria-labelledby="pagesDropdown">
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Dealer A/c's</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Cart ID</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Payment Pending</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Repair History</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">TT Business Overview</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Booking Calender</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Payment A/c's</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Sales Report</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Purchase Report</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">GST Report</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Expense Sheet</a>
                </li>
               
             
              </ul>
            </li>
             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-book-open nav-icon"></i>
                  Reports
              </a>
              <ul class="dropdown-menu" aria-labelledby="pagesDropdown">
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Staff Report</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">P&L Report</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Monthly Report</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Yearly Report</a>
                </li>
                <li>
                  <a class="dropdown-item" href="javascript:alert('we are working')">Battery Report</a>
                </li>
                           
              </ul>
            </li>
              
              </ul>
            </li>
          </ul>

        </div>
         <ul class="header-actions">
          
          
          <li class="dropdown">
            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
              {{-- <span class="user-name">Zyan Ferris</span> --}}
              <span class="avatar"><img src="{{ asset('assets/avtar.webp') }}"> <span class="status busy"></span></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
              <div class="header-profile-actions">
                <div class="header-user-profile">
                  <div class="header-user">
                   {{--  <img src="img/user.png" alt="Admin Template" /> --}}
                  </div>
                  <h5>{{ Auth::User()->name }}</h5>
                  <p>{{ ucfirst(Auth::User()->role) }}</p>
                </div>
                <a href="#"><i class="icon-user1"></i> My Profile</a>
                <a href="{{ route('meta.index') }}"><i class="icon-settings1"></i> Settings</a>
                <a href="{{ route('admin.logout') }}"><i class="icon-log-out1"></i> Sign Out</a>
              </div>
            </div>
          </li>
         
        </ul> 
      </nav>
      <!-- Navigation end -->

    <!--*************  Header section end *************-->
    <!-- Page header start -->
        <div class="page-header">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">@yield('title')</li>
          </ol>

          <ul class="app-actions">
            <li>
              <a href="#" id="reportrange">
                <span class="range-text"> {{ date('M d') }},{{ date('Y') }} </span>
                <i class="icon-chevron-down"></i> 
              </a>
            </li>
            <li>
              <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print">
                <i class="icon-print"></i>
              </a>
            </li>
            <li>
              <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download CSV">
                <i class="icon-cloud_download"></i>
              </a>
            </li>
          </ul>
        </div>
        @yield('content');

      @if(Session::has('msg'))
        <script>
        swal("Good job!", "{{ Session::get('msg') }}", "success");
        </script>
      @endif
      <!-- Footer start -->
      <footer class="main-footer">© Rainbow </footer>
      <!-- Footer end -->

    </div>
    <!-- Container fluid end -->

    <!-- ************Required JavaScript Files -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    
    <script src="{{ asset('resources/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('resources/js/moment.js') }}"></script>

                <script>
                        CKEDITOR.replace( 'term' );


                        $(window).scroll(function(){
                        if ($(window).scrollTop() >= 200) {
                          $('nav.navbar').addClass('fixed');
                         }
                         else {
                          $('nav.navbar').removeClass('fixed');
                         }
                      });
                </script>
    <!-- *************
      ************ Vendor Js Files *************
    ************* -->
    <!-- Slimscroll JS -->
    <script src="{{ asset('resources/vendor/slimscroll/slimscroll.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/slimscroll/custom-scrollbar.js') }}"></script>

    <!-- Daterange -->
    <script src="{{ asset('resources/vendor/daterange/daterange.js') }}"></script>
    <script src="{{ asset('resources/vendor/daterange/custom-daterange.js') }}"></script>

    <!-- Rating JS -->
    <script src="{{ asset('resources/vendor/rating/raty.js') }}"></script>
    <script src="{{ asset('resources/vendor/rating/raty-custom.js') }}"></script>

    <!-- jQcloud Keywords -->
    <script src="{{ asset('resources/vendor/jqcloud/jqcloud-1.0.4.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/jqcloud/custom-jqcloud.js') }}"></script>

    <!-- Apex Charts -->
    <script src="{{ asset('resources/vendor/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/apex/ecommerce-dashboard/by-device.js') }}"></script>
    <script src="{{ asset('resources/vendor/apex/ecommerce-dashboard/by-customer-type.js') }}"></script>
    
    <!-- jVector Maps -->
    <script src="{{ asset('resources/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>

    <!-- Main Js Required -->
    <!-- Data Tables -->
    <script src="{{ asset('resources/vendor/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/dataTables.bootstrap.min.js') }}"></script>
    
    <!-- Custom Data tables -->
    <script src="{{ asset('resources/vendor/datatables/custom/custom-datatables.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/custom/fixedHeader.js') }}"></script>

    <!-- Download / CSV / Copy / Print -->
    <script src="{{ asset('resources/vendor/datatables/buttons.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/html5.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/datatables/buttons.print.min.js') }}"></script>

    <script src="{{ asset('resources/js/main.js?v='.time()) }}"></script>
    <script src="{{ asset('resources/js/custom.js?v='.time()) }}"></script>

  </body>

</html>