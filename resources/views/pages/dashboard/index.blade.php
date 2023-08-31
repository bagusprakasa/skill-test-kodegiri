@extends('layouts.template')
@section('content')
    {{-- <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-money-bill" style="color: #28a745"></i> Total Income</div>
                </div>
                <div class="card-body">
                    <h3>{{ Helper::rupiah($data['totalTransaction'][0]->grandTotal) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="fas fa-shopping-cart" style="color: #007bff"></i> Total Order</div>
                </div>
                <div class="card-body">
                    <h3>{{ $data['sales'] }}</h3>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
