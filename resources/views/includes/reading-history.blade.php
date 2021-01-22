<div class="history__block">
    <div class="history??title">読書履歴</div>
    <ul class="history__lists">
        <a href="{{route('')}}" class="history__link">
            <li class="history__item history__item-done">読んだ本</li>
        </a>
        <a href="{{route('', ['user_id'=> Auth::id()]) }}" class="history__link">
            <li class="history__item history__item-book">読みたい本</li>
        </a>
        <a href="{{route('')}}" class="history__link">
            <li class="history__item history__item-author">著者リスト</li>
        </a>
    </ul>
</div>