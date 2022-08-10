{{-- @if ( $dataStatus->status==-1)
<span data-status="{{ $dataStatus->status }}" class="badge badge-danger">
    Hủy bỏ
</span>
@elseif($dataStatus->status==1)
<span data-status="{{ $dataStatus->status }}" class="badge badge-1">
    Chưa sử lý
</span>
@elseif($dataStatus->status==2)
<span data-status="{{ $dataStatus->status }}" class="badge badge-2">
    Nhận đơn
</span>
@elseif($dataStatus->status==3)
<span data-status="{{ $dataStatus->status }}" class="badge badge-3">
    Đang vận chuyển
</span>
@elseif($dataStatus->status==4)
<span data-status="{{ $dataStatus->status }}" class="badge badge-4">
    Hoàn thành
</span>
@endif
--}}

@foreach ($listStatus as $status)
    @if ($status['status']==$dataStatus->status)
        <span data-status="{{ $dataStatus->status }}" class="badge badge-@if ($dataStatus->status<=0)danger @else{{ $dataStatus->status }}@endif">
            {{ $status['name'] }}
        </span>
    @endif
@endforeach

