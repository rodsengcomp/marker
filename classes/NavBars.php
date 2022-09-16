<?php

if(empty($usuarioid)):
if(!empty($user->cornavcustom)): $cornavcustom = $user->cornavcustom; endif;
if(!empty($user->cornavcustom)): $cornavcustom = $user->cornavcustom; endif;
if(!empty($user->navcolor)): $navcolor = $user->navcolor; endif;
if(!empty($user->navcolor) && $user->navcolor == 'light') : $text_color = 'dark';
else: $text_color = 'light'; endif;



    // Consulta os dados no banco - PDOStatement
    $user = Tables::queryList($conexao, '*', 'usuarios', 'id='.$usuarioid, '');

    if(!empty($user->cornav)):
        $cornav = $user->cornav;
    endif;
    if(!empty($user->cornavcustom)):
        $cornavcustom = $user->cornavcustom; endif;
    if(!empty($user->navcolor)):
        $navcolor = $user->navcolor; endif;
    if(!empty($user->navcolor) && $user->navcolor == 'light') :
        $text_color = 'dark';
    else: $text_color = 'light'; endif;

else:

    $navs = NavBars::colorNavs($usuarioid, 'bg-dark', 'dark', '');

endif;

class NavBars {

    static function colorNavs($usuarioid, $cn, $nv, $cnc) {
        if(empty($usuarioid)):

        if($cn != '' && $usuarioid != 0):
            return 'navbar-'.$nv.' '.$cn.' navbar-expand-sm fixed-top"';
        elseif($cnc != '' && $usuarioid != 0):
            return 'navbar-'.$nv.' navbar-expand-sm fixed-top" style="background-color: '.$cnc.'"';
        else:
            return 'navbar-dark bg-dark navbar-expand-sm fixed-top"';
        endif;
    }

    static function borderColor($usuarioid, $cn, $cnc) {
        if($cn != '' && $usuarioid != 0):
            return 'text-'.$cn;
        elseif($cnc != '' && $usuarioid != 0):
            return 'style="background-color: '.$cnc.'"';
        else:
            return '';
        endif;
    }
}