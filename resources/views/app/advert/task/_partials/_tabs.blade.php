<div class="tabs-caption">
    <a class="tab-button{{ $page === 'all'  ? ' active' : '' }}" href="{{ route('tasks.index') }}">
        Все задания
    </a>
    <a class="tab-button{{ $page === 'recommended' ? ' active' : '' }}" href="{{ route('tasks.recommended') }}">
        Рекомендации
    </a>
    <a class="tab-button{{ $page === 'offers' ? ' active' : '' }}" href="{{ route('tasks.offers') }}">
        Предложения
    </a>
</div>
