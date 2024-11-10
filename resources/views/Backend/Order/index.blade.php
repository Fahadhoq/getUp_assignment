@extends('layouts.MasterDashboard')

@section('css')
<!-- Include necessary datatable and custom CSS -->
@include('layouts.partials.datatable-css')
<style>
    .category-header {
        background-color: #f8f9fa;
        font-weight: bold;
        text-align: center;
        padding: 10px;
        border-top: 2px solid #343a40;
        border-bottom: 1px solid #ced4da;
        margin-bottom: 10px;
    }

    .table-category {
        margin-bottom: 20px;
    }

    .no-child-orders {
        text-align: center;
        color: #6c757d;
        margin: 20px 0;
    }
</style>
@endsection

@section('container')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">Recent Orders by Product Category</h4>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name') }}</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                            <li class="breadcrumb-item active">Recent Orders</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Main container start -->
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            @include('layouts.partials.message-show')

                            @foreach($parent_orders as $parent_order)
                                <div class="mb-4">
                                    <h5 class="category-header">Order ID: {{ $parent_order->id }}</br> 
                                        <small>{{ $parent_order->customer->name }} </small>
                                    </h5>

                                    @if($parent_order->child_orders_grouped->isEmpty())
                                        <p class="no-child-orders">No child orders for this parent order.</p>
                                    @else
                                        @foreach($parent_order->child_orders_grouped as $category => $groupedOrders)
                                        <h6 class="mb-3 text-primary">Category: {{ ucwords(str_replace(['_', '-'], ' ', $category)) }}</h6>

                                            <table class="table table-hover table-bordered table-category">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th style="text-align:center">SL</th>
                                                        <th style="text-align:center">Product Name</th>
                                                        <th style="text-align:center">Category</th>
                                                        <th style="text-align:center">Total Amount</th>
                                                        <th style="text-align:center">Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp
                                                    @foreach($groupedOrders as $order)
                                                        <tr>
                                                            <td style="text-align:center">{{ $i++ }}</td>
                                                            <td style="text-align:center">{{ $order->product->name }}</td>
                                                            <td style="text-align:center">{{ $order->product->category->name }}</td>
                                                            <td style="text-align:center">{{ $order->total_price }}</td>
                                                            <td style="text-align:center">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main container end -->
        </div>
    </div>
</div>
@endsection

@section('jquery')
@include('layouts.partials.datatable-js')
@endsection

@section('script')
<script>
    // Custom script if needed
</script>
@endsection
