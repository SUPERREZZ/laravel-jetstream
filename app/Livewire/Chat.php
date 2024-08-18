<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Carbon\Carbon;
class Chat extends Component
{
    public $message;
    public $messages;
    protected $listeners = ['messageReceived' => 'prependMessage'];

    public function render()
    {
        return view('livewire.chat');
    }
    public function mount()
    {
        $this->messages = Message::with('user')->latest()->get();


    }

    public function sendMessage()
    {
        $newmessage = Message::create([
            'user_id' => Auth::id(),
            'message' => $this->message
        ]);
        event(new MessageSent($newmessage));
        $this->messages->prepend($newmessage);
        $this->message = '';
        $this->messages = Message::with('user')->latest()->get();
    }
    public function deletemessage($id)
    {

        if (Auth::user()->id == Message::find($id)->user_id) {
            Message::find($id)->delete();
            $this->messages = $this->messages->where('id', '!=', $id);
        }
    }

    public function prependMessage($message)
    {
        $this->messages->prepend($message);
    }


}