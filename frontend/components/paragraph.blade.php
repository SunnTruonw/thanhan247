

@if (isset($data) && $data)
    @foreach ($data->paragraphs()->where([['type', $typeKey], ['active', 1], ['parent_id', 0]])->orderby('order')->orderByDesc('created_at')->get()
    as $paragraph)
        @php
            $level = $loop->index + 1;
            $index = $loop->index + 1;
        @endphp
     @php
            $tranParagraph=($paragraph->translationsLanguage()->first());
            if(!$tranParagraph){
                $tranParagraph=($paragraph->translationsLanguage(config('languages.default'))->first());
            }
    @endphp
        <li>
            <a href="#para-{{ $typeKey . '-' . $level }}"><span class="index">{{ $index }}
                </span>{!! $tranParagraph->name !!}</a>

            @if ($paragraph->childs()->where([['active', 1], ['type', $typeKey]])->count())
                <ul class="">
                    @foreach ($paragraph->childs()->where([['active', 1], ['type', $typeKey]])->orderby('order')->orderByDesc('created_at')->get()
                        as $childValue)

                        @include('frontend.components.paragraph-child', ['childs' => $childValue])
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
@endif
