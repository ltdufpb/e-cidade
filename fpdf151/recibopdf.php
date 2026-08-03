<?php 
define('FPDF_FONTPATH','fpdf151/font/');
require(modification('fpdf151/fpdf.php'));

class scpdf extends fpdf {

function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
 {
   $k = $this->k;
   $hp = $this->h;
   if($style=='F')
      $op='f';
   elseif($style=='FD' or $style=='DF')
      $op='B';
   else
      $op='S';
   $MyArc = 4/3 * (sqrt(2) - 1);
   $this->_out(sprintf('%.2f %.2f m',($x+$r)*$k,($hp-$y)*$k ));

   $xc = $x+$w-$r;
   $yc = $y+$r;
   $this->_out(sprintf('%.2f %.2f l', $xc*$k,($hp-$y)*$k ));
   if (!str_contains((string) $angle, '2'))
       $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k,($hp-$y)*$k ));
   else
       $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
   $xc = $x+$w-$r;
   $yc = $y+$h-$r;
   $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$yc)*$k));
   if (!str_contains((string) $angle, '3'))
      $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-($y+$h))*$k));
   else
      $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
   $xc = $x+$r;
   $yc = $y+$h-$r;
   $this->_out(sprintf('%.2f %.2f l',$xc*$k,($hp-($y+$h))*$k));
   if (!str_contains((string) $angle, '4'))
       $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-($y+$h))*$k));
   else
       $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
   $xc = $x+$r ;
   $yc = $y+$r;
   $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$yc)*$k ));
   if (!str_contains((string) $angle, '1'))
   {
      $this->_out(sprintf('%.2f %.2f l',($x)*$k,($hp-$y)*$k ));
      $this->_out(sprintf('%.2f %.2f l',($x+$w)*$k,($hp-$y)*$k ));
   }else
      $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
      $this->_out($op);
   }
function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
   {
   $h = $this->h;
   $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
   $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
   }
}
?>
