@extends('partview.main')

@section('content')
    <form method="post">
        @csrf
        <label for="email">email</label>
        <input type="email" name="email" id="email">
<br>
        <a href="/">Login!</a>
<br>
        <button type="submit">send reset password!</button>
    </form>
@endsection