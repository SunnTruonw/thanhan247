@php
$level .= '-' . ($loop->index + 1);
$index .='.'.($loop->index + 1);
@endphp
@php
$tranParagraph=($childs->translationsLanguage()->first());
if(!$tranParagraph){
    $tranParagraph=($childs->translationsLanguage(config('languages.default'))->first());
}
@endphp
<div id="para-{{ $typeKey . '-' . $level }}">

    <div class="name-p"><span class="index">{{ $index }} </span> <span>{!! $tranParagraph->name !!}</span></div>
    <div class="content-p">
     {!! $tranParagraph->value !!}
  </div>
</div>
@if ($childs->childs()->where([['active', 1], ['type', $typeKey]])->count())
    @foreach ($childs->childs()->where([['active', 1], ['type', $typeKey]])->orderby('order')->orderByDesc('created_at')->get()
      as $childValue2)
        @include('frontend.components.paragraph-content-child', ['childs' => $childValue2])
    @endforeach
@endif
