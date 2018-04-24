<?php
// licensed under http://www.apache.org/licenses/LICENSE-2.0

function showJsonTemplate($t, $o) {
  if (!is_array($t)) {
    return $t;
  }

  if (count($t) < 1) {
    return NULL;
  }

  if (count($t) == 1) {
    return array_key_exists($t[0], $o) ? $o[$t[0]] : NULL;
  }

  $op = '$all';
  if (is_string($t[0]) && strpos($t[0], '$') == 0) {
    $op = array_shift($t);
  }

  $ra = [];

  foreach ($t as $v) {
    array_push($ra, showJsonTemplate($v, $o));
  };

  switch ($op) {
  case '$first': {
    return array_reduce($ra, function ($a, $c) {
    return $a ? $a : $c;
  });
  } break;

  case '$any': {
    return implode($ra);
  }

  default:
  case '$all': {
      $r = array_reduce($ra, function ($a, $c) {
        return (is_null($a) || is_null($c)) ? NULL : ($a . $c);
      }, '');

      return is_null($r) ? '' : $r;
    } break;
  }
}
 ?>
