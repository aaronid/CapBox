<!--



waJSQuery(function() {
	

	var _itemsRoot = waJSQuery(".waDynmenu-root");
	_itemsRoot.each(function(){
		
			waJSQuery(this).css("cursor","pointer")
	})
	
	
	
	//
	var _items = waJSQuery(".waDynmenu-item");
	_items.each(function(){
		
		if (isMSIE())
		{
			waJSQuery(this).css("background","url(wa_transparent.gif)")
		}
	})
	
	
	_items.hover(function(){
			var _cl = waJSQuery(this).attr("class");
			var _arr2;
			var _arr = splitClassParameters(_cl,'[',']')
			if (_arr['param']!=undefined)
			{
				_arr2 = wa_evaluate("["+_arr['param']+"]");
				waDynMenuOver(waJSQuery(this),_arr2);
			}
			else
			{
				waDynMenuOver(waJSQuery(this));
			}
			
			
		},
		function(){
	//alert('out')
		}
	)
	
	
	
});



function _waDynMenuContenair()
{
	return waJSQuery("#dynmenu-container");
}

function waGetJsonCss(_o,_name)
{
	var _s = _waParseJsonCss(_o,_name)
	_s = _s.replace(/''/g,"\"")
	return waJSQuery.parseJSON( _s )
}

function _waParseJsonCss(_o,_name)
{
	var _cl = _o.attr("class");
	if (_cl==undefined) return ""
//	alert(_cl)
	var _key = "json['"+_name+"']"
	
	var _n = _cl.indexOf(_key)
	if (_n>-1)
	{
		_n = _n + _key.length
		var _bracketCount = 0;
		var _started = false;
		for (var i=_n;i<_cl.length;i++)
		{
			var _c = _cl.charAt(i)
			if (_c == "{")
			{
				if (_started==false)
				{
					_started = true;
				}
				_bracketCount++;
			}
			if (_c == "}")
			{
				_bracketCount--;
				
				if (_started && (_bracketCount==0))
				{
					return _cl.substring(_n, i+1)
				}
			}
		}
	}
	return "";	
}


function _waDynMenuGetRootItem(_o)
{
	var i = 0;
	var _item = _o
	var _newitem = null;
	do
	{
		_newitem = null;
		
		var _objMenu = _item.parents(".wa-menu-div")
		
		
		if (_objMenu.length==1)
		{
			_newitem = _objMenu.data("menu-item-parent")
		}
		if ((_newitem!=null)&& (_newitem.length>0))
		{
			_item = _newitem;
		}
		i++
	}
	while ((_newitem!=null)&&(_newitem.length>0))
	return _item
}


function _waDynMenuConfig(_o)
{
	var _menu = _o.parents(".wa-dynmenu")
	var _config = null
	if (_menu.length==1)
	{
		_config = waGetJsonCss(_menu,"config");
	}

	if (_config==null)
	{
		var _it = _waDynMenuGetRootItem(_o)
		_menu = _it.parents(".wa-dynmenu")
		_config = waGetJsonCss(_menu,"config");
	}
	return _config;
	
}

function waDynMenuOver(_o,_menuStruct)
{	

	//alert(_o.html())
	var _cont = _waDynMenuContenair()
	
	
	var _config =  _waDynMenuConfig(_o)
	var _hasSub = (_menuStruct!=undefined) 
	
	if (_hasSub)
	{
		var _builded = _o.data("menu-builded")
		if (_builded != true)
		{

			_o.data("menu-builded",true)
			var _indexMenu = _cont.data("index-menu")
			if (_indexMenu==undefined)
			{
				_indexMenu= 0;
			}
			else
			{
				_indexMenu++;
			}
			_cont.data("index-menu",_indexMenu)

			var _rootIndex = "root"
			_waBuildMenu(_o,_config,_indexMenu,true,_menuStruct)
			_waActivatedItemWithSubMenu(_o,_config,_indexMenu,null,_menuStruct);	
		}
	}
	else
	{
		_waActivatedSingleItem(_o)
	}

	
	var _currentObjMenu = _cont.data("current-raised-obj-menu")
	if (_currentObjMenu!=undefined)
	{
		_waMenuHide(_currentObjMenu,true)
	}
	var _objMenu = _o.data("obj-menu")
	_cont.data("current-raised-obj-menu",_objMenu)
	///
	_waMenuHover(_o)
}

function _waMenuGetParentMenu(_o)
{
	var _objParent = _o.parents(".wa-menu-div")
	if (_objParent.length>0)
	{
		return _objParent;
	}
	var _parentItemMenu = _o.data("menu-item-parent")
	if (_parentItemMenu!=undefined)
	{
		var _objParent = _parentItemMenu.parents(".wa-menu-div")
		if (_objParent.length>0)
		{
			return _objParent;
		}
	}
	return null
}

function _waMenuTopPositionRoot()
{
	return 0-document.webaca_banner_height
}

function _waMenuHover(_o)
{
	var _config = _waDynMenuConfig(_o)
	var _xDec = 0;
	if (document.webaca_page_is_centered)
	{
		if (waJSQuery(window).width()>document.webaca_width_page)
		{

			//
			/*
			if (isWindowsMobile()==true)
			{
				_xDec = Math.max(0,(waJSQuery(window).width()-document.webaca_width_page)/2)
				
				var _bgOffsetX = 0;
				var _lxWin=getDocumentSize().width()
				var _lxPage=document.webaca_width_page
				if (_lxWin>_lxPage)_bgOffsetX=(_lxWin-_lxPage)/2;
				
				var _bgOffsetX2 = waJSQuery(window).scrollLeft(); 
				
				if (_bgOffsetX2 > _bgOffsetX)
				{
					_xDec += _bgOffsetX2
				}
				
				
			}
			else
			*/
			{
				_xDec = (waJSQuery(window).width()-document.webaca_width_page)/2
			}
		}
	}
	
	var _objParent = _o.parents(".wa-menu-div")
	var _isRoot = (_objParent.length==0)
	
	///
	var _href = _o.find("a")
	if (_href.length==0)
	{
		_href = _o
	}
	
	var _cssInitialized = _o.data("cssInitialized")
	if (_cssInitialized!=true)
	{
		_o.data("cssInitialized",true)
		var _oldCssHref = {
			color:_href.css("color"),
			"text-decoration":_href.css("text-decoration")
		}
		var _oldCss = {
			backgroundColor:_o.css("backgroundColor")	
		}	
		// 
		_o.data("oldCssHref",_oldCssHref)
		_o.data("oldCss",_oldCss)
	}
	
	
	//alert(_o.css("color"))
	
	//alert(_href.length)
	if (_isRoot)
	{
		_href.css("color",_config.root_col_text_over)
		_href.css("text-decoration",(_config.root_text_u_over)?"underline":"none")
		_o.css("backgroundColor",compliantColor(_config.root_col_bg_over))

		if (false)
		{
			if (_o.position().left==0)
			{
				_o.css({borderLeft:"1px solid "+_config.root_col_border})
			}
			_o.css({borderTop:"1px solid "+_config.root_col_border})
			_o.css({borderBottom:"1px solid "+_config.root_col_border})
		}
	}
	else
	{
		_href.css("color",_config.sub_col_text_over)
		_href.css("text-decoration",(_config.sub_text_u_over)?"underline":"none")
		_o.css("backgroundColor",compliantColor(_config.sub_col_bg_over))
	}
	
	
	//alert(_config.sub_col_bg_over)
	//alert(_config.sub_style_text)
	
	//
	
	///

	var _objMenu = _o.data("obj-menu")

	_waMenuClearHide(_objParent)
	_waMenuClearHide(_objMenu)

	//if (_objMenu!=undefined)
	{
		
		if (_objParent.length>0)
		{
			var _curSubObjMenu = _objParent.data("current-sub-obj-menu")
			if (_curSubObjMenu!=null)
			{
				_waMenuHide(_curSubObjMenu,true)
			}
			
			//if (_objMenu!=undefined)
			_objParent.data("current-sub-obj-menu",_objMenu)
		}
	}

	if (_objMenu!=undefined)
	{
		
		var _x = 0;
		var _y = 0;
		if (_isRoot)
		{
			
			if (_config.vertical)
			{
				var _menu = _o.parents(".wa-dynmenu")
				_x = _o.offset().left + _menu.outerWidth(true) -_xDec;
				_y = _o.offset().top;
			}
			else
			{
				_x = _o.offset().left -_xDec;
				_y = _o.offset().top+_o.height()+3;
			}
			

		}
		else
		{
			var _parentMenu = _waMenuGetParentMenu(_o)
			_x = _parentMenu.offset().left + _parentMenu.outerWidth(true)-_xDec;
			_y = _o.offset().top;	
		}

		var _margin = 10;
		_x = Math.max(_x,waJSQuery(window).scrollLeft())
		_x = Math.min(_x,waJSQuery(window).scrollLeft()+waJSQuery(window).width()-_objMenu.width()-_margin)

		_y = Math.min(_y,waJSQuery(window).scrollTop()+waJSQuery(window).height()-_objMenu.height()-_margin)
		_y = Math.max(_y,waJSQuery(window).scrollTop())
		
		_y+=_waMenuTopPositionRoot()

		_objMenu.stop(true, true).fadeIn();
		_objMenu.css({"left":_x,"top":_y})	
	}
	
}


function _waMenuHout(_o)
{
	//return;
	var _href = _o.find("a")
	if (_href.length==0)
	{
		_href = _o
	}
	var _oldCss = _o.data("oldCss")
	var _oldCssHref = _o.data("oldCssHref")
	
	_href.css(_oldCssHref)
	_o.css(_oldCss)
	
	var _objMenu = _o.data("obj-menu")
	
	var _objParent = _o.parents(".wa-menu-div")
//	console.log("_waMenuHout "+_objMenu.attr("id"))
	_waMenuWantHide(_objParent)
	if (_objParent.length==0)
	{
		_waMenuWantHide(_objMenu)
	}
	

}


function _waMenuClearHide(_objMenu)
{

	if (_objMenu==undefined) return;
	
	if (_objMenu.length>0)
	{
		var _timer = _objMenu.data("timer-menu-out")
		clearTimeout(_timer)
		_objMenu.show();
	}
//	alert(_objMenu.html())
	
	var _objParent =_waMenuGetParentMenu(_objMenu)
	_waMenuClearHide(_objParent)
}


function _waMenuHide(_objMenu,_bFast)
{
	
	var _childItemMenu = _objMenu.children(".wa-menu-item-div")
	_childItemMenu.each(function(){
		
		var _objParent= waJSQuery(this).data("obj-menu")
		if (_objParent!=null)
		_objParent.stop(true, true).fadeOut();
	})
	
	if (_bFast)
	{
		_objMenu.hide();
	}
	else
	{
		_objMenu.stop(true, true).fadeOut();
	}
	
}

function _waMenuWantHide(_objMenu)
{
	
	if (_objMenu==undefined) return;
	if (_objMenu.length==0) return;
	

	
	var _time = 600;
	if (_objMenu.length>0)
	{
		var _timer = wa_timeout(function()
		{
			_waMenuHide(_objMenu)
			
		},_time)
		_objMenu.data("timer-menu-out",_timer)
	}

///
	var _objParent =_waMenuGetParentMenu(_objMenu)
	_waMenuWantHide(_objParent)
}


function _waMenuParent(_obj)
{
	return _o.parents(".wa-menu-div");
}

function _waBuildMenu(_o,_config,_indexMenu,_isRoot,_menuStruct)
{
	var _cont = _waDynMenuContenair()

	var _indexSubMenu = _cont.data("id-menu")
	if (_indexSubMenu==undefined)
	{
		_indexSubMenu = 0;
		_cont.data("id-menu",_indexSubMenu)
	}
	

	if (_isRoot)
	{
		_o.data("id-menu",_indexSubMenu)
	}
	
	var _html ="";

	var _idMenu = "wa-sub-menu-"+_indexMenu+"-"+_indexSubMenu

	_html += "<div class='wa-menu-div' id='"+_idMenu+"' style='position:absolute;left:0px;top:0px;width:1000px;text-align:"+_config.sub_align_text+";background-color:"+compliantColor(_config.sub_col_bg)+";";

	_html += "z-index:"+_indexSubMenu+";"

	if (_config.sub_menu_shadow)
	{
		_html += "-webkit-box-shadow: 1px 1px 12px #555555;-moz-box-shadow:1px 1px 12px #555555; box-shadow:1px 1px 12px #555555; ;";
	}
	
	_html += "padding-top:3px;padding-bottom:3px;;"
	//_html += "padding:0px;"


	_html += "border:1px solid "+_config.sub_col_border+";' >"
	
	
	//_config
	for (var i=0;i<_menuStruct.length;i++)
	{
		var _sub = _menuStruct[i]
		
		//
		var _idSubMenu =""
		var _haveSubMenu = (_sub.length>1)
		if (_haveSubMenu)
		{
			_indexSubMenu = _cont.data("id-menu")
			_indexSubMenu++;
			_cont.data("id-menu",_indexSubMenu)
		}
		
		
		if (_sub.length>0)
		{
			var _subDef=_sub[0]
			var _label=_subDef[0]
			var _url=_subDef[1]
			var _target=_subDef[2]
var _js=_subDef[4]
			var _idMenuBis = ""
			
			var _class="wa-menu-item-div wa-sub-item-menu"
	
			if (_haveSubMenu)
			{
				_class+= " param[index_sub_menu("+_indexSubMenu+")]"
			}

			
			_html += "<div class='"+_class+"' style='position:absolute;overflow:auto;left:0px;"
			_html += "'>"
			
			var _cssText="position:relative;"+_config.sub_style_text

			if (_config.sub_text_u)
			{
				_cssText += "text-decoration:underline;"
			}
			
			else
			{
				_cssText += "text-decoration:none;"
			}
			
			var _hasActionOnLink = false;
			if (_url.length==0)
			{
				//_url = "#"
				_url = "javascript:void(0)"
				
				
				//_cssText += "cursor:default;"
			}
			else
			{
				_hasActionOnLink = true;
			}
			_html += "<a href=\""+_url+"\" ";
			
			
			if (_js!=undefined)
			{
				_html += "onclick=waLaunchFunction("+_js+") ";
				_hasActionOnLink = true;
			}
			
			//cursor
			if (_hasActionOnLink)
			{
				_cssText += "cursor:pointer;"
			}
			else
			{
				_cssText += "cursor:default;"
			}
	
			
			
			
			
			
			_html +="style=\""+_cssText

			
			_html += "\" target=\""+_target+"\">"

			_html += _label
			
			if (_haveSubMenu)
			{
				_html += " <b>&rsaquo;</b>"
			}
			else
			{
				//_html += " &nbsp;"
			}
			_html += "</a>"
			_html += "</div>"
		}

		///

		///

		if (_haveSubMenu)
		{
			var _subMenuStruct = _sub[1]
			_waBuildMenu(_o,_config,_indexMenu,false,_subMenuStruct)
		}
	}

	_html += "</div>"
	
	_cont.append(_html)
}



function _waActivatedItemWithSubMenu(_o,_config,_indexMenu,_indexSubMenu,_menuStruct)
{
	if (_indexSubMenu==null)
	{
		_indexSubMenu = _o.data("id-menu")
	}
	
	_o.hover(function(){
			_waMenuHover(waJSQuery(this),_config)
		},
		function(){

			_waMenuHout(waJSQuery(this),_config)

		}
	)
	////

	var _maxWidth = 0;
	var _maxHeight = 0;
	var _yCur = 3;
	
	if (_menuStruct!=undefined)
	{
		var _objMenu = waJSQuery("#wa-sub-menu-"+_indexMenu+"-"+_indexSubMenu);
		_o.data("obj-menu",_objMenu)

		if (_objMenu.length>0)
		{
			_objMenu.data("menu-item-parent",_o)
		}
		
	//		alert("_waActivatedMenu "+_o+"  "+_indexSubMenu)
		var _subObjects = new Array()
		_objMenu.find(".wa-sub-item-menu").each(function(i) 
		{
			_subObjects.push(waJSQuery(this))
		 });

		for (var i=0;i<_menuStruct.length;i++)
		{
			var _sub = _menuStruct[i]
			if (_sub.length>0)
			{
					var _subDef=_sub[0]
					///
					var _label=_subDef[0]

					var _subObj = _subObjects[i]

					var _w = _subObj.outerWidth(true)*1.2
					

					
					

					
					var _h = _subObj.outerHeight(true)*1.5
					var _heightSub = _h+4
					

					var _margin = _heightSub*0.5
					_margin = Math.max(_margin,3)
					
					var _widthSub = _w+5+_margin;//+10
					//_widthSub = Math.max(_widthSub,70)
					
					
					var _yOffset = (_heightSub-_subObj.height())/2
	
					_subObj.css({top:_yCur,width:_widthSub,height:_heightSub})

					var _href = _subObj.find("a")

					_href.css({top:_yOffset})
					
					
					
					_maxWidth = Math.max(_maxWidth,_widthSub)
					_maxHeight += _heightSub

					_yCur+=_heightSub;
					
					
					//////
					if (_config.sub_align_text=="center")
					{
						_href.css({"marginLeft":0,"marginRight":0})
					}
					else
					if (_config.sub_align_text=="right")
					{
						_href.css({"marginLeft":0,"marginRight":_margin})

						//_html += "margin-right:"+_margin+"px;"
					}
					else
					{
						_href.css({"marginLeft":_margin,"marginRight":0})
						//_html += "margin-left:"+_margin+"px;"	
					}


					
					///
					
					if (_sub.length>1)
					{
						
						var _subMenuStruct = _sub[1]
						
						var _indexSubMenu = extractParamInfo(_subObj,"index_sub_menu")
						_waActivatedItemWithSubMenu(_subObj,_config,_indexMenu,_indexSubMenu,_subMenuStruct)
					}
					else
					{
						_waActivatedSingleItem(_subObj,_indexMenu,_config)
					}
					
		
			}
			

		}

		for (var i=0;i<_menuStruct.length;i++)
		{
			var _sub = _menuStruct[i]
			if (_sub.length>0)
			{
				var _subObj = _subObjects[i];
				//
				_subObj.css({"width":_maxWidth})
			}

		}
		
		
		var _corner = _config.sub_corner
		_objMenu.css({"-webkit-border-radius":_corner,"-moz-border-radius":_corner,"border-radius":_corner})

		_objMenu.css({width:_maxWidth,height:_maxHeight})
		_objMenu.hide()	
	}
}

function _waActivatedSingleItem(_o,_config,_indexMenu)
{
	_o.hover(function(){
	//	alert('over')
			_waMenuHover(waJSQuery(this))
		},
		function(){

			_waMenuHout(waJSQuery(this))

		}
	)
}1
-->
