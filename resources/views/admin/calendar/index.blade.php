@extends(_app())

@section('title', 'Booking Calendar')

@section('content')

{{-- <!DOCTYPE html>
<html lang="en"> --}}
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
            <div class="col-xl-4 col-md-6 ">
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
            
            {{-- <div class="col-xl-3 col-md-6 ">
                <div class="stats-card card-success">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">This Month</div>
                            <div class="h5 mb-0 font-weight-bold" id="monthBookings">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div> --}}
            
            <div class="col-xl-4 col-md-6 ">
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
            
            <div class="col-xl-4 col-md-6 ">
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
        </div>
        
        <!-- Filters -->
        {{-- <div class="row">
            <div class="col-12">
                <div class="filter-section">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="occasionFilter">Occasion</label>
                                <select class="form-control" id="occasionFilter">
                                    <option value="">All Occasions</option>
                                    <option value="Wedding">Wedding</option>
                                    <option value="Birthday">Birthday</option>
                                    <option value="Corporate">Corporate</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="venueFilter">Venue</label>
                                <input type="text" class="form-control" id="venueFilter" placeholder="Filter by venue">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="clientFilter">Client</label>
                                <input type="text" class="form-control" id="clientFilter" placeholder="Filter by client">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="dateRangeFilter">Date Range</label>
                                <select class="form-control" id="dateRangeFilter">
                                    <option value="">All Dates</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="nextMonth">Next Month</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         --}}
        <!-- Calendar -->
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Booking No:</strong> <span id="modal_booking_no"></span></p>
                            <p><strong>Quotation No:</strong> <span id="modal_quotation_no"></span></p>
                            <p><strong>Client Name:</strong> <span id="modal_client_name"></span></p>
                            <p><strong>Contact Person:</strong> <span id="modal_contact_name"></span></p>
                            <p><strong>Mobile:</strong> <span id="modal_mobile"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Venue:</strong> <span id="modal_venue"></span></p>
                            <p><strong>Occasion:</strong> <span id="modal_occasion"></span></p>
                            <p><strong>Date:</strong> <span id="modal_date"></span></p>
                            <p><strong>Total Amount:</strong> ₹<span id="modal_total_amount"></span></p>
                            <p><strong>Total Amount:</strong> ₹<span id="modal_total_tax"></span></p> 
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Items:</strong> <span id="modal_items"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editBookingBtn">Edit</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Create Booking Modal -->
    <div class="modal fade" id="createBookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createBookingForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="clientName" class="form-label">Client Name</label>
                            <input type="text" class="form-control" id="clientName" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookingDate" class="form-label">Booking Date</label>
                            <input type="date" class="form-control" id="bookingDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookingVenue" class="form-label">Venue</label>
                            <input type="text" class="form-control" id="bookingVenue">
                        </div>
                        <div class="mb-3">
                            <label for="bookingAmount" class="form-label">Total Amount (₹)</label>
                            <input type="number" class="form-control" id="bookingAmount" min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Booking</button>
                    </div>
                </form>
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
            '<br><small>' + event.venue + '</small>' +
            '<br><small>₹' + event.total_amount + '</small>'
        );
    },
    eventClick: function(event) {
        $.ajax({
            url: SITEURL + "/booking-calendar/events/" + event.id,
            type: "GET",
            success: function(response) {
                $('#modal_booking_no').text(response.booking_no);
                $('#modal_quotation_no').text(response.quotation_no);
                $('#modal_client_name').text(response.client_name);
                $('#modal_contact_name').text(response.contact_name);
                $('#modal_mobile').text(response.mobile);
                $('#modal_venue').text(response.venue);
                $('#modal_occasion').text(response.occasion);
                $('#modal_date').text(response.date);
                $('#modal_total_amount').text(response.total_amount);
                $('#modal_total_tax').text(response.total_tax);
                $('#modal_items').text(response.items);
                
                
                $('#bookingModal').modal('show');
            },
            error: function() {
                toastr.error('Failed to load booking details');
            }
        });
    },
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

// Create booking
$('#createBookingForm').on('submit', function(e) {
    e.preventDefault();
    var formData = {
        title: $('#clientName').val(),
        start: $('#bookingDate').val(),
        venue: $('#bookingVenue').val(),
        total_amount: $('#bookingAmount').val() || 0,
        type: 'add'
    };

    $.ajax({
        url: SITEURL + "/booking-calendar/events",
        type: "POST",
        data: formData,
        success: function() {
            $('#createBookingModal').modal('hide');
            $('#createBookingForm')[0].reset();
            $('#calendar').fullCalendar('refetchEvents');
            toastr.success('Booking created successfully');
        },
        error: function() {
            toastr.error('Failed to create booking');
        }
    });
});

// Today button
$('#todayBtn').click(function() {
    $('#calendar').fullCalendar('today');
});

// Create booking button
$('#createBookingBtn').click(function() {
    $('#createBookingModal').modal('show');
});

// Update stats
function updateStats(events) {
    $('#totalBookings').text(events.length);
    
    var thisMonth = moment().format('YYYY-MM');
    var monthCount = events.filter(function(event) {
        return moment(event.start).format('YYYY-MM') === thisMonth;
    }).length;
    $('#monthBookings').text(monthCount);
    
    var today = moment().startOf('day');
    var upcomingCount = events.filter(function(event) {
        return moment(event.start).isSameOrAfter(today);
    }).length;
    $('#upcomingBookings').text(upcomingCount);
    
    var totalRevenue = events.reduce(function(sum, event) {
        return sum + (parseFloat(event.total_amount) || 0);
    }, 0);
    $('#totalRevenue').text('₹' + totalRevenue.toLocaleString('en-IN'));
}

        });
    </script>
{{-- </body>
</html> --}}
@endsection