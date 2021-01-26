<h1>Hello {{ $user[0]->user_name }}</h1>
<p style="font-size: 24px;">
    Please click reset button to reset your password
    <form action="{{ url('/reset_pass') }}" method="post">
        @csrf
        <button type="submit" style="background-color: #f44336; border: 0px; border-radius: 8px; height: 50px; color: white;">Reset Password</button>
        <input type="hidden" name="user_id" value="{{$user[0]->user_id}}">
    </form>
</p>