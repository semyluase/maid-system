<div wire:poll>
    @php
        use App\Http\Resources\NotificationResource;
        use App\Models\Notification;
        use Illuminate\Support\Str;
        use Illuminate\Support\Carbon;

        Notification::where('to_role', 1)
            ->where('is_readed', false)
            ->update([
                'is_readed' => true,
            ]);

        $notifications = new NotificationResource(
            Notification::where('to_role', 1)
                ->groupBy('tanggal')
                ->limit(10)
                ->get('tanggal'),
        );
    @endphp

    @foreach ($notifications as $notifDate)
        <div class="row mb-3">
            <div class="col">
                <div class="font-bold text-black">{{ Carbon::parse($notifDate->tanggal)->isoFormat('DD MMMM YYYY') }}
                </div>
            </div>
            <hr class="divider">
            <div class="col">
                @php
                    $notificationDatas = new NotificationResource(
                        Notification::with(['fromUser'])
                            ->where('to_role', 1)
                            ->where('tanggal', Carbon::parse($notifDate->tanggal)->isoFormat('YYYY-MM-DD'))
                            ->get(),
                    );
                @endphp
                @foreach ($notificationDatas as $notifData)
                    <div class="row">
                        <div class="col">
                            <p class="text-black">{{ $notifData->message }}</p>
                            <p class="text-muted">{{ $notifData->fromUser->name }}</p>
                        </div>
                    </div>
                    <hr class="divider">
                @endforeach
            </div>
        </div>
    @endforeach
</div>
