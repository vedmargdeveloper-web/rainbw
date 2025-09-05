@extends(_app())
@section('title', 'Booking Calendar')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>Booking Calendar</title> --}}
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-bg: #f8f9fc;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Nunito', sans-serif;
        }
        
        .calendar-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 20px;
            margin-top: 20px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .fc-toolbar h2 {
            font-size: 1.5rem;
            color: #5a5c69;
        }
        
        .fc-event {
            border-radius: 4px;
            border: none;
            padding: 3px 5px;
            cursor: pointer;
            font-size: 0.85rem;
        }
        
        .fc-day-grid-event .fc-content {
            white-space: normal;
        }
        
        .filter-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .stats-card {
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .stats-card i {
            font-size: 2rem;
            opacity: 0.8;
        }
       
        .card-primary {
             background: #2fc892; 
             color: #5a5c69;
        }
        .card-success {
             background: white; 
             color: #5a5c69;
            }
        .card-warning { 
            background:  #f3d27d;
            color: #5a5c69; 
        }
        .card-danger {
             background: #b1cbdf; 
             color: #5a5c69;
            }

        .card-upcoming {
             background: #d4edda; 
             color: #5a5c69;
            }

        #bookingModal .modal-body p {
            margin-bottom: 4px;      
            font-size: 13px;         
            font-weight: 400;         
            line-height: 1.2;        
        }

        

        #bookingModal .modal-body p strong {
            font-weight: 600;        
        }

        #bookingModal h6 {
            font-size: 14px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        #bookingModal table {
            font-size: 12px;        
        }

        #bookingModal table th,
        #bookingModal table td {
            padding: 4px 6px;  
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Page Heading -->
      <div class="mb-2 mt-2 text-end">
            <a href="{{ route('ajax.last.booking') }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-plus"></i> New Booking
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6 ">
                <div class="stats-card card-primary ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs  font-weight-bold text-uppercase mb-1">Total Bookings</div>
                            <div class="h5 mb-0 font-weight-bold" id="totalBookings">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
         
            <div class="col-xl-3 col-md-6 ">
                <div class="stats-card card-danger">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Revenue</div>
                            <div class="h5 mb-0 font-weight-bold" id="totalRevenue">₹0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-xl-3 col-md-6 ">
                <div class="stats-card card-warning">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Upcoming</div>
                            <div class="h5 mb-0 font-weight-bold" id="upcomingBookings">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 ">
                <div class="stats-card card-upcoming">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Upcoming Revenue</div>
                            <div class="h5 mb-0 font-weight-bold" id="totalUpcomingRevenue">₹0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-rupee-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <div class="calendar-container">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    
  
    <!-- Booking Details Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Booking No:</strong> <span id="modal_booking_no"></span></p>
                            <p><strong>Contact Person:</strong> <span id="modal_contact_name"></span></p>
                            <p><strong>Mobile:</strong> <span id="modal_mobile"></span></p>
                            <p><strong>Occasion:</strong> <span id="modal_occasion"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Client Name:</strong> <span id="modal_client_name"></span></p>
                            <p><strong>Venue:</strong> <span id="modal_venue"></span></p>
                            <p><strong>Delivery Address:</strong> <span id="modal_delivery_address"></span></p>
                            <p><strong>Date:</strong> <span id="modal_date"></span></p>
                           
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6><strong>Items:</strong></h6>
                            <div id="modal_items"></div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                   <a href="#" class="btn btn-primary" id="editBookingBtn" target="_blank">Edit</a>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        $(document).ready(function() {
           var SITEURL = "{{ url('/admin') }}";
var currentEvents = [];

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    editable: true,
    eventLimit: true,
    events: function(start, end, timezone, callback) {
        $.ajax({
            url: SITEURL + "/booking-calendar/events",
            type: "GET",
            data: {
                start: start.format('YYYY-MM-DD'),
                end: end.format('YYYY-MM-DD')
            },
            success: function(response) {
                currentEvents = response;
                callback(response);
                updateStats(response);
            },
            error: function() {
                toastr.error('Failed to load events');
            }
        });
    },
    eventRender: function(event, element) {
        element.find('.fc-title').html(
            '<strong>' + event.title + '</strong>' + 
            '<br><small>' + event.delivery_address + '</small>' +
            '<br><small>₹' + event.net_amount + '</small>'
        );
    },
   eventClick: function(event) {
    $.ajax({
        url: SITEURL + "/booking-calendar/events/" + event.id,
        type: "GET",
        success: function(response) {
            // Fill simple fields
            $('#modal_booking_no').text(response.booking_no);
            $('#modal_quotation_no').text(response.quotation_no);
            $('#modal_client_name').text(response.client_name);
            $('#modal_contact_name').text(response.contact_name);
            $('#modal_mobile').text(response.mobile);
            $('#modal_venue').text(response.venue);
            $('#modal_delivery_address').text(response.full_delivery_address);
            $('#modal_occasion').text(response.occasion);
            $('#modal_date').text(response.date);
            $('#modal_net_amount').text(response.net_amount);
            $('#modal_total_tax').text(response.total_tax);
            $('#modal_amount_in_words').text(response.amount_in_words);
            $('#modal_event_id').text(response.id);

            // Build items table
            let itemsHtml = `<table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>S.No</th>
                        <th>HSN</th>
                        <th>Description</th>
                        <th>Item</th>
                        <th>Rate</th>
                        <th>Qty</th>
                        <th>Days</th>
                        <th>Gross</th>
                        <th>Discount</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>IGST</th>
                        <th>Tax Amt</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>`;

            response.items.forEach(item => {
                itemsHtml += `
                    <tr>
                        <td>${item.sno}</td>
                        <td>${item.hsn_code}</td>
                        <td>${item.description}</td>
                        <td>${item.item}</td>
                        <td>${item.rate}</td>
                        <td>${item.quantity}</td>
                        <td>${item.days}</td>
                        <td>${item.gross_amount}</td>
                        <td>${item.discount}</td>
                        <td>${item.cgst}</td>
                        <td>${item.sgst}</td>
                        <td>${item.igst}</td>
                        <td>${item.tax_amount}</td>
                        <td>${item.total_amount}</td>
                    </tr>`;
            });

            // Add footer row like in invoice
            itemsHtml += `
                <tr class="center bottom-footer-tr">
                    <td></td>
                    <td colspan="3">Tax Payable on Rev. Charge Basis: NO</td>
                    <td colspan="3">Net Amount</td>
                    <td>${response.net_amount}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>${response.total_tax}</td>
                    <td>${response.total_amount}</td>
                </tr>
                
            `;

            itemsHtml += `</tbody></table>`;
            $('#modal_items').html(itemsHtml);

             $('#editBookingBtn').attr('href', SITEURL + '/booking/' + response.id + '/edit');
            $('#bookingModal').modal('show');
        },
        error: function() {
            toastr.error('Failed to load booking details');
        }
    });
}
,
    eventDrop: function(event) {
        $.ajax({
            url: SITEURL + "/booking-calendar/events",
            type: "POST",
            data: {
                id: event.id,
                start: event.start.format('YYYY-MM-DD'),
                end: event.end ? event.end.format('YYYY-MM-DD') : event.start.format('YYYY-MM-DD'),
                type: 'update'
            },
            success: function() {
                toastr.success('Booking updated successfully');
            },
            error: function() {
                toastr.error('Failed to update booking');
                $('#calendar').fullCalendar('refetchEvents');
            }
        });
    },
    selectable: true,
    // select: function(start, end) {
    //     $('#bookingDate').val(start.format('YYYY-MM-DD'));
    //     $('#createBookingModal').modal('show');
    // }
    select: function(start, end) {
    let bookingUrl = "{{ route('ajax.last.booking') }}"
    bookingUrl += "?date=" + start.format("YYYY-MM-DD");
    window.open(bookingUrl, "_blank");
}
});

// Filter logic
$('#occasionFilter, #venueFilter, #clientFilter, #dateRangeFilter').on('change keyup', function() {
    var occasion = $('#occasionFilter').val().toLowerCase();
    var venue = $('#venueFilter').val().toLowerCase();
    var client = $('#clientFilter').val().toLowerCase();
    var dateRange = $('#dateRangeFilter').val();

    var filteredEvents = currentEvents.filter(function(event) {
        var matchesOccasion = occasion === '' || (event.occasion || '').toLowerCase().includes(occasion);
        var matchesVenue = venue === '' || (event.venue || '').toLowerCase().includes(venue);
        var matchesClient = client === '' || (event.client_name || '').toLowerCase().includes(client);
        
        var matchesDate = true;
        if (dateRange) {
            var eventDate = moment(event.start);
            var today = moment();
            
            switch(dateRange) {
                case 'today':
                    matchesDate = eventDate.isSame(today, 'day');
                    break;
                case 'week':
                    matchesDate = eventDate.isSame(today, 'week');
                    break;
                case 'month':
                    matchesDate = eventDate.isSame(today, 'month');
                    break;
                case 'nextMonth':
                    matchesDate = eventDate.isSame(today.add(1, 'month'), 'month');
                    break;
                
            }
        }
        
        return matchesOccasion && matchesVenue && matchesClient && matchesDate;
    });
    
    $('#calendar').fullCalendar('removeEvents');
    $('#calendar').fullCalendar('addEventSource', filteredEvents);
    updateStats(filteredEvents);
});


// Today button
$('#todayBtn').click(function() {
    $('#calendar').fullCalendar('today');
});

// Create booking button
$('#createBookingBtn').click(function() {
    $('#createBookingModal').modal('show');
});



function updateStats(events) {
    $('#totalBookings').text(events.length);
    
    var thisMonth = moment().format('YYYY-MM');
    var monthEvents = events.filter(function(event) {
        return moment(event.start).format('YYYY-MM') === thisMonth;
    });
    $('#monthBookings').text(monthEvents.length);
    
    var today = moment().startOf('day');

    // Today’s events
    var todayEvents = events.filter(function(event) {
        return moment(event.start).isSame(today, 'day');
    });
    $('#todayBookings').text(todayEvents.length);

    // Upcoming (strictly after today)
    var upcomingEvents = events.filter(function(event) {
        return moment(event.start).isAfter(today, 'day');
    });
    $('#upcomingBookings').text(upcomingEvents.length);
    
    // Total revenue
    var totalRevenue = events.reduce(function(sum, event) {
        return sum + (parseFloat(event.net_amount) || 0);
    }, 0);
    $('#totalRevenue').text('₹' + totalRevenue.toLocaleString('en-IN'));
    
    // Upcoming revenue
    var totalUpcomingRevenue = upcomingEvents.reduce(function(sum, event) {
        return sum + (parseFloat(event.net_amount) || 0);
    }, 0);
    $('#totalUpcomingRevenue').text('₹' + totalUpcomingRevenue.toLocaleString('en-IN'));

    // Today revenue (optional)
    var totalTodayRevenue = todayEvents.reduce(function(sum, event) {
        return sum + (parseFloat(event.net_amount) || 0);
    }, 0);
    $('#totalTodayRevenue').text('₹' + totalTodayRevenue.toLocaleString('en-IN'));
}


        });
    </script>
@endsection