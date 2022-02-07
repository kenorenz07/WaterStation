<!DOCTYPE html>
<html>
<head>
    <title>Delivery Orders Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <h1>Delivery Orders Report</h1>
    <p></p>
    <h3 class="text-left">TOTAL: {{$grandtotal."php"}}</h3>
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-primary">
                <th scope="col">Order#</th>
                <th scope="col">Customer</th>
                <th scope="col">DeliveryMan</th>
                <th scope="col">ProductsOrdered</th>
                <th scope="col">SubTotal</th>
                <th scope="col">Status</th>
                <th scope="col">OrderedTime</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <th scope="row">{{ $order->id }}</th>
                <td>{{ $order->user->name }} ({{$order->user->email}})</td>
                <td>
                    @if ($order->delivery_man)
                        {{  $order->delivery_man->name }} ({{$order->delivery_man->username}})
                    @else
                        Not Assigned
                    @endif
                </td>
                <td>
                    @foreach (json_decode($order->orders) as $key => $item)
                        <p>{{$key + 1}} =  Name: {{$item->product->name}}, Price: {{$item->product->price."php"}}, Qty: {{$item->quantity}}</p>
                    @endforeach
                </td>
                <td>{{ $order->total."php" }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>