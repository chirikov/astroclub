var el = document.createElement('TABLE');
		el.cellpadding = 0;
		el.cellspacing = 0;
		el.background = 'images/logo.gif';
		el.width = 200;
		el.height = 200;
		el.border = 2;
		el.id = 'table'+i;
		//el.class = 'text';
		td1.appendChild(el);
		
		var el = document.createElement('TR');
		el.id = 'tr1'+i;
		document.getElementById('table'+i).appendChild(el);
		
		var el = document.createElement('TD');
		el.innerHTML = 'Комментарий: ';
		el.width = 200;
		el.height = 200;
		
		el.background = 'images/logo.gif';
		el.align = 'right';
		document.getElementById('tr1'+i).appendChild(el);
		
		var el = document.createElement('TD');
		document.getElementById('tr1'+i).appendChild(el);
		
		i++;