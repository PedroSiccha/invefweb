<table class="table m-b-xs" id="tabBancos">
                    <tbody>
                        @foreach($listaBancos as $lb)
                            <?php
                                $estado = $lb->estado;
                                $nombre = $lb->tipo;
                                $monto = $lb->monto;
                                $idBanco = $lb->banco_id;
                                
                                if ($monto <= 0){
                                    $monto = 0.00;
                                }
                                
                                if($estado == "abierta"){
                                    echo "<tr style='background-color: #1AB394; color: #FFFFFF;'>
                                            <td>
                                                <a title='$nombre' data-gallery=''>$nombre</a>
                                            </td>
                                            <td>
                                                <p style='text-align:right;'>S/. $monto</p>
                                            </td>
                                          </tr>";
                                }else{
                                    echo "<tr onclick=modalAbrirBanco($idBanco) style='background-color: #ed0e0e; color: #FFFFFF;'>
                                            <td>
                                                <a title='$nombre' data-gallery=''>$nombre</a>
                                            </td>
                                            <td>
                                                <p style='text-align:right;'>S/. $monto</p>
                                            </td>
                                          </tr>";
                                }
                                
                                
                            ?>
                        @endforeach
                    </tbody>
                </table>