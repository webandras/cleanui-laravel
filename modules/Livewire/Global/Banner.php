<?php

namespace Modules\Livewire\Global;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Banner extends Component
{
    /**
     * @var bool
     */
    public bool $show;


    /**
     * @var string
     */
    public string $style;


    /**
     * @var string
     */
    public string $message;


    /**
     * @var string[]
     */
    protected $listeners = [
        'onAlert'
    ];


    /**
     * @return void
     */
    public function mount(): void
    {
        $this->show = false;
        $this->style = '';
        $this->message = '';
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('global.livewire.banner');
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
