<?php

namespace App\Http\Livewire\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatUser;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ChatComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['bajarScroll', 'refresh'];

    public $chat_id, $chat_tipo;
    public $new_message;

    public function mount()
    {
        $chatuser = ChatUser::where('users_id', Auth::id())->where('default', 1)->first();
        if ($chatuser){
            $this->chat_id = $chatuser['chats_id'];
            $this->chat_tipo = $chatuser->chat->tipo;
        }else{
            $chat = Chat::where('id', 1)->first();
            if (!$chat){
                $chat = new Chat();
                $chat->id = 1;
                $chat->save();
            }
            $chatuser = new ChatUser();
            $chatuser->users_id = Auth::id();
            $chatuser->chats_id = $chat->id;
            $chatuser->save();
            $this->chat_id = $chat->id;
        }
    }


    public function render()
    {
        $chat = Chat::find($this->chat_id);
        $chatUser = ChatUser::where('users_id', Auth::id())->count();
        $chatmessages = ChatMessage::where('chats_id', $this->chat_id)->orderBy('created_at')->get();
        return view('livewire.chat.chat-component')
            ->with('chat', $chat)
            ->with('room', $chatUser)
            ->with('messages', $chatmessages);
    }

    public function limpiar()
    {
        $this->reset([
            'new_message'
        ]);
    }

    protected $rules = [
        'new_message' => 'required|min:4'
    ];

    protected $messages = [
        'new_message.required' => 'El campo mensaje es obligatorio.',
        'new_message.min' => ' El campo mensaje debe contener al menos 4 caracteres.',
    ];

    public function save()
    {
        $this->validate();
        $chatmessage = new ChatMessage();
        $chatmessage->chats_id = $this->chat_id;
        $chatmessage->users_id = Auth::id();
        $chatmessage->message = $this->new_message;
        $chatmessage->save();
        $this->emit('bajarScroll', $chatmessage->id);
        $this->limpiar();
        /*$this->alert(
            'success',
            'Mensaje enviado.'
        );*/
    }

    public function refresh()
    {
        $chatMessage = ChatMessage::orderBy('created_at', 'DESC')->first();
        if ($chatMessage){
            $this->emit('bajarScroll', $chatMessage->id);
        }
    }

    public function bajarScroll()
    {
        //desplazamiento hasta el final del scroll
    }

}
