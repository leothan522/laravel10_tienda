<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\User;
use App\Services\FirebaseCloudMessagingService;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{
    use LivewireAlert;

    public $chats_id, $tipo, $fecha, $count, $new = 0;
    public $chatusers_id, $vistos, $mensaje, $ultimo_mensaje;
    protected $messaging;
    public $modal_nombre, $modal_email, $modal_telefono, $modal_mensajes, $modal_fecha, $modal_imagen;

    public function mount()
    {
        $chatuser = ChatUser::where('users_id', auth()->id())->where('default', 1)->first();

        if (!$chatuser) {

            $chat = Chat::where('id', 1)->first();
            if (!$chat) {
                $chat = new Chat();
                $chat->id = 1;
                $chat->save();
            }

            $chatuser = new ChatUser();
            $chatuser->users_id = auth()->id();
            $chatuser->chats_id = $chat->id;
            $chatuser->save();

        }

        $this->chatusers_id = $chatuser->id;
        $this->chats_id = $chatuser->chats_id;
        $this->tipo = $chatuser->chat->tipo;
        $this->fecha = $chatuser->chat->created_at;
        $this->vistos = $chatuser->mensajes_vistos;
        $this->count = ChatMessage::where('chats_id', $this->chats_id)->count();

        if ($this->count > $this->vistos){
            $this->new = $this->count - $this->vistos;
        }

        $ultimo = ChatMessage::where('chats_id', $this->chats_id)
            ->where('users_id', auth()->id())
            ->orderBy('created_at', 'DESC')
            ->first();
        if ($ultimo){
            $this->ultimo_mensaje = $ultimo->id;
            $this->dispatch('downScroll', i: $this->ultimo_mensaje);
        }
    }

    public function render()
    {
        //$chat = Chat::find($this->chats_id);
        $chatmessages = ChatMessage::where('chats_id', $this->chats_id)
            ->orderBy('created_at', 'DESC')
            ->limit(50)
            ->get();
        $sorted = $chatmessages->sortBy('created_at');
        $sorted->values()->all();
        return view('livewire.chat.chat-component')
            ->with('listarMessages', $sorted);
    }

    protected $rules = [
        'mensaje' => 'required'
    ];

    public function save()
    {
        $this->validate();
        $chatmessage = new ChatMessage();
        $chatmessage->chats_id = $this->chats_id;
        $chatmessage->users_id = auth()->id();
        $chatmessage->message = $this->mensaje;
        $chatmessage->save();

        $this->count = ChatMessage::where('chats_id', $this->chats_id)->count();

        $chatUser = ChatUser::find($this->chatusers_id);
        $chatUser->mensajes_vistos = $this->count;
        $chatUser->save();

        $this->sendMessage(ucwords($chatmessage->user->name), $chatmessage->message);

        $this->reset('mensaje');
        $this->new = 0;
        $this->ultimo_mensaje = $chatmessage->id;
        $this->dispatch('downScroll', i: $chatmessage->id);
        $this->alert('success', 'Mensaje Enviado.');
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
                if ($user->id != auth()->id()){
                    $message = CloudMessage::withTarget('token', $user['fcm_token'])
                        ->withData($data);
                    $this->messaging->send($message);
                }
            }
        } catch (MessagingException|FirebaseException $e) {
            //mensaje en caso de error
        }
    }

    #[On('downScroll')]
    public function downScroll($i)
    {
        //JS
    }

    public function show()
    {
        $this->count = ChatMessage::where('chats_id', $this->chats_id)->count();
        $chatUser = ChatUser::find($this->chatusers_id);
        $chatUser->mensajes_vistos = $this->count;
        $chatUser->save();
        $this->new = 0;
        $ultimo = ChatMessage::where('chats_id', $this->chats_id)
            ->orderBy('created_at', 'DESC')
            ->first();
        $this->ultimo_mensaje = $ultimo->id;
        $this->dispatch('downScroll', i: $ultimo->id);
    }

    public function showModal($id)
    {
        $user = User::find($id);
        $this->modal_nombre = $user->name;
        $this->modal_email = $user->email;
        $this->modal_telefono = $user->telefono;
        $this->modal_imagen = $user->profile_photo_path;
        $this->modal_mensajes = ChatMessage::where('chats_id', $this->chats_id)->where('users_id', $user->id)->count();;
        $chat = ChatUser::find($this->chatusers_id);
        $this->modal_fecha = Carbon::create($chat->created_at)->diffForHumans();
    }

    #[On('refresh')]
    public function refresh()
    {
        $count = ChatMessage::where('chats_id', $this->chats_id)->count();
        if ($count > $this->count) {
            $this->new = $count - $this->count;
        }
    }

}
