


 <div class="card-body table-responsive p-0">
    <table class="table table-head-fixed">
       <thead>
          <tr>
             <th>ID</th>
             <th class="text-nowrap">Thông tin</th>
             <th class="text-nowrap">Acount</th>
             <th class="text-nowrap">Trạng thái</th>
             <th class="text-nowrap">Địa chỉ</th>
             <th class="text-nowrap">Mô tả</th>
             <th class="text-nowrap">Nội dung</th>
             <th>Thời gian</th>

          </tr>
       </thead>
       <tbody>
           @foreach ($data as $contact)
           <tr>
               <td>{{ $contact->id }}</td>
               <td>
                   <ul>
                       <li>
                         <strong>Name:</strong>  {{ $contact->name }}
                       </li>
                       <li>
                          <strong>Email:</strong>   {{ $contact->email }}
                       </li>
                       <li>
                        <strong>Phone:</strong>   {{ $contact->phone }}
                       </li>
                       <li>
                            <strong>Chuyên mục:</strong>   {{ $contact->chuyen_muc }}
                        </li>
                        <li>
                            <strong>Tiêu đề:</strong>   {{ $contact->title }}
                        </li>

                   </ul>
               </td>
               <td class="text-nowrap">{{ $contact->user_id?'Thành viên':'Khách vãng lai' }}</td>
               <td class="text-nowrap status-2" data-url="{{ route('admin.contact.loadNextStepStatus',['id'=>$contact->id]) }}">
                  @include('admin.components.status-2',[
                      'dataStatus' => $contact,
                      'listStatus'=>$listStatus,
                  ])
               </td>
               <td class="text-nowrap">
                  <ul>
                      @if ($contact->city_id&&$contact->district_id&&$contact->commune_id)
                          <li> <strong>Tỉnh:</strong> {{ $contact->city->name }}</li>
                          <li><strong>Quận:</strong>  {{  $contact->district->name}}</li>
                          <li><strong>Phường/xã:</strong>    {{  $contact->commune->name }} </li>
                      @endif
                      @if ($contact->address_detail )
                          <li> <strong>Địa chỉ</strong> {{ $contact->address_detail }}</li>
                      @endif
                  </ul>
              </td>
              <td class="text-nowrap"> {!! $contact->description !!} </td>
               <td class="text-nowrap"> {{ $contact->content }} </td>
               <td class="text-nowrap"> {{ date_format($contact->created_at,"d/m/Y") }} </td>

            </tr>
           @endforeach

       </tbody>
    </table>
 </div>
