<div wire:pool>
    @php
        use App\Http\Resources\NotificationResource;
        use App\Models\Notification;
        use Illuminate\Support\Str;

        $countNotification = collect(
            Notification::where('is_readed', false)
                ->where('to_role', 1)
                ->get(),
        )->count();

    @endphp

    {{ $countNotification }}
</div>
