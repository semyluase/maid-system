<?php

namespace App\Http\Livewire;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\View\Component as ViewComponent;
use Livewire\Component;

class ShowNotification extends Component
{
    public function render()
    {
        return view('livewire.show-notification');
    }
}
