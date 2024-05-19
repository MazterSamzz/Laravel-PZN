<html>

<body>
    @while ($i < 10)
        The Current Value is {{ $i }}
        @php
            $i++;
        @endphp
    @endwhile
</body>

</html>
