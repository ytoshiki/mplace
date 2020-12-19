<?php

  function shortenTitle($sentence) {
    $stren = strlen($sentence);
    if($stren > 30) {
      $sentence_s = substr($sentence, 0, 30);
      $sentence_s .= '...';
      return $sentence_s;
    } else {
      return $sentence;
    }
  }

?>