<html>

<body>
    @includeWhen($user['owner'], 'include-condition.header-admin')
    <p>Selamat Datang {{ $user['name'] }}</p>
    @includeUnless($user['owner'], 'include-condition.header-admin-2')
</body>

</html>
