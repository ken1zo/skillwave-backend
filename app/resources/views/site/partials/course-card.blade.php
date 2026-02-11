<article class="course-card">
    @if ($course->image_path)
        <img src="{{ asset('storage/'.$course->image_path) }}" alt="{{ $course->title }}">
    @else
        <div class="course-card__placeholder"></div>
    @endif

    <h3>{{ $course->title }}</h3>
    <div class="price">{{ number_format((float) $course->price, 0, ',', ' ') }} ₽</div>

    <details>
        <summary>Описание и уроки</summary>
        <p class="muted">{{ $course->description ?: 'Описание пока не заполнено.' }}</p>
        <ul>
            @foreach ($course->lessons as $lesson)
                <li>{{ $lesson->title }}</li>
            @endforeach
        </ul>
    </details>

    @if (in_array($course->id, $ownedCourseIds, true))
        <button class="btn btn-outline" type="button" disabled>Уже куплен</button>
    @elseif (auth()->check())
        <form action="{{ route('courses.buy', $course) }}" method="POST">
            @csrf
            <button class="btn btn-primary" type="submit">Купить курс</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">Войти и купить</a>
    @endif
</article>
