<table class="table table-bordered">
    <thead>
       <tr>
          <th style="width: 10px">#</th>
          <th>Avatar</th>
          <th>Name</th>
          <th class="text-nowrap">Số lượng</th>
          <th class="text-nowrap">Total</th>
          {{-- <th>Action</th> --}}
       </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>
                <img src="{{ $order->avatar_path }}" alt="{{ $order->name }}" style="width:80px;">
            </td>
            <td>
                <ul style="padding: 0;margin:0;">
                    <li>
                        <strong>MSP</strong>    {{ $order->product->masp }}
                        </li>
                    <li>
                    <strong>Tên SP</strong>    {{ $order->name }}
                    </li>
                </ul>
            </td>
            <td>{{ $order->quantity }}</td>
            <td>{{ number_format($order->new_price) }}</td>
            {{-- <td>
                <a href="" class="btn btn-sm btn-infor btn-danger">
                <i class="far fa-trash-alt"></i>
                </a>
            </td> --}}
        </tr>
       @endforeach
    </tbody>
 </table>
