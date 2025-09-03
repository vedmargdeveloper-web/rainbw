@extends(_app())

@section('title', $title ?? 'Challans')

@section('content')

    <div class="main-container">
        <div class="content-wrapper">
            <form method="GET" action="{{ route('challan.index') }}" class="mb-3 row g-2">
                <div class="col">
                    <select name="challan_type" class="form-control">
                        <option value="">Select Type</option>
                        @foreach ($challanTypes as $type)
                            <option value="{{ $type->type_name }}">{{ $type->type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="text" name="challan_no" class="form-control" placeholder="Challan No"
                        value="{{ request('challan_no') }}">
                </div>
                <div class="col">
                    <input type="text" name="ref_pi_no" class="form-control" placeholder="Ref PI No."
                        value="{{ request('ref_pi_no') }}">
                </div>
                <div class="col">
                    <select name="customer_type" class="form-control">
                        <option value="">All Customers</option>
                        @foreach ($customerTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ request('customer_type') == $type->id ? 'selected' : '' }}>
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('challan.index') }}" class="btn btn-secondary">Reset</a>
                    <a href="{{ route('challan.create') }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-plus"></i> New Challan
                    </a>
                </div>

            </form>

            <div class="row gutters">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="card">
                        <div class="table-container">
                            <div class="table-responsive">
                                <h4 class="text-center">Challans</h4>
                                <table id="copy-print-csv" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>S/No.</th>
                                            <th>Challan Type</th>
                                            <th>Challan No</th>
                                            <th>Ref PI No.</th>
                                            <th>Billing Date</th>
                                            <th>Customer Type</th>
                                            {{-- <th>Net Amount</th>
                                            <th>Total Tax</th>
                                            <th>Total Amount</th> --}}
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if ($challans && count($challans) > 0)
                                            @foreach ($challans as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->challan_type }}</td>
                                                    <td>{{ $data->challan_no }}</td>
                                                    <td>{{ $data->ref_pi_no ?? '' }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($data->billing_date)) }}</td>
                                                    <td>{{ $data->customerType ? $data->customerType->type : '' }}</td>
                                                    {{-- <td>{{ $data->net_amount }}</td>
                                                    <td>{{ $data->total_tax }}</td>
                                                    <td>{{ $data->total_amount }}</td> --}}
                                                    <td>
                                                        <a href="{{ route('challan.edit', ['id' => $data->id]) }}"
                                                            class="badge badge-success">Edit</a>
                                                        {{-- <a href="{{ route('return.challan', ['id' => $data->id]) }}"
                                                                class="badge badge-info">R.Ch
                                                            </a> --}}
                                                        {{-- <a href="{{ route('challan.print', ['id' => $data->id]) }}"
                                                                class="badge badge-info">Print
                                                            </a> --}}
                                                        {{-- <a href="{{ route('challan.email', ['id' => $data->id]) }}"
                                                                class="badge badge-success">Email Challan
                                                            </a> --}}

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center text-danger">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <div class="card">
                        <div class="table-container">
                            <div class="table-responsive">
                                <h4 class="text-center">Returnable Challans</h4>
                                <table id="copy-print-csv" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>S/No.</th>
                                            <th>Challan Type</th>
                                            <th>Challan No</th>
                                            <th>Ref PI No.</th>
                                            <th>Billing Date</th>
                                            <th>Customer Type</th>
                                            {{-- <th>Net Amount</th>
                                            <th>Total Tax</th>
                                            <th>Total Amount</th> --}}
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    {{-- Returnable Challans --}}
                                    <tbody>
                                        @if ($returnableChallans && count($returnableChallans) > 0)
                                            @foreach ($returnableChallans as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->challan_type }}</td>
                                                    <td>{{ $data->challan_no }}</td>
                                                    <td>{{ $data->ref_pi_no ?? '' }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($data->billing_date)) }}</td>
                                                    <td>{{ $data->customerType ? $data->customerType->type : '' }}</td>
                                                    {{-- <td>{{ $data->net_amount }}</td>
                                                    <td>{{ $data->total_tax }}</td>
                                                    <td>{{ $data->total_amount }}</td> --}}
                                                    <td>
                                                        <a href="{{ route('challan.edit', ['id' => $data->id]) }}"
                                                            class="badge badge-success">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="9" class="text-center text-danger">No Data Found</td>
                                            </tr>
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
