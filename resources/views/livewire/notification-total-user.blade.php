<div wire:pool>
    @php
    use App\Http\Resources\NotificationResource;
    use App\Models\Notification;
    use Illuminate\Support\Str;

    $countNotification = collect(
    Notification::where('is_readed', false)
    ->where('to_user', auth()->user()->id)
    ->get(),
    )->count();

    @endphp

    @if ($countNotification > 0)
    {{ $countNotification }}
    @endif
</div>