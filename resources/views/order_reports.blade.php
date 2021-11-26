<!DOCTYPE html>
<html>
<head>
    <title>Order Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <h1>Order Reports</h1>
    <p></p>
    <h3 class="text-left">GRAND TOTAL : {{"PHP ".$grandtotal}}</h3>
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-primary">
                <th scope="col">Order #</th>
                <th scope="col">Customer</th>
                <th scope="col">Delivery man</th>
                <th scope="col">Products Ordered</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col">Ordered at</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <th scope="row">{{ $order->id }}</th>
                <td>{{ $order->user->name }}({{$order->user->email}})</td>
                <td>
                    @if ($order->delivery_man)
                        {{  $order->delivery_man->name }} ({{$order->delivery_man->username}})
                    @else
                        Not Assigned
                    @endif
                </td>
                <td>
                    @foreach (json_decode($order->orders) as $key => $item)
                        <p>{{$key}} =  Name:{{$item->product->name}}, Price:{{"PHP ".$item->product->price}}, Qnt.:{{$item->quantity}}</p>
                    @endforeach
                </td>
                <td>{{ "PHP ".$order->total }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>