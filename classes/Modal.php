<?php


class Modal {

    public $colorHeader;
    public $idModal;
    public $typeHeader;
    public $typeBody;
    public $typeFooter;

    /**
     * @return mixed
     */
    public function getIdModal() {
        return $this->idModal;
    }

    /**
     * @return mixed
     */
    public function getTypeHeader() {
        return $this->typeHeader;
    }

    /**
     * @return mixed
     */
    public function getTypeBody() {
        return $this->typeBody;
    }

    /**
     * @return mixed
     */
    public function getTypeFooter() {
        return $this->typeFooter;
    }


    public function Modals() {
        return '<div class="modal fade" id="'.$this->getIdModal().'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content fw-bold fs-5">
                            <div class="modal-header text-white bg-secondary">'.
                                    $this->getTypeHeader().'
                                <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button>
                           </div>
                            <div class="modal-body">
                                <div class="text-center">'.
                                    $this->getTypeBody().
                            '</div>
                            </div>
                                <div class="modal-footer justify-content-center">'.
                                    $this->getTypeFooter().
                                '</div>
                            </div>
                        </div>
                    </div>';
    }

    public function ModalLixeiraList($usuarioniveldeacesso) {

        $this->idModal = 'myModalLixo';
        $this->colorHeader = 'text-white bg-secondary';
        $this->typeHeader = '<p><i class="fa fa-trash me-3"></i> Lixeira da Lista</p>';

        if($usuarioniveldeacesso > 0 && $usuarioniveldeacesso < 3) :
            $this->typeBody = '<div class="textdel fw-bold fs-5"></div>';
            $this->typeFooter = '<div class="buttondel fw-bold fs-5"></div>';

            return $this->Modals();
        else:
            $this->typeBody = '<p> Antes de descartar o registro <br> Favor se logar !!!</p>';
            $this->typeFooter = '<a href="/sisdamwebnew" role="button" class="btn btn-outline-success btn-sm fw-bold fs-5 text-center"><i class="fa fa-hand-o-up"></i> Entendido</a>';
            return $this->Modals();
        endif;
    }

    public function ModalLixeiraEdit($usuarioniveldeacesso, $nametitle, $idaction, $nameaction, $pag_system, $pagina, $get_year) {

        $this->idModal = 'modalLixeira';
        $this->colorHeader = 'text-white bg-secondary';
        $this->typeHeader = '<p><i class="fa fa-trash me-3"></i> Lixeira da Lista</p>';

        if($usuarioniveldeacesso > 0 && $usuarioniveldeacesso < 3) :
            $this->typeBody = '<div class="modal-title text-center  fw-bold fs-5" id="modalDel">Deseja enviar a lixeira '.$nametitle.' : <span class="badge rounded-pill bg-danger pt-2 pb-2">'.$idaction.'</span><br> de '.$get_year.' ?</div>';
            $this->typeFooter = '<a accesskey="S" href="'.$pag_system.'?pagina=acao-'.$pagina.'&idaction='.$idaction.'&nameaction='.$nameaction.'&ano='.$get_year.'&action=lixeira" role="button" class="btn btn-outline-success btn-sm me-3 fw-bold"><i class="fa fa-trash me-2"></i> <u>S</u>IM</a>
            <button type="button" class="btn btn-outline-danger btn-sm fw-bold" data-dismiss="modal"><i class="fa fa-remove me-2"></i>NÃO</button>';
            return $this->Modals();
        else:
            $this->typeBody = '<p> Antes de descartar o registro <br> Favor se logar !!!</p>';
            $this->typeFooter = '<a href="/sisdamwebnew" role="button" class="btn btn-outline-success btn-sm fw-bold fs-5 text-center"><i class="fa fa-hand-o-up"></i> Entendido</a>';
            return $this->Modals();
        endif;
    }

    static function ModalSN($id, $title, $text_header ,$header_color, $header_icon, $body, $btnhref) {
        return '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content fw-bold fs-6">
                            <div class="modal-header text-center text-'.$text_header.' bg-'.$header_color.'"><i class="fa fa-'.$header_icon.' me-3"></i>
                                '.$title.'
                                <button type="button" class="btn-close text-white" data-dismiss="modal" aria-label="Close"></button>
                           </div>
                            <div class="modal-body">
                                <div class="text-center">'.$body.'</div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <a accesskey="S" href="'.$btnhref.'" role="button" class="btn btn-outline-success btn-sm me-3 fw-bold"><i class="fa fa-trash me-2"></i> <u>S</u>IM</a>
                                <button type="button" class="btn btn-outline-danger btn-sm fw-bold" data-dismiss="modal"><i class="fa fa-remove me-2"></i>NÃO</button></div>
                            </div>
                        </div>
                    </div>';
    }

}