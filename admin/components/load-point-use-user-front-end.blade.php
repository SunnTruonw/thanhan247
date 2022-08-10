<div class="card card-outline card-primary">
    <div class="card-header">Lịch sử sử dụng tiền các thành viên</div>
    <div class="card-body table-responsive p-0 lb-list-category">
        <table class="table table-head-fixed">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Kiểu</th>
                    <th>Người nạp</th>
                    <th>Số tiền đã thanh toán</th>
                    <th>Ghi chú</th>
                  </tr>
              </thead>
              <tbody>

                {{-- {{dd($user->orders)}} --}}

                @isset($point)
                    @if (count($point)>0)
                        @foreach ($point as $item)
                        <tr>
                            <td>{{ date_format($item->created_at,'d/m/Y H:i:s') }}</td>
                            <td>{{ $typePoint[$item->type]['name'] }}</td>
                            <td><a href="{{ optional($item->product)->slug_full }}">{{ optional($item->product)->name }}</a></td>
                            <td>{{ $item->point }}</td>
                        </tr>
                        @endforeach
                    @else
                    <tr class="text-center">
                        <td colspan="4" class="p-3">Không có </td>

                    </tr>
                    @endif

                @endisset
                {{-- @isset($user->orders)
                    @if (count($user->orders)>0)
                        @foreach ($user->orders as $item)
                        <tr>
                            <td>{{$item->order_code}}</td>
                            <td>{{ date_format($item->created_at,'d/m/Y H:i:s') }}</td>
                            <td>{{number_format($item->total_money, 0, ',', '.')}}</td>
                            <td>{{number_format($item->shipping_fee, 0, ',', '.')}}</td>
                            <td>{{$item->note}}</td>
                            @if(isset($item->file))
                            <td><a href="{{ asset( $item->file )}}" target="_blank"> View Pdf </a></td>
                            @endif
                        </tr>
                        @endforeach
                    @else
                    <tr class="text-center">
                        <td colspan="4" class="p-3">Không có </td>

                    </tr>
                    @endif

                @endisset --}}

              </tbody>
        </table>
    </div>
</div>
{{ $point->appends('type','use')->links() }}
