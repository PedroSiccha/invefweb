<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerNosotros;
use App\Models\BannerPregunta;
use App\Models\BannerServicio;
use App\Models\Caracteristicas;
use App\Models\Nosotros;
use App\Models\PreguntaFrecuente;
use App\Models\Resumen;
use App\Models\ResumenEmpresa;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class WebController extends Controller
{
    public function noticia()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }

        $banner = DB::SELECT('SELECT * FROM banner');

        $resumenEmpresa = DB::SELECT('SELECT * FROM resumenempresa');

        $resumen = DB::SELECT('SELECT * FROM resumen');

        $caracteristicas = DB::SELECT('SELECT * FROM caracteristicas');

        return view('web.noticia', compact('usuario', 'notificacion', 'cantNotificaciones', 'banner', 'resumenEmpresa', 'resumen', 'caracteristicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarBanner(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $img=$request->banner;

        if ($request->hasFile('banner')) { 
            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('banner')->put($nuevoNombre, File::get($img));
            if($subido){
                $urlGuardar='img/banner/'.$nuevoNombre;
            }
        }

        $ban = new Banner();
        $ban->nombre = $request->nombre;
        $ban->descripcion = $request->descripcion;
        $ban->imagen = $urlGuardar;
        $ban->estado = $request->estado;
        $ban->fecinicio = date('Y-m-d');
        $ban->fecfin = date('Y-m-d');
        if ($ban->save()) {
            $res = "1";
        }

        $banner = DB::SELECT('SELECT * FROM banner');

        return response()->json(["view"=>view('web.tabBanner', compact('banner'))->render(), '$res'=>$res]);
    }

    public function editarBanner(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $urlAntiguo = DB::SELECT('SELECT imagen FROM banner WHERE id = "'.$request->id.'"');
        $img=$request->banner;

        if ($img != null) {
            # code...
            if ($request->hasFile('banner')) { 
                $nombre=$img->getClientOriginalName();
                $extension=$img->getClientOriginalExtension();
                $nuevoNombre=$nombre.".".$extension;
                $subido = Storage::disk('banner')->put($nuevoNombre, File::get($img));
                if($subido){
                    $urlGuardar='img/banner/'.$nuevoNombre;
                }
            }
    
            $ban = Banner::where('id', '=',  $request->id)->first();
            $ban->nombre = $request->nombre;
            $ban->descripcion = $request->descripcion;
            $ban->imagen = $urlGuardar;
            $ban->estado = $request->estado;
            $ban->fecinicio = date('Y-m-d');
            $ban->fecfin = date('Y-m-d');
            if ($ban->save()) {
                $res = "1";
            }

        }else {

            $ban = Banner::where('id', '=',  $request->id)->first();
            $ban->nombre = $request->nombre;
            $ban->imagen = $urlAntiguo[0]->imagen;
            $ban->descripcion = $request->descripcion;
            $ban->estado = $request->estado;
            $ban->fecinicio = date('Y-m-d');
            $ban->fecfin = date('Y-m-d');
            if ($ban->save()) {
                $res = "1";
            }

        }


        $banner = DB::SELECT('SELECT * FROM banner');

        return response()->json(["view"=>view('web.tabBanner', compact('banner'))->render(), '$res'=>$res]);
    }

    public function eliminarBanner(Request $request)
    {
        $res = 0;

        $ban = Banner::find($request->id);

        if ($ban->delete()) {
            $res = 1;
        }

        $banner = DB::SELECT('SELECT * FROM banner');

        return response()->json(["view"=>view('web.tabBanner', compact('banner'))->render(), '$res'=>$res]);
        
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cambiarEstadoBanner(Request $request)
    {
        $id = $request->id;
        $estado = $request->nuevoEstado;
        $res = "0";
        $not = "0";

        $ban = Banner::where('id', '=', $id)->first();
        $ban->estado = $estado;
        if ($ban->save()) {
            $res = "1";
            if ($estado == "ACTIVO") {
                $not = "1";
            }else {
                $not = "2";
            }

        }

        $banner = DB::SELECT('SELECT * FROM banner');

        return response()->json(["view"=>view('web.tabBanner', compact('banner'))->render(), 'res'=>$res, 'not'=>$not ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarResumenEmpresa(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $img=$request->foto;

        if ($request->hasFile('foto')) { 
            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('resumenEmpresa')->put($nuevoNombre, File::get($img));
            if($subido){
                $urlGuardar='img/resumenEmpresa/'.$nuevoNombre;
            }
        }

        $resu = new Resumen();
        $resu->titulo = $request->titulo;
        $resu->subtitulo = $request->subTitulo;
        $resu->descripcion = $request->descripcion;
        $resu->icono = $request->icono;
        $resu->estado = $request->estado;
        $resu->imagen = $urlGuardar;
        $resu->tituloboton = $request->btnAsignar;
        $resu->urlboton = $request->asignarUrl;
        if ($resu->save()) {
            $res = "1";
        }

        $resumen = DB::SELECT('SELECT * FROM resumen');

        return response()->json(["view"=>view('web.tabResumenEmpresa', compact('resumen'))->render(), '$res'=>$res]);
    }

    public function editarResumenEmpresa(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $urlAntiguo = DB::SELECT('SELECT imagen FROM resumen WHERE id = "'.$request->id.'"');
        $img=$request->banner;

        if ($img != null) {
            # code...
            if ($request->hasFile('foto')) { 
                $nombre=$img->getClientOriginalName();
                $extension=$img->getClientOriginalExtension();
                $nuevoNombre=$nombre.".".$extension;
                $subido = Storage::disk('resumenEmpresa')->put($nuevoNombre, File::get($img));
                if($subido){
                    $urlGuardar='img/resumenEmpresa/'.$nuevoNombre;
                }
            }
    
            $resu = Resumen::where('id', '=',  $request->id)->first();
            $resu->titulo = $request->titulo;
            $resu->subtitulo = $request->subTitulo;
            $resu->descripcion = $request->descripcion;
            $resu->icono = $request->icono;
            $resu->estado = $request->estado;
            $resu->imagen = $urlGuardar;
            $resu->tituloboton = $request->btnAsignar;
            $resu->urlboton = $request->asignarUrl;
            if ($resu->save()) {
                $res = "1";
            }

        }else {

            $resu = Resumen::where('id', '=',  $request->id)->first();
            $resu->titulo = $request->titulo;
            $resu->subtitulo = $request->subTitulo;
            $resu->descripcion = $request->descripcion;
            $resu->icono = $request->icono;
            $resu->estado =  $urlAntiguo[0]->imagen;
            $resu->imagen = $urlGuardar;
            $resu->tituloboton = $request->btnAsignar;
            $resu->urlboton = $request->asignarUrl;
            if ($resu->save()) {
                $res = "1";
            }

        }


        $resumen = DB::SELECT('SELECT * FROM resumen');

        return response()->json(["view"=>view('web.tabResumenEmpresa', compact('resumen'))->render(), '$res'=>$res]);
    }

    public function eliminarResumen(Request $request)
    {
        $res = 0;

        $resE = Resumen::find($request->id);

        if ($resE->delete()) {
            $res = 1;
        }

        $resumen = DB::SELECT('SELECT * FROM resumen');

        return response()->json(["view"=>view('web.tabResumenEmpresa', compact('resumen'))->render(), 'res'=>$res]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cambiarEstadoResumenEmpresa(Request $request)
    {
        $id = $request->id;
        $estado = $request->nuevoEstado;
        $res = "0";
        $not = "0";

        $ban = Resumen::where('id', '=', $id)->first();
        $ban->estado = $estado;
        if ($ban->save()) {
            $res = "1";
            if ($estado == "ACTIVO") {
                $not = "1";
            }else {
                $not = "2";
            }

        }

        $resumen = DB::SELECT('SELECT * FROM resumen');

        return response()->json(["view"=>view('web.tabResumenEmpresa', compact('resumen'))->render(), 'res'=>$res, 'not'=>$not ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function mostrarResumen(Request $request)
    {
        $id = $request->id;

        $resumen = DB::SELECT(' SELECT * FROM resumen
                                  WHERE id = "'.$id.'"');

        return response()->json(["view"=>view('web.verResumen', compact('resumen'))->render()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardarPorQueElegirnos(Request $request)
    {
        $res = 0;

        $resEmp = new ResumenEmpresa();
        $resEmp->titulo = $request->titulo;
        $resEmp->descripcion = $request->descripcion;
        $resEmp->icono = $request->icono;
        $resEmp->estado = $request->estado;
        $resEmp->fecinicio = date('Y-m-d');
        $resEmp->fecfin = date('Y-m-d');
        if ($resEmp->save()) {
            $res = 1;
        }

        $resumenEmpresa = DB::SELECT('SELECT * FROM resumenempresa');

        return response()->json(["view"=>view('web.tabPorQueElegirnos', compact('resumenEmpresa'))->render(), '$res'=>$res]);
    }

    public function editarPorQueElegirnos(Request $request)
    {
        $res = 0;

        $resEmp = ResumenEmpresa::where("id", "=", $request->id)->first();
        $resEmp->titulo = $request->titulo;
        $resEmp->descripcion = $request->descripcion;
        $resEmp->icono = $request->icono;
        $resEmp->estado = $request->estado;
        $resEmp->fecinicio = date('Y-m-d');
        $resEmp->fecfin = date('Y-m-d');
        if ($resEmp->save()) {
            $res = 1;
        }

        $resumenEmpresa = DB::SELECT('SELECT * FROM resumenempresa');

        return response()->json(["view"=>view('web.tabPorQueElegirnos', compact('resumenEmpresa'))->render(), '$res'=>$res]);
    }

    public function cambiarEstadoPorQueElegirnos(Request $request)
    {
        $id = $request->id;
        $estado = $request->nuevoEstado;
        $res = "0";
        $not = "0";

        $rEm = ResumenEmpresa::where('id', '=', $id)->first();
        $rEm->estado = $estado;
        if ($rEm->save()) {
            $res = "1";
            if ($estado == "ACTIVO") {
                $not = "1";
            }else {
                $not = "2";
            }

        }

        $resumenEmpresa = DB::SELECT('SELECT * FROM resumenempresa');

        return response()->json(["view"=>view('web.tabPorQueElegirnos', compact('resumenEmpresa'))->render(), 'res'=>$res, 'not'=>$not]);
    }

    public function eliminarPorQueElegirnos(Request $request)
    {
        $res = 0;

        $pqe = ResumenEmpresa::find($request->id);

        if ($pqe->delete()) {
            $res = 1;
        }
        
        $resumenEmpresa = DB::SELECT('SELECT * FROM resumenempresa');

        return response()->json(["view"=>view('web.tabPorQueElegirnos', compact('resumenEmpresa'))->render(), '$res'=>$res]);
    }

    public function guardarCaracteristica(Request $request)
    {
        $res = 0;

        $car = new Caracteristicas();
        $car->titulo = $request->tituloCaracteristica;
        $car->descripcion = $request->descripcionCaracteristica;
        $car->icono = $request->iconoCaracteristica;
        $car->estado = $request->estadoCaracteristica;
        if ($car->save()) {
            $res = 1;
        }

        $caracteristicas = DB::SELECT('SELECT * FROM caracteristicas');

        return response()->json(["view"=>view('web.tabCaracteristica', compact('caracteristicas'))->render(), '$res'=>$res]);
    }

    public function cambiarEstadoCaracteristica(Request $request)
    {
        $id = $request->id;
        $estado = $request->nuevoEstado;
        $res = "0";
        $not = "0";

        $car = Caracteristicas::where('id', '=', $id)->first();
        $car->estado = $estado;
        if ($car->save()) {
            $res = "1";
            if ($estado == "ACTIVO") {
                $not = "1";
            }else {
                $not = "2";
            }

        }

        $caracteristicas = DB::SELECT('SELECT * FROM caracteristicas');

        return response()->json(["view"=>view('web.tabCaracteristica', compact('caracteristicas'))->render(), 'res'=>$res, 'not'=>$not]);
    }

    public function editarCaracteristica(Request $request)
    {
        $res = 0;
        $car = Caracteristicas::where('id', '=', $request->idEc)->first();
        $car->titulo = $request->tituloEc;
        $car->descripcion = $request->descripcionEc;
        $car->icono = $request->iconoEc;
        $car->estado = $request->estadoEc;
        if ($car->save()) {
            $res = 1;
        }


        $caracteristicas = DB::SELECT('SELECT * FROM caracteristicas');

        return response()->json(["view"=>view('web.tabCaracteristica', compact('caracteristicas'))->render(), '$res'=>$res]);
    }

    public function eliminarCaracteristica(Request $request)
    {
        $res = 0;

        $car = Caracteristicas::find($request->id);

        if ($car->delete()) {
            $res = 1;
        }

        $caracteristicas = DB::SELECT('SELECT * FROM caracteristicas');

        return response()->json(["view"=>view('web.tabCaracteristica', compact('caracteristicas'))->render(), 'res'=>$res]);
        
    }

    public function configNosotros(){

        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }
        
        $banner = DB::SELECT('SELECT * FROM banernosotros');

        $nosotros = DB::SELECT('SELECT * FROM nosotros');

        return view('web.regNosotros', compact('usuario', 'notificacion', 'cantNotificaciones', 'banner', 'nosotros'));

    }

    public function configServicios(){

        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }

        $banner = DB::SELECT('SELECT * FROM bannerservicios');

        $resumen = DB::SELECT('SELECT * FROM servicios');

        return view('web.regServicios', compact('usuario', 'notificacion', 'cantNotificaciones', 'banner', 'resumen'));

    }

    public function guardarBannerServicio(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $img=$request->banner;

        if ($request->hasFile('banner')) { 
            $nombre=$img->getClientOriginalName();
            //$extension=$img->getClientOriginalExtension();
            //$nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('bannerServicio')->put($nombre, File::get($img));
            if($subido){
                $urlGuardar='img/bannerServicio/'.$nombre;
            }
        }

        $bs = new BannerServicio();
        $bs->titulo = $request->nombre;
        $bs->descripcion = $request->descripcion;
        $bs->imagen = $urlGuardar;
        $bs->estado = $request->estado;
        if ($bs->save()) {
            $res = "1";
        }

        $banner = DB::SELECT('SELECT * FROM bannerservicios');

        return response()->json(["view"=>view('web.tabBannerServicio', compact('banner'))->render(), '$res'=>$res]);
    }

    public function cambiarEstadoBannerServicio(Request $request)
    {
        $id = $request->id;
        $estado = $request->nuevoEstado;
        $res = "0";
        $not = "0";

        $ban = BannerServicio::where('id', '=', $id)->first();
        
        $ban->estado = $estado;
        if ($ban->save()) {
            $res = "1";
            if ($estado == "ACTIVO") {
                $not = "1";
            }else {
                $not = "2";
            }

        }

        $banner = DB::SELECT('SELECT * FROM bannerservicios');

        return response()->json(["view"=>view('web.tabBannerServicio', compact('banner'))->render(), 'res'=>$res, 'not'=>$not]);
    }

    public function editarBannerServicio(Request $request)
    {

        $res = "0";
        $subido="";
        $urlGuardar="";
        $urlAntiguo = DB::SELECT('SELECT imagen FROM bannerservicios WHERE id = "'.$request->id.'"');
        $img=$request->banner;

        if ($img != null) {
            # code...
            if ($request->hasFile('banner')) { 
                $nombre=$img->getClientOriginalName();
                $extension=$img->getClientOriginalExtension();
                $nuevoNombre=$nombre.".".$extension;
                $subido = Storage::disk('bannerServicio')->put($nuevoNombre, File::get($img));
                if($subido){
                    $urlGuardar='img/bannerServicio/'.$nuevoNombre;
                }
            }
    
            $ban = BannerServicio::where('id', '=',  $request->id)->first();
            $ban->nombre = $request->nombre;
            $ban->descripcion = $request->descripcion;
            $ban->imagen = $urlGuardar;
            $ban->estado = $request->estado;
            $ban->fecinicio = date('Y-m-d');
            $ban->fecfin = date('Y-m-d');
            if ($ban->save()) {
                $res = "1";
            }

        }else {

            $ban = BannerServicio::where('id', '=',  $request->id)->first();
            $ban->titulo = $request->nombre;
            $ban->imagen = $urlAntiguo[0]->imagen;
            $ban->descripcion = $request->descripcion;
            $ban->estado = $request->estado;
            if ($ban->save()) {
                $res = "1";
            }

        }


        $banner = DB::SELECT('SELECT * FROM bannerservicios');

        return response()->json(["view"=>view('web.tabBannerServicio', compact('banner'))->render(), '$res'=>$res]);

    }

    public function eliminarBannerServicio(Request $request)
    {

        $res = 0;

        $pqe = BannerServicio::find($request->id);

        if ($pqe->delete()) {
            $res = 1;
        }
        
        $banner = DB::SELECT('SELECT * FROM bannerservicios');

        return response()->json(["view"=>view('web.tabBannerServicio', compact('banner'))->render(), 'res'=>$res]);
        
    }

    public function guardarServicio(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $img=$request->foto;

        if ($request->hasFile('foto')) { 
            $nombre=$img->getClientOriginalName();
            //$extension=$img->getClientOriginalExtension();
            //$nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('imgServicio')->put($nombre, File::get($img));
            if($subido){
                $urlGuardar='img/imgServicio/'.$nombre;
            }
        }

        $s = new Servicio();
        $s->titulo = $request->titulo;
        $s->resumen = $request->resumen;
        $s->imagen = $urlGuardar;
        $s->estado = $request->estado;
        $s->desc01 = $request->desc01;
        $s->desc02 = $request->desc02;
        $s->desc03 = $request->desc03;
        $s->desc04 = $request->desc04;
        $s->desc05 = $request->desc05;
        if ($s->save()) {
            $res = "1";
        }

        $resumen = DB::SELECT('SELECT * FROM servicios');

        return response()->json(["view"=>view('web.tabServicio', compact('resumen'))->render(), '$res'=>$res]);
    }

    public function cambiarEstadoServicio(Request $request)
    {
        $id = $request->id;
        $estado = $request->nuevoEstado;
        $res = "0";
        $not = "0";

        $ban = Servicio::where('id', '=', $id)->first();
        
        $ban->estado = $estado;
        if ($ban->save()) {
            $res = "1";
            if ($estado == "ACTIVO") {
                $not = "1";
            }else {
                $not = "2";
            }

        }

        $resumen = DB::SELECT('SELECT * FROM servicios');

        return response()->json(["view"=>view('web.tabServicio', compact('resumen'))->render(), 'res'=>$res, 'not'=>$not]);

    }

    public function editarServicio(Request $request)
    {

        $res = "0";
        $subido="";
        $urlGuardar="";
        $urlAntiguo = DB::SELECT('SELECT imagen FROM servicios WHERE id = "'.$request->id.'"');
        $img=$request->foto;

        if ($img != null) {
            # code...
            if ($request->hasFile('foto')) { 
                $nombre=$img->getClientOriginalName();
                /*
                $extension=$img->getClientOriginalExtension();
                $nuevoNombre=$nombre.".".$extension;
                */
                $subido = Storage::disk('imgServicio')->put($nombre, File::get($img));
                if($subido){
                    $urlGuardar='img/imgServicio/'.$nombre;
                }
            }
    
            $s = Servicio::where('id', '=',  $request->id)->first();
            $s->titulo = $request->titulo;
            $s->resumen = $request->resumen;
            $s->imagen = $urlGuardar;
            $s->estado = $request->estado;
            $s->desc01 = $request->desc01;
            $s->desc02 = $request->desc02;
            $s->desc03 = $request->desc03;
            $s->desc04 = $request->desc04;
            $s->desc05 = $request->desc05;
            if ($s->save()) {
                $res = "1";
            }

        }else {

            $s = Servicio::where('id', '=',  $request->id)->first();
            $s->titulo = $request->titulo;
            $s->resumen = $request->resumen;
            $s->imagen = $urlAntiguo[0]->imagen;
            $s->estado = $request->estado;
            $s->desc01 = $request->desc01;
            $s->desc02 = $request->desc02;
            $s->desc03 = $request->desc03;
            $s->desc04 = $request->desc04;
            $s->desc05 = $request->desc05;
            if ($s->save()) {
                $res = "1";
            }

        }


        $resumen = DB::SELECT('SELECT * FROM servicios');

        return response()->json(["view"=>view('web.tabServicio', compact('resumen'))->render(), 'res'=>$res]);

    }

    public function eliminarServicio(Request $request)
    {

        $res = 0;

        $pqe = Servicio::find($request->id);

        if ($pqe->delete()) {
            $res = 1;
        }
        
        $banner = DB::SELECT('SELECT * FROM servicios');

        return response()->json(["view"=>view('web.tabBannerServicio', compact('banner'))->render(), 'res'=>$res]);


    }

    public function configPregFrecuentes()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }

        $banner = DB::SELECT('SELECT * FROM bannerpreguntafrecuenta');

        $resumen = DB::SELECT('SELECT * FROM preguntafrecuente');

        return view('web.configPregFrec', compact('usuario', 'notificacion', 'cantNotificaciones', 'banner', 'resumen'));
    }

    public function guardarBannerPregunta(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $img=$request->banner;

        if ($request->hasFile('banner')) { 
            $nombre=$img->getClientOriginalName();
            //$extension=$img->getClientOriginalExtension();
            //$nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('bannerPregunta')->put($nombre, File::get($img));
            if($subido){
                $urlGuardar='img/bannerPregunta/'.$nombre;
            }
        }

        $bs = new BannerPregunta();
        $bs->titulo = $request->nombre;
        $bs->descripcion = $request->descripcion;
        $bs->imagen = $urlGuardar;
        $bs->estado = $request->estado;
        if ($bs->save()) {
            $res = "1";
        }

        $banner = DB::SELECT('SELECT * FROM bannerpreguntafrecuenta');

        return response()->json(["view"=>view('web.tabBannerPregunta', compact('banner'))->render(), '$res'=>$res]);
    }

    public function guardarPreguntaFrecuente(Request $request)
    {
        $pf = new PreguntaFrecuente();
        $pf->pregunta = $request->pregunta;
        $pf->respuesta = $request->respuesta;
        $pf->area = $request->area;
        $pf->contacto = $request->numContacto;
        $pf->estado = $request->estado;
        if ($pf->save()) {
            $res = "1";
        }

        $resumen = DB::SELECT('SELECT * FROM preguntafrecuente');

        return response()->json(["view"=>view('web.tabPregunta', compact('resumen'))->render(), '$res'=>$res]);
    }

    public function configProductos(){

        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }

        $banner = DB::SELECT('SELECT * FROM bannerproducto');

        return view('web.regProductos', compact('usuario', 'notificacion', 'cantNotificaciones', 'banner'));

    }

    public function guardarBannerNostros(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $img=$request->bannerNosotros;

        if ($request->hasFile('bannerNosotros')) { 
            $nombre=$img->getClientOriginalName();
            //$extension=$img->getClientOriginalExtension();
            //$nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('bannerNosotros')->put($nombre, File::get($img));
            if($subido){
                $urlGuardar='img/bannerNosotros/'.$nombre;
            }
        }

        $ban = new BannerNosotros();
        $ban->titulo = $request->titulo;
        $ban->descripcion = $request->descripcion;
        $ban->imagen = $urlGuardar;
        $ban->estado = $request->estado;
        if ($ban->save()) {
            $res = "1";
        }

        $banner = DB::SELECT('SELECT * FROM banernosotros');

        return response()->json(["view"=>view('web.tabBannerNosotros', compact('banner'))->render(), '$res'=>$res]);
    }

    public function guardarResumenNosotros(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar="";
        $img=$request->imagenNosotros;

        if ($request->hasFile('imagenNosotros')) { 
            $nombre=$img->getClientOriginalName();
            //$extension=$img->getClientOriginalExtension();
            //$nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('imgNosotros')->put($nombre, File::get($img));
            if($subido){
                $urlGuardar='img/imgNosotros/'.$nombre;
            }
        }

        $nos = new Nosotros();
        $nos->titulo = $request->titulo;
        $nos->posicion = $request->posicion;
        $nos->estado = $request->estado;
        $nos->descripcion = $request->descripcionNosotros;
        $nos->imagen = $urlGuardar;
        if ($nos->save()) {
            $res = "1";
        }

        $nosotros = DB::SELECT('SELECT * FROM nosotros');

        return response()->json(["view"=>view('web.tabNosotros', compact('nosotros'))->render(), '$res'=>$res]);
    }

    public function guardarDetalleNosotros(Request $request)
    {
        $res = "0";
        $subido="";
        $urlGuardar=""; 
        $img=$request->imagen;

        if ($request->hasFile('imagen')) { 
            $nombre=$img->getClientOriginalName();
            //$extension=$img->getClientOriginalExtension();
            //$nuevoNombre=$nombre.".".$extension;
            $subido = Storage::disk('detalleNosotros')->put($nombre, File::get($img));
            if($subido){
                $urlGuardar='img/detalleNosotros/'.$nombre;
            }
        }

        // $det = new DetalleNosotros();
        // $det->subtitulo = $request->subtitulo;
        // $det->descripcion = $request->descripcion;
        // $det->imagen = $urlGuardar;
        // $det->nosotros_id = $request->idNosotros;
        // if ($det->save()) {
        //     $res = "1";
        // }

        $detalleNosotros = DB::SELECT('SELECT * FROM detalles_nosotros');

        return response()->json(["view"=>view('web.tabDetalleNosotros', compact('detalleNosotros'))->render(), '$res'=>$res]);
    }

    public function configAreas()
    {
        $user = Auth::user();
        $usuario = DB::SELECT('SELECT e.nombre, e.apellido, e.id, u.name AS area, e.foto AS foto, e.sede_id AS sede
                                FROM empleado e, users u 
                                WHERE e.users_id = u.id AND u.id = "'.$user->id.'"');

        $notificacion = DB::SELECT('SELECT * FROM  notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if ($notificacion == null) {
            $notificacion = DB::SELECT('SELECT "" AS icono, "" AS asunto, "00:00:00" AS tiempo');
        }

        $cantNotificaciones = DB::SELECT('SELECT COUNT(*) AS cant FROM notificacion WHERE estado = "PENDIENTE" AND sede = "'.$usuario[0]->sede.'"');

        if($cantNotificaciones == null){
            $cantNotificaciones = DB::SELECT('SELECT "0" AS cant');
        }

        $banner = DB::SELECT('SELECT * FROM bannerarea');

        $resumen = DB::SELECT('SELECT * FROM area');

        return view('web.regProductos', compact('usuario', 'notificacion', 'cantNotificaciones', 'banner', 'resumen'));
    }
}
