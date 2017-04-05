

function _waPatchRotationIE()
{
	//patch rotaion
	waJSQuery(".wa-comp").each(function(i) 
	{
		var _o = waJSQuery(this)
		var _CSSStr = _o.attr("style")
		
		
		var _opacity = _o.data("ms-opacity")
		var _rotation = waExtractCssStyle(_CSSStr,"-moz-transform")
		if (_rotation.length>0)
		{
		//	alert(_CSSStr)
			var _n = _rotation.indexOf("(")
			if (_n>-1)
			{
				_rotation = _rotation.substring(_n+1)
				_n = _rotation.indexOf("deg")
				if (_n>-1)
				{
					_rotation = _rotation.substring(0,_n)
				}
			}

			_rotation = parseInt(_rotation)
		

			var _offsetX = 0;
			var _offsetY = 0;
			var _offset = waExtractCssStyle(_CSSStr,"-ms-transform-offset")
		//	alert(_offset)
			var _arrOffset = _offset.split(" ")
			if (_arrOffset.length==2)
			{
				_offsetX = parseInt(_arrOffset[0])
				_offsetY = parseInt(_arrOffset[1])
			}
		//	alert(_rotation+"  x:"+_offsetX+" y:"+_offsetY)

		var rad_rot = _rotation*2*Math.PI/360;
		var costheta = Math.cos(rad_rot);
		var sintheta = Math.sin(rad_rot);
		
		var M11 = costheta;
		var M12 = -sintheta;
		var M21 = sintheta;
		var M22 = costheta;

		//	alert('r')
		_o.css({"left":_o.position().left+_offsetX,"top":_o.position().top+_offsetY})
		
		
		var _filter = "progid:DXImageTransform.Microsoft.Matrix(M11="+M11+",M12="+M12+",M21="+M21+",M22="+M22+",SizingMethod='auto expand') ";
	
		if ((isNaN(_opacity)==false) && (_opacity>=0) && (_opacity<1))
		{
			_filter +="Alpha(opacity="+Math.floor(_opacity*100)+")"
		}
		//	alert(_filter)
		_o.css("filter",_filter)
		//	_o.css("filter","Alpha(opacity=50)")
		}

	});
}

function _waPatchLink(_o,_href,_target)
{

	if (_target==undefined)_target=""
	if ( _href && (_href!="#") && (_href!="javascript:void(0)") && (_href.indexOf("javascript:")==-1))
	{

		_o.css("cursor","pointer")

		_o.data("href_ie8",_href)
		_o.data("target_ie8",_target)
		
		_o.attr("href","javascript:void(0)")
		_o.attr("target","")
		
		
		
		_o.click(function() {
			var _o = waJSQuery(this)
			var _href = _o.data("href_ie8")
			var _target = _o.data("target_ie8")
			
			return waOnClick(_href,{"targ":_target})
		});
		
		
		
	}
}

function _waPatchIE8()
{
	/*
	waJSQuery(".reflect").each(function(i) 
	{
		var _o = waJSQuery(this).parent("a")
		var _href = _o.attr("href")
		var _target = _o.attr("target")

		_waPatchLink(_o,_href,_target)
	})
	*/
	
	
	//patch opacity
	waJSQuery(".wa-comp").each(function(i) 
	{
		var _o = waJSQuery(this)
		var _CSSStr = _o.attr("style")
		var _opacity = waExtractCssStyle(_CSSStr,"opacity")
		var _opacity = parseFloat(_opacity)
		if ((isNaN(_opacity)==false) && (_opacity>=0) && (_opacity<1))
		{
			_o.css("filter","Alpha(opacity="+Math.floor(_opacity*100)+")")
			_o.data("ms-opacity",_opacity)
		}
	});
	
	waJSQuery(".wa-button").each(function(i) 
	{
		var _o = waJSQuery(this)
		var _txt = _o.find(".wa-but-txt")
		var _divText = _txt.parent("div")
		_divText.css("width",_txt.width())
		if (_o.height()<_divText.height())
		{
			var _xDiff = (_o.width()-_divText.width())/2
			var _yDiff = (_o.height()-_divText.height())/2// /_txt.height()-_o.height()
			_divText.css({"position":"absolute","left":_xDiff,"top":_yDiff})
		}
		//alert(_o.width()+" "+_divText.width())
		//alert(_o.height()+" "+_divText.height())
	});	
//	alert(document.documentMode+" "+document.compatMode)
//	if (document.documentMode==7)
	{
		waJSQuery(".wa-dynmenu").each(function(i) 
		{
			var _o = waJSQuery(this)
			
			var _config = waGetJsonCss(_o,"config");
			if(_config.vertical)
			{
				var _td = _o.find("TD")
				_td.each(function(i) 
				{
					var _item = waJSQuery(this)
					var _h = _item.height()
					_h = _h-2
					_item.css({"line-height":_h+"px","height":_h+"px"})
				})

			}
		});
	}

	
	
	
	_waPatchRotationIE()
	
	
	
}

function waPatchIE()
{
	if (isMSIE()==false)
	{
		return;
	}
	if (isMSIE_lower_than_ie9())
	{
		_waPatchIE8()
	}


///
//return;


}

