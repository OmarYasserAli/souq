@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Shop Page'))

@push('css_or_js')
    @if($shop['id'] != 0)
        <meta property="og:image" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}"/>
        <meta property="og:title" content="{{ $shop->name}} "/>
        <meta property="og:url" content="{{route('shopView',[$shop['id']])}}">
    @else
        <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"/>
        <meta property="og:title" content="{{ $shop['name']}} "/>
        <meta property="og:url" content="{{route('shopView',[$shop['id']])}}">
    @endif
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    @if($shop['id'] != 0)
        <meta property="twitter:card" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}"/>
        <meta property="twitter:title" content="{{route('shopView',[$shop['id']])}}"/>
        <meta property="twitter:url" content="{{route('shopView',[$shop['id']])}}">
    @else
        <meta property="twitter:card"
              content="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"/>
        <meta property="twitter:title" content="{{route('shopView',[$shop['id']])}}"/>
        <meta property="twitter:url" content="{{route('shopView',[$shop['id']])}}">
    @endif

    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">


    <link href="{{asset('public/assets/front-end')}}/css/home.css" rel="stylesheet">
    <style>
        .headerTitle {
            font-size: 34px;
            font-weight: bolder;
            margin-top: 3rem;
        }

        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}                       !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        /***********************************/
        .sidepanel {
            width: 0;
            position: fixed;
            z-index: 6;
            height: 500px;
            top: 0;
            left: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 40px;
        }

        .sidepanel a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        .sidepanel a:hover {
            color: #f1f1f1;
        }

        .sidepanel .closebtn {
            position: absolute;
            top: 0;
            right: 0px;
            font-size: 36px;
        }

        .openbtn {
            font-size: 18px;
            cursor: pointer;
            background-color: #ffffff;
            color: #373f50;
            width: 40%;
            border: none;
        }

        .openbtn:hover {
            background-color: #444;
        }

        .for-display {
            display: block !important;
        }
        .slhov{
            position: relative;
             top: 0;
        }
        .slhov:hover{
                top:-3px;
                transition: top ease 0.2s;
                
            }

        @media (max-width: 360px) {
            .openbtn {
                width: 59%;
            }

            .for-shoting-mobile {
                margin-right: 0% !important;
            }

            .for-mobile {

                margin-left: 10% !important;
            }

        }

        @media screen and (min-width: 375px) {

            .for-shoting-mobile {
                margin-right: 7% !important;
            }

            .custom-select {
                width: 86px;
            }


        }

        @media (max-width: 500px) {
            .for-mobile {

                margin-left: 27%;
            }

            .openbtn:hover {
                background-color: #fff;
            }

            .for-display {
                display: flex !important;
            }

            .for-shoting-mobile {
                margin-right: 11%;
            }

            .for-tab-display {
                display: none !important;
            }

            .openbtn-tab {
                margin-top: 0 !important;
            }

        }

        @media screen and (min-width: 500px) {
            .openbtn {
                display: none !important;
            }


        }

        @media screen and (min-width: 800px) {


            .for-tab-display {
                display: none !important;
            }

        }

        @media (max-width: 768px) {
            .headerTitle {
                font-size: 23px;

            }

            .openbtn-tab {
                margin-top: 3rem;
                display: inline-block !important;
            }

            .for-tab-display {
                display: inline;
            }
            

        }


    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row rtl">
            <!-- banner  -->
            <div class="col-lg-12 mt-2">
                <div style="background: white">
                    @if($shop['id'] != 0)
                        <img style="width:100%; height: auto; max-height: 13.75rem; border-radius: 3px;"
                             src="{{asset('storage/app/public/shop/banner')}}/{{$shop->banner}}"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             alt="">
                    @else
                        @php($banner=\App\CPU\Helpers::get_business_settings('shop_banner'))
                        <img style="width:100%; height: auto; max-height: 13.75rem; border-radius: 3px;"
                             src="{{asset("storage/app/public/shop")}}/{{$banner??""}}"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             alt="">
                    @endif
                </div>
            </div>
            {{-- sidebar opener --}}
            <div class="col-md-3 mt-2 rtl" style=" width: 100%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                <a class="openbtn-tab" style="" onclick="openNav()">
                    <div style="font-size: 20px; font-weight: 600; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}" class="for-tab-display"> ☰ {{\App\CPU\translate('categories')}}</div>
                </a>
            </div>
            {{-- seller info+contact --}}
            <div class="col-lg-12 rtl" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                <div class="mt-4 mb-2">
                    <div class="row" style="margin-left: 2px">
                        {{-- logo --}}
                        <div class="row col-lg-6 col-md-6 col-12" style="margin-bottom: 10px">
                            <div class="element-center">
                                @if($shop['id'] != 0)
                                    <img style="height: 65px; border-radius: 2px;"
                                         src="{{asset('storage/app/public/shop')}}/{{$shop->image}}"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         alt="">
                                @else
                                    <img style="height: 65px; border-radius: 2px;"
                                         src="{{asset('storage/app/public/company')}}/{{$web_config['fav_icon']->value}}"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         alt="">
                                @endif
                            </div>
                            <div class="row col-8 mx-1" style="display:inline-block;">
                                <div class="ml-3 row">
                                    <h6 class=" font-weight-bold mt-3">
                                        @if($shop['id'] != 0)
                                            {{ $shop->name}} 
                                        @else
                                            {{ $web_config['name']->value }}
                                        @endif
                                    </h6>
                                    
                                    @if($seller_id!=0)
                                        @if($seller->verification=='verified')
                                        &nbsp;&nbsp;
                                            <div class="row col-2 mt-3">
                                                <i  data-visualcompletion="css-img" aria-label="حساب تم التحقق منه" role="img" 
                                                style="background-image: url({{asset('public/assets/front-end/png')}}/verified.png);
                                                background-position: 0px 0px;
                                                background-size: 26px 26px; width: 26px; height: 26px; background-repeat: no-repeat; display: inline-block;"></i>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                               
                                <div class="row ml-4 flex-start">
                                    <div class="mr-3">
                                        <span class="mr-1">{{round($avg_rating,2)}}</span>
                                        @for($count=0; $count<5; $count++)
                                            @if($avg_rating >= $count+1)
                                                <i class="sr-star czi-star-filled active"></i>
                                            @else
                                                <i class="sr-star czi-star active"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div>{{ $total_review}} {{\App\CPU\translate('reviews')}}
                                        / {{ $total_order}} {{\App\CPU\translate('orders')}}</div>
                                </div>
                            </div>
                        </div>
                        {{-- copy link --}}
                        <div class="col-lg-2 col-md-2 col-12 row" >
                            @if($seller_id!=0)
                                <div class="col-lg-4 col-md-2 col-12 "></div>
                                <div class="col-lg-4 col-md-2 col-12 ">
                                    <button class="btn btn-primary btn-md  text-center" 
                                            title="Copy to clipboard" onclick="copyToClipboard()">
                                        <textarea id="url" hidden></textarea>
                                        <i class="fa  fa-share  " aria-hidden="true" ></i>
                                    </button>
                                    <div id='cpyflashmsg'class="alert alert-success" role="alert" style="width:220px; position: absolute; display:none;">
                                        <p style="  font-size:18px;">{{\App\CPU\translate('Coppied_to_clipboard')}} </p>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-2 col-12 ">
                                    <form action="tel:{{$seller->phone}}">
                                        <button class="btn btn-primary btn-md  text-center" 
                                        type="submit">
                                        <i class="fa  fa-phone" aria-hidden="true"></i>
                                        </button>
                                </div>
                                
                            @endif
                        </div>
                        {{-- contact --}}
                        <div class="col-lg-2 col-md-2 col-12">
                            @if($seller_id!=0)
                                @if (auth('customer')->check())
                                    <div class="d-flex">
                                        <button class="btn btn-primary btn-block" data-toggle="modal"
                                                data-target="#exampleModal">
                                            <i class="fa fa-envelope" aria-hidden="true" ></i>
                                            {{\App\CPU\translate('Contact')}} {{\App\CPU\translate('Seller')}} 
                                        </button>
                                    </div>
                                @else
                                    <div class="d-flex">
                                        <a href="{{route('customer.auth.login')}}" class="btn btn-primary btn-block">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                            {{\App\CPU\translate('Contact')}} {{\App\CPU\translate('Seller')}}
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>

                        {{-- search --}}
                        <div class="col-lg-2 col-md-3 col-sm-12 col-12 pt-2" style="direction: ltr;">
                            <form class="{{--form-inline--}} md-form form-sm mt-0" method="get"
                                  action="{{route('shopView',['id'=>$seller_id])}}">
                                <div class="input-group input-group-sm mb-3">
                                    <input type="text" class="form-control" name="product_name" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                                           placeholder="{{\App\CPU\translate('Search Product')}}" aria-label="Recipient's username"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text" id="basic-addon2">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row mt-0">
                    <div class="col-lg-12 col-md-2 col-12">
                        @if($seller_id!=0)
                            <div class="" style=" text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}"> {{$seller->bio}}</div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 col-md-2 col-12 row font-weight-bold {{Session::get('direction') === "rtl" ? 'flex-row-reverse' : 'flex-row'}}" style="font-size: 32px;">
                        
                        @if($seller_id!=0)
                            @if($seller->active_facebook && $seller->facebook!='')
                                <div class="col-lg-1 col-md-4 col-12 slhov text-center">
                                    <!-- Facebook -->
                                    <a href="{{$seller->facebook}}" target="_blank" class=""><i class="fa fa-facebook-f"></i></a>
                                </div >
                            @endif
                            @if($seller->active_twitter && $seller->twitter!='')
                                <div class="col-lg-1 col-md-4 col-12 slhov text-center">
                                   
                                    <!-- Twitter -->
                                    <a href="{{$seller->twitter}}" target="_blank" > <i class="fa fa-twitter"></i></a>
                                </div>
                            @endif
                            @if($seller->active_instagram && $seller->instagram!='')
                            <div class="col-lg-1 col-md-4 col-12 slhov text-center"> 
                                <!-- Instagram -->
                                <a href="{{$seller->instagram}}" target="_blank" > <i class="fa fa-instagram"></i></a>
                                
                            </div>
                        @endif
                        @if($seller->active_tiktok && $seller->tiktok!='')
                            <div class="col-lg-1 col-md-4 slhov text-center"> 
                                <!-- tiktok -->
                                <a href="{{$seller->tiktok}}" target="_blank" class='mb-1' > <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-tiktok" viewBox="0 0 22 22">
                                    <path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3V0Z"/>
                                </svg></i></a>
                                
                            </div>
                        @endif
                        @if($seller->active_website_url && $seller->website_url!='')
                            <div class="col-lg-1 col-md-4 slhov text-center"> 
                                <!-- tiktok -->
                                <a href="{{$seller->website_url}}" target="_blank" > <i class="fa fa-globe"></i></a>
                                
                            </div>
                        @endif
                        @if($seller->active_map_location && $seller->map_location!='')
                            <div class="col-lg-1 col-md-4 slhov text-center"> 
                                <!-- tiktok -->
                                <a href="{{$seller->map_location}}" target="_blank" > <i class="fa fa-map-marker"></i></a>
                            </div>
                        @endif
                        @if($seller->active_whatsapp)
                            <div class="col-lg-1 col-md-4 col-12 slhov text-center"> 
                                <!-- Instagram -->
                                <a href="whatsapp://send?phone={{$seller->phone}}" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i></a>
                                
                            </div>
                        @endif
                        @endif
                    </div>
                    
                </div>
                {{-- Motal --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="card-header">
                                {{\App\CPU\translate('write_something')}}
                            </div>
                            <div class="modal-body">
                                <form action="{{route('messages_store')}}" method="post" id="chat-form">
                                    @csrf
                                    @if($shop['id'] != 0)
                                        <input value="{{$shop->id}}" name="shop_id" hidden>
                                        <input value="{{$shop->seller_id}}}" name="seller_id" hidden>
                                    @endif

                                    <textarea name="message" class="form-control" required></textarea>
                                    <br>
                                    @if($shop['id'] != 0)
                                        <button class="btn btn-primary" style="color: white;">{{\App\CPU\translate('send')}}</button>
                                    @else
                                        <button class="btn btn-primary" style="color: white;" disabled>{{\App\CPU\translate('send')}}</button>
                                    @endif
                                </form>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('chat-with-seller')}}" class="btn btn-primary mx-1">
                                    {{\App\CPU\translate('go_to')}} {{\App\CPU\translate('chatbox')}}
                                </a>
                                <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">{{\App\CPU\translate('close')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        {{-- sidebar opener --}}
        <button class="openbtn" onclick="openNav()" style="width: 100%">
            <div style="margin-bottom: -30%; text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                {{Session::get('direction') !== "rtl" ? '☰' : ''}}
                {{\App\CPU\translate('categories')}}
                {{Session::get('direction') === "rtl" ? '☰' : ''}}
            </div>
        </button>

        <div class="row mt-2 mr-0 rtl">
            {{-- sidebar (Category) - before toggle --}}
            <div class="col-lg-3 mt-3 pr-0 mr-0">
                <aside class=" hidden-xs SearchParameters" id="SearchParameters">
                    <!-- Categories Sidebar-->
                    <div class="cz-sidebar rounded-lg box-shadow-lg" id="shop-sidebar">
                        <div class="cz-sidebar-body">
                            <!-- Categories-->
                            <div class="widget widget-categories mb-4 pb-4 border-bottom">
                                <div>
                                    <div style="display: inline">
                                        <h3 class="widget-title"
                                            style="font-weight: 700;display: inline">{{\App\CPU\translate('categories')}}</h3>
                                    </div>
                                </div>
                                <div class="divider-role"
                                     style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: 5px;"></div>
                                <div class="accordion mt-n1" id="shop-categories">
                                    @foreach($categories as $category)
                                        <div class="card">
                                            <div class="card-header p-1 flex-between">
                                                <label class="for-hover-lable" style="cursor: pointer"
                                                       onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$category['id']])}}'" {{--onclick="productSearch({{$seller_id}}, {{$category['id']}})"--}}>
                                                    {{$category['name']}}
                                                </label>
                                                <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                        onclick="$('#collapse-{{$category['id']}}').toggle(400)">
                                                    {{$category->childes->count()>0?'+':''}}
                                                </strong>
                                            </div>
                                            <div class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-{{$category['id']}}"
                                                 style="display: none">
                                                @foreach($category->childes as $child)
                                                    <div class=" for-hover-lable card-header p-1 flex-between">
                                                        <label style="cursor: pointer"
                                                               onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$child['id']])}}'">
                                                            {{$child['name']}}
                                                        </label>
                                                        <strong class="pull-right" style="cursor: pointer"
                                                                onclick="$('#collapse-{{$child['id']}}').toggle(400)">
                                                            {{$child->childes->count()>0?'+':''}}
                                                        </strong>
                                                    </div>
                                                    <div class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-{{$child['id']}}"
                                                         style="display: none">
                                                        @foreach($child->childes as $ch)
                                                            <div class="card-header p-1 flex-between">
                                                                <label class="for-hover-lable" style="cursor: pointer"
                                                                       onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$ch['id']])}}'">
                                                                    {{$ch['name']}}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
            {{-- sidebar (Category mobile) - after toggle --}}
            <div id="mySidepanel" class="sidepanel" style="text-align: {{Session::get('direction') === "rtl" ? 'right:0; left:auto' : 'right:auto; left:0'}};">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                <div class="cz-sidebar-body">
                    <div class="widget widget-categories mb-4 pb-4 border-bottom">
                        <div>
                            <div style="display: inline">
                                <h3 class="widget-title"
                                    style="font-weight: 700;display: inline">{{\App\CPU\translate('categories')}}</h3>
                            </div>
                        </div>
                        <div class="divider-role"
                             style="border: 1px solid whitesmoke; margin-bottom: 14px;  margin-top: 5px;"></div>
                        <div class="accordion mt-n1" id="shop-categories" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            @foreach($categories as $category)
                                <div class="card">
                                    <div class="card-header p-1 flex-between">
                                        <label class="for-hover-lable" style="cursor: pointer"
                                               onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$category['id']])}}'" {{--onclick="productSearch({{$seller_id}}, {{$category['id']}})"--}}>
                                            {{$category['name']}}
                                        </label>
                                        <strong class="pull-right for-brand-hover" style="cursor: pointer"
                                                onclick="$('#collapse-m-{{$category['id']}}').toggle(400)">
                                            {{$category->childes->count()>0?'+':''}}
                                        </strong>
                                    </div>
                                    <div class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-m-{{$category['id']}}"
                                         style="display: none">
                                        @foreach($category->childes as $child)
                                            <div class=" for-hover-lable card-header p-1 flex-between">
                                                <label style="cursor: pointer"
                                                       onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$child['id']])}}'">
                                                    {{$child['name']}}
                                                </label>
                                                <strong class="pull-right" style="cursor: pointer"
                                                        onclick="$('#collapse-m-{{$child['id']}}').toggle(400)">
                                                    {{$child->childes->count()>0?'+':''}}
                                                </strong>
                                            </div>
                                            <div class="card-body {{Session::get('direction') === "rtl" ? 'mr-2' : 'ml-2'}}" id="collapse-m-{{$child['id']}}"
                                                 style="display: none">
                                                @foreach($child->childes as $ch)
                                                    <div class="card-header p-1 flex-between">
                                                        <label class="for-hover-lable" style="cursor: pointer"
                                                               onclick="location.href='{{route('shopView',['id'=> $seller_id,'category_id'=>$ch['id']])}}'">
                                                            {{$ch['name']}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- main body (Products) --}}
            <div class="col-lg-9 product-div">
                <!-- Products grid-->
                <div class="row mt-3" id="ajax-products">
                    @include('web-views.products._ajax-products',['products'=>$products])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function productSearch(seller_id, category_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{url('/')}}/shopView/' + seller_id + '?category_id=' + category_id,

                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
        function copyToClipboard() {
            
            var Url = document.getElementById("url");
            url.hidden = false;
            Url.innerHTML = window.location.href;
            // console.log(Url.innerHTML)
            Url.select();
            var successful = document.execCommand("copy");
            url.hidden = true;
            // console.log(successful)
            $('#cpyflashmsg').fadeIn().delay(900).fadeOut();
        }
    </script>

    <script>
        function openNav() {

            document.getElementById("mySidepanel").style.width = "50%";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>

    <script>
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{route('messages_store')}}',
                data: $('#chat-form').serialize(),
                success: function (respons) {

                    toastr.success('{{\App\CPU\translate('send successfully')}}', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#chat-form').trigger('reset');
                }
            });

        });
    </script>
@endpush
