<html>

<head>
    @error('name')
        <p>{{ $message }}</p>
    @enderror

    @error('password')
        <p>{{ $message }}</p>
    @enderror
</head>

</html>
