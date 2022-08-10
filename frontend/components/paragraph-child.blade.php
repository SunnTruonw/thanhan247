@php
$level .='-'.($loop->index + 1);
$index .='.'.($loop->index + 1);
@endphp
@php
$tranParagraph=($childs->translationsLanguage()->first());
if(!$tranParagraph){
    $tranParagraph=($childs->translationsLanguage(config('languages.default'))->first());
}
@endphp
<li>
    <a href="#para-{{ $typeKey . '-' . ($level) }}"><span class="index">{{ $index }} </span> {!! $tranParagraph->name !!}</a>
    @if ($childs->childs()->where([
        ['active',1],
        ['type', $typeKey]
    ])->count())
        <ul>
            @foreach ($childs->childs()->where([
                ['active',1],
                ['type', $typeKey]
            ])->orderby('order')->orderByDesc('created_at')->get() as $childValue2)
                @include('frontend.components.paragraph-child', ['childs' => $childValue2])
            @endforeach
        </ul>
    @endif
</li>

