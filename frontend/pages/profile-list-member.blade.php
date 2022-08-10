@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="wrap-content-main">

                    <div class="row">
                        <div class="col-sm-12">
							<div class="card-header">
								<h3 class="card-title">Danh sách thành viên</h3>
							</div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Tên </th>
                                      <th>SỐ CMT</th>
                                      <th>Level</th>
                                      <th>H</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                    @isset($data)
                                        @if (count($data)>0)
                                            @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>
                                                    {{ $item['cmt']??"" }}
                                                </td>
                                                <td>{{ $item['active']?'CVKD':'CTV' }}</td>
                                                <td>H{{ $item['level'] }}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                        <tr><td colspan="4" class="text-center p-3">Bạn chưa có thành viên  nào</td></tr>
                                        @endif
                                    @endisset

                                  </tbody>
                                </table>
                              </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
