<html>

<body>
    <ul>
        @forelse ($hobbies as $hobby)
            <li>{{ $hobby }}</li>
        @empty
            <li>Tidak punya hobby</li>
        @endforelse
    </ul>
</body>

</html>
