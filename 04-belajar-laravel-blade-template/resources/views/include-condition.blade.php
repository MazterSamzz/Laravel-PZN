<html>

<body>
    @includeWhen($user['owner'], 'header-admin')
    <p>Selamat Datang {{ $user['name'] }}</p>
    @includeUnless($user['owner'], 'header-admin-2')
</body>

</html>
