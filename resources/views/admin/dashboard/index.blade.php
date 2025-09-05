@extends(_app())
@section('title', $title ?? 'Dashboard')
@section('content')
    <style>
        .shadow-sm {
            border-radius: 8px;
        }

        .select-months {
            margin-right: 5px;
        }

        .form-select {
            border-radius: 8px;
        }

        .search {
            border-radius: 20px;
            height: 40px;
        }
    </style>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container">
            <div class="search-container position-relative">
                <form method="GET" action="javascript:void(0);">
                    <input type="text" name="search" class="form-control w-100 search"
                       placeholder="Search by PI No, Invoice No, Client Name, POC, Phone, Email, or Venue...">

                </form>

                <!-- Floating search results -->
                <div id="searchResultsContainer" 
                    class="card shadow mt-1 position-absolute w-100" 
                    style="display:none; z-index:1050; max-height:400px; overflow-y:auto;">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Client</th>
                                <th>POC</th>
                                <th>Unique ID</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Whatsapp</th>
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="searchResults"></tbody>
                    </table>
                </div>
            </div>
            </div>



            <main class="container-fluid py-4 ">
                <!-- KPI Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4 col-lg">
                        <a href="{{ route('invoice.index') }}">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Bill</p>
                                    <h3 class="fw-bold mb-0">{{ $invoiceCount }}</h3>
                                    <small class="text-muted">₹{{ $invoiceTotal }}</small>

                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-lg">
                        <a href="{{ route('inquiry.index') }}">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Total Inquiries</p>
                                    <h3 class="fw-bold mb-0">{{ $inquiryCount }}</h3>
                                    <small class="text-muted d-block fixed-small"
                                        style=" min-height: 18px; display: inline-block;">&nbsp;</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-lg">
                        <a href="{{ route('quotation.index') }}">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Quotation</p>
                                    <h3 class="fw-bold mb-0">{{ $quotationCount }}</h3>
                                    <small class="text-muted">₹{{ $quotationTotalAmount }}</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-lg">
                        <a href="{{ route('booking.index') }}">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Confirmed Bookings</p>
                                    <h3 class="fw-bold mb-0">{{ $bookingCount }}</h3>
                                    <small class="text-muted">₹{{ $bookingTotalAmount }}</small>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-lg">
                        <a href="{{ route('pitch.index') }}">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Pitch</p>
                                    <h3 class="fw-bold mb-0">{{ $pitchCount }}</h3>
                                    <small class="text-muted">₹{{ $pitchTotalAmount }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 col-lg">

                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="text-muted mb-1">Total Gross Profit</p>
                                <h3 class="fw-bold mb-0">₹96.3L</h3>
                                <small class="text-muted"><span class="text-success">45.33%</span> Avg. GP</small>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <!-- For Summary -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Summary</h5>
                                    <div class="d-flex gap-2 mb-2">
                                        <select id="summaryMonth" class="form-select form-select-sm select-months">
                                            <option value="">Month</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">
                                                    {{ DateTime::createFromFormat('!m', $m)->format('M') }}</option>
                                            @endfor
                                        </select>

                                        <select id="summaryYear" class="form-select form-select-sm">
                                            <option value="">Year</option>
                                            @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                </div>
                                <div class="chart-container" style="height: 250px;">
                                    <canvas id="summaryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- For status Inquiry -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Status of Inquiries</h5>

                                    <div class="d-flex gap-2 mb-2">
                                        <select class="form-select form-select-sm select-months" id="leadStatusMonth">
                                            <option value="">Month</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">
                                                    {{ DateTime::createFromFormat('!m', $m)->format('M') }}</option>
                                            @endfor
                                        </select>
                                        <select class="form-select form-select-sm" id="leadStatusYear">
                                            <option value="">Year</option>
                                            @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="chart-container" style="height: 250px;">
                                    <canvas id="leadStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- For Loss Business -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Loss of Business</h5>
                                    <div class="d-flex gap-2 mb-2">
                                        <select class="form-select form-select-sm select-months" id="lossBusinessMonth">
                                            <option value="">Month</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">
                                                    {{ DateTime::createFromFormat('!m', $m)->format('M') }}</option>
                                            @endfor
                                        </select>
                                        <select class="form-select form-select-sm" id="lossBusinessYear">
                                            <option value="">Year</option>
                                            @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="chart-container" style="height: 300px;">
                                    <canvas id="lossBusinessChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- For Financial Performance -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class=" mb-0">Financial Performance (<span id="fyText">Business Analysis
                                            Report</span>)</h5>
                                    <div class="d-flex gap-2 mb-2">
                                        <select class="form-select form-select-sm select-months" id="financialMonth">
                                            <option value="">Month</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">
                                                    {{ DateTime::createFromFormat('!m', $m)->format('M') }}</option>
                                            @endfor
                                        </select>
                                        <select class="form-select form-select-sm" id="financialYear">
                                            <option value="">Year</option>
                                            @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                </div>
                                <div class="chart-container" style="height: 300px;">
                                    <canvas id="financialChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Tables Section -->
                <div class="row g-3">
                    {{-- <div class="col-xl-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Finds Values</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>S/No.</th>
                                            <th>Type</th>
                                            <th>Client Name</th>
                                            <th>Unique id</th>
                                            <th>Phone No</th>
                                            <th>Email</th>
                                            <th>Whatsapp</th>
                                            <th>Lead Status</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($latestInquiries && count($latestInquiries) > 0)
                                            @foreach ($latestInquiries as $inv)
                                                @php
                                                    $customer = json_decode($inv->customer_details, true);

                                                    $contact_person = $inv->customer
                                                        ? json_decode($inv->customer->contact_person_name, true)
                                                        : false;
                                                    $contact_person_mobile = $inv->customer
                                                        ? json_decode($inv->customer->mobile, true)
                                                        : false;

                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }} </td>
                                                    <td>{{ $inv->customer->company_name ?? '' }}</td>
                                                    <td>{{ }}</td>
                                                    <td>{{ $inv->unique_id }}</td>
                                                    <td>{{ $contact_person ? $contact_person_mobile[$inv->contact_person_c] ?? $contact_person_mobile[0] : 'Something Wrong' }}
                                                    </td>
                                                    <td>{{ $inv->customer ? $inv->customer->email : 'Something Wrong' }}
                                                    </td>
                                                    <td>{{ $inv->customer->cwhatsapp ?? '' }}</td>
                                                    <td>{{ $inv->leadstatus ? $inv->leadstatus->status : '' }}</td>
                                                    <td colspan="3">
                                                        <a href="{{ route('inquiry.edit', ['inquiry' => $inv->id]) }}"
                                                            class="badge badge-success">Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-xl-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Upcoming Events</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Booking No</th>
                                            <th>Quotation Id</th>
                                            <th>Client</th>
                                            <th>POC</th>
                                            <th>Mobile</th>
                                            <th>Booking Date</th>
                                            <th>Readyness</th>
                                            <th>Venue</th>
                                            <th>Occassion</th>
                                            <th>Total Amount</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($latestBooking && count($latestBooking) > 0)
                                            @foreach ($latestBooking as $inv)
                                                @php
                                                    $customer_details = json_decode($inv->customer_details, true);
                                                    $venue_details = json_decode($inv->delivery_details, true);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $inv->invoice_no }}</td>
                                                    <td>{{ $inv->quotaiton->invoice_no ?? '' }}</td>
                                                    <td>{{ $customer_details['company_name'] ?? '' }}</td>
                                                    <td>{{ is_numeric($customer_details['contact_person_c']) ? $customer_details['select_two_name'] ?? '' : $customer_details['contact_person_c'] }}
                                                    </td>
                                                    <td>

                                                        {{ $customer_details['cmobile'] ?? '' }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($inv->billing_date)) }}</td>
                                                    <td>{{ $customer_details['creadyness'] ?? '' }}</td>
                                                    <td>{{ $venue_details['dvenue_name'] ?? '' }}</td>
                                                    <td>{{ $inv->quotaiton->occasion->occasion ?? '' }}</td>


                                                    <td>{{ $inv->total_amount }}</td>
                                                    <td colspan="3">

                                                        <a href="{{ route('booking.print', ['id' => $inv->id]) }}"
                                                            class="badge badge-info">Print
                                                        </a>
                                                        <a href="{{ route('booking.email', ['id' => $inv->id]) }}"
                                                            class="badge badge-success">Email Booking
                                                        </a>
                                                        <a href="{{ route('booking.edit', ['booking' => $inv->id]) }}"
                                                            class="badge badge-primary">Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div> --}}
                </div>
                <div class="modal fade" id="searchModal" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Search Results</h5>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">x</button>
                    </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                <th>S/No</th>
                                <th>Type</th>
                                <th>Client</th>
                                <th>Unique ID</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Whatsapp</th>
                                <th>Status</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults"></tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    </div>

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const base_url = "{{ config('app.url') }}";

        document.addEventListener('DOMContentLoaded', function() {
            // Lead Status Chart (Doughnut)
            const leadStatusCtx = document.getElementById('leadStatusChart').getContext('2d');
            const leadStatusChart = new Chart(leadStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($leadStatusLabels),
                    datasets: [{
                        data: @json($leadStatusData),
                        backgroundColor: [
                            '#3B82F6', '#F59E0B', '#10B981', '#EF4444',
                            '#8B5CF6', '#EC4899', '#14B8A6', '#F97316',
                            '#22C55E', '#64748B', '#E11D48', '#0EA5E9',
                            '#A16207', '#BE185D', '#16A34A', '#EA580C'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 15
                            }
                        },
                    }
                }
            });

            // Financial Performance Chart (Bar & Line)
            const financialCtx = document.getElementById('financialChart').getContext('2d');
            const financialChart = new Chart(financialCtx, {
                type: 'bar',
                data: {
                    labels: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb',
                        'Mar'
                    ],
                    datasets: [
                        // TT Business Dataset (Bars)
                        {
                            type: 'bar',
                            label: 'TT Business (₹)',
                            data: @json($ttBusinessData),
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgb(59, 130, 246)',
                            borderWidth: 1,
                            yAxisID: 'y'
                        },
                        // GP % Dataset (Line)
                        {
                            type: 'line',
                            label: 'GP %',
                            data: @json($gpPercentData),
                            backgroundColor: 'rgba(239, 68, 68, 0.2)',
                            borderColor: 'rgb(239, 68, 68)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'TT Business (₹)'
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            min: 0,
                            max: 100,
                            title: {
                                display: true,
                                text: 'GP %'
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    }
                }
            });


            //Summary Chart
            const summaryData = @json($summary);
            const labels = Object.keys(summaryData).map(key => {
                const item = summaryData[key];
                if (item.amt && item.amt > 0) {
                    return `${key} (${item.qty}, ₹${Number(item.amt).toLocaleString()})`;
                }
                return `${key} (${item.qty})`;
            });
            const qtyValues = Object.values(summaryData).map(item => item.qty);

            // Chart.js
            const ctx = document.getElementById('summaryChart').getContext('2d');
            const summaryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: qtyValues,
                        backgroundColor: [
                            '#3B82F6', // Inquiry
                            '#10B981', // P.I.
                            '#F59E0B', // Bookings
                            '#8B5CF6', // Invoices
                            '#EF4444' // Challans
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const key = context.label.split(" ")[0];
                                    const val = summaryData[key];
                                    let amtText = (val.amt && val.amt > 0) ?
                                        `, Amt: ₹${Number(val.amt).toLocaleString()}` :
                                        '';
                                    return `Qty: ${val.qty}${amtText}, Conv: ${val.conv}`;
                                }
                            }
                        }
                    }
                }

            });

            // Business Loss Chart
            const lossBusinessLabels = @json(array_column($lossBusinessFinal, 'head'));
            const lossBusinessData = @json(array_column($lossBusinessFinal, 'qty'));
            const lossBusinessPerc = @json(array_column($lossBusinessFinal, 'percent'));

            console.log('Labels:', lossBusinessLabels);
            console.log('Data:', lossBusinessData);
            console.log('Perc:', lossBusinessPerc);

            const ctxLoss = document.getElementById('lossBusinessChart');
            let lossBusinessChart = null;

            if (ctxLoss) {
                lossBusinessChart = new Chart(ctxLoss.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: lossBusinessLabels,
                        datasets: [{
                            data: lossBusinessData,
                            backgroundColor: [
                                '#EF4444', '#F59E0B', '#10B981', '#3B82F6',
                                '#8B5CF6', '#EC4899', '#14B8A6', '#F97316',
                                '#6366F1', '#84CC16', '#DC2626'
                            ],
                            borderWidth: 1,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    boxWidth: 15
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const idx = context.dataIndex;
                                        const qty = lossBusinessData[idx];
                                        const perc = lossBusinessPerc[idx];
                                        return `${context.label}: ${qty} (${perc}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                console.warn("No data for Loss Business Chart");
            }

            const charts = {
                summary: summaryChart,
                leadStatus: leadStatusChart,
                lossBusiness: lossBusinessChart,
                financial: financialChart
            };

            // ===== UPDATE CHART FUNCTION =====
            function updateChart(type, month, year) {
                console.log("Updating chart:", type, "Month:", month, "Year:", year);

                fetch(`${base_url}/admin/dashboard/filter-chart?chartType=${type}&month=${month}&year=${year}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log("Data received for", type, data);

                        const chart = charts[type];
                        if (!chart) {
                            console.error("Chart not found:", type);
                            return;
                        }

                        if (type === 'summary') {
                            chart.data.labels = data.labels;
                            chart.data.datasets[0].data = data.qtyValues;
                        } else if (type === 'leadStatus') {
                            chart.data.labels = data.labels;
                            chart.data.datasets[0].data = data.data;
                        } else if (type === 'lossBusiness') {
                            chart.data.labels = data.map(d => d.head);
                            chart.data.datasets[0].data = data.map(d => d.qty);
                        } else if (type === 'financial') {
                            chart.data.datasets[0].data = data.ttBusinessData;
                            chart.data.datasets[1].data = data.gpPercentData;
                            chart.data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
                                'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                            ];
                        }

                        chart.update();
                    })
                    .catch(error => console.error('Error fetching chart data:', error));
            }


            // ===== ATTACH FILTER EVENTS =====
            function addFilterEvents(chartType, monthId, yearId) {
                const monthEl = document.getElementById(monthId);
                const yearEl = document.getElementById(yearId);

                function applyFilter() {
                    const month = monthEl.value;
                    const year = yearEl.value;
                    updateChart(chartType, month, year);
                }

                monthEl.addEventListener('change', applyFilter);
                yearEl.addEventListener('change', applyFilter);
            }

            // Attach events for each chart
            addFilterEvents('summary', 'summaryMonth', 'summaryYear');
            addFilterEvents('leadStatus', 'leadStatusMonth', 'leadStatusYear');
            addFilterEvents('lossBusiness', 'lossBusinessMonth', 'lossBusinessYear');
            addFilterEvents('financial', 'financialMonth', 'financialYear');

        });


        $(document).ready(function () {
            let timer;

            $('.search').on('keyup', function () {
                clearTimeout(timer);
                let searchTerm = $(this).val();

                if (searchTerm.length < 2) {
                    $('#searchResultsContainer').hide();
                    $('#searchResults').html('');
                    return;
                }

                timer = setTimeout(function () {
                    $.ajax({
                        url: "{{ route('dashboard.search') }}",
                        type: "GET",
                        data: { search: searchTerm },
                        success: function (data) {
                            let rows = '';

                            if (data.length === 0) {
                                rows = `<tr><td colspan="9" class="text-center">No results found</td></tr>`;
                            } else {
                                data.forEach((item, index) => {
                                    rows += `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${item.type}</td>
                                            <td>${item.client}</td>
                                            <td>${item.poc}</td>
                                            <td>${item.unique_id}</td>
                                            <td>${item.phone}</td>
                                            <td>${item.email}</td>
                                            <td>${item.whatsapp}</td>
                                        
                                            <td>
                                                <a href="${item.edit_url}" class="btn btn-sm btn-primary">Edit</a>
                                            </td>
                                        </tr>
                                    `;
                                });
                            }

                            $('#searchResults').html(rows);
                            $('#searchResultsContainer').show();
                        }
                    });
                }, 400);
            });
        });


    </script>
@endsection
