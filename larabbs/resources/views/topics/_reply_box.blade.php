@section('styles')
  	<link rel="stylesheet" type="text/css" href="/css/AT/jquery.atwho.min.css">
@endsection

@section('scripts')
  {{-- 引入@插件 开始 --}}
	<script src="/js/AT/jquery.caret.min.js"></script>
	<script src="/js/AT/jquery.atwho.min.js"></script>
	<script type="text/javascript">
  	$('#reply_box').atwho({
  		at: "@",
      limit: 10,
      maxLen: 4,
  		callbacks: {
  			remoteFilter: function(query, callback){
  				$.getJSON("/at_user", {topic_id: {{ $topic->id }} }, function(data) {
  					callback(data)
  				});
  			}
  		}
  	})
	</script>
  {{-- 引入@插件 结束 --}}

  {{-- 点击回复，【回复框】获得焦点，内容加上 ‘ @name ’  开始 --}}
  <script type="text/javascript">
    function reply (obj) {
      var AT_name = ' @' + $(obj).data('name') + ' ';
      $('#reply_box').focus().val($('#reply_box').val() + AT_name);
    }
  </script>
  {{-- 点击回复，【回复框】获得焦点，内容加上 ‘@name ’  结束 --}}
@endsection

@include('shared._error')

<div class="reply-box">
  <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
    <div class="form-group">
      <textarea class="form-control" rows="3" placeholder="分享你的见解~" name="content" id="reply_box"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-share mr-1"></i> 回复</button>
  </form>
</div>
<hr>

