@extends(_app())

@section('title', $title ?? 'Dashboard')

@section('content')

    <div class="main-container">
        <div class="content-wrapper">
            <div class="row gutters">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="table-container">
                            <div class="table-responsive">
                                <table id="copy-print-csv" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Challan Type</th>
                                            <th>Challan No</th>
                                            <th>Ref PI No.</th>
                                            <th>Billing Date</th>
                                            <th>Customer Type</th>
                                            <th>Net Amount</th>
                                            {{-- <th>Net Discount</th> --}}
                                            <th>Total Tax</th>
                                            <th>Total Amount</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($challans && count($challans) > 0)
                                            @foreach ($challans as $data)
                                                <tr>
                                                  <td>
                                                        @if($data->challan_type == 'challan')
                                                            Delivery Challan
                                                        @elseif($data->challan_type == 'return-challan')
                                                            Return Challan
                                                        @else
                                                            {{ ucfirst($data->challan_type) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->challan_no }}</td>
                                                    <td>{{ $data->ref_pi_no  ?? ''}}</td>
                                                    <td>{{ date('d-m-Y', strtotime($data->billing_date)) }}</td>
                                                    <td>{{ $data->customerType ? $data->customerType->type : '' }}</td>
                                                    <td>{{ $data->net_amount }}</td>
                                                    {{-- <td>{{ $data->net_discount }}</td> --}}
                                                    <td>{{ $data->total_tax }}</td>
                                                    <td>{{ $data->total_amount }}</td>
                                                    <td colspan="3">
                                                        <a href="{{ route('challan.edit', ['id' => $data->id]) }}"
                                                            class="badge badge-success">Edit
                                                        </a>
                                                        {{-- <a href="{{ route('challan.print', ['id' => $data->id]) }}"
                                                            class="badge badge-info">Print
                                                        </a> --}}
                                                        {{-- <a href="{{ route('challan.email', ['id' => $data->id]) }}"
                                                            class="badge badge-success">Email Challan
                                                        </a> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
