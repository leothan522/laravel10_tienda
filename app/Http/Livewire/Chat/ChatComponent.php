<?php

namespace App\Http\Livewire\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\User;
use App\Services\FirebaseCloudMessagingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Livewire\Component;
use Livewire\WithPagination;

class ChatComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['bajarScroll', 'refresh', 'verMessage'];

    public $chat_id, $chat_tipo, $chat_count, $count_new;
    public $new_message, $ultimo_mensaje;
    protected $messaging;
    public $modal_nombre, $modal_email, $modal_telefono, $modal_mensajes, $modal_fecha, $modal_imagen;

    public function mount()
    {
        $chatuser = ChatUser::where('users_id', Auth::id())->where('default', 1)->first();
        if ($chatuser) {
            $this->chat_id = $chatuser['chats_id'];
            $this->chat_tipo = $chatuser->chat->tipo;
            $this->chat_count = ChatMessage::where('chats_id', $this->chat_id)->count();
            if ($this->chat_count > $chatuser['mensajes_vistos']){
                $this->count_new = $this->chat_count - $chatuser['mensajes_vistos'];
            }
        } else {
            $chat = Chat::where('id', 1)->first();
            if (!$chat) {
                $chat = new Chat();
                $chat->id = 1;
                $chat->save();
            }
            $chatuser = new ChatUser();
            $chatuser->users_id = Auth::id();
            $chatuser->chats_id = $chat->id;
            $chatuser->save();
            $this->chat_id = $chat->id;
            $this->chat_count = ChatMessage::where('chats_id', $this->chat_id)->count();
            if ($this->chat_count > $chatuser['mensajes_vistos']){
                $this->count_new = $this->chat_count - $chatuser['mensajes_vistos'];
            }
        }

        $ultimo = ChatMessage::where('chats_id', $this->chat_id)->orderBy('created_at', 'DESC')->first();
        if ($ultimo){
            if ($this->count_new < 50){
                $this->ultimo_mensaje = $ultimo->id - $this->count_new;
            }else{
                $this->ultimo_mensaje = $ultimo->id - 49;
            }
        }else{
            $this->ultimo_mensaje = 0;
        }
    }


    public function render()
    {
        $chat = Chat::find($this->chat_id);
        $chatmessages = ChatMessage::where('chats_id', $this->chat_id)->orderBy('created_at', 'desc')->take(50)->get();
        $sorted = $chatmessages->sortBy('created_at');
        $sorted->values()->all();
        return view('livewire.chat.chat-component')
            ->with('chat', $chat)
            ->with('messages', $sorted);
    }

    public function limpiar()
    {
        $this->reset([
            'new_message'
        ]);
    }

    protected $rules = [
        'new_message' => 'required'
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
        $this->chat_count = ChatMessage::where('chats_id', $this->chat_id)->count();
        $chatUser = ChatUser::where('chats_id', $this->chat_id)->where('users_id', Auth::id())->first();
        $chatUser->mensajes_vistos = $this->chat_count;
        $chatUser->save();
        $this->count_new = 0;
        $this->emit('bajarScroll', $chatmessage->id);
        $this->limpiar();
        $this->alert('success', 'Mensaje Enviado.');
        $this->sendMessage(ucwords($chatmessage->user->name), $chatmessage->message);
    }

    public function refresh()
    {
        $count = ChatMessage::where('chats_id', $this->chat_id)->count();
        if ($count > $this->chat_count) {
            $this->count_new = $count - $this->chat_count;
        }
    }

    public function verMessage()
    {
        $this->chat_count = ChatMessage::where('chats_id', $this->chat_id)->count();
        $chatUser = ChatUser::where('chats_id', $this->chat_id)->where('users_id', Auth::id())->first();
        $chatUser->mensajes_vistos = $this->chat_count;
        $chatUser->save();
        $this->count_new = 0;
        $ultimo = ChatMessage::where('chats_id', $this->chat_id)->orderBy('created_at', 'DESC')->first();
        $this->emit('bajarScroll', $ultimo->id);
    }

    public function bajarScroll()
    {
        //desplazamiento hasta el final del scroll
    }

    public function sendMessage($title, $body)
    {
        try {
            $this->messaging = FirebaseCloudMessagingService::connect();
            $data = [
                'title' => $title,
                'body' => $body,
                'subText' => 'Chat Directo',
                'destino' => 1
            ];
            $users = User::where('fcm_token', '!=', null)->get();
            foreach ($users as $user) {
                if ($user->id != Auth::id()){
                    $message = CloudMessage::withTarget('token', $user['fcm_token'])
                        ->withData($data);
                    $this->messaging->send($message);
                }
            }
        } catch (MessagingException|FirebaseException $e) {
            //mensaje en caso de error
        }
    }

    public function showModal($id)
    {
        $user = User::find($id);
        $this->modal_nombre = $user->name;
        $this->modal_email = $user->email;
        $this->modal_telefono = $user->telefono;
        $this->modal_imagen = $user->profile_photo_path;
        $mensajes = ChatMessage::where('chats_id', $this->chat_id)->where('users_id', $user->id)->count();
        $this->modal_mensajes = $mensajes;
        $chat = ChatUser::where('chats_id', $this->chat_id)->where('users_id', $user->id)->first();
        $this->modal_fecha = Carbon::create($chat['created_at'])->diffForHumans();
    }

}
