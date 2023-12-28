<?php

namespace App\Http\Livewire\Admin\Tag\Trait;

trait Reactive
{
    /**
     * @return void
     */
    private function closeModal(): void
    {
        $this->isModalOpen = false;
    }


    /**
     * Initialize the properties for the modal forms (create or edit)
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->isModalOpen = false;
        if (isset($this->iteration)) {
            $this->iteration++;
        }

        if (isset($this->tag)) {
            $this->name            = $this->tag->name;
            $this->slug            = $this->tag->slug;
            $this->cover_image_url = $this->tag->cover_image_url;
            $this->cover_image     = null;
        } else {
            $this->name            = '';
            $this->slug            = '';
            $this->cover_image_url = '';
            $this->filterKeyword   = '';
        }
    }

    /**
     * @return void
     */
    public function rerenderList(): void
    {
        $this->emitUp('listUpdated');
    }


    public function triggerOnAlert(): void
    {
        $this->emitTo(
            'global.banner',
            'onAlert',
            ['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')]
        );

    }
}

