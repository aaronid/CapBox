<!--


waJSQuery.fn.outerScrollHeight = function(includeMargin) {
var element = this[0];
var jElement = waJSQuery(element);
var totalHeight = element.scrollHeight; //includes padding
//totalHeight += parseInt(jElement.css("border-top-width"), 10) + parseInt(jElement.css("border-bottom-width"), 10);
//if(includeMargin) totalHeight += parseInt(jElement.css("margin-top"), 10) + parseInt(jElement.css("margin-bottom"), 10);
totalHeight += jElement.outerHeight(includeMargin) - jElement.innerHeight();
return totalHeight;
};


waJSQuery(window).load(function () {
	initializeAllWA_dialog();
	
	/*
	var _cont = waJSQuery(".wa-fullscreen-contenair");
	_cont.click(function() {
	  alert("Handler for .click() called.");
	});
	*/
});


waJSQuery(window).resize(function() 
{
	WA_Dialog.resizeUI()
});

waJSQuery(window).scroll(function() 
{
	//centerFullPageContainer()
});


waJSQuery(window).keypress(function(e) {
	
	if (WA_Dialog._m_cur_win)
	{
		var _win=WA_Dialog._m_cur_win
		_win.onCustomKeypress(e.which)
	}
});

waJSQuery(window).keydown(function(e) {
	
	if (WA_Dialog._m_cur_win)
	{
		var _win=WA_Dialog._m_cur_win
		_win.onkeydown(e.which)
	}
});

function _waIsProtectedPage()
{
	var _pwd = WA_GetCookie("wa-js-password");
	
	var _protectDiv = waJSQuery("#is-password-form-layer")
	if (_protectDiv.length>0)
	{
		var _form = _protectDiv.find("FORM")
		var _inputPwd =  _form.find(".waInputPassword")
		if (MD5("#"+_pwd+"#") == extractParamInfo(_inputPwd,"crc"))
		{
			//alert("ok")
			return false;
		}

	}
	

	return true;
}

function _waCheckPassword()
{
	var _protectDiv = waJSQuery("#is-password-form-layer")
//	alert(_waIsProtectedPage())
	if (_waIsProtectedPage()==false)
	{
		
		//alert('_waCheckPassword')
		_protectDiv.hide()
		waJSQuery("#is-global-layer").show()
		
		initializeWA_JQuery()
		return true
	}
	else
	{
	
		var _form = _protectDiv.find("FORM")
		var _inputPwd =  _form.find(".waInputPassword")
		_inputPwd.focus()
	}
	return false
}

function initializeAllWA_dialog()
{
	
	if (document.wa_page_under_construction)
	{
		var w = new WA_Dialog(false);
		w._information(Translator.tr("Page Under construction")+"<br><a href='index.html'>index.html</a>")

	}
	
	
	
	if (_waCheckPassword()==false)
	{
		var _protectDiv = waJSQuery("#is-password-form-layer")
		if (_protectDiv.length>0)
		{
			_protectDiv.show()
			var _form = _protectDiv.find("FORM")
			_form.submit(function() 
			{
				var _inputPwd =  _form.find(".waInputPassword")
				_pwd = _inputPwd.val();
				WA_SetCookie("wa-js-password",_pwd);
				_waCheckPassword()
				return false;
			})
		}
	}
	

}


function createWaButton(_c)
{
	var _default = {
		x:0,y:0,
		position:"absolute",
		w:50,h:25,
		corner:4,
		shadow:false,
		label:"Texte",
		//href:"http://www.numento.com",
		fct:function(){alert('call function')},
		fct_obj:null,
		id:""}
		
	if (_c==undefined) _c = new Array();
	
	for (k in _default)
	{
		if (_c[k]==undefined) _c[k] = _default[k]
	}
	var _label = _c.label.replace(" ","&nbsp;")
	var _html = ""
	

	
	var _themeButtons = CONST_WA_GLOBAL_SETTINGS.theme.buttons
	var _bg1 = compliantColor(_themeButtons.bg)
	var _bg2 = compliantColor(_themeButtons.bg)
	var _colText = compliantColor(_themeButtons.text)
	var _border = compliantColor(_themeButtons.border)
	
	var _bg1_over = compliantColor(_themeButtons.bg_over)
	var _bg2_over = compliantColor(_themeButtons.bg_over)
	var _colText_over = compliantColor(_themeButtons.text_over)
	var _border_over = compliantColor(_themeButtons.border_over)
		
	var _hackOver="param[bord("+_border_over+") inner_bord() bg("+_bg1_over+" "+_bg2_over+") txt("+_colText_over+") bg_img() img() ]"
	

	
	var _hackGradient = "param[grad(0 0 0 "+_c.h+" "+_bg1+" "+_bg2+") bord("+_border+") inborder() ]"
//	alert(_hackGradient)  position:relative;z-index:1000012;
	_html += "<div id='"+_c.id+"' class=\"wa-button-link wa-js-action "+_hackOver+"\" style='position:"+_c.position+";z-index:1000012;width:"+_c.w+"px;height:"+_c.h+"px;left:"+_c.x+"px;top:"+_c.y+"px;'>";

	_html += "<button class=\"wa-button "+_hackGradient+"\" style=\"position:static;top:0px;left:0px;background-color:red;margin:0px;padding:0px;spacing:0px;width:"+(_c.w)+"px;height:"+(_c.h)+"px;-moz-border-radius:"+_c.corner+"px;border-radius:"+_c.corner+"px "+_c.corner+"px "+_c.corner+"px "+_c.corner+"px;";
	if (_c.shadow) _html += "-webkit-box-shadow: 1px 1px 12px #555;-moz-box-shadow: 1px 1px 12px #555;box-shadow: 1px 1px 12px #555;"
	_html += "border:1px solid "+_border+";";
	_html += "background:-webkit-gradient(linear,0 0, 0 "+_c.h+",from("+_bg1+"),to("+_bg2+"));background:-moz-linear-gradient(top left 270deg,"+_bg1+" 0px,"+_bg2+" "+_c.h+"px);text-align:center;color:"+_colText+";\" >"
	_html += "<div>";
//	alert(_colText)
	_html += "<a href='javascript:void(0)' class='wa-but-txt' style=\"position:relative;cursor:pointer;margin:0px;padding:0px;display:inline;vertical-align:middle;font-weight:normal;font-size:12px;color:"+_colText+";font-family:Arial;text-decoration:none;\">"+_label+"</a>"
	_html += "</div>";
	_html += "</button>"
	_html += "</div>"
/*
	_html += "<div  class=\"wa-button-link wa-comp param[bord(#032264) inner_bord(rgba(255,255,255,0.4)) bg(#032264 #043396) u(0) bg_img() img() ]\" style=\"position:relative;z-index:1000012;width:130px;height:30px;;text-decoration:none;\"><div class=\"waButInner\" style=\"position:absolute;left:1px;top:1px;padding:0px;margin:0px;width:126px;height:26px;border:1px solid rgba(255,255,255,0.4);-moz-border-radius:7px;border-radius:7px;-webkit-border-radius:7px;\" ></div>"
	_html += "<div class=\"waButGlossInner\" style=\"position:absolute;left:0px;top:0px;margin:0px;width:130px;height:15px;background:-webkit-gradient(linear,0 0, 0 15,from(rgba(255,255,255,0.5)),to(rgba(255,255,255,0.1)));background:-moz-linear-gradient(top left 270deg,rgba(255,255,255,0.5) 0px,rgba(255,255,255,0.1) 15px);-moz-border-radius:7px;border-radius:7px;-webkit-border-radius:7px;\" ></div>"
	_html += "<button class=\"wa-button param[grad(0 21 0 30 #006ffc #7bb5ff) aqua(1) border(#006ffc) inborder(rgba(255,255,255,0.4)) ]\" style=\"overflow: hidden; position:static;margin:0px;padding:0px;width:130px;height:30px;-moz-border-radius:7px;border-radius:7px;-webkit-border-radius:7px;border:1px solid #006ffc;background:-webkit-gradient(linear,0 21, 0 30,from(#006ffc),to(#7bb5ff));background:-moz-linear-gradient(top left 270deg,#006ffc 21px,#7bb5ff 30px);text-align:center;font-weight:normal;font-size:12px;color:#ffffff;font-family:'Arial';\" >"
	_html += "<div><a href=\"javascript:void(0)\" onclick=\"return false;\" class=\"wa-but-txt \" style=\"position:relative;margin:0px;padding:0px;display:inline;vertical-align:middle;font-weight:normal;font-size:12px;color:#ffffff;font-family:'Arial';text-decoration:none;\" >Texte</a></div></button>"
	_html += "</div>"
*/
	//alert(_html)
	return _html
}

function activateWaButton(_c)
{
	var _but=waJSQuery("#"+_c.id)
	if (_but.length==0)
	{
		//alert("but '"+_c.id+"' doesn't exists")
	}
	else
	{
	_but.click(function() {_c.fct.call(_c.fct_obj,_c.fct_params)})
	_but.css("cursor","pointer")
	}
	
}

function WA_Dialog(_b_close_button)
{
	this._width = 0;
	this._height = 0;
	
	this._max_win_width = 600;
	this._max_win_height = 400;
	this._min_win_height = 200;
	
	this._m_definition_buttons = new Array();
	
	this._PREFIXE_BUT_ID = "wa-dialog-but-";
	this._PREFIXE_BUT_DIV = this._PREFIXE_BUT_ID+"div-";

	this.BUTTON_HEIGHT = 22;

	this._b_close_button = _b_close_button;

	this._m_title =""
	
	this._marginContent = 16;
	
	
	this.size=function()
	{
		return new Size(this._width,this._height)
	
	}
	this.setTitle=function(_title)
	{
		this._m_title =_title
	
	}
	
	this.marginContent=function()
	{
		return this._marginContent;
	
	}
	this._constructorWA_Dialog=function()
	{
		if (this._b_close_button==undefined)this._b_close_button=true;
		this._initialize_buttons();	
	}	
	
	this.resetButtons=function()
	{
		this._initialize_buttons();	
	}

	this.idealHeight=function()
	{
		return this._idealHeight
	}	
	
	this.displayWindowWithAutoResize=function(_minHeight,_fctDisplay)
	{
		this._autoResize=false
		this._idealHeight=_minHeight
		this._fctDisplayWindow=_fctDisplay
		//
	
		this.resetButtons();
	//	alert("displayWindowWithAutoResize")
		_fctDisplay.call(this)
			
		var l = document.getElementById('wa-dialog-content');
		if (this._autoResize==false)
		if (l.scrollHeight>200)
		{
			this._autoResize=true
			this._idealHeight=l.scrollHeight+150
			this.resetButtons();	
			_fctDisplay.call(this)
		}
		
		waHackButtons()	
		waActivateOverButtons()
		
		
		waGlobalPatchIE()
	}	
	
	////////
	this.initializeWindow=function(_max_lx,_max_ly)
	{
		if (WA_Dialog._m_cur_win)WA_Dialog._m_cur_win.closeWin()
		WA_Dialog._m_cur_win = this;		

		this._max_win_width = _max_lx;
		this._max_win_height = _max_ly;	
		
		this._min_win_height = _max_ly	
		this._create_win()	
		
	
	}
	
	this.progress=function()
	{
		this.initializeWindow(300,130)


		this.writeContent("<div align=center style=''>"+htmlDynamicLoader(true)+"</div>")
		waActivateDynamicLoader(waJSQuery("#wa-dialog-content"),true)
	}
	
	
	this._information=function(mess)
	{
		//
		this.initializeWindow(450,130)
		var s =""
		s+="<table border=0 style='width:100%;'><tr>";
		s+="<td align=center>"
		s+=mess
		s+="</td></tr></table>"
		this.writeContent(s)
		
	}
	
	this.addButton=function(_label,_fct,_obj,_params)
	{
		//alert(_obj)
		var _index = this._m_definition_buttons.length

		var _lx =Math.max((_label.length*8)*1.2+30,80)
		var _size = new Size(_lx,this.BUTTON_HEIGHT);
		this._addInternalButton("action_"+_index,_index,_label,_fct,_size,_obj,_params)
	}
	
	this._initialize_buttons=function()
	{
		this._m_definition_buttons = new Array();
	}
	
	this._addInternalButton=function(_suffixe,_index,_label,_fct,_size,_obj,_params)
	{
		var _def = [_suffixe,_size,_index,_label,_fct,_obj,_params];
		this._m_definition_buttons.push(_def);
	}
	
	this.writeContent=function(s)
	{
		waJSQuery("#wa-dialog-content").html(s)
		this.adjustHeight()
//		this._max_win_height=waJSQuery("#wa-dialog-content").outerScrollHeight()+120;//+200
//		this._update()
	}	
	
	this.adjustHeight=function()
	{
		var _h = waJSQuery("#wa-dialog-content").outerScrollHeight()+120;
		
		
	//	var _nb_buttons = this._m_definition_buttons.length;
//alert(_nb_buttons+" "+_h+" "+waJSQuery("#wa-dialog-content").height())


		_h = Math.max(_h,150)
		this._max_win_height=_h;
		this._update()
	}	

	this._def_button=function(_suffixe)
	{	
		for (var _n=0;_n<this._m_definition_buttons.length;_n++)
		{
			var _def = this._m_definition_buttons[_n];
			//alert(_suffixe+"  : "+_def[0]+" "+_def[2])
			if ( (_def[0]==_suffixe) || (_def[2]+""==_suffixe+"") )
			return _def;
		}
		return undefined;
	}
	
	this._size_button=function(_suffixe)
	{
		var _def = this._def_button(_suffixe);
		return _def[1]
	}	


	this._get_div_button_config=function(_action)
	{
		var _def = this._def_button(_action);
		var _size = this._size_button(_action)
		var _c = {
			id:this._PREFIXE_BUT_DIV+_def[0],	
			fct:_def[4],
		//	fct_call:_def[4],
			fct_obj:_def[5],
			fct_params:_def[6],
			label:_def[3],
			w:_size.width(),
			h:_size.height()
		}
	//	alert(_c.id+" "+this+"  "+_def[4])
		//_c.fct = function () {this.fct_call.call(this.fct_obj)} //=function(){wa_evaluate(_def[4]+"()")}
		return _c;
	}
	
	this._create_div_button=function(_action)
	{
		return createWaButton(this._get_div_button_config(_action));
	}
	
	this._activate_div_button=function(_action)
	{
		return activateWaButton(this._get_div_button_config(_action));
	}

	this._get_button_div=function(_suffixe)
	{
		var _def = this._def_button(_suffixe)
		if (_def)
		{
			var _key = this._PREFIXE_BUT_DIV+_def[0];
			return waJSQuery("#"+_key)	
		}
		return undefined

	}	
			
	this._create_win=function()
	{	
		var l = waJSQuery('#wa-dialog-container');
		//l.touchwipe()
		l.show()
		//
		var s="";
		
		s+="<div class='wa-dialog-container-bg' style='position:absolute;left:0px;top:0px;' ></div>"
		
		var _yBgWin=document.webaca_banner_height
		s+="<div id='wa-dialog-main' style='position:absolute;left:0px;top:"+_yBgWin+"px;' >"
		s+="<div style='position:absolute;left:0px;top:0px;width:100px;height:100px;' ></div>"
		
		for  (var _i in this._m_definition_buttons)
		{
			s+=this._create_div_button(this._m_definition_buttons[_i][2]);
		}	
		//close button	
		if (this._b_close_button)
		{
			s+="<div id='wa-dialog-bt-close' class='wa-bt-close-style'>X</div>"
	
		}
		
		s+="<div id='wa-dialog-title' style='position:absolute;left:0px;top:0px;"
//		s+="background-color:#00ff00;;"
		s+=";' ></div>"

		
		s+="<div id='wa-dialog-content' style='position:absolute;left:0px;top:0px;"
		//s+="background-color:rgba(0,0,0,0.5);"
		if (isMSIE_lower_than_ie9()==false)
		{
			s+="overflow:auto;"
		}
		
		s+="' ></div>"
		s+="</div>"



		l.html(s);
	
		for  (var _i in this._m_definition_buttons)
		{
			this._activate_div_button(this._m_definition_buttons[_i][2]);
		}
		
		/////

		var _dlg = this;
		WA_exec_callback_opera_compliant(this,this._firstUpdate)
		
		var _contBg = l.find(".wa-dialog-container-bg")
		_contBg.click( function() {
			_dlg.closeWin()
			});
			
			/*
			var _cont = waJSQuery(".wa-fullscreen-contenair");

			_cont.click( function() {
				//_dlg.closeWin()
				});
				*/
		waSetVisibilityMainPageContenair(false)
	}
	
	this._firstUpdate=function()
	{
		this._initialScrollY = waJSQuery(window).scrollTop()
		//alert("init "+this._initialScrollY )
		this._update()
		
		var _dlg = this;
		var _close = waJSQuery("#wa-dialog-bt-close")
		_close.html("<a id='wa-dialog-bt-close-inner' style='position: absolute; text-align: center; left: 24px; top: -16px; background: url(&quot;wa_closecross.png&quot;) no-repeat;width: 35px;height:35px;'></a>");
		_close.click(function(){
			_dlg.closeWin()
			return false;
		})
		
		/*_close.hover(function(){
			//alert('act close')
			waJSQuery(this).toggleClass("wa-bt-close-style-hover")
			return false;
		})*/
		
		/*
		if (isAppleMobile())
		{
			//alert('_firstUpdate')
			document.body.scrollLeft = 0
			document.body.scrollTop = 0
		}
		*/
		
		//pour panier
			waHackButtons()
			waActivateOverButtons()
	}	
	
	this.intern_closeWin=function()
	{
		waJSQuery("#wa-dialog-container").hide()
		waJSQuery("#wa-dialog-container").empty()
		WA_Dialog._m_cur_win = false
		waSetVisibilityMainPageContenair(true)
	}
		
	this.closeWin=function()
	{
		if (this._b_close_button!=true) return
		this.intern_closeWin()
	}

	this.onCustomKeypress=function(_k)
	{
		if ((this._m_definition_buttons.length==1)&&(_k==13))
		{
				this.closeWin()
				return true;	
		}
		return false;		
	}	
	
	this.onkeypress=function(_k)
	{
		return this.onCustomKeypress(_k)
	}
		
	this.onkeydown=function(_k)
	{

		if (_k==27)
		{
			if (this._b_close_button)
			{
				this.closeWin()
				return true;
			}

		}
		
		return this.onCustomKeypress(_k)
		//return false;
	
	}
	
	this.customUpdate = function(){}
	

	this._update=function()
	{
		
		//alert('_update')
		var _title = waJSQuery("#wa-dialog-title")
		
		
		_title.html("<div id='wa-dialog-title-inner' style='position:absolute;'>"+this._m_title+"</div>")
		

			
		var _lx_page=document.webaca_width_page;
		var _ly_page=document.webaca_height_page;
		
		var _lx_window=getDocumentSize().width()
		var _ly_window=getDocumentSize().height()

		var _lx_full_client = getWindowSize().width()
		var _ly_full_client = getWindowSize().height()
		
		
		
		//alert(waJSQuery(window).scrollTop())
	
	//	waJSQuery(window).scrollTop()

		var _minWidthWindow = 550;
		var _minHeightWindow = 400;
		
		_lx_window = Math.max(_lx_window,_minWidthWindow);
		_ly_window = Math.max(_ly_window,_minHeightWindow);
/****
		if (isAppleMobile())
		{
			_lx_window = 600;
			_ly_window = 700;
		
		}
*/
		this._width = Math.min(_lx_window*0.9,this._max_win_width)
//this._height = Math.min(_ly_window*0.9,this._max_win_height)
	this._height = Math.max(this._min_win_height,this._max_win_height)

		var _x = waJSQuery(window).scrollTop() +(_lx_window-this._width)/2
	//	var _y = waJSQuery(window).scrollLeft() +(_ly_window-this._height)/2
	var _y = waJSQuery(window).scrollLeft() +(_ly_window-this._height)/2

		_x = (_lx_window-this._width)/2
		_y = (_ly_window-this._height)/2
		
		_x = Math.max(0,_x)
		_y = Math.max(0,_y)	
			/******
		if (isAppleMobile())
		{		
			_x = 0
			_y = 0;
		}
		*/

		var _main = waJSQuery('#wa-dialog-main')
		
		_main.css({left:_x,top:_y,width:this._width,height:this._height})

		var _marginContent = this._marginContent;

		/////buttons

		//
		var _nb_buttons = this._m_definition_buttons.length;
		
		
		//alert(_nb_buttons)
		var _space_buttons = 10;
		var _lx_all_button = 0;
		for (var _i = 0;_i < _nb_buttons;_i++)
		{
			if (_i>0) _lx_all_button += _space_buttons;
			var _size_but = this._size_button(_i);
			_lx_all_button += _size_but.width();
		}
		var _x_button = (this._width - _lx_all_button)/2
		for (var _i = 0;_i < _nb_buttons;_i++)
		{
			if (_i>0) _x_button += _space_buttons;
			var _but_div= this._get_button_div(_i);
			var _size_but = this._size_button(_i);
			//alert(_size_but)
			_but_div.css({left:_x_button,top:this._height-_size_but.height()-2*_marginContent})
			_x_button += _size_but.width();
		}
		///	
		
		var _ly_top = 47;
		var _ly_bottom = this.BUTTON_HEIGHT + 2*_marginContent;
		if (_nb_buttons ==0)
		{
			_ly_bottom = 0;
		}
		
		var _ly_content = (this._height-_ly_top-_ly_bottom) - _marginContent

		
		var _content = waJSQuery("#wa-dialog-content")
		var _w_content = Math.round(this._width - 2*_marginContent)
		var _h_content = Math.round(_ly_content)


		this.m_content_lx=_w_content
		this.m_content_ly=_h_content
		_content.css({left:Math.round(( this._width - _w_content )/2) ,top:Math.round(_ly_top + ( _ly_content-_h_content )/2 ), width:_w_content , height:_h_content})

		//title
	
		_title.css({left:_marginContent,top:0, width:_w_content , height:_ly_top})
		
			var _titleInner = waJSQuery("#wa-dialog-title-inner")
			var _yTitle = (_title.height()-_titleInner.height())/2;
			_titleInner.css("top",_yTitle)
			
		//close
		var _dlg = this;
		var _close = waJSQuery("#wa-dialog-bt-close")
		/*
		_close.click(function(){
			_dlg.closeWin()
			return false;
		})
		
		_close.hover(function(){
			//alert('act close')
			waJSQuery(this).toggleClass("wa-bt-close-style-hover")
			return false;
		})
		_close.html("<div id='wa-dialog-bt-close-inner' style='position:absolute;text-align:center'>X</div>")
		*/
		
		var _closeInner = waJSQuery("#wa-dialog-bt-close-inner")
		//_closeInner.css({left:(_close.width()-_closeInner.width())/2,top:(_close.height()-_closeInner.height())/2})
		_close.css({top:0,left:this._width-_close.width(),cursor:"pointer"})
	
		this.customUpdate()
		//
		
		
		
		
		
		
		//container
		var _cont = waJSQuery("#wa-dialog-container")
		
		
	//	window.status = "_lx_page="+_lx_page+"  xDec="+xDec+"  "+waJSQuery(window).width()+  "   "+waJSQuery(document).width()
		centerFullPageContainer() ;
		
	
	}	
	
	////////constructor
	this._constructorWA_Dialog();
	
			
}


//////



//
WA_Dialog.getCurrent = function()
{
	return WA_Dialog._m_cur_win;
}

WA_Dialog._m_cur_win = false;

WA_Dialog.resizeUI = function()
{
	
	if (WA_Dialog._m_cur_win)
	{
		var _win=WA_Dialog._m_cur_win
		if (isAppleMobile()==false)
		{
			_win._update()
		}
		
	}
	
}

WA_Dialog.alert = function(s)
{
	var w = new WA_Dialog();
	w.setTitle(Translator.tr("Information"))
	w._information(s)
	
}

WA_Dialog.progress = function()
{
	var w = new WA_Dialog(false);
	w.progress()
}

function centerFullPageContainer() 
{
	/*
	var _win = WA_Dialog.getCurrent()
	var _dialog = waJSQuery("#wa-dialog-main")
	//alert(_dialog.length+"  "+_win)
	if ((_dialog.length>0)&&(_win!=false))
	{
		var _cont = waJSQuery('#wa-dialog-container');

		var _contBg = _cont.find(".wa-dialog-container-bg");//waJSQuery('#wa-dialog-container');
		//alert(_contBg.length)
		_contBg.css({"left":0,"top":0 ,"width":getDocumentSize().width(), "height":getDocumentSize().height() })
		// 

		if (isMSIE_lower_than_ie9())
		{
			_cont.css({backgroundColor:"#555555"})
		}
		_cont.show()
	}
	
*/
	

var _lx_page=document.webaca_width_page;
var _ly_page=document.webaca_height_page;	

var _cont = waJSQuery('#wa-dialog-container');
// wa-dialog-container-bg
var _lx_full_client = waJSQuery(window).width()
var _ly_full_client = waJSQuery(window).height()

var _y_bg = waJSQuery(window).scrollTop();


	var _win = WA_Dialog.getCurrent()
var _bIphoneMode = _win && isAppleMobile();
if (_bIphoneMode)
{
//	_y_bg=0
}


var _xBg = 0;

var _dialog = waJSQuery("#wa-dialog-main")
//alert(_dialog.length+"  "+_win)
if ((_dialog.length>0)&&(_win!=false))
{
	var _xDialog = 0;
	var _yDialog = 0;

	if (_dialog.width() <= waJSQuery(window).width())	
	{
		_xDialog = (waJSQuery(window).width() - _dialog.width())/2+waJSQuery(window).scrollLeft()
	}
	else
	{
		var xDialogCenter = (_lx_page - _dialog.width())/2
		_xDialog = xDialogCenter
		var x0 = xDialogCenter + _dialog.width()/2 -waJSQuery(window).width()
		if (waJSQuery(window).scrollLeft() > x0+_dialog.width()/2)
		{
			var _diff = waJSQuery(window).scrollLeft()-x0 
			_xDialog+=_diff-_dialog.width()/2
		}
		if (waJSQuery(window).scrollLeft() <xDialogCenter)
		{
			var _diff = xDialogCenter - waJSQuery(window).scrollLeft() 
			_xDialog-=_diff
		}
	}

	////

	if (_dialog.height() <= waJSQuery(window).height())	
	{
		_yDialog = (waJSQuery(window).height() - _dialog.height())/2+waJSQuery(window).scrollTop()
	}
	else
	{
		var yDialogCenter = (_ly_page - _dialog.height())/2
		_yDialog = yDialogCenter

		var y0 = yDialogCenter + _dialog.height()/2 - waJSQuery(window).height()

		if (waJSQuery(window).scrollTop() > y0 + _dialog.height()/2)
		{
			var _diff = waJSQuery(window).scrollTop()-y0 
			_yDialog+=_diff-_dialog.height()/2
		}

		if (waJSQuery(window).scrollTop() <yDialogCenter)
		{
			var _diff = yDialogCenter - waJSQuery(window).scrollTop() 
			_yDialog-=_diff
		}
		
		//////
		_yDialog = _win._initialScrollY
		_yDialog = Math.min(_yDialog,waJSQuery(window).scrollTop())
		
		var _y2 = (waJSQuery(window).scrollTop()+waJSQuery(window).height())-_dialog.height()
		_yDialog = Math.max(_yDialog,_y2)
		_yDialog +=10
	}
	////////
	
	//alert(_win._initialScrollY)
//	alert(isAppleMobile() +"  "+isAndroidMobile())
	
//	if (isMobileBrowser()==false)
	{
		_dialog.css({left:_xDialog,top:_yDialog})	
	}
	//_dialog.css({left:_xDialog,top:_yDialog})	
}


var _widthBg = waJSQuery(window).width();
var _heightBg = waJSQuery(window).height();

if (_widthBg<_lx_page)
{
	_widthBg= waJSQuery(document).width();
}

if (_heightBg<_ly_page)
{
	_heightBg= waJSQuery(document).height();
}

//alert(_widthBg+" "+_heightBg)
if ((_dialog.length>0)&&(_win!=false))
{
	_cont.css({left:0,top:0 ,width:_widthBg, height:_heightBg })

	var _contBg = _cont.find(".wa-dialog-container-bg");
	
	
	//alert(CONST_WA_GLOBAL_SETTINGS.overlayColor)
	
	//alert(_contBg.length)
	_contBg.css({left:0,top:0 ,width:_widthBg, height:_heightBg })
	// 
	var _colBg = new RGBColor(CONST_WA_GLOBAL_SETTINGS.overlayColor)
	_contBg.css({"backgroundColor":_colBg.toHexaOpaqueColor(),"opacity":_colBg.a})


	_cont.show()
}



}



-->
