<div class="col-lg-3" onclick="modalCaja('', '', '')" <?php if ($ver=="1") { echo ""; }else { echo "hidden"; } ?>>
        <div class="widget style1 navy-bg">
            <div class="row">
                <div class="col-4">
                    <i class="fa fa-money fa-5x"></i>
                </div>
                <div class="col-8 text-right">
                    <span> Abrir Caja </span>
                    <h2 class="font-bold">S/. {{ $caja[0]->monto }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3" onclick="modalCaja()" <?php if ($ver=="0") { echo ""; }else { echo "hidden"; } ?>>
        <div class="widget style1 red-bg">
            <div class="row">
                <div class="col-4">
                    <i class="fa fa-money fa-5x"></i>
                </div>
                <div class="col-8 text-right">
                    <span> Cerrar Caja </span>
                    <h2 class="font-bold">S/. {{ $caja[0]->monto}}</h2>
                    <input type="text" class="form-control text-success" id="montoFin" value=" " hidden>
                </div>
            </div>
        </div>
    </div>