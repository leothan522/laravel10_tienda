@foreach($listarMessages as $mensaje)

    <!-- Message -->
    <div class="direct-chat-msg @if($mensaje->users_id == Auth::id()) right @endif" id="page-bottom_{{ $mensaje->id }}"
         xmlns:wire="http://www.w3.org/1999/xhtml">

        <div class="direct-chat-infos clearfix">
            <span class="direct-chat-name @if($mensaje->users_id == Auth::id()) float-right @endif">
                {{ ucwords($mensaje->user->name) }}
            </span>
            <span
                class="direct-chat-timestamp @if($mensaje->users_id == Auth::id()) float-left @else float-right @endif">
                {{ haceCuanto($mensaje->created_at) }}
            </span>
        </div>

        <img class="direct-chat-img" wire:click="showModal({{ $mensaje->users_id }})"
             src="{{ verImagen($mensaje->user->profile_photo_path, true) }}"
             data-toggle="modal" data-target="#exampleModal" alt="Message User Image" style="cursor: pointer;">

        <div class="direct-chat-text">
            {{ $mensaje->message }}
        </div>

    </div>
    <!-- /.direct-chat-msg -->

    @if($ultimo_mensaje == $mensaje->id && $new > 0)
        <div class="col-12 text-center mt-3">
        <span class="text-sm text-muted link-black">
            <i class="far fa-comments mr-1"></i> Nuevos
        </span>
        </div>
    @endif

@endforeach
