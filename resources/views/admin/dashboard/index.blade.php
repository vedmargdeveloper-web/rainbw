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

        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 18px;
            height: 14px;
        }

        .hamburger span {
            display: block;
            height: 2px;
            background-color: black;
        }

        .Hamburger-dropdown {
            background-color: #fff; 
            padding: 6px 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
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
                                <th>Unique ID/Invoice No</th>
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
                                <h3 class="fw-bold mb-0">{{ $overallGPValueFormatted }}</h3>
                                <small class="text-muted"><span class="text-success">{{ $overallGPPercent }}%</span> Avg. GP</small>
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
                                <!-- Left: Title -->
                                <h5 class="mb-0">
                                    Financial Performance (<span id="fyText">Business Analysis Report</span>)
                                </h5>

                                <!-- Right: Filters + Download -->
                                <div class="d-flex align-items-center gap-2 ms-auto">
                                    <!-- Month/Year selects -->
                                    <select class="form-select form-select-sm select-months" id="financialMonth">
                                        <option value="">Month</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}">
                                                {{ DateTime::createFromFormat('!m', $m)->format('M') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select class="form-select form-select-sm mr-2" id="financialYear">
                                        <option value="">Year</option>
                                        @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>

                                    <!-- Hamburger dropdown -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary Hamburger-dropdown" type="button" data-bs-toggle="dropdown">
                                            <div class="hamburger">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" id="downloadPNG">Download PNG</a></li>
                                            {{-- <li><a class="dropdown-item" href="#" id="downloadSVG">Download SVG</a></li> --}}
                                            <li><a class="dropdown-item" href="#" id="downloadCSV">Download CSV</a></li>
                                        </ul>
                                    </div>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="modal fade" id="summaryModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title" id="summaryModalLabel">Details</h5>
        <div class="d-flex gap-2">
          <button type="button" id="exportExcelBtn"
                  class="btn btn-light btn-sm mr-2"
                  title="Export">
              <i class="bi bi-download"></i>
          </button>
          <button type="button" class="btn-close" id="summaryModalClose" aria-label="Close">X</button>
        </div>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped" id="summaryChartTable">
            <thead></thead>  
            <tbody id="summaryChartResults"></tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="leadStatusModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable"> 
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title" id="leadStatusModalLabel">Details</h5>
        <div class="d-flex gap-2">
            <button type="button" 
                    id="leadStatusexportExcelBtn" 
                    class="btn btn-light btn-sm d-flex align-items-center gap-1 mr-2"
                    title="Export">
                <i class="bi bi-download"></i>
            </button>
            <button type="button" class="btn-close" id="leadStatusModalClose" aria-label="Close">X</button>
        </div>
      </div>

      <div class="modal-body">
        <!-- Responsive Table Wrapper -->
        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle" id="leadStatusChartTable">
            <thead class="table-light">
              <tr>
                <th>S/No</th>
                <th>Type</th>
                <th>Client</th>
                <th>POC</th>
                <th>Unique ID</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Whatsapp</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="leadStatusChartResults"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="lossBusinessModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title" id="lossBusinessModalLabel">Loss Business Details</h5>
        <div class="d-flex gap-2">
            <button type="button" 
                    id="lossBusinessexportExcelBtn" 
                    class="btn btn-light btn-sm d-flex align-items-center gap-1 mr-2"
                    title="Export">
                <i class="bi bi-download"></i>
            </button>
            <button type="button" class="btn-close" id="lossBusinessModalClose" aria-label="Close">X</button>
        </div>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>S/No</th>
                <th>Client</th>
                <th>Unique ID</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Whatsapp</th>
                <th>Reason</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="lossBusinessChartResults"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas2svg@1.0.19/canvas2svg.min.js"></script>



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
 
               // ===== Bootstrap Modal Instance =====
            const leadStatusModalEl = document.getElementById('leadStatusModal');
            const leadStatusModal   = new bootstrap.Modal(leadStatusModalEl);

            // ===== Click on Chart Slice =====
            document.getElementById('leadStatusChart').onclick = function(evt) {
                const activePoints = leadStatusChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
                if (!activePoints.length) return;

                const index = activePoints[0].index;
                const key   = leadStatusChart.data.labels[index]; // <-- FIXED

                // Filters
                const month = document.getElementById('leadStatusMonth')?.value || '';
                const year  = document.getElementById('leadStatusYear')?.value || '';

                fetch(`${base_url}/admin/dashboard/leadStatus-details?type=${encodeURIComponent(key)}&month=${month}&year=${year}`)
                    .then(res => res.json())
                    .then(rows => {
                        let html = '';
                        rows.forEach((row, i) => {
                            html += `
                                <tr>
                                    <td>${i+1}</td>
                                    <td>${row.type}</td>
                                    <td>${row.client}</td>
                                    <td>${row.poc}</td>
                                    <td>${row.unique_id}</td>
                                    <td>${row.phone}</td>
                                    <td>${row.email}</td>
                                    <td>${row.whatsapp}</td>
                                    <td><a href="${row.edit_url}" class="btn btn-sm btn-primary">Edit</a></td>
                                </tr>
                            `;
                        });
                        document.getElementById('leadStatusChartResults').innerHTML = html;
                        document.getElementById('leadStatusModalLabel').textContent = `${key} Details`;
                        leadStatusModal.show();
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Failed to load details. Please try again.");
                    });
            };

            // Close modal button
            document.getElementById('leadStatusModalClose')?.addEventListener('click', () => {
                leadStatusModal.hide();
            });

            // Export Excel
            document.getElementById('leadStatusexportExcelBtn').addEventListener('click', () => {
                const type  = document.getElementById('leadStatusModalLabel').textContent.split(' Details')[0];
                const month = document.getElementById('leadStatusMonth')?.value || '';
                const year  = document.getElementById('leadStatusYear')?.value || '';

                const url = `${base_url}/admin/dashboard/leadStatus-export?type=${encodeURIComponent(type)}&month=${month}&year=${year}`;
                window.open(url, '_blank'); 
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


            document.getElementById('downloadPNG').addEventListener('click', function() {
                const link = document.createElement('a');
                link.href = financialChart.toBase64Image();
                link.download = 'Financial-Chart.png';
                link.click();
            });

            // document.getElementById('downloadSVG').addEventListener('click', function() {
            //     const canvas = financialChart.canvas;
            //     const svgData = `
            //         <svg xmlns="http://www.w3.org/2000/svg" width="${canvas.width}" height="${canvas.height}">
            //             <foreignObject width="100%" height="100%">
            //                 ${canvas.outerHTML}
            //             </foreignObject>
            //         </svg>
            //     `;
            //     const blob = new Blob([svgData], {type: 'image/svg+xml'});
            //     const url = URL.createObjectURL(blob);
            //     const a = document.createElement('a');
            //     a.href = url;
            //     a.download = 'Financial-Chart.svg';
            //     a.click();
            //     URL.revokeObjectURL(url);
            // });

            // ---- Download CSV ----
           
            document.getElementById('downloadCSV').addEventListener('click', function() {
            const month = document.getElementById('financialMonth').value;
            const year = document.getElementById('financialYear').value;

            // Build URL with query params
            const url = `${base_url}/admin/financial-chart/export-csv?month=${month}&year=${year}`;

            fetch(url)
                .then(res => res.blob())
                .then(blob => {
                    const downloadUrl = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = downloadUrl;
                    a.download = 'Financial-Chart.csv';
                    a.click();
                    window.URL.revokeObjectURL(downloadUrl);
                });
            });


            //Summary Chart
            const summaryData = @json($summary);
            const labels = Object.keys(summaryData).map(key => {
                const item = summaryData[key];
                if (item.amt && item.amt > 0) {
                    return `${key} (${item.qty}, ₹${Number(item.amt).toLocaleString()})`;
                    //  return `${key} (${item.qty})`;
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
   
                // ===== Bootstrap Modal Instance =====
        
            const summaryModalEl = document.getElementById('summaryModal');
                const summaryModal   = new bootstrap.Modal(summaryModalEl);

                // ===== Click on Chart Slice =====
                document.getElementById('summaryChart').onclick = function(evt) {
                    const activePoints = summaryChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
                    if (!activePoints.length) return;

                    const index = activePoints[0].index;
                    const key   = Object.keys(summaryData)[index];

                    // Filters
                    const month = document.getElementById('summaryMonth')?.value || '';
                    const year  = document.getElementById('summaryYear')?.value || '';

                    fetch(`${base_url}/admin/dashboard/summary-details?type=${encodeURIComponent(key)}&month=${month}&year=${year}`)
                        .then(res => res.json())
                        .then(data => {
                            // ===== Build Table Head =====
                            let theadHtml = '<tr>';
                            data.columns.forEach(col => {
                                theadHtml += `<th>${col}</th>`;
                            });
                            theadHtml += '</tr>';
                            document.querySelector("#summaryChartTable thead").innerHTML = theadHtml;

                            // ===== Build Table Body =====
                            let tbodyHtml = '';
                            data.rows.forEach((row, i) => {
                                tbodyHtml += '<tr>';
                                tbodyHtml += `<td>${i+1}</td>`; // First column always S/No.

                                // Loop through row keys except edit_url
                                Object.keys(row).forEach(k => {
                                    if (k !== 'edit_url') {
                                        tbodyHtml += `<td>${row[k] ?? ''}</td>`;
                                    }
                                });

                                // Action column (edit link/button)
                                if (row.edit_url) {
                                    tbodyHtml += `<td><a href="${row.edit_url}" class="badge bg-primary">Edit</a></td>`;
                                } else {
                                    tbodyHtml += '<td>-</td>';
                                }

                                tbodyHtml += '</tr>';
                            });

                            document.querySelector("#summaryChartTable tbody").innerHTML = tbodyHtml;

                            // ===== Update Modal Title & Show =====
                            document.getElementById('summaryModalLabel').textContent = `${data.type} Details`;
                            summaryModal.show();
                        })
                        .catch(err => {
                            console.error(err);
                            alert("Failed to load details. Please try again.");
                        });
                };

                // ===== Close modal button =====
                document.getElementById('summaryModalClose')?.addEventListener('click', () => {
                    summaryModal.hide();
                });

                // ===== Export button =====
                document.getElementById('exportExcelBtn')?.addEventListener('click', () => {
                    const type  = document.getElementById('summaryModalLabel').textContent.split(' ')[0];
                    const month = document.getElementById('summaryMonth')?.value || '';
                    const year  = document.getElementById('summaryYear')?.value || '';

                    window.location.href = `${base_url}/admin/dashboard/summary-export?type=${encodeURIComponent(type)}&month=${month}&year=${year}`;
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


            // ===== Bootstrap Modal Instance =====
            const lossBusinessModalEl = document.getElementById('lossBusinessModal');
            const lossBusinessModal   = new bootstrap.Modal(lossBusinessModalEl);

            // ===== Click on Chart Slice =====
            document.getElementById('lossBusinessChart').onclick = function(evt) {
                const activePoints = lossBusinessChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
                if (!activePoints.length) return;

                const index = activePoints[0].index;
                const reason = lossBusinessChart.data.labels[index]; // reason text

                // Filters
                const month = document.getElementById('lossBusinessMonth')?.value || '';
                const year  = document.getElementById('lossBusinessYear')?.value || '';

                fetch(`${base_url}/admin/dashboard/lossBusiness-details?reason=${encodeURIComponent(reason)}&month=${month}&year=${year}`)
                    .then(res => res.json())
                    .then(rows => {
                        let html = '';
                        rows.forEach((row, i) => {
                            html += `
                                <tr>
                                    <td>${i+1}</td>
                                    <td>${row.client}</td>
                                    <td>${row.unique_id}</td>
                                    <td>${row.phone}</td>
                                    <td>${row.email}</td>
                                    <td>${row.whatsapp}</td>
                                    <td>${reason}</td>
                                    <td><a href="${row.edit_url}" class="btn btn-sm btn-primary">Edit</a></td>
                                </tr>
                            `;
                        });
                        document.getElementById('lossBusinessChartResults').innerHTML = html;
                        document.getElementById('lossBusinessModalLabel').textContent = `${reason} Details`;
                        lossBusinessModal.show();
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Failed to load details. Please try again.");
                    });
            };

            // Close modal button
            document.getElementById('lossBusinessModalClose')?.addEventListener('click', () => {
                lossBusinessModal.hide();
            });

            // Export Excel
            document.getElementById('lossBusinessexportExcelBtn').addEventListener('click', () => {
                const reason = document.getElementById('lossBusinessModalLabel').textContent.split(' Details')[0];
                const month  = document.getElementById('lossBusinessMonth')?.value || '';
                const year   = document.getElementById('lossBusinessYear')?.value || '';

                const url = `${base_url}/admin/dashboard/lossBusiness-export?reason=${encodeURIComponent(reason)}&month=${month}&year=${year}`;
                window.open(url, '_blank'); 
            });




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
                            const labels = data.map(d => d.head);
                            const quantities = data.map(d => d.qty);
                            const percents = data.map(d => d.percent);

                            // Replace datasets entirely to fix doughnut chart issues
                            chart.data.labels = labels;
                            chart.data.datasets = [{
                                data: quantities,
                                backgroundColor: [
                                    '#EF4444', '#F59E0B', '#10B981', '#3B82F6',
                                    '#8B5CF6', '#EC4899', '#14B8A6', '#F97316',
                                    '#6366F1', '#84CC16', '#DC2626'
                                ],
                                borderWidth: 1,
                                hoverOffset: 6
                            }];

                            // Optional: update tooltip with percentage
                            chart.options.plugins.tooltip.callbacks.label = function(context) {
                                const idx = context.dataIndex;
                                return `${context.label}: ${quantities[idx]} (${percents[idx]}%)`;
                            };

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
