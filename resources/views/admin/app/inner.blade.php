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