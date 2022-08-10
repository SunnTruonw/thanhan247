<div class="card card-outline card-primary">
    <div class="card-header">Lịch sử thanh toán thành viên</div>
    <div class="card-body table-responsive p-0 lb-list-category">
        <table class="table table-head-fixed">
            <thead>
                <tr>
                  <th>Thời gian</th>
                  <th>Kiểu</th>
                  <th>Người nạp</th>
                  <th>Số tiền đã thanh toán</th>
                  <th>Ghi chú</th>
                  <th>Tệp</th>
                </tr>
              </thead>
              <tbody>

                @isset($point)
                    @if ($point->count()>0)
                        @foreach ($point as $item)
                        {{-- {{dd($item)}} --}}
                        <tr>
                            <td>{{ date_format($item->created_at,'d/m/Y H:i:s') }}</td>
                            <td>{{ $typePoint[$item->type]['name'] }}</td>
                            <td>{{ optional($item->admin)->name }}</td>
                            <td> {{number_format($item->point, 0, ',', '.')}}</td>
                            <td>{{ $item->note }}</td>
                            @if(isset($item->file))
                            <td><a href="{{ asset( $item->file )}}" target="_blank"> View Pdf </a></td>
                            @endif
                        </tr>
                        @endforeach
                    @else
                    <tr class="text-center"><td class="p-3" colspan="4">Chưa nạp</td></tr>
                    @endif
                @endisset

              </tbody>
        </table>
    </div>
</div>

{{ $point->appends('type','nap')->links() }}
