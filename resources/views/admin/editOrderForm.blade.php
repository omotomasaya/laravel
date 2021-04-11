@extends('layouts.admin')

@section('body')


<div class="table-responsive">

    <form action="{{ route('adminUpdateOrder',['order_id' => $order->order_id ])}}" method="post">

        @csrf

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" name="date" id="date" placeholder="Date" value="{{$order->date}}" required>
        </div>
        <div class="form-group">
            <label for="del_date">Delivery Dates</label>
            <input type="date" class="form-control" name="delivery_date" id="del_date" placeholder="Delivery date" value="{{$order->delivery_date}}" required>
        </div>


        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="Price" value="{{$order->price}}" required>
        </div>

        <div class="form-group">
            <label for="status">status</label>
            <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="{{$order->status}}" required>
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>

</div>




@endsection
