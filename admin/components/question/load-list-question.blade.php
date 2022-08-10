@php
$folder = '';
@endphp
<ul class="nav nav-tabs">
    @foreach ($type as $key => $value)
        <li class="nav-item">
            <a class="nav-link {{ $typeActive == $key ? 'active' : '' }}" data-toggle="tab"
                href="#type_question_{{ $key }}">{{ $value }}
                ({{ $data->questions()->where('type', $key)->count() }})</a>
        </li>
    @endforeach
</ul>

<div class="tab-content">
    @foreach ($type as $key => $value)
        <div id="type_question_{{ $key }}"
            class="container tab-pane {{ $typeActive == $key ? 'active show' : '' }} fade">
            <div class="">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:50px;">STT</th>
                            <th>Câu hỏi</th>
                            <th style="width:110px;" class="">Sửa/Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->questions()->where('type', $key)->orderby('order')->orderByDesc('created_at')->get()
    as $item)
                            <tr>
                                <td style="width:50px;">{{ $item->order }}</td>
                                <td>{!! $item->name !!}</td>
                                <td style="width:130px;">
                                    <a data-url="{{ route('admin.exam.loadEditQuestion', ['id' => $item->id]) }}"
                                        class="btn btn-sm  btn-success btnShowExercise"><i class="fas fa-edit"></i></a>
                                    <a data-url="{{ route('admin.exam.destroyQuestion', ['id' => $item->id]) }}"
                                        class="btn btn-sm  btn-danger lb_delete_exercise"><i
                                            class="far fa-trash-alt"></i></a>
                                    <a class="btn btn-sm  btn-info toggleAnser">
                                        <i class="fas @if (isset($questionActive) && $questionActive && $questionActive==$item->id) fa-minus @else fa-plus @endif"></i>
                                    </a>

                                </td>
                            </tr>
                            @if ($item->type == 1)
                                <tr class="answers" @if (isset($questionActive) && $questionActive && $questionActive==$item->id) style="display: table-row;" @else @endif>
                                    <td colspan="4">
                                        <div class="text-right">
                                            <a data-url="{{ route('admin.exam.loadCreateNowQuestionAnswer', ['id' => $item->id]) }}"
                                                class="btn btn-sm btn-info btnCreateQuestionAnswer">+ Thêm đáp án</a>
                                        </div>
                                        <ul class="list-group">
                                            <li class="p-2 list-group-item"><span class="mda p-1">Mã ĐA</span> <span
                                                    class="da p-1">Đáp án</span> <span
                                                    class="action p-1 text-center">Xóa</span></li>
                                            @foreach ($item->answers as $answer)
                                                <li
                                                    class="border-top  list-group-item {{ $answer->correct ? 'list-group-item-success' : '' }}">
                                                    <span class="mda pl-1 pr-1 ">{{ $answer->code }}</span>
                                                    <span class="da pl-1 pr-1 ">{!! $answer->name !!}</span>
                                                    <span class="action pl-1 pr-1 text-center">
                                                        <a data-url="{{ route('admin.exam.loadEditAnswer', ['id' => $answer->id]) }}"
                                                            class="btn btn-sm  btn-success btnShowQuestionAnswer"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a data-url="{{ route('admin.exam.destroyAnswer', ['id' => $answer->id]) }}"
                                                            class="btn btn-sm  btn-danger deleteQuestionAnswerAjax"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @else
                                <tr class="answers">
                                    <td colspan="4">
                                        <ul>
                                            <li class="d-block"><strong>Tiêu đè </strong> <br>
                                                <div>{{ $item->title }}</div>
                                            </li>
                                            <hr>
                                            <li class="d-block"><strong>Đáp án </strong> <br>
                                                <div>{!! $item->answer !!}</div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
