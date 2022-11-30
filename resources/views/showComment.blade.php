@include('layouts.app')

<div class="ftco-blocks-cover-1">
    <div class="site-section-cover overlay" style="background-image: url({{url('uploads/posts/'.$post->image)}})">
{{--        @if($post->image != '' && file_exists(public_path().'/uploads/posts/'.$post->image))--}}
{{--            <img src="{{url('uploads/posts/'.$post->image)}}" alt="" class="site-section-cover overlay">--}}
{{--        @else--}}
{{--            <img src="{{url('assets/images/no-image.png')}}" alt=""  class="site-section-cover overlay">--}}
{{--        @endif--}}
        <div class="container" style="color: #FFFFFF">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-7">
                    <span class="d-block mb-3 text-white" data-aos="fade-up">&bullet;{{$post->created_at->diffForHumans()}}<span class="mx-2 text-primary"></span></span>
                    <h1 class="mb-4" data-aos="fade-up" data-aos-delay="100">{{$post->name}}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<section style="background-color: #FFFFFF;">
<div class="container">
        <div class="row">
            <div class="col-8 blog-content">
                <p class="lead mt-5">{{$post->description}}</p>
                    <div class="container my-5 py-5">
                        <div class="d-flex justify-content-center">
                            <div class="col-md-12 col-lg-10">
                                <div class="card">
                                    <div class="card-body fetch_comments">
                                        </div>
                                        <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                            <div class="d-flex flex-start w-100">
                                                <img class="rounded-circle shadow-1-strong me-3" src="{{url('assets/images/profile.png')}}" alt="avatar" width="40" height="40" />
                                                <div class="form-outline w-100">
                                                    <input type="hidden" class="form-control post_id" id="comment_id" value="{{$post->id}}">
{{--                                                    <input type="hidden" class="form-control user_id" value="{{$post->name}}">--}}
                                                    <textarea class="form-control comment" id="textAreaExample" rows="4" style="background: #fff;"></textarea>
                                                    <label class="form-label" for="textAreaExample">Comment</label>
                                                </div>
                                            </div>
                                            <div class="float-end mt-2 pt-1">
                                                <button type="button" class="btn btn-primary btn-sm add_comment">Post comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
</section>




                                {{--<div class="row  align-items-center justify-content-center">--}}
{{--    <div class="d-flex flex-row align-items-center">--}}
{{--        <div class="card col-12">--}}
{{--            <div class="card-body">--}}
{{--            <h2><strong class="font-weight-bold" style="font-size: larger">--}}
{{--                    <small style="font-size: smaller;color: #9ca3af">by</small>--}}
{{--                    {{$post->name}}--}}
{{--                </strong>--}}
{{--                <small class="mr-2" style="margin-left: 1100px"><small style="font-size: small;color: #9ca3af">posted</small>--}}
{{--                    {{$post->created_at->diffForHumans()}}--}}
{{--                </small>--}}

{{--            </h2>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="">--}}
{{--            <div class="card col-12">--}}
{{--                <div class="d-flex justify-content-between p-2 px-3">--}}
{{--                </div>--}}
{{--                @if($post->image != '' && file_exists(public_path().'/uploads/posts/'.$post->image))--}}
{{--                    <img src="{{url('uploads/posts/'.$post->image)}}" alt="" class="img-fluid">--}}
{{--                @else--}}
{{--                    <img src="{{url('assets/images/no-image.png')}}" alt=""  class="img-fluid">--}}
{{--                @endif--}}
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                    <h4>{{$post->description}}</h4>--}}
{{--                    </div>--}}
{{--                    <div class="justify-start">--}}
{{--                            <div class="d-flex flex-row mb-2">--}}
{{--                                <div class="d-flex flex-column ml-2 fetch_comments">--}}

{{--                                </div>--}}

{{--                            </div>--}}
{{--                        <form class="myform">--}}
{{--                            <div class="inline-block comments">--}}
{{--                                <div id="saveform_errlist"></div>--}}
{{--                                <div class="input-group mb-3">--}}
{{--                                    <textarea type="text" class="form-control comment" rows="1" cols="8" required></textarea>--}}
{{--                                    <input type="hidden" class="form-control post_id" id="comment_id" value="{{$post->id}}">--}}
{{--                                    <div class="input-group-append">--}}
{{--                                        <button class="btn btn-outline-secondary add_comment"><i class="fa fa-send"></i>--}}
{{--                                        </button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--    </div>--}}

{{--</div>--}}
{{--</div>--}}
@section('scripts')
    <script>
        $(document).ready(function () {
            fetchcomment();
            function fetchcomment(){
                var cmt = '';
                var comment_id = $('#comment_id').val();
                $.ajax({
                    type: "Get",
                    url:"../comment",
                    datatype: "json",
                    success: function (response){
                        console.log(response.comments);
                        $.each(response.comments, function (key, data){
                            // console.log(data.id);
                            if(data.post_id === comment_id){
                            cmt += '<div class="d-flex flex-start align-items-center">' +
                                '<img class="rounded-circle shadow-1-strong me-3"' +
                                'src="{{url('assets/images/profile.png')}}" alt="avatar" width="60" height="60" />' +
                                '<div>' +
                                '<h6 class="fw-bold text-primary mb-1">'+data.user_id+'</h6>' +
                                '<p class="text-muted small mb-0">'+data.created_at+'</p>' +
                                '</div>' +
                                '</div>' +
                                '<p class="mt-3 mb-4 pb-2">'+data.comment+'</p>' +
                                '</div>'};
                            });
                        $('.fetch_comments').html(cmt);
                    }
                })
            }

            $(document).on('click', '.add_comment', function (e){
                e.preventDefault();
                var values = {
                    'comment': $('.comment').val(),
                    'post_id': $('.post_id').val(),
                    'user_id': $('.user_id').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "../comment",
                    data: values,
                    datatype: "json",
                    success: function (response){
                        if(response.status == 405){
                            $('#saveform_errlist').html("");
                            $('#saveform_errlist').addClass("alert alert-danger");
                            $.each(response.errors, function (key , err_values){
                                $('#saveform_errlist').append('<li>'+err_values+'</li>')
                            });
                        }
                        else{
                            $('#saveform_errlist').html("");
                            $('#success_message').addClass("aler alert-success");
                            $('.comments').find('input').val("");
                            fetchcomment();
                            $('.myform')[0].reset();
                        }
                    }
                })

            });
        });
    </script>
@endsection
@include('layouts.footer')
