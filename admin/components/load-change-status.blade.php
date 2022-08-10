@switch($data->status)
    @case(1)
        <span>Đã đăng</span>
        @if ($data->active == 0)
            <span>Đã hạ bài</span>
        @endif
        @can('post-send-duyet')
            <a class="btn btn-sm btn-primary lb-status" data-url="{{ route('admin.post.guiDuyet', ['id' => $data->id]) }}"
                data-type="Gửi duyệt bài">
                Gửi duyệt
            </a>
        @endcan
        @can('post-trabai')
            <a class="btn btn-sm btn-danger lb-status" data-url="{{ route('admin.post.traBai', ['id' => $data->id]) }}"
                data-type="Trả bài">
                Trả lại
            </a>
        @endcan
        <div class="info-post">
            <ul>
                <li>Người đăng <a>{{ optional($data->admin)->name }}</a></li>
                @if ($data->active == 0)
                    <li>Người hạ bài <a>{{ optional($data->adminHaBai)->name }}</a></li>
                @endif
                @if ($data->adminEdit)
                <li>Người sửa bài cuối cùng <a>{{ optional($data->adminEdit)->name }}</a></li>
                @endif
            </ul>
        </div>
    @break
    @case(2)
        <span>Đã gửi duyệt</span>
        @if ($data->active == 0)
            <span>Đã hạ bài</span>
        @endif
        @can('post-duyet')
            <a class="btn btn-sm btn-success lb-status" data-url="{{ route('admin.post.duyet', ['id' => $data->id]) }}"
                data-type="Duyệt bài">
                Duyệt bài
            </a>
        @endcan
        @can('post-trabai')
            <a class="btn btn-sm btn-danger lb-status" data-url="{{ route('admin.post.traBai', ['id' => $data->id]) }}"
                data-type="Trả bài">
                Trả lại
            </a>
        @endcan
        <div class="info-post">
            <ul>
                <li>Người đăng <a>{{ optional($data->admin)->name }}</a></li>
                @if ($data->active == 0)
                    <li>Người hạ bài <a>{{ optional($data->adminHaBai)->name }}</a></li>
                @endif
                <li>Người gửi duyệt <a>{{ optional($data->adminSendDuyet)->name }}</a></li>
                @if ($data->adminEdit)
                <li>Người sửa bài cuối cùng <a>{{ optional($data->adminEdit)->name }}</a></li>
                @endif
            </ul>
        </div>
    @break
    @case(3)
        <span>Đã duyệt</span>
        @if ($data->active == 0)
            <span>Đã hạ bài</span>
        @endif
        @can('post-active')
            <a class="btn btn-sm  {{ $data->active == 1 ? 'btn-warning' : 'btn-success' }} lb-status"
                data-url="{{ route('admin.post.load.active', ['id' => $data->id]) }}"
                data-type="{{ $data->active == 1 ? 'Hạ bài' : 'Bỏ hạ bài' }}">
                {{ $data->active == 1 ? 'Hạ bài' : 'Bỏ hạ bài' }}
            </a>
        @endcan
        @can('post-trabai')
            <a class="btn btn-sm btn-danger lb-status" data-url="{{ route('admin.post.traBai', ['id' => $data->id]) }}"
                data-type="Trả bài">
                Trả lại
            </a>
        @endcan

        <div class="info-post">
            <ul>
                <li>Người đăng <a>{{ optional($data->admin)->name }}</a></li>
                @if ($data->active == 0)
                    <li>Người hạ bài <a>{{ optional($data->adminHaBai)->name }}</a></li>
                @endif
                <li>Người gửi duyệt <a>{{ optional($data->adminSendDuyet)->name }}</a></li>
                <li>Người duyệt <a>{{ optional($data->adminDuyet)->name }}</a></li>
                @if ($data->adminEdit)
                <li>Người sửa bài cuối cùng <a>{{ optional($data->adminEdit)->name }}</a></li>
                @endif
            </ul>
        </div>
    @break
    @case(4)
        <span>Đã trả lại</span>
        @if ($data->active == 0)
            <span>Đã hạ bài</span>
        @endif
        <div class="info-post">
            <ul>
                <li>Người đăng <a>{{ optional($data->admin)->name }}</a></li>
                @if ($data->active == 0)
                    <li>Người hạ bài <a>{{ optional($data->adminHaBai)->name }}</a></li>
                @endif
                <li>Người gửi duyệt <a>{{ optional($data->adminSendDuyet)->name }}</a></li>
                <li>Người duyệt <a>{{ optional($data->adminDuyet)->name }}</a></li>
                <li>Người trả bài <a>{{ optional($data->adminTraBai)->name }}</a></li>
                @if ($data->adminEdit)
                <li>Người sửa bài cuối cùng <a>{{ optional($data->adminEdit)->name }}</a></li>
                @endif
            </ul>
        </div>
    @break
    @case(5)
        <span>Đã sửa lại (trả lại)</span>
        @if ($data->active == 0)
            <span>Đã hạ bài bởi</span>
        @endif
        @can('post-send-duyet')
            <a class="btn btn-sm btn-primary lb-status" data-url="{{ route('admin.post.guiDuyet', ['id' => $data->id]) }}"
                data-type="Gửi duyệt bài">
                Gửi duyệt
            </a>
        @endcan
        @can('post-trabai')
            <a class="btn btn-sm btn-danger lb-status" data-url="{{ route('admin.post.traBai', ['id' => $data->id]) }}"
                data-type="Trả bài">
                Trả lại
            </a>
        @endcan
        <div class="info-post">
            <ul>
                <li>Người đăng <a>{{ optional($data->admin)->name }}</a></li>
                @if ($data->active == 0)
                    <li>Người hạ bài <a>{{ optional($data->adminHaBai)->name }}</a></li>
                @endif
                <li>Người gửi duyệt <a>{{ optional($data->adminSendDuyet)->name }}</a></li>
                <li>Người duyệt <a>{{ optional($data->adminDuyet)->name }}</a></li>
                <li>Người trả bài <a>{{ optional($data->adminTraBai)->name }}</a></li>
                @if ($data->adminEdit)
                <li>Người sửa bài cuối cùng <a>{{ optional($data->adminEdit)->name }}</a></li>
                @endif

            </ul>
        </div>
    @break
    @default

@endswitch
