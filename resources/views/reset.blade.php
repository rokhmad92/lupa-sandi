<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>password Baru</title>
</head>
@error('password')
    <p>{{ $message }}</p>
@enderror
@error('confirm_password')
    <p>{{ $message }}</p>
@enderror
@error('token')
    <p>{{ $message }}</p>
@enderror
@error('email')
    <p>{{ $message }}</p>
@enderror
<body>
    <form action="/forgot/reset" method="get">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <label for="password">password</label>
        <input type="password" name="password" id="password">
<br>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
<br>
        <button type="submit">reset Password!</button>
    </form>
</body>
</html>