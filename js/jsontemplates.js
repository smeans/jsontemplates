// licensed under http://www.apache.org/licenses/LICENSE-2.0

function evalJsonTemplate(t, o) {
  if (t.constructor !== Array) {
  	return t;
  }

  if (t.length < 1) {
	  return undefined;
  }

  if (t.length == 1) {
  	return o[t[0]];
  }

  var op = '$all';
  if (t[0].indexOf('$') == 0) {
  	op = t.shift();
  }

  var ra = [];

  t.forEach(v => {
  	ra.push(evalJsonTemplate(v, o));
  });

  switch (op) {
  case '$first': {
  	return ra.reduce((a, c) => a || c);
  } break;

  case '$any': {
  	return ra.join('');
  }

  default:
  case '$all': {
  		var r = ra.reduce((a, c) => (a == undefined || c == undefined) ? undefined : a + c, '');
      return r == undefined ? '' : r;
    } break;
  }
}
