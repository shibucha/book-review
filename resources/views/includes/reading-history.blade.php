<div class="history__block">
    <div class="history__title">読書履歴</div>
    <ul class="history__lists">
        <a href="{{route('curious.index', ['user_id'=> Auth::id()]) }}" class="history__link">
            <li class="history__item history__item-book">読みたい本</li>
        </a>
    </ul>
</div>