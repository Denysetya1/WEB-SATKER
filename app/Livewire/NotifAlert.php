<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use Livewire\Component;

class NotifAlert extends Component
{
    use LivewireAlert;

    protected string $id = '';
    protected string $type = '';
    protected string $title = '';
    public function render()
    {
        return view('livewire.notif-alert');
    }

    public function __construct(string $id, string $type, string $title)
    {
        $this->id = $id;
        $this->type = $type;
        $this->title = $title;
    }

    public static function make(?string $id = null, string $type, string $title): static
    {
        $static = app(static::class, ['id' => $id ?? Str::orderedUuid(), 'type' => $type, 'title' => $title]);
        // $static->configure();

        return $static;
    }

    public function send(): static
    {
        $this->alert($this->type, $this->title, [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
        ]);

        return $this;
    }
}
