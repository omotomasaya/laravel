@extends('layouts.admin')

@section('body')

<h1>Orders Panel</h1>

@if(session('orderDeletionStatus'))
<div class="alert alert-danger">{{ session('orderDeletionStatus') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#order_id</th>
            <th>Date</th>
            <th>Delivery Date</th>
            <th>Price</th>
            <th>user_id</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Remove</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
        <tr>
          <td>{{ $order->order_id }}</td>
          <td>{{ $order->date }}</td>
          <td>{{ $order->delivery_date }}</td>
          <td>{{ $order->price }}</td>
          <td>{{ $order->user_id }}</td>
          <td>{{ $order->status }}</td>
          <td><a href="{{ route('adminEditOrderForm',['order_id'=> $order->order_id]) }}" class="btn btn-primary">Edit</a></td>
          <td><a href="{{ route('adminDeleteOrder',['order_id'=> $order->order_id]) }}" class="btn btn-warning" >Remove</a></td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
@endsection
