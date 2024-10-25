<?php

namespace App\Future\PostResource\View\Modal;

use Adminftr\Form\Future\ModalForm;
use Livewire\Attributes\On;
use App\Models\Post;
use Adminftr\Form\Future\Components\Form;

class Detail extends ModalForm
{
    public $model = Post::class;

    public $post;

    #[On('setModel')]
    public function setData($id)
    {
        $this->post = Post::with(['user', 'images'])->find($id);
    }

    public function form(Form $form)
    {
    }

    public function render()
    {
        return view('post.modal-detail');
    }

    public function getRules(): array
    {
        return [];
    }
}
