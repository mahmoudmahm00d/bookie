<div>
    @if (count($notifications) == 0)
        You don't have any notifications.
    @else
        @foreach ($notifications as $notification)
            <div class="bg-white rounded p-2 mb-2">
                <dt clas>{{ $notification->title }}</dt>
                <dd class="text-truncate">{{ $notification->body }}</dd>
            </div>
        @endforeach
    @endif
</div>
