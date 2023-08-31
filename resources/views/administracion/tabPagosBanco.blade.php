<table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>SERIE</th>
                                            <th>BANCO</th>
                                            <th>DETALLE</th>
                                            <th>MONTO</th>
                                            <th>RECIBO</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($historialBanco as $hb)
                                                <tr>
                                                    <td>{{ $hb->codigo }}</td>
                                                    <td>{{ $hb->banco }}</td>
                                                    <td>{{ $hb->concepto }}</td>
                                                    <td>{{ $hb->garantia }}</td>
                                                    <td class="text-navy"> <i class="fa fa-level-up"></i> {{ $hb->monto }} </td>
                                                    <td>
                                                        <a href="{{ $hb->documento }}" title="{{ $hb->concepto }}" data-gallery="" >
                                                            <img src="{{ $hb->documento }}"  width="60" height="60">
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>