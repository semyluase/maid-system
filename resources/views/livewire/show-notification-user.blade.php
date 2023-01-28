<div wire:poll>
    @php
        use App\Http\Resources\NotificationResource;
        use App\Models\Notification;
        use Illuminate\Support\Str;

        $notifications = new NotificationResource(
            Notification::where('is_readed', false)
                ->where('to_user', auth()->user()->id)
                ->limit(5)
                ->get(),
        );
    @endphp

    @if (collect($notifications)->count() > 0)
        @foreach ($notifications as $n)
            <li>
                <a class="dropdown-item"><strong class="text-muted">{{ Str::upper($n->type) }}</strong> -
                    {{ Str::title(Str::words($n->message, 5, '...')) }}</a>
            </li>
        @endforeach
        <hr class="divider">
        <li>
            <small>
                <a href="javascript:;" class="dropdown-item text-center text-muted">Show all notification</a>
            </small>
        </li>
    @else
        <li>
            <a class="dropdown-item">No notification available</a>
        </li>
    @endif
</div>
