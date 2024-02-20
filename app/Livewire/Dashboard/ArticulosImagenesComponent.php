<?php

namespace App\Livewire\Dashboard;

use App\Models\Articulo;
use App\Models\ArtImg;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArticulosImagenesComponent extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $articulos_id;
    public $principalPhoto, $img_principal, $img_ver, $img_borrar_principal,
        $img_borrar_categoria, $img_imagen_categoria, $listarGaleria,
        $galeria_1, $geleria_2, $galeria_3, $galeria_4, $galeria_5, $galeria_6,
        $photo1, $photo2, $photo3, $photo4, $photo5, $photo6,
        $ver_galeria1, $ver_galeria2, $ver_galeria3, $ver_galeria4, $ver_galeria5, $ver_galeria6,
        $db_galeria1, $db_galeria2, $db_galeria3, $db_galeria4, $db_galeria5, $db_galeria6,
        $galeria_id1, $galeria_id2, $galeria_id3, $galeria_id4, $galeria_id5, $galeria_id6,
        $borrar_galeria1, $borrar_galeria2, $borrar_galeria3, $borrar_galeria4, $borrar_galeria5, $borrar_galeria6;

    public function render()
    {
        return view('livewire.dashboard.articulos-imagenes-component');
    }

    #[On('getArticuloImagenes')]
    public function getArticuloImagenes($articuloID)
    {
        $this->articulos_id = $articuloID;
        $this->reset([
            'principalPhoto', 'photo1', 'photo2', 'photo3', 'photo4', 'photo5', 'photo6',
            'galeria_id1', 'galeria_id2', 'galeria_id3', 'galeria_id4', 'galeria_id5', 'galeria_id6',
            'borrar_galeria1', 'borrar_galeria2', 'borrar_galeria3', 'borrar_galeria4', 'borrar_galeria5', 'borrar_galeria6',
        ]);
        $this->resetErrorBag();
        $articulo = Articulo::find($this->articulos_id);
        $this->img_principal = $articulo->imagen;
        $this->img_ver = $articulo->mini;
        $this->listarGaleria = ArtImg::where('articulos_id', $articulo->id)->get();
        $this->btn_editar = false;
        $this->btn_cancelar = true;
        $this->view = "imagen";
        $listarGaleria = ArtImg::where('articulos_id', $this->articulos_id)->get();
        $i = 0;
        foreach ($listarGaleria as $galeria){
            $i++;
            switch ($i){
                case 1:
                    $this->db_galeria1 = $galeria->imagen;
                    $this->ver_galeria1 = $galeria->mini;
                    $this->galeria_id1 = $galeria->id;
                    break;
                case 2:
                    $this->db_galeria2 = $galeria->imagen;
                    $this->ver_galeria2 = $galeria->mini;
                    $this->galeria_id2 = $galeria->id;
                    break;
                case 3:
                    $this->db_galeria3 = $galeria->imagen;
                    $this->ver_galeria3 = $galeria->mini;
                    $this->galeria_id3 = $galeria->id;
                    break;
                case 4:
                    $this->db_galeria4 = $galeria->imagen;
                    $this->ver_galeria4 = $galeria->mini;
                    $this->galeria_id4 = $galeria->id;
                    break;
                case 5:
                    $this->db_galeria5 = $galeria->imagen;
                    $this->ver_galeria5 = $galeria->mini;
                    $this->galeria_id5 = $galeria->id;
                    break;
                case 6:
                    $this->db_galeria6 = $galeria->imagen;
                    $this->ver_galeria6 = $galeria->mini;
                    $this->galeria_id6 = $galeria->id;
                    break;
            }
        }

    }

    public function updatedPrincipalPhoto()
    {
        $messages = [
            'principalPhoto.max' => 'la imagen no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'principalPhoto' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->img_principal){
            $this->img_borrar_principal = $this->img_principal;
        }
    }

    public function saveImagen()
    {
        $alert = false;
        $messages = [
            'principalPhoto.max' => 'la imagen no debe ser mayor que 1024 kilobytes.',
            'photo1.max' => 'la imagen 1 no debe ser mayor que 1024 kilobytes.',
            'photo2.max' => 'la imagen 2 no debe ser mayor que 1024 kilobytes.',
            'photo3.max' => 'la imagen 3 no debe ser mayor que 1024 kilobytes.',
            'photo4.max' => 'la imagen 4 no debe ser mayor que 1024 kilobytes.',
            'photo5.max' => 'la imagen 5 no debe ser mayor que 1024 kilobytes.',
            'photo6.max' => 'la imagen 6 no debe ser mayor que 1024 kilobytes.',
        ];

        $this->validate([
            'principalPhoto' => 'nullable|image|max:1024', // 1MB Max
            'photo1' => 'nullable|image|max:1024', // 1MB Max
            'photo2' => 'nullable|image|max:1024', // 1MB Max
            'photo3' => 'nullable|image|max:1024', // 1MB Max
            'photo4' => 'nullable|image|max:1024', // 1MB Max
            'photo5' => 'nullable|image|max:1024', // 1MB Max
            'photo6' => 'nullable|image|max:1024', // 1MB Max
        ], $messages);

        $articulo  = Articulo::find($this->articulos_id);

        if ($this->principalPhoto){
            //imagen actual database
            $imagen = $articulo->imagen;
            $ruta = $this->principalPhoto->store('public/articulos');
            $articulo->imagen = str_replace('public/', 'storage/', $ruta);
            //miniaturas
            $nombre = explode('articulos/', $articulo->imagen);
            $path_data = "storage/articulos/size_".$nombre[1];
            $miniatura = crearMiniaturas($articulo->imagen, $path_data);
            $articulo->mini = $miniatura['mini'];
            $articulo->detail = $miniatura['detail'];
            $articulo->cart = $miniatura['cart'];
            $articulo->banner = $miniatura['banner'];
            //borramos imagenes anteriones si existen
            if ($this->img_borrar_principal){
                borrarImagenes($imagen, 'articulos');
            }
            $alert = true;
        }else{
            if ($this->img_borrar_principal){
                $articulo->imagen = null;
                $articulo->mini = null;
                $articulo->detail = null;
                $articulo->cart = null;
                $articulo->banner = null;
                borrarImagenes($this->img_borrar_principal, 'articulos');
                $alert = true;
            }
        }

        if ($alert){
            $articulo->update();
            $this->reset('img_borrar_principal');
            $this->alert('success', 'Imagenes Actualizadas.');
        }

        // Galeria
        for ($i = 1; $i <= 6; $i++){
            $alert_galeria = false;
            switch ($i){
                case 1:
                    $photo = $this->photo1;
                    $galeria_id = $this->galeria_id1;
                    $borrar_galeria = $this->borrar_galeria1;
                    break;
                case 2:
                    $photo = $this->photo2;
                    $galeria_id = $this->galeria_id2;
                    $borrar_galeria = $this->borrar_galeria2;
                    break;
                case 3:
                    $photo = $this->photo3;
                    $galeria_id = $this->galeria_id3;
                    $borrar_galeria = $this->borrar_galeria3;
                    break;
                case 4:
                    $photo = $this->photo4;
                    $galeria_id = $this->galeria_id4;
                    $borrar_galeria = $this->borrar_galeria4;
                    break;
                case 5:
                    $photo = $this->photo5;
                    $galeria_id = $this->galeria_id5;
                    $borrar_galeria = $this->borrar_galeria5;
                    break;
                case 6:
                    $photo = $this->photo6;
                    $galeria_id = $this->galeria_id6;
                    $borrar_galeria = $this->borrar_galeria6;
                    break;
            }

            if ($galeria_id){
                //editar
                $galeria = ArtImg::find($galeria_id);
                $galeria_imagen = $galeria->imagen;
            }else{
                //nuevo
                $galeria = new ArtImg();
                $galeria_imagen = null;
            }

            if ($photo){
                $ruta = $photo->store('public/galeria/art_id_'.$this->articulos_id);
                $galeria->imagen = str_replace('public/', 'storage/', $ruta);
                //miniaturas
                $nombre = explode('art_id_'.$this->articulos_id.'/', $galeria->imagen);
                $path_data = "storage/galeria/art_id_".$this->articulos_id."/size_".$nombre[1];
                $miniatura = crearMiniaturas($galeria->imagen, $path_data);
                $galeria->mini = $miniatura['mini'];
                $galeria->detail = $miniatura['detail'];
                $galeria->cart = $miniatura['cart'];
                $galeria->banner = $miniatura['banner'];
                $galeria->articulos_id = $this->articulos_id;
                $galeria->save();
                $alert_galeria = true;
                if ($borrar_galeria){
                    borrarImagenes($galeria_imagen, 'art_id_'.$this->articulos_id);
                }
            }else{
                if ($borrar_galeria){
                    $galeria->delete();
                    $alert_galeria = true;
                    borrarImagenes($galeria_imagen, 'art_id_'.$this->articulos_id);
                }
            }

            if ($alert_galeria){
                $this->alert('success', 'Imagenes Actualizadas.');
            }

        }
        $this->getArticuloImagenes($this->articulos_id);

    }

    public function btnBorrarImagen()
    {
        $this->img_ver = null;
        $this->reset('principalPhoto');
        $this->img_borrar_principal = $this->img_principal;
    }

    public function btnBorrarGaleria($i)
    {
        switch ($i){
            case 1:
                $this->ver_galeria1 = null;
                $this->reset('photo1');
                $this->borrar_galeria1 = $this->db_galeria1;
                break;
            case 2:
                $this->ver_galeria2 = null;
                $this->reset('photo2');
                $this->borrar_galeria2 = $this->db_galeria2;
                break;
            case 3:
                $this->ver_galeria3 = null;
                $this->reset('photo3');
                $this->borrar_galeria3 = $this->db_galeria3;
                break;
            case 4:
                $this->ver_galeria4 = null;
                $this->reset('photo4');
                $this->borrar_galeria4 = $this->db_galeria4;
                break;
            case 5:
                $this->ver_galeria5 = null;
                $this->reset('photo5');
                $this->borrar_galeria5 = $this->db_galeria5;
                break;
            case 6:
                $this->ver_galeria6 = null;
                $this->reset('photo6');
                $this->borrar_galeria6 = $this->db_galeria6;
                break;
        }
    }

    public function updatedPhoto1()
    {
        $messages = [
            'photo1.max' => 'la imagen 1 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo1' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria1){
            $this->borrar_galeria1 = $this->db_galeria1;
        }
    }

    public function updatedPhoto2()
    {
        $messages = [
            'photo2.max' => 'la imagen 2 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo2' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria2){
            $this->borrar_galeria2 = $this->db_galeria2;
        }
    }
    public function updatedPhoto3()
    {
        $messages = [
            'photo3.max' => 'la imagen 3 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo3' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria3){
            $this->borrar_galeria3 = $this->db_galeria3;
        }
    }

    public function updatedPhoto4()
    {
        $messages = [
            'photo4.max' => 'la imagen 4 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo4' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria4){
            $this->borrar_galeria4 = $this->db_galeria4;
        }
    }

    public function updatedPhoto5()
    {
        $messages = [
            'photo5.max' => 'la imagen 5 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo5' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria5){
            $this->borrar_galeria5 = $this->db_galeria5;
        }
    }

    public function updatedPhoto6()
    {
        $messages = [
            'photo6.max' => 'la imagen 6 no debe ser mayor que 1024 kilobytes.'
        ];

        $this->validate([
            'photo6' => 'image|max:1024', // 1MB Max
        ], $messages);
        if ($this->db_galeria6){
            $this->borrar_galeria6 = $this->db_galeria6;
        }
    }

}
