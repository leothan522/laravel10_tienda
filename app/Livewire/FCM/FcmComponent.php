<?php

namespace App\Livewire\FCM;

use App\Models\User;
use App\Services\FirebaseCloudMessagingService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class FcmComponent extends Component
{
    use LivewireAlert;

    public $title, $body, $fcm_token = "todos", $fcm_tipo;
    private $messaging;

    public function render()
    {
        $users = User::where('fcm_token', '!=', null)->get();
        return view('livewire.f-c-m.fcm-component')
            ->with('listarUsers', $users);
    }

    protected $rules = [
        'title' => 'required|min:4',
        'body' => 'required|min:4',
        'fcm_token' => 'required',
    ];

    public function sendMessage()
    {
        $this->validate();
        try {

            $this->messaging = FirebaseCloudMessagingService::connect();

            $notificacion = Notification::fromArray([
                'title' => $this->title,
                'body' => $this->body
            ]);

            $data = [
                'title' => $this->title,
                'body' => $this->body,
                'subText' => 'Administrador',
                'destino' => 0
            ];

            if ($this->fcm_token != "todos") {

                if ($this->fcm_tipo == "notification") {
                    $message = CloudMessage::withTarget('token', $this->fcm_token)
                        ->withNotification($notificacion);
                } else {
                    $message = CloudMessage::withTarget('token', $this->fcm_token)
                        ->withData($data);
                }
                $this->messaging->send($message);

            } else {

                $listarUsers = User::where('fcm_token', '!=', null)->get();
                foreach ($listarUsers as $user) {
                    if ($this->fcm_tipo == "notification") {
                        $message = CloudMessage::withTarget('token', $user->fcm_token)
                            ->withNotification($notificacion);
                    } else {
                        $message = CloudMessage::withTarget('token', $user->fcm_token)
                            ->withData($data);
                    }
                    $this->messaging->send($message);
                }

            }

            $this->alert(
                'success',
                'Mensaje enviado.'
            );

        } catch (MessagingException|FirebaseException $e) {
            $this->alert('warning', '¡ERROR FCM!', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => $e->getMessage(),
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'OK',
            ]);
        }
    }

    #[On('tokenSeleccionado')]
    public function tokenSeleccionado($token)
    {
        $this->fcm_token = $token;
    }
}
