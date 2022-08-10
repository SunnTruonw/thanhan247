
@foreach ($data->paragraphs()->where([['type', $typeKey], ['active', 1], ['parent_id', 0]])->orderby('order')->orderByDesc('created_at')->get()
    as $paragraph)
@php
$tranParagraph=($paragraph->translationsLanguage()->first());
if(!$tranParagraph){
    $tranParagraph=($paragraph->translationsLanguage(config('languages.default'))->first());
}
@endphp
    @php
        $level = $loop->index + 1;
        $index = $loop->index + 1;
    @endphp

    <div id="para-{{ $typeKey . '-' . $level }}">
        <div class="name-p"><span class="index">{{ $index }} </span> <span>{!! $tranParagraph->name !!}</span></div>
        <div class="content-p">
            {!! $tranParagraph->value !!}
        </div>
    </div>

    @if ($paragraph->childs()->where([['active', 1], ['type', $typeKey]])->count())
        @foreach ($paragraph->childs()->where([['active', 1], ['type', $typeKey]])->orderby('order')->orderByDesc('created_at')->get()
            as $childValue)
            @include('frontend.components.paragraph-content-child', ['childs' => $childValue])
        @endforeach
    @endif

@endforeach
