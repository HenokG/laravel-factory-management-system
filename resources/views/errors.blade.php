
@foreach($errors->all() as $error)
    <span class="text-danger col-md-3 offset-md-5" style="margin-top: 2rem;">{{$error}}</span><div class="clearfix"></div>
    <script>
        let notification_message = ''{{$notification_message ?? 'not found'}};
        console.log(notification_message);
    </script>
@endforeach