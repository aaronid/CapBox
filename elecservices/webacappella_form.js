<!--
waJSQuery(window).load(function () {
	initializeAllWA_form();
});

function _waResetForm(_form)
{
	//_form.find('select,input,textarea').val('');
	var _inputs = _form.find('select,input,textarea');
	_inputs.each(function(i)
	{
		var _inEl = _inputs[ i ];

		if ( _inEl.type == 'checkbox' ) {
			_inEl.checked = false;
		}
		else if ( _inEl.type.startsWith( 'select' ) ) {
			var _index = _inEl.options.selectedIndex;

			if ( _index != -1 ) {
				_inEl.options.selectedIndex = -1;
				_inEl.options[ _index ].selected = false;
			}
		}
		else {
			_inEl.value = '';
		}
	});
}

function _waSubmitForm(_form)
{
//	alert('_waSubmitForm')
	var _inputs = _form.find('select,input[type!=checkbox],textarea,div[class*=divCheckBox]')
	var _url = extractParamInfo(_form,"url")
	var _validPostEmail = extractParamInfo(_form,"email_valid")
	var _bBreak = false;
	var backgroundError = "#f8c7c7";

	_inputs.each(function(i)
	{
		var _inEl = _inputs[ i ];
		var _elem = waJSQuery(this);
		var _max = parseInt(extractParamInfo(_elem,"max"))
		var _mandatory = extractParamInfo(_elem,"mandatory")
		var _isEmail = extractParamInfo(_elem,"email")

		if ( _inEl.tagName.toLowerCase() == 'div' ) {
			if (_mandatory=="1")
			{
				var checkedCount = _elem.find("input[type=checkbox]:checked").size(); //find all checked checkboxes
				if ( checkedCount == 0 )
				{
					_elem.css("backgroundColor",backgroundError);
					_elem.focus();
					_bBreak = true;
					return false;
				}
			}
		}
		else
		{
			_elem.val(waJSQuery.trim(_elem.val()))
			//alert(extractParamInfo(_elem,"max"))
			var _val = _elem.val();
			var _valLength = _val != undefined ? _val.length : 0;

			if (_max>0)
			{
				if (_valLength>_max)
				{
					_elem.css("backgroundColor",backgroundError)
					_elem.focus()
					_bBreak = true;
					return false;
				}
			}

			if (_mandatory=="1")
			{
				var hasValidLength = _valLength > 0;

				if (!hasValidLength)
				{
					_elem.css("backgroundColor",backgroundError)
					_elem.focus()
					_bBreak = true;
					return false;
				}
			}

			if (_isEmail=="1")
			{
				if ((_valLength>0) && (isValidEmailAddress(_val)==false))
				{
					_elem.css("backgroundColor",backgroundError)
					_elem.focus()
					_bBreak = true;
					return false;
				}
			}
		}
	});
	////
	if (_bBreak) return false;


	if (document.webaca_is_preview)
	{
		WA_Dialog.alert(Translator.tr("Operation not allowed in preview mode"));return false;
	}

	WA_Dialog.progress();

	var _stParams= "";

	_inputs.each(function(i)
	{
		var _el = waJSQuery(this)
		var _inEl = _inputs[ i ];
/*
		if (_stParams.length>0)
		{
			_stParams+=","
		}
*/
		var _name = _el.attr("name");
		var _val = '';

		if ( _inEl.tagName.toLowerCase() == 'div' ) {
			var _checkboxes = _el.find("input[type=checkbox]:checked"); //find all checked checkboxes

			_checkboxes.each(function(j)
			{
				var _inElCk = _checkboxes[ j ];

				if (_val.length>0)
				{
					_val += ', '
				}

				_val += _inElCk.value;
			});

			if ( _checkboxes.length > 0 ) {
				_name = _el.find("input[type=checkbox]")[ 0 ].name;
			}
			else {
				_name = '';
			}
		}
		else
		{
			_val = _el.val();
		}

		_val = _val.replace(/\n/gi,"\\n")
		_val = _val.replace(/"/gi,"\\\"")

		if ( _name.length>0) {
			if (_stParams.length>0)
			{
				_stParams+=","
			}
			_stParams += "\""+_name+"\":\""+_val+"\"";
		}
	});

	//alert(_stParams);


	//console.log( _stParams );

	var _params = waJSQuery.parseJSON( "{"+_stParams +"}");

	waJSQuery.post(_url,_params, function(data) {

		//alert(data)

		if (data.indexOf("<?php")>-1)
		{
			WA_Dialog.alert(Translator.tr("Error:No php on server"));
		}
		else
		{
			var _json = waParseCleanStringJSON( data );

			//alert(_json)
			if (_json==null)
			{
				WA_Dialog.alert(Translator.tr("Error:Malformed response !"));
				/*
				if (data.indexOf("htWaGlobalFunction.php")>0)
				{

				}
				*/


			}
			else
			{
				if (_json.success==true)
				{
					//alert(_json.success)
					_waResetForm(_form)
					var _mess= Translator.tr("Success:Mail sended");
					if (_json.error.length>0)
					{
						_mess+="<br>"
						_mess+="<br>"
						_mess+=_json.error
					}


					WA_Dialog.alert(_mess);

				}
				else
				{
					WA_Dialog.alert(_json.error);
				}

			}
		}

	    })
	   .success(function() { /*alert("second success");*/})
	   .error(function() { WA_Dialog.alert("*error send mail!"); })
	   .complete(function() { /*alert("complete");*/});

  	return true;
};


function initializeAllWA_form()
{
	waJSQuery(".wa-form").each(function(i)
	{
		var _form = waJSQuery(this)
		var _inputs = _form.find('select,input[type!=checkbox],textarea,div[class*=divCheckBox]')
		var _url = extractParamInfo(_form,"url")
		var _validPostEmail = extractParamInfo(_form,"email_valid")

		///

		_inputs.each(function(i)
		{
			var _elem = waJSQuery(this);
			var oldBg = _elem.attr( "oldBackgroundColor" );

			if ( oldBg == undefined ) {
				oldBg = _elem.css( "backgroundColor" );
				_elem.attr( "oldBackgroundColor", oldBg );
			}

			_elem.keypress(function(e) {
				var _elem = waJSQuery(this)
				if (e.which==13)
				{
					if (_elem.prop('tagName')=="TEXTAREA")
					{
						return true;
					}
					//alert('Handler for .keypress() called. '+e.which+" "+_elem.prop('tagName'));
					return false;
				}

				return true;
			});
			var _max = parseInt(extractParamInfo(_elem,"max"))
			if (_max>0)
			{
				_elem.keyup(function(e) {
				var _el = waJSQuery(this)
				var _max = parseInt(extractParamInfo(_el,"max"))
				var _val = _elem.val()
				var _valLength = _val != undefined ? _val.length : 0;
				if (_valLength>_max)
				{
					_el.val(_val.substring(0,_max))
				}
				  //alert('Handler for .keyup() called.');
				});
			}
			_elem.change(function()
			{
				var oldBg = _elem.attr( "oldBackgroundColor" );
				_elem.css("backgroundColor", oldBg)
			});

		});


	});



	waJSQuery(".wa-form-button-reset").each(function(i)
	{
		var _but = waJSQuery(this)
		//alert(_but)
		var _lnk = _but;//.parent("div");
		_lnk.css("cursor","pointer")
		_but.css("cursor","pointer")


		_lnk.click(function()
		{
			var _form = waJSQuery(this).parents("form")
			//alert('reset ' +i)
			_waResetForm(_form)
			return false;
		});
/*
		_but.click(function()
		{
			var _form = waJSQuery(this).parents("form")
			//alert('reset ' +i)
			_waResetForm(_form)
			return false;
		});
		*/



	});

	waJSQuery(".wa-form-button-submit").each(function(i)
	{
		var _but = waJSQuery(this)
		var _lnk = _but;//.parent("div");
		_lnk.css("cursor","pointer")
		_but.css("cursor","pointer")
		//_lnk.attr("target","")

		_lnk.click(function()
		{
			var _form = waJSQuery(this).parents("form")
			_waSubmitForm(_form)
			return false;
		});
	/*
		_but.click(function()
		{
			var _form = waJSQuery(this).parents("form")
			_waSubmitForm(_form)
			return false;
		});
		*/
	});
}

-->
