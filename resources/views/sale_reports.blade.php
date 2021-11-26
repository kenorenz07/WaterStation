<!DOCTYPE html>
<html>
<head>
    <title>Sales Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <h1>Sales Reports</h1>
    <p></p>
    <h3 class="text-left">GRAND TOTAL : {{"PHP ".$grandtotal}}</h3>
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-primary">
                <th scope="col">SALE #</th>
                <th scope="col">Customer</th>
                <th scope="col">Delivery man</th>
                <th scope="col">Products Ordered</th>
                <th scope="col">Date delivered</th>
                <th scope="col">Time delivered</th>
                <th scope="col">Total</th>
                <th scope="col">Sold at</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <th scope="row">{{ $sale->id }}</th>
                <td>{{ $sale->user->name }}({{$sale->user->email}})</td>
                <td>
                    @if ($sale->delivery_man)
                        {{  $sale->delivery_man->name }} ({{$sale->delivery_man->username}})
                    @else
                        Not Assigned
                    @endif
                </td>
                <td>
                    @foreach (json_decode($sale->orders) as $key => $item)
                        <p>{{$key}} =  Name:{{$item->product->name}}, Price:{{"PHP ".$item->product->price}}, Qnt.:{{$item->quantity}}</p>
                    @endforeach
                </td>
                <td>{{ $sale->date_delivered }}</td>
                <td>{{ $sale->time_delivered }}</td>
                <td>{{ "PHP ".$sale->total }}</td>
                <td>{{ $sale->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>