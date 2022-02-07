<!DOCTYPE html>
<html>
<head>
    <title>Delivery Sales Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <h1>Delivery Sales Report {{$delivery_names ? 'of '.$delivery_names : '' }}</h1>
    <p></p>
    <h3 class="text-left">TOTAL: {{$grandtotal."php"}}</h3>
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-primary">
                <th scope="col">Sale#</th>
                <th scope="col">Customer</th>
                <th scope="col">DeliveryMan</th>
                <th scope="col">ProductsOrdered</th>
                <th scope="col">DateDelivered</th>
                <th scope="col">TimeDelivered</th>
                <th scope="col">SubTotal</th>
                <!--<th scope="col">SoldAt</th>-->
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <th scope="row">{{ $sale->id }}</th>
                <td>{{ $sale->user->name }} ({{$sale->user->email}})</td>
                <td>
                    @if ($sale->delivery_man)
                        {{  $sale->delivery_man->name }} ({{$sale->delivery_man->username}})
                    @else
                        Not Assigned
                    @endif
                </td>
                <td>
                    {{-- @foreach (json_decode($sale->orders) as $key => $item)
                        <p>{{$key + 1}} =  Name: {{$item->product->name}}, Price: {{$item->product->price."php"}}, Qty: {{$item->quantity}}</p>
                    @endforeach --}}
                </td>
                <td>{{ $sale->date_delivered }}</td>
                <td>{{ $sale->time_delivered }}</td>
                <td>{{ $sale->total."php" }}</td>
                <!--<td>{{ $sale->created_at }}</td>-->
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>