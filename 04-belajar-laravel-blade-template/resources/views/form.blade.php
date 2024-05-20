<html>

<body>
    <form action="">
        <input type="checkbox" @checked($user['premium']) value="Premium">
        <input type="text" value="{{ $user['name'] }}" @readonly(!$user['admin'])>
    </form>
</body>

</html>
