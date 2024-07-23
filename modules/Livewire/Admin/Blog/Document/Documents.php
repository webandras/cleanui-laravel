<?php

namespace Modules\Livewire\Admin\Blog\Document;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Blog\Models\Document;

class Documents extends Component
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.document.documents')->with([
            'documents' => Document::orderBy('order', 'ASC')->get(),
            'documentStatuses' => Document::getDocumentStatuses(),
            'documentStatusColors' => Document::getDocumentStatusColors(),
        ]);
    }


    /**
     * @param $list
     * @return void
     */
    public function updateOrder($list): void
    {
        DB::transaction(function() use ($list) {
            foreach($list as $item) {
                Document::find($item['value'])->update(['order' => $item['order']]);
            }
        });
    }
}
