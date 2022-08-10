

  <ol class="breadcrumb mb-0 admintest">
    @foreach ($breadcrumbs as $item)

    {{-- <li class="breadcrumb-item active ">{{ $item['name'] }}</li>
   --}}
    <li class="breadcrumb-item"><a href="#">{{ $item->name }}</a></li>


    @endforeach
  </ol>

