@extends('Layout.total')

@section('title', 'UMKM Transactions')

@section('content')

    <style>


        .transaction-row {
            /* background-color: #2D3748; */

        }
        .transaction-row td, .transaction-row th {
            padding: 15px;
        }

        .transaction-row td {

        }
        .transaction-details {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .total-price {
            font-size: 1.25rem;
            font-weight: bold;
            /* background-color: #2D3748; */

            padding: 15px;
            text-align: right;
        }
        .card {
            margin-top: 30px;
            /* background-color: #1a202c; */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card img {
            border-radius: 8px;
        }
        .card p {
            margin: 0;
        }

    </style>
</head>

<body>


        <div class="card bg-base-200">
            <h2 class="text-lg font-bold mb-4">Transaction Details</h2>
            <table class="table w-full">
              <!-- head -->
              <thead>
                <tr class="transaction-row bg-base-300">
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <!-- Sales Items Rows -->
                @foreach ($sale->salesItems as $salesItem)
                <tr class="transaction-row bg-base-300">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-squircle h-12 w-12">
                          <img
                            src="{{ asset('storage/' . $salesItem->item->image) }}"
                            alt="Item Image" />
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">{{ $salesItem->item->itemName }}</div>
                      </div>
                    </div>
                  </td>
                  <td>{{ $salesItem->quantity }}</td>
                  <td>{{ $salesItem->price }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="total-price mt-4">
                Total : {{ $sale->total_price }}
            </div>
        </div>

        @endsection




    <script>
        // Function to refresh the page every 1 second
        function refreshPage() {
            window.location.reload();
        }

        // Set the interval to call refreshPage every 1000 milliseconds (1 second)
        setInterval(refreshPage, 1000);
    </script>
</body>
</html>
