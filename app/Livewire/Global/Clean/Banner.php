<?php

namespace App\Livewire\Global\Clean;

use Livewire\Component;

class Banner extends Component
{
    public bool $show;
    public string $style;
    public string $message;


    protected $listeners = [
        'onAlert'
    ];


    public function mount()
    {
        $this->show = false;
        $this->style = '';
        $this->message = '';
    }


    public function render()
    {
        return view('admin.livewire.clean.global.banner');
    }


    /**
     * @param  array  $args
     * @return void
     */
    public function onAlert(array $args): void
    {
        $this->show = true;
        $this->dispatch('$refresh')->self();
        $this->style = $args['style'];
        $this->message = $args['message'];
    }
}
