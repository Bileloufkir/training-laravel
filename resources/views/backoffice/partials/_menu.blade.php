<div class="position-sticky pt-3">
        <ul class="nav flex-column">
                @foreach ($items as $item)
                        <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ $item['link'] }}">
                                        {{ $item['title'] }}
                                </a>
                        </li>
                @endforeach
        </ul>
</div>
