<!--

//waJSQuery.noConflict()
waJSQuery(function() {

/*
	if (waJSQuery().waJSQuery!='1.7.1') 
	{
	WA_loadScript("waJSQuery.js?v=86c",function(){
	*/	

		waJSQuery.fn.extend({ 
		        disableSelection : function() { 
		                this.each(function() { 
		                        this.onselectstart = function() { return false; }; 
		                        this.unselectable = "on"; 
		                        waJSQuery(this).css('-moz-user-select', 'none'); 
		                        waJSQuery(this).css('-webkit-user-select', 'none'); 
		                }); 
		        } 
		});

		waJSQuery.fn.extend({ everyTime: function(interval, label, fn, times, belay) { return this.each(function() { waJSQuery.timer.add(this, interval, label, fn, times, belay); }); }, oneTime: function(interval, label, fn) { return this.each(function() { waJSQuery.timer.add(this, interval, label, fn, 1); }); }, stopTime: function(label, fn) { return this.each(function() { waJSQuery.timer.remove(this, label, fn); }); } }); waJSQuery.extend({ timer: { guid: 1, global: {}, regex: /^([0-9]+)\s*(.*s)?$/, powers: { /* Yeah this is major overkill... */'ms': 1, 'cs': 10, 'ds': 100, 's': 1000, 'das': 10000, 'hs': 100000, 'ks': 1000000 }, timeParse: function(value) { if (value == undefined || value == null) return null; var result = this.regex.exec(waJSQuery.trim(value.toString())); if (result[2]) { var num = parseInt(result[1], 10); var mult = this.powers[result[2]] || 1; return num * mult; } else { return value; } }, add: function(element, interval, label, fn, times, belay) { var counter = 0; if (waJSQuery.isFunction(label)) { if (!times) times = fn; fn = label; label = interval; } interval = waJSQuery.timer.timeParse(interval); if (typeof interval != 'number' || isNaN(interval) || interval <= 0) return; if (times && times.constructor != Number) { belay = !!times; times = 0; } times = times || 0; belay = belay || false; if (!element.$timers) element.$timers = {}; if (!element.$timers[label]) element.$timers[label] = {}; fn.$timerID = fn.$timerID || this.guid++; var handler = function() { if (belay && this.inProgress) return; this.inProgress = true; if ((++counter > times && times !== 0) || fn.call(element, counter) === false) waJSQuery.timer.remove(element, label, fn); this.inProgress = false; }; handler.$timerID = fn.$timerID; if (!element.$timers[label][fn.$timerID]) element.$timers[label][fn.$timerID] = window.setInterval(handler,interval); if ( !this.global[label] ) this.global[label] = []; this.global[label].push( element ); }, remove: function(element, label, fn) { var timers = element.$timers, ret; if ( timers ) { if (!label) { for ( label in timers ) this.remove(element, label, fn); } else if ( timers[label] ) { if ( fn ) { if ( fn.$timerID ) { window.clearInterval(timers[label][fn.$timerID]); delete timers[label][fn.$timerID]; } } else { for ( var fn in timers[label] ) { window.clearInterval(timers[label][fn]); delete timers[label][fn]; } } for ( ret in timers[label] ) break; if ( !ret ) { ret = null; delete timers[label]; } } for ( ret in timers ) break; if ( !ret ) element.$timers = null; } } } }); if (waJSQuery.browser.msie) waJSQuery(window).one("unload", function() { var global = waJSQuery.timer.global; for ( var label in global ) { var els = global[label], i = els.length; while ( --i ) waJSQuery.timer.remove(els[i], label); } });
		
		if (document.internalPreview!=true)
		{
			waJSQuery(".wa-market-link").each(function() 
			{
				var _lnk = waJSQuery(this);
				_lnk.css("cursor","pointer")
				//alert(_lnk)
				_lnk.click(function() 
				{
					javascript:WA_showMarketCart()
					////
				});
			});
		}
	//	alert(waJSQuery().waJSQuery)

});


/*******************/
/*    DIVERS      */
/*******************/

function waParseCleanStringJSON(s)
{
	var _sep1 = "{"
	var _sep2 = "}"
	
	var _result=""
	var c;
	for (var i=0;i<s.length;i++)
	{
		c = s.charAt(i)
		if (c=="\"")
		{
			do
			{
				i++;
				c = s.charAt(i)
			}
			while (c!="\"")
		}
		if (c==_sep1)
		{
			var _countBracket = 0;
			var _bOk = true;
			var _isInString = false;
			do
			{
				_bOk = true;
				i++;
				c = s.charAt(i)
				if ((_isInString==false)&&(c=="\""))
				{
					_isInString = true;
				}
				else
				if ((_isInString==true)&&(c=="\""))
				{
					_isInString = false;
				}

				if (_isInString==false)
				{
					if (c==_sep1)
					{
						_countBracket++;
					}	
					if ((c!=_sep2)||(_countBracket!=0))
					{
						_result+=c;
					}

					if (_countBracket>0)
					if (c==_sep2)
					{
						_countBracket--;
						_bOk = false
					}
				}
				else
				{
					_result+=c;
				}



			}
			while ((_bOk==false)||(c!=_sep2)||(_countBracket!=0))
			break;
		}
	}
	
	_result = _sep1+_result+_sep2

//alert(_result)
	try { 
		return waJSQuery.parseJSON( _result );
	} 
	catch( e ) {
	}
	return null;	
}


function waLoadGoogleFonts()
{
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
}


var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();


function RGBColor(_color_string)
{
    this.ok = false;this.a = 1.0;
    if (_color_string.charAt(0) == '#') { _color_string = _color_string.substr(1);}
    _color_string = _color_string.replace(/ /g,'');
    _color_string = _color_string.toLowerCase();
    var _color_defs = [
        {re: /^rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*(\d{1,2}\.*\d{0,2})\)$/,_process: function (bits){return [ parseInt(bits[1]),parseInt(bits[2]),parseInt(bits[3]),parseFloat(""+bits[4]) ]; }},
        {re: /^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/,_process: function (bits){ return [ parseInt(bits[1]),parseInt(bits[2]),parseInt(bits[3])];}},
        {re: /^(\w{2})(\w{2})(\w{2})(\w{2})$/,_process: function (bits){return [ parseInt(bits[1], 16),parseInt(bits[2], 16),parseInt(bits[3], 16),Math.round(parseInt(bits[4],16)*100/255)/100 ];}},
        {re: /^(\w{2})(\w{2})(\w{2})$/,_process: function (bits){return [ parseInt(bits[1], 16),parseInt(bits[2], 16),parseInt(bits[3], 16) ];}}
    ];

    // search through the definitions to find a match
    for (var i = 0; i < _color_defs.length; i++) {
        var _re = _color_defs[i].re;
        var _processor = _color_defs[i]._process;
	//
        var _bits = _re.exec(_color_string);
        if (_bits) {

            var _channels = _processor(_bits);
            this.r = _channels[0];this.g = _channels[1];this.b = _channels[2];this.a = _channels[3];
            this.ok = true;
        }
    }
    this.r = (this.r < 0 || isNaN(this.r)) ? 0 : ((this.r > 255) ? 255 : this.r);
    this.g = (this.g < 0 || isNaN(this.g)) ? 0 : ((this.g > 255) ? 255 : this.g);
    this.b = (this.b < 0 || isNaN(this.b)) ? 0 : ((this.b > 255) ? 255 : this.b);
	this.a = (this.a > 1 || isNaN(this.a)) ? 1 : ((this.a < 0) ? 0 : this.a);
    this.toRGB = function () 
	{
		if (this.a==1)return 'rgb(' + this.r + ', ' + this.g + ', ' + this.b + ')';
		return 'rgba(' + this.r + ', ' + this.g + ', ' + this.b + ','+this.a+')';
    }
	
    this.toRGB_opaque = function () 
	{
		return 'rgb(' + this.r + ', ' + this.g + ', ' + this.b + ')';
    }
    this._formatTo2Digit = function (_s) 
	{
		if (_s.length==1)_s="0"+_s
		return _s
	}
    this.toHexaOpaqueColor = function () 
	{
		/*
	  	var _decColor = this.r + 256 * this.g + 65536 * this.b;
	    return _decColor.toString(16);
	*/
	return  "#"+this._formatTo2Digit(this.r.toString(16))+this._formatTo2Digit(this.g.toString(16))+this._formatTo2Digit(this.b.toString(16));
    }
}

function compliantColor(_rgba)
{
	if (isMSIE_lower_than_ie9())
	{
		if (_rgba=="") return "";
		if (_rgba=="transparent") return "";
		var _col = new RGBColor(_rgba)
		
		if (_col.a==0) return ""
		
		return _col.toHexaOpaqueColor();
	}
	return _rgba;
}

//alert(compliantColor("rgba(255,0,0,0.5)"))




function isProbablyRobot()
{
	return BrowserDetect.browser.length==0
	
}


function isMSIE()
{
	return BrowserDetect.browser=="Explorer"
	
}
function isFirefox()
{
	return BrowserDetect.browser=="Firefox"
	
//	return true;//BrowserDetect.browser=="Explorer"
}

function isChrome()
{
	return BrowserDetect.browser=="Chrome"
}


function isWindowsOS()
{
	if (BrowserDetect.OS.match(/windows/i)) return true; 
	return false;
}



function isMSIE8()
{
	if ((BrowserDetect.browser=="Explorer") && (BrowserDetect.version==8))
	{
		return true;
	}
	return false;
}

function isMSIE_lower_than_ie9()
{
	if (isMSIE())
	{
		
		if (document.documentMode) 
		{
			if (document.documentMode>=9)
			{
				return false;
			}	
		}
		
		return true;

	}
	return false;
}

function isMSIE_higher_than_ie8()
{
	if (isMSIE())
	{
		
		if (document.documentMode) 
		{
			if (document.documentMode>=9)
			{
				return true;
			}	
		}
		
		return false;

	}
	return false;
}
function isWebKit()
{
	if (navigator.userAgent.match(/webkit/i)) return true;
	return false;
}

function isAndroidMobile()
{
	if (navigator.userAgent.match(/android/i)) return true;
	return false;
}


function isMobileBrowser()
{
	if (navigator.userAgent.match(/(zunewp7|android|iphone|blackberry|symbian|symbianos|symbos|netfront|model-orange|javaplatform|iemobile|windows phone|samsung|htc|opera mobile|opera mobi|opera mini|presto|huawei|blazer|bolt|doris|fennec|gobrowser|iris|maemo browser|mib|cldc|minimo|semc-browser|skyfire|teashark|teleca|uzard|uzardweb|meego|nokia|bb10|playbook)/gi)) 
	{
	    return true;
	} 
	return false;
	//return isAppleMobile() || isAndroidMobile();
}

function isChrome()
{
	if ( navigator.userAgent.match(/Chrome/i) )
	return true;
	return false;
}

function isWindowsMobile()
{
	if (isMobileBrowser())
	{
		if (isMSIE())
		{
			return true;
		}
	}
	return false;
}

function isAppleMobile()
{
	return isIPhone() || isIPad()
}

function isIPad()
{
	if ( navigator.userAgent.match(/iPad/i))
	return true;
	return false;
}

function isIPhone()
{
	if ( navigator.userAgent.match(/iPhone/i)  || navigator.userAgent.match(/iPod/i) )
	return true;
	return false;
}


function extractNum(st)
{
	var len  = st.length
	if ((len>0)&&(st.substring(len-2,len)=="px"))
	{
		return wa_evaluate(st.substring(0,len-2))
	}
	return 0;
}

function waJSONLinkToHref(_lnk)
{
	var _s=""
	var _url=_lnk.url
	var _lng=Translator.m_lang_for_filename
	if (_lng.length>0)_lng="_"+_lng
	_url = _url.replace(/@lng@/g,_lng)

	var _js = _lnk.js
	if (_js==undefined)_js = ""
	
	
	_s+="href=\""+_url+"\" "
	if (_lnk.open==1)
	{
		_s+="target="
		_s+="_blank "
	}
	
	if (_js.length>0)
	{
		_s += "onclick=waLaunchFunction(function(){"+_js+"}) "
	}
	return _s;
}


function waJSONLinkToOnClick(_lnk)
{
	var _s=""
	var _url=_lnk.url
	var _lng=Translator.m_lang_for_filename
	if (_lng.length>0)_lng="_"+_lng
	_url = _url.replace(/@lng@/g,_lng)
	var _target = "";
	if (_lnk.open==1)
	{
		_target="_blank"
	}
	var _js = _lnk.js
	if (_js==undefined)_js = ""
	
	_js = _js.replace(/\"/g,"&quot;")
	
	_s+="onclick=\"waOnClick('"+_url+"',{'targ':'"+_target+"'";
	
	if (_js.length>0)
	{
		_s += ",'js':function(){"+_js+"}"
	}
	
	_s+="});return false;\" "

	return _s;
}

function waLaunchFunction(_fct)
{
	_fct()
}

function waOnClick(_url,_par)
{
	if (_par.js!=undefined)
	{
		//launch js
		try
		{
			_par.js()
		}
		catch(e)
		{
			alert('ERROR: javascript link '+_par.js)
		}
		
	}
	
	if ((_url==undefined)||(_url.length==0)) return;
//	alert(_par.js)
	var _target=_par.targ;
	if (_target && _target.length>0)
	{
		if ((_target.length>0)&&(_target!="_blank"))
		{
			window.frames[_target].location.href = (_url)
		}
		else
		{
			window.open(_url,_target)
		}
	}
	else
	{
		window.location.href = (_url)
	}
	return false;	
}
/********************************/
/********** DIV UTILS ***********/
/********************************/


function waActivateDynamicLoader(_parent,_autoResize)
{
	
	var _loader = _parent.find(".wa-dyn-loader")
	if (_loader.data('timer_animation_initialized')==true)
	{
		return;
	}
	_loader.data('timer_animation_initialized',true)
	//alert(_parent.length)
	if (_autoResize)
	{
		_loader.css({"width":_parent.width(),"height":_parent.height()})
	}
	
	var _delay = 65
	var _delayMaxImg = 500;
	var _img = _loader.children("img")
	

	_loader.everyTime(_delay,function(i) 
	{
		var _delayImage= waJSQuery(this).data("anim_delay_img")
		if (_delayImage==undefined)_delayImage = _delay;
		if (_delayImage>=_delayMaxImg)
		{
			_img.show()
		}
		
		var _frm = _loader.data("anim_frm")
		if (_frm==undefined)_frm = 0;
		
		var _size = 40
		var _xImg = 0;
		var _yImg = _frm*_size
		var _xImg2 = _xImg+_size;
		var _yImg2 = _yImg+_size;;
		var _decX = (waJSQuery(this).width()-_size)/2
		var _decY = (waJSQuery(this).height()-_size)/2
		
		
		_img.css({"left":_decX,"top":-_yImg+_decY})
		
		
		_img.css({"clip":"rect("+_yImg+"px,"+_xImg2+"px,"+_yImg2+"px,"+_xImg+"px)"})
		_frm = (_frm+1)%12
		waJSQuery(this).data("anim_frm",_frm)
		_delayImage+=_delay
		waJSQuery(this).data("anim_delay_img",_delayImage)

	});


}

function htmlDynamicLoader(_absolute,_width,_height)
{

	var _s = ""
	_s += "<div class='wa-dyn-loader' style=\"";
	if (_absolute)
	{
		_s += "position:absolute;left:0px;top:0px;"
	}
	else
	{
		_s += "position:relative;left:0px;top:0px;"
	}
	_s += "width:"+_width+"px;height:"+_height+"px;"
	_s += "overflow:hidden;"
	
	
//	_s += "border:1px solid red;"
	var n = 0
	var _size = 40
	var _xImg = 0;
	var _yImg = n*_size
	var _xImg2 = _xImg+_size;
	var _yImg2 = _yImg+_size;;
	
//	_s += "width:"+_size+"px;height:"+_size+"px;text-align:center;\">"
	_s += ";\">"
	_s += "<img style=\"position:absolute;border:none;left:0px;top:0px;";
	//_s += "width:"+_size+"px;height:"+_size+"px;"
	_s += "display:none;"
	_s += "clip:rect("+_yImg+"px,"+_xImg2+"px,"+_yImg2+"px,"+_xImg+"px);"
	_s += "\" ";
	_s += "src=\"wa_loading.png\" />"
	_s += "</div>"
	return _s;
}




function Size(lx,ly)
{
	this._width = lx;this._height = ly;
	this.width = function(){return this._width}
	this.height = function(){return this._height}
	
	this.clone = function(){return new Size(this._width,this._height)}
	
	this.greaterThan = function(_s){if ( _s==undefined) return null; return (this._width>_s._width)&&(this._height>_s._height)}
	
	this.toString=function()
	{
		return this.width()+"x"+this.height()
	}
	
	this.scale=function(_max,_canIncrease)
	{
		if (!_canIncrease)_canIncrease=false
		var _size = this;
		var _lx0=_size.width()
		var _ly0=_size.height()
		var p1 = _lx0 * _max.height();
		var p2 = _max.width() * _ly0;
		var r1 = _lx0 / _ly0;
		var r2 = _ly0 / _lx0;
		var newSize1 = new Size(_max.height() * r1,_max.height());
		var newSize2 = new Size(_max.width(),_max.width() * r2);	
		if (p2 > p1)
		{
			if ((_canIncrease==true)||((newSize1.width()<=_size.width())&&(newSize1.height()<=_size.height())))
			{
				_size._width= Math.round(newSize1.width());
				_size._height= Math.round(newSize1.height());				
			}
		}
		else
		{
			if ((_canIncrease==true)||((newSize2.width()<=_size.width())&&(newSize2.height()<=_size.height())))
			{
				_size._width= Math.round(newSize2.width());
				_size._height= Math.round(newSize2.height());				
			}
		}
		this._width=_size.width();
		this._height=_size.height();
		
		return true;
	}
	this.scaleByExpanding=function(_max)
	{

		var _size = this;
		var _lx0=_size.width()
		var _ly0=_size.height()
		
		var p1 = _lx0 * _max.height();
		var p2 = _max.width() * _ly0;
		var r1 = _lx0 / _ly0;
		var r2 = _ly0 / _lx0;
		var newSize1 = new Size(_max.height() * r1,_max.height());
		var newSize2 = new Size(_max.width(),_max.width() * r2);
		
		
		
		
		if (p2 < p1)
		{
			if ((newSize1.width()<=_size.width())&&(newSize1.height()<=_size.height()))
			{
				_size._width= Math.round(newSize1.width());
				_size._height= Math.round(newSize1.height());				
			}
		}
		else
		{
			if ((newSize2.width()<=_size.width())&&(newSize2.height()<=_size.height()))
			{
				_size._width= Math.round(newSize2.width());
				_size._height= Math.round(newSize2.height());				
			}
		}
		
		this._width=_size.width();
		this._height=_size.height();
		
		return true;
	}
}


function Point(p_x,p_y){this.x = p_x;this.y = p_y;
	this.translate = function(_x,_y){this.x+=_x;this.y+=_y;}
	this.clone = function(){return new Point(this.x,this.y)}
	}
	
function Rect(p_x,p_y,lx,ly)
{
	this.x = p_x;this.y = p_y;this.width = lx;this.height = ly;
	this.clone = function(){return new Rect(this.x,this.y,this.width,this.height)}
	this.equals = function(_o){return (this.x==_o.x)&&(this.y==_o.y)&&(this.width==_o.width)&&(this.height==_o.height);}
	this.copy = function(_o){this.x=_o.x;this.y=_o.y;this.width=_o.width;this.height=_o.height;}
	this.translate = function(_x,_y){this.x+=_x;this.y+=_y;}
	this.isValid = function(){ return (this.width>0)&&(this.height>0);}
}



var _m_table_accent = [		
								{acc:"e", l:["é","è","ë"]}, 
								{acc:"a", l:["à","ä","â","ã"]}, 
								{acc:"u", l:["ü","û"]}, 
								{acc:"c", l:["ç"]}, 
								{acc:"o", l:["ö","ô"]}
								];
								
function removeAccentsFromString(s)
{
	var res = s.toLowerCase();
    for(var i=0;i<_m_table_accent.length;i++) 
	{ 
		var array2 = _m_table_accent[i].l;
   	 	for(var i2=0;i2<array2.length;i2++) 
		{   
			var reg=new RegExp(array2[i2], "g");
			res=res.replace(reg,_m_table_accent[i].acc)
		}			
	}	                         
	return res;	
}

function IsNumeric(_sText)
{
   var _ValidChars = "0123456789.";var _IsNumber=true;var _Char;
   for (_i = 0; _i < _sText.length && _IsNumber == true; _i++){ _Char = _sText.charAt(_i);if (_ValidChars.indexOf(_Char) == -1) _IsNumber = false;}
   return _IsNumber;
}

function getDocumentSize() 
{
	return new Size(waJSQuery(document).width(),waJSQuery(document).height());
}

function getWindowSize() 
{
	
	if (isAppleMobile())
	{
		return new Size(window.innerWidth,window.innerHeight);
	}
	
	return new Size(waJSQuery(window).width(),waJSQuery(window).height());
}


function urlSuffixe(_delay_minuts)
{
	var _freeCacheSecondeDelay = _delay_minuts * 60;
	var _now_date = new Date();
	var _sec = 0;
	_sec+=_now_date.getYear()  *  12 * 31 * 24 * 60 * 60;
	_sec+=_now_date.getMonth()  * 31 * 24 * 60 * 60;
	_sec+=_now_date.getDate() * 24 * 60 * 60;
	_sec+=_now_date.getHours() * 60 * 60;
	_sec+=_now_date.getMinutes() * 60;	
	_sec+=_now_date.getSeconds();	
	if (_freeCacheSecondeDelay!=0)
	{
		_sec = Math.floor(_sec/_freeCacheSecondeDelay)*_freeCacheSecondeDelay
	}
	return "-"+_sec;
}

function urlAntiCacheForPreview()
{
	if (document.webaca_is_preview) return urlSuffixe(0);
	return "";
}



function _disableMouseOverEvents()
{
	var _list=document.getElementsByTagName("A");
	for  (var _i=0;_i<_list.length;_i++)
	{
		var _o = _list[_i];
		if (_o.onmouseover)_o.onmouseover = null;
		if (_o.onmouseout)_o.onmouseout = null;
	}	
}

function _enableFocusEvents()
{
//	alert("_enableFocusEvents"+document.wa_global_list_element.length)
	for  (var _n in document.wa_global_list_element)
	{
		var _id=document.wa_global_list_element[_n]
		var _el = document.getElementById(_id)
		_el.onclick = function()
		{
			WA_focus(this)
		}
	}	
}



function WA_declare(_id)
{
	if (!document.wa_global_list_element)
	{
		document.wa_global_list_element = new Array();;
	}
	document.wa_global_list_element.push(_id)
}


function _WA_getQueryInfo()
{
	var _url =  window.location.search;
	if (_url.substr(0,1)=="?")_url=_url.substr(1);
	if (_url.length==0)return;	
	var _qs = new Array();
	var _vars = _url.split("&"); 
	for (var i=0;i<_vars.length;i++) 
	{ 
		var _pair = _vars[i].split("=");_qs[_pair[0]]=_pair[1];
	}
	var _s_info = _qs["wa_key"];
	if (!_s_info)return;
	var _query_info = new Array();
	_query_info.m_unid=_s_info;
	_query_info.m_index_item=-1;
	var _ind_sep_info = _s_info.indexOf("-") ;
	if (_ind_sep_info != -1)
	{
		_query_info.m_unid=_s_info.substring(0,_ind_sep_info);
		_query_info.m_index_item=parseInt(_s_info.substring(_ind_sep_info+1));
	}		
	document.wa_global_query_info=_query_info;
//	alert("#"+_query_info.m_unid+"  "+_query_info.m_index_item+"#")
}


function IS_onload_WA()
{
	if (isAppleMobile())
	{
		_disableMouseOverEvents()
	}
	else
	{
		_enableFocusEvents()
	}
	
	_WA_getQueryInfo();
	//
	
	
	///
	_WAcenterBackgroundImage()	
	
	
}


function _WAcenterBackgroundImage()
{
	
	
	var _bgOffsetX = 0;
	var _bgOffsetY =document.webaca_banner_height;	

	var _bgALign = document.webaca_page_option_background
	if (document.webaca_page_is_centered)
	{
		var _lxWin=getDocumentSize().width()
		//var _lxWin=getWindowSize().width()
		//getWindowSize() 
		var _lxPage=document.webaca_width_page
	
		if ((_bgALign==0)||(_bgALign==1))
		{
			if (_lxWin>_lxPage)_bgOffsetX=(_lxWin-_lxPage)/2;
		}
		else
		if (_bgALign==2)
		{
			//nop
		}
		else
		if (_bgALign==3)//center bg
		{
			_bgOffsetX=_lxWin/2-(document.webaca_page_background_img_size[0]/2);
		}	
		
	}	
	if (document.body && document.body.style)
	document.body.style.backgroundPosition=_bgOffsetX+"px "+_bgOffsetY+"px";
}

waJSQuery(window).resize(function() {
  _WAcenterBackgroundImage()
});

/********************************/
/******** TRANSLATOR *************/
/********************************/

function WA_loadMessages()
{
	for (var k in CONST_WA_TR)
	{
		var key = CONST_WA_TR[k]
		Translator.m_tr[key[0]]=key[1]
	}
	for (var n=0;n<CONST_WA_COUNTRIES.codes.length;n++)
	{
		var _key = CONST_WA_COUNTRIES.codes[n]
		var _label = CONST_WA_COUNTRIES.labels[n]
		Translator.m_countries[_key]=_label
	}
}

//////
function Translator()
{
}

Translator.m_tr = new Array();
Translator.m_countries = new Array();
Translator.tr=function(k,bEncodeBr)
{
	try
	{
		var v = Translator.m_tr[k]
		if ((v==undefined)||(v.length==0))return "@"+k;
		if (bEncodeBr!=false)
		{
			v=v.replace(/\n/g,"<br>")
		}
		
		return v
	}
	catch (e){}
	return k;
}




Translator.country=function(k)
{
	try
	{
		var v = Translator.m_countries[k]
		if ((v==undefined)||(v.length==0))return "@"+k;
		return v
	}
	catch (e){}
	return k;
	
}


//////////////////////////

///////



function isOperaBrowser()
{
 return (/opera/i.test(navigator.userAgent))
}

function WA_exec_callback_opera_compliant(_obj,_callback)
{
	/*
	if(/opera/i.test(navigator.userAgent))
	WA_exec_delayedCallback(_obj,_callback)
	else
	*/
	_callback.call(_obj)
}

function WA_exec_delayedCallback(_obj,_callback)
{
	wa_timeout(Delegate.create(_obj, _callback), 0);
}


/////////////////

function WA_loadScript(url, callback,params) 
{

    var e = document.createElement("script");
    e.src = url;
    e.type = "text/javascript";
	e.onerror=function(){callback(params,false);}// Other browsers
    if (/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent)) {
      // IE
      e.onreadystatechange = function(){
        if ((this.readyState == 'complete')||(this.readyState == 'loaded')) {
          callback(params,true);
        }
      }
    } else 
	{
		e.onload=function(){
			//timeout ->bug sous opera
			
			if (/opera/i.test(navigator.userAgent))
			wa_timeout(callback,0,params,true);
			else
			callback(params,true);
			
			}// Other browsers
    }
    document.getElementsByTagName("head")[0].appendChild(e);
}


function WA_onSearch(_id_input)
{
	

	var _input = document.getElementById(_id_input);
	if (document.wa_search_js_loaded == true)
	{
		WA_openSearchDialog(_input,document.const_wa_search_index_js)
	}
	else
	{
		WA_Dialog.progress();
		_WA_loadSearchLibrary(_input)
	}
}

function _WA_SearchLibraryLoaded(_params)
{
	document.wa_search_js_loaded = true
	WA_openSearchDialog(_params[0],document.const_wa_search_index_js)
}


function _WA_loadSearchLibrary(_input_field)
{
	WA_loadScript(document.const_wa_search_js,_WA_SearchLibraryLoaded,[_input_field]) 
}


function _getCookieVal(offset) {
	var endstr=document.cookie.indexOf (";", offset);
	if (endstr==-1)
      		endstr=document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
}

function WA_GetCookie(name) 
{	
	var arg=name+"=";
	var alen=arg.length;
	var clen=document.cookie.length;
	var i=0;
	while (i<clen) 
	{
		var j=i+alen;
		if (document.cookie.substring(i, j)==arg)
                        return _getCookieVal (j);
                i=document.cookie.indexOf(" ",i)+1;
                        if (i==0) break;
    }
	return "";
}

function WA_SetCookie (name, value) {
	var argv=WA_SetCookie.arguments;
	var argc=WA_SetCookie.arguments.length;
	var expires=(argc > 2) ? argv[2] : null;
	var path=(argc > 3) ? argv[3] : null;
	var domain=(argc > 4) ? argv[4] : null;
	var secure=(argc > 5) ? argv[5] : false;
	document.cookie=name+"="+escape(value)+
		((expires==null) ? "" : ("; expires="+expires.toGMTString()))+
		((path==null) ? "" : ("; path="+path))+
		((domain==null) ? "" : ("; domain="+domain))+
		((secure==true) ? "; secure" : "");
}


/*
function RGBColor(_color_string)
{
    this.ok = false;this.a = 1.0;
    if (_color_string.charAt(0) == '#') { _color_string = _color_string.substr(1);}
    _color_string = _color_string.replace(/ /g,'');
    _color_string = _color_string.toLowerCase();
    var _color_defs = [
        {re: /^rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*(\d{1,2}\.*\d{0,2})\)$/,_process: function (bits){return [ parseInt(bits[1]),parseInt(bits[2]),parseInt(bits[3]),parseFloat(""+bits[4]) ]; }},
        {re: /^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/,_process: function (bits){ return [ parseInt(bits[1]),parseInt(bits[2]),parseInt(bits[3])];}},
        {re: /^(\w{2})(\w{2})(\w{2})(\w{2})$/,_process: function (bits){return [ parseInt(bits[1], 16),parseInt(bits[2], 16),parseInt(bits[3], 16),Math.round(parseInt(bits[4],16)*100/255)/100 ];}},
        {re: /^(\w{2})(\w{2})(\w{2})$/,_process: function (bits){return [ parseInt(bits[1], 16),parseInt(bits[2], 16),parseInt(bits[3], 16) ];}}
    ];

    // search through the definitions to find a match
    for (var i = 0; i < _color_defs.length; i++) {
        var _re = _color_defs[i].re;
        var _processor = _color_defs[i]._process;
	//
        var _bits = _re.exec(_color_string);
        if (_bits) {

            var _channels = _processor(_bits);
            this.r = _channels[0];this.g = _channels[1];this.b = _channels[2];this.a = _channels[3];
            this.ok = true;
        }
    }
    this.r = (this.r < 0 || isNaN(this.r)) ? 0 : ((this.r > 255) ? 255 : this.r);
    this.g = (this.g < 0 || isNaN(this.g)) ? 0 : ((this.g > 255) ? 255 : this.g);
    this.b = (this.b < 0 || isNaN(this.b)) ? 0 : ((this.b > 255) ? 255 : this.b);
	this.a = (this.a > 1 || isNaN(this.a)) ? 1 : ((this.a < 0) ? 0 : this.a);
    this.toRGB = function () 
	{
		if (this.a==1)return 'rgb(' + this.r + ', ' + this.g + ', ' + this.b + ')';
		return 'rgba(' + this.r + ', ' + this.g + ', ' + this.b + ','+this.a+')';
    }
	
    this.toRGB_opaque = function () 
	{
		return 'rgb(' + this.r + ', ' + this.g + ', ' + this.b + ')';
    }
	
	this.toHsl = function(){
		var r = this.r;var g = this.g;var b = this.b;r /= 255, g /= 255, b /= 255;
	    var max = Math.max(r, g, b), min = Math.min(r, g, b);
	    var h, s, l = (max + min) / 2;
	    if(max == min){h = s = 0; // achromatic
	    }else{
	        var d = max - min;s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
	        switch(max){
	            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
				case g: h = (b - r) / d + 2; break;
				case b: h = (r - g) / d + 4; break;
	        }
	        h /= 6;
	    }
	    return [h, s, l];
	}
	//
    this._hue2rgb=function(p, q, t)
	{
        if(t < 0) t += 1;if(t > 1) t -= 1;if(t < 1/6) return p + (q - p) * 6 * t;if(t < 1/2) return q;if(t < 2/3) return p + (q - p) * (2/3 - t) * 6;
        return p;
    };	
	this.fromHsl = function(h, s, l){
		if (l>1.0)l=1.0
	    var r, g, b;
	    if(s == 0){r = g = b = l; // achromatic
	    }else{
	        var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
	        var p = 2 * l - q;
	        r = this._hue2rgb(p, q, h + 1/3);g = this._hue2rgb(p, q, h);b = this._hue2rgb(p, q, h - 1/3);
	    }
		r= r * 255;g= g * 255;b= b * 255;
		r = Math.round(r);g = Math.round(g);b = Math.round(b);
		if (r<0)r=-r;if (g<0)g=-g;if (b<0)b=-b
		this.r = r;this.g = g;this.b = b;
	};
}
*/
///////
function MD5(string) {
 
	function RotateLeft(lValue, iShiftBits) {
		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
	}
 
	function AddUnsigned(lX,lY) {
		var lX4,lY4,lX8,lY8,lResult;
		lX8 = (lX & 0x80000000);
		lY8 = (lY & 0x80000000);
		lX4 = (lX & 0x40000000);
		lY4 = (lY & 0x40000000);
		lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		if (lX4 & lY4) {
			return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		}
		if (lX4 | lY4) {
			if (lResult & 0x40000000) {
				return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			}
		} else {
			return (lResult ^ lX8 ^ lY8);
		}
 	}
 
 	function F(x,y,z) { return (x & y) | ((~x) & z); }
 	function G(x,y,z) { return (x & z) | (y & (~z)); }
 	function H(x,y,z) { return (x ^ y ^ z); }
	function I(x,y,z) { return (y ^ (x | (~z))); }
 
	function FF(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function ConvertToWordArray(string) {
		var lWordCount;
		var lMessageLength = string.length;
		var lNumberOfWords_temp1=lMessageLength + 8;
		var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		var lWordArray=Array(lNumberOfWords-1);
		var lBytePosition = 0;
		var lByteCount = 0;
		while ( lByteCount < lMessageLength ) {
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
			lByteCount++;
		}
		lWordCount = (lByteCount-(lByteCount % 4))/4;
		lBytePosition = (lByteCount % 4)*8;
		lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		return lWordArray;
	};
 
	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	};
 
	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	};
 
	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;
 
	string = Utf8Encode(string);
 
	x = ConvertToWordArray(string);
 
	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
 
	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}
 
	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
 
	return temp.toLowerCase();
}

/*
function htmlImageResource(_nImage)
{
	var _sizeImg = [
		[26,18],[19,19],[25,16],[10,10],[15,15],[15,15],
		[18,18],[ 9, 9],[12, 8],[12, 8],[11,11],[15,12]
		]
	var _matrixCols = 6;
	var _matrix = 41;
	var _colImage = _nImage%_matrixCols
	var _rowImage = Math.floor((_nImage*_matrix)/(_matrixCols*_matrix))
	var _xImg = _colImage*_matrix;
	var _yImg = _rowImage*_matrix
	var _xImg2 = _xImg+_sizeImg[_nImage][0];
	var _yImg2 = _yImg+_sizeImg[_nImage][1];;
	var _lx=_sizeImg[_nImage][0]-1
	var _ly=_sizeImg[_nImage][1]-1
	var _src = 'webacappella4.png'
	var _imgHtml = ""
//	window.status = _xImg+" "+_yImg+"  "+ _xImg2+" "+_yImg2+  "   "+_rowImage+"x"+_colImage
	_imgHtml = "<div style='position:absolute;width:"+_lx+"px;height:"+_ly+"px;'><img src='"+_src+"' style='position:absolute;";
	
//	_imgHtml+="-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-o-user-select: none;user-select: none;"
	_imgHtml+="left:"+(-_xImg)+"px;top:"+(-_yImg)+"px;clip:rect("+_yImg+"px,"+_xImg2+"px,"+_yImg2+"px,"+_xImg+"px);'></div>"

	_imgHtml = "<div style='position:absolute;;width:"+_lx+"px;height:"+_ly+"px;"
	//_imgHtml +="-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-o-user-select: none;user-select: none;"
	_imgHtml += "'>";
	
	_imgHtml += "<div style='";
	_imgHtml+="position:absolute;"
	_imgHtml+="width:"+((_colImage+1)*_matrix)+"px;height:"+((_rowImage+1)*_matrix)+"px;"
	_imgHtml+="background:url("+_src+");"
	_imgHtml+="left:"+(-_xImg)+"px;top:"+(-_yImg)+"px;"
	_imgHtml+="clip:rect("+_yImg+"px,"+_xImg2+"px,"+_yImg2+"px,"+_xImg+"px);"
	_imgHtml+="'> </div> </div>"

//alert(_imgHtml)
	return _imgHtml;
}
*/



function centerTextContent(_o)
{
	var _label = _o.html()
	_o.html("<div class='inner-content' style='position:absolute;'></div>")
	var _inner = _o.find(".inner-content")
	_inner.html(_label)
	_inner.css({top:(_o.height()-_inner.height())/2,left:(_o.width()-_inner.width())/2})
}



function centerElement(_elem,_class)
{
var _img = _elem.children(_class)
_img.css("left",(_elem.width()-_img.width())/2)
_img.css("top",(_elem.height()-_img.height())/2)
}

/*
var s = "bg1(#ff0000 #ff000)  bg(rbga(1,2,3,4) #ff0000) bg2()"
var ar = splitClassParameters(s,"(",")")
alert(ar['bg'])
*/
function splitClassParameters(s,sep1,sep2)
{
	s = jQuery.trim(s);
	var arr = new Array()
	var clName=""
	var clParam = ""
	var c;
	for (var i=0;i<s.length;i++)
	{
		c = s.charAt(i)
		if ((c==' ')||(c=='\n')||(c==sep2))
		{
			arr[clName] = clParam;

			clName = ""
			clParam = ""
		}
		else
		if (c==sep1)
		{
			var _countBracket = 0;
			var _bOk = true;
			do
			{
				_bOk = true;
				i++;
				c = s.charAt(i)
				
				if (c==sep1)
				{
					_countBracket++;
				}

				if ((c!=sep2)||(_countBracket!=0))
				{
					clParam+=c;
				}
				
				if (_countBracket>0)
				if (c==sep2)
				{
					_countBracket--;
					_bOk = false
				}
			}
			while ((_bOk==false)||(c!=sep2)||(_countBracket!=0))
			//alert(clName+"="+clParam)
		}
		else
		{
			clName+=c;
		}
	}
	if (clName.length>0)
	{
		arr[clName] = clParam;
	}
	
	return arr;	
}


function splitClass(s)
{
	var arr = splitClassParameters(s,'[',']')
	
	for (k in arr)
	{
		var v = arr[k];
		
		if (v.length>0)
		{
			
			var arr2 = splitClassParameters(v,'(',')')
			for (k2 in arr2)
			{
				alert("#"+k+"  "+k2+ " = "+arr2[k2])	
			}
		}
	}
}

function extractClassInfo(s,className)
{
	//alert('extractClassInfo '+className)
	var arr = splitClassParameters(s,'[',']')
	
	for (k in arr)
	{
	
		var v = arr[k];
		
		
		if (v.length>0)
		{
			//
			if (k == className)
			{
				
				//
				var arr2 = splitClassParameters(v,'(',')')
				//alert("splitClassParameters="+v+" "+arr2.length)
			//	alert("extractClassInfo "+k+"  "+arr2['bg'])
				return arr2;
			}
		}
	}
	return null
}


function extractParamInfo(_o,_nameParam,_blocName)
{
	if (_blocName==undefined)_blocName="param"
	if (_o==undefined) return ""
	var _cl = _o.attr("class");
	//alert(_cl)
	if (_cl==undefined) return ""
	var _clParam = extractClassInfo(_cl,_blocName);
	
//	alert(_cl+"  "+_clParam)
	if (_clParam==null) return ""
	if (_clParam==undefined) return ""
	if (_clParam[_nameParam]==undefined) return ""

	if (_nameParam) return  _clParam[_nameParam]
	return _clParam;
}


/*******************/
/*    initializeWA_waJSQuery   */
/*******************/

function getBrowserInfos()
{
	var _map={
	}
	if (waJSQuery.browser.webkit)_map.engine  = "webkit"
	if (waJSQuery.browser.mozilla)_map.engine  = "ff"
	if (waJSQuery.browser.msie)_map.engine  = "ie"
	
	
	return _map
}


function waSetVisibilityMainPageContenair(_b)
{
	
	if (_b)
	{
		waJSQuery(".wa-video").show()
	}
	else
	{
		waJSQuery(".wa-video").hide()
	}
	
	
}

function isValidEmailAddress(_email) 
{
var _pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
return _pattern.test(_email);
}



function _waDrawRect(c,x,y,lx,ly)
{
	c.beginPath();
	c.moveTo(x,y);
	c.lineTo(x+lx,y);
	c.lineTo(x+lx,y+ly);
	c.lineTo(x,y+ly);
	c.lineTo(x,y);
	c.closePath();
}

/*
function _waDrawRoundedRect(c,x,y,lx,ly,_arc)
{
	c.beginPath();
	_waBasicDrawRoundedRect(c,x,y,lx,ly,_arc)
	c.closePath();
}
*/
function _waBasicDrawRoundedRect(c,x,y,lx,ly,_arc,_clowckwise)
{
	if (typeof(_arc)=="number")
	{
		_arc = [_arc,_arc,_arc,_arc]
	}
	if (_clowckwise)
	{

		//alert(_arc[0]+1)
		c.moveTo(x+_arc[0],y);c.lineTo(x+lx-_arc[1],y);c.quadraticCurveTo(x+lx,y,x+lx,y+_arc[1]);c.lineTo(x+lx,y+ly-_arc[2]);c.quadraticCurveTo(x+lx,y+ly,x+lx-_arc[2],y+ly);c.lineTo(x+_arc[3],y+ly);c.quadraticCurveTo(x,y+ly,x,y+ly-_arc[3]);c.lineTo(x,y+_arc[0]);c.quadraticCurveTo(x,y,x+_arc[0],y);
	//	c.lineTo(x,y+_arc[0]);

		return;		
	}
	c.moveTo(x,y+_arc[0]);c.lineTo(x,y+ly-_arc[3]);c.quadraticCurveTo(x,y+ly,x+_arc[3],y+ly);c.lineTo(x+lx-_arc[2],y+ly);c.quadraticCurveTo(x+lx,y+ly,x+lx,y+ly-_arc[2]);c.lineTo(x+lx,y+_arc[1]);c.quadraticCurveTo(x+lx,y,x+lx-_arc[1],y);c.lineTo(x+_arc[0],y);c.quadraticCurveTo(x,y,x,y+_arc[0]);
	//c.lineTo(x,y+_arc[0]);
}

function waExtractCssStyle(_s,_key)
{
	return _waExtractCssStyle(_s,_key);
}
function _waExtractCssStyle(_s,_key)
{
	//alert(_s)
	if (_s==undefined) return ""
	var _n0 = _s.indexOf(_key);
	if ( (_n0>-1)  ||  ((_n0>0) && (_s.substring(_n0-1)==";")) )
	{
		_s = _s.substring(_n0)
		_n0 = _s.indexOf(";");
		if (_n0>-1)
		{
			_s= _s.substring(0,_n0)
		//	alert("css="+_s)
			_n0 = _s.indexOf(":");
			if (_n0>-1)
			{
				_s= _s.substring(_n0+1)
			}
			
			return waJSQuery.trim(_s);
		}
		else
		{
				_n0 = _s.indexOf(":");
				if (_n0>-1)
				{
					_s= _s.substring(_n0+1)
				}

				return waJSQuery.trim(_s);	
		}
	}
	return "";
}

function waExtractRadiusFromCss(_o)
{
	var _borderWidth = 0;
	var _CSSStr = _o.attr("style");
	
	//alert(_CSSStr)
	var _tagBorderRadius = "border-radius"
	
	if (isMSIE_higher_than_ie8())
	{
		_tagBorderRadius = "-moz-border-radius" //bizarrement le tag est tronqué sous IE9
	}
	var  _radiusStr= _waExtractCssStyle(_CSSStr,_tagBorderRadius)
//	alert("@@@ "  +_radiusStr+ " "+_CSSStr)
	if (_radiusStr.length==0)
	{
	//	alert(_CSSStr)
		var _arc0 = _waExtractCssStyle(_CSSStr,"border-top-left-radius")
		var _arc1 = _waExtractCssStyle(_CSSStr,"border-top-right-radius")
		var _arc2 = _waExtractCssStyle(_CSSStr,"border-bottom-right-radius")
		var _arc3 = _waExtractCssStyle(_CSSStr,"border-bottom-left-radius")
		/*
		if (_arc0.length==0)_arc0 = _waExtractCssStyle(_CSSStr,"border-left-top-radius")
		if (_arc1.length==0)_arc1 = _waExtractCssStyle(_CSSStr,"border-right-top-radius")
		if (_arc2.length==0)_arc2 = _waExtractCssStyle(_CSSStr,"border-right-bottom-radius")
		if (_arc3.length==0)_arc3 = _waExtractCssStyle(_CSSStr,"border-left-bottom-radius")
		*/
		if (_arc0.length==0)_arc0="0px"
		if (_arc1.length==0)_arc1="0px"
		if (_arc2.length==0)_arc2="0px"
		if (_arc3.length==0)_arc3="0px"

		_radiusStr=_arc0+" "+_arc1+" "+_arc2+" "+_arc3
		
		//alert(_radiusStr)
		//border-top-left-radius
	//	alert(splitradiusStr)
	}
//	alert("@@# "+_radiusStr)
	
	
	var splitradiusStr = _radiusStr.split(" ")
	
//	alert(_radiusStr+" "+splitradiusStr.length)
	

	
	//	alert("@"+_radiusStr.substring(_tagBorderRadius.length+1)+"@  "+ splitradiusStr[0]+" "+splitradiusStr[1])

	var _arc1=Math.max(0,parseInt(splitradiusStr[0])-_borderWidth)
	var _arc2=Math.max(0,parseInt(splitradiusStr[1])-_borderWidth)
	var _arc3=Math.max(0,parseInt(splitradiusStr[2])-_borderWidth)
	var _arc4=Math.max(0,parseInt(splitradiusStr[3])-_borderWidth)
	if (splitradiusStr.length==1)
	{
		_arc2=_arc1;_arc3=_arc1;_arc4=_arc1;
	}
	/*
	if (isNaN(_arc1))_arc1 = 0
	if (isNaN(_arc2))_arc2 = 0
	if (isNaN(_arc3))_arc3 = 0
	if (isNaN(_arc4))_arc4 = 0
	*/
	
	if (isNaN(_arc1))_arc1 = 0
	if (isNaN(_arc2))_arc2 = _arc1
	if (isNaN(_arc3))_arc3 = _arc2
	if (isNaN(_arc4))_arc4 = _arc3
	
	return new Array(_arc1,_arc2,_arc3,_arc4)
}

function waSoustractFromArrayRadius(_arr,_val)
{
	for (var i=0;i<_arr.length;i++)
	{
		if (isNaN(_arr[i])||(_arr[i].length==0))
		{
			_arr[i] = 0
		}
		else
		{
			_arr[i] = Math.max(0,_arr[i]-_val)
		}
		
	}
	return _arr;
}



function waGenerateNewGradientID()
{
	var _curId = waJSQuery(document).data("curCanvasGradientId")
	if (_curId==undefined)_curId=0;
	waJSQuery(document).data("curCanvasGradientId",_curId+1)
	return "canvasGradientId"+_curId;
}


function waGetDrawingSurface(_o,_w,_h)
{

	
	var _className="wa-div-bg-gradient"
//	alert(_className)
	var _canv = null
	var _div = _o.find("."+_className)
	//alert(_div.length)
	if (_div.length==0)
	{
		//_w+=5
		//_h+=5
		
		var _index = -1;
		_o.append("<div class='"+_className+"' ></div>")
		_div = _o.find("."+_className)
		_div.css({position:"absolute",top:0,left:0,width:_w,height:_h,zIndex:_index})
		
		var _canvId=waGenerateNewGradientID();
		//alert(_canvId)
		_div.html("<canvas id='"+_canvId+"' width="+_w+" height="+_h+" style='z-index:"+_index+"' ></canvas>")
		
		_div.data("waCanvasId",_canvId)
		_canv = document.getElementById(_canvId);
		
		//alert(isMSIE_lower_than_ie9())
		if (isMSIE_lower_than_ie9())
		{
			if (window.G_vmlCanvasManager)
		 	window.G_vmlCanvasManager.initElement(_canv);	
		}	
		//alert(_canv)
		
		
	}
	else
	{
		
		var _canvId=_div.data("waCanvasId")
		_canv = document.getElementById(_canvId);
		
	}

	if (_canv==null)
	{
		if (isMSIE())
		{
			if (document.documentMode==8)
			{
				//alert(navigator.userAgent)
				if ( /MSIE 9/.test(navigator.userAgent) )
				{
					if (document.warning_ie9_frame!=true)
					{
						document.warning_ie9_frame = true
						alert(window.location+"\n"+Translator.tr("This site is probably in a frame,Display problems can occur with IE9 you have to enabled Force IE8 rendering in WA4 website properties",false));
						
					}
				}
				
			}
			//alert(document.compatMode+"  "+document.documentMode)
		}	
		return null;
	}
	var _c = _canv.getContext('2d');
	return _c;	
}


function _waPutFillLinearGradient(_c,_gradProps)
{
	var _arrGradStr = _gradProps.split(" ")
	if (_arrGradStr.length>1)
	{
		var _x1 = parseInt(_arrGradStr[0]);
		var _y1 = parseInt(_arrGradStr[1]);;
		var _x2 = parseInt(_arrGradStr[2]);
		var _y2 = parseInt(_arrGradStr[3]);

		var _col1=_arrGradStr[4]
		var _col2="";

		if (_arrGradStr.length>5)
		{
			_col2 = _arrGradStr[5]
		}

		if (_col1=="undefined")_col1=""	
		if (_col2=="undefined")_col2=""

		//_col1 = compliantColor(_col1)
		//_col2 = compliantColor(_col2)
		
		
		////if (_col1=="")_col1="transparent"
		
		//	alert(_col2)
		if (_col2=="")_col2=_col1
		
		
		if (isMSIE_lower_than_ie9())
		{
			//_col1 = compliantColor(_col1)
			//_col2 = compliantColor(_col2)
			var _oCol1 = new RGBColor(_col1)
			var _oCol2 = new RGBColor(_col2)
			if (_col1=="")
			{
				var _tmp = new RGBColor(_col2)
				_tmp.a = 0;
				_col1 = _tmp.toRGB()
			}
			
			if (_col2=="")
			{
				var _tmp = new RGBColor(_col1)
				_tmp.a = 0;
				_col2 = _tmp.toRGB()
			}		
			/*
			
			if (_col1=="transparent")_col1=
			if (_col1=="transparent")_col1="transparent"
			*/
			
		}
		
		//_col2=""
		//_col2="#ffffffff"
		
		//if (_col2=="")_col2="transparent"
		

		//_col2="transparent"
		
	//	alert(_col1+"  "+_col2)
	//	alert(_col2)
		
		var _grad = _c.createLinearGradient(_x1,_y1,_x2,_y2);
		//alert(_col1+" "+_col2)
		_grad.addColorStop(0,_col1);
		_grad.addColorStop(1,_col2);

		//alert(_col2)
		//alert(_col1+"  "+_col2)
	//	_c.fillStyle = _grad
		return _grad	
	}
	else
	{
	//	_c.fillStyle = _gradProps
		return _gradProps
	}
}

function waDrawRoundedRectInSurface(_c,_w,_h,_arc,_gradProps,_borderWidth,_borderColor)
{
	//	alert(_borderColor
	//	alert(_borderColor+"  "+_borderWidth+"  "+_borderColor.length)
		if ((_borderColor==undefined) || (_borderColor.length==0))
		{
			_borderWidth=0
		}
		if (_borderWidth==0)
		{
			_borderColor=""
		}
		

//alert(_borderColor+"  "+_borderWidth+"  "+_borderColor.length)
		var _wInner = _w-2*_borderWidth
		var _hInner = _h-2*_borderWidth

		var _arcInner = new Array(_arc[0],_arc[1],_arc[2],_arc[3])

		_arcInner = waSoustractFromArrayRadius(_arcInner,_borderWidth)


		if (_gradProps!=null)
		{
			{
					_c.fillStyle = _waPutFillLinearGradient(_c,_gradProps)
					////
				
					var _x = _borderWidth
					var _y = _borderWidth

					if (_c.fillStyle !="")
					{
						_c.beginPath();
						_waBasicDrawRoundedRect(_c,_x,_y,_wInner,_hInner,_arcInner)
						_c.closePath();
						_c.fill()	
					}
			}
		}
		


		if ((_borderWidth>0)&&(_borderColor)&&(_borderColor.length>0))
		{
		//	alert(_borderColor+" "+_h)
			_c.fillStyle = _borderColor;
			_c.beginPath();
			_waBasicDrawRoundedRect(_c,0,0,_w,_h,_arc)
			_waBasicDrawRoundedRect(_c,_borderWidth,_borderWidth,_wInner,_hInner,_arcInner,true)
			_c.closePath();
			_c.fill()
		}


	
}

function waDrawRoundedRect(_o,_w,_h,_arc,_gradProps,_borderWidth,_borderColor)
{

var _c = waGetDrawingSurface(_o,_w,_h)
	waDrawRoundedRectInSurface(_c,_w,_h,_arc,_gradProps,_borderWidth,_borderColor)
}


function waDrawButton(_o,_gradProps,_borderColor,_innerBorderColor,_bgImage)
{
	//alert('waDrawButton')
	var _pars = _o.parent()
	var _waButInner=_pars.find(".waButInner")
	_waButInner.hide()
	var _waGlossInner=_pars.find(".waButGlossInner")
	_waGlossInner.hide()

	_o.css("background","")
	_o.css("border","none")

	
	var _borderWidth = 1;
	
	if ((_borderColor==undefined)|| (_borderColor.length==0))
	{
		_borderWidth = 0;
	}
	
	var _innerBorderWidth = 1;
	
	var _widthBut = _o.outerWidth()
	var _heightBut = _o.outerHeight()

	var _w = _widthBut
	var _h = _heightBut
	
	var _hasAquaEffect= (extractParamInfo(_o,"aqua")=="1")

	var _arc = waExtractRadiusFromCss(_o)

	var _c = waGetDrawingSurface(_o,_w,_h)
	
//	alert(_c)
	if (isMSIE_lower_than_ie9())
	{
		_o.css("border","")
	}
	
	
	//alert(_gradProps)

	_c.clearRect(0,0,_w,_h)
	var _bordColor0 = _borderColor
	
	if (isMSIE_lower_than_ie9())
	{
		
		//alert(_gradProps)
		var _arrGrad = _gradProps.split(" ")
		var _col1=""
		var _col2=""
	//	alert(_arrGrad.length)
	
		if (_arrGrad.length<=1)
		{
			_col1=_gradProps
			_col2=_gradProps
		}
		else
		{
			_col1=_arrGrad[4]
			_col2=_arrGrad[5]
		}
		
		if (_col1 == _col2)
		{
			waDrawRoundedRectInSurface(_c,_w,_h,_arc,_col1,_borderWidth,_bordColor0)
		}
		else
		{
			var _percentGrad = 40;
			if (_hasAquaEffect)
			{
				_percentGrad = 70;
			}
			var _hGrad = _h - Math.round(_h*_percentGrad/100)
			
			var _arc1 = [_arc[0],_arc[1],0,0]
			
			waDrawRoundedRectInSurface(_c,_w,_h-_hGrad,_arc1,_col1,_borderWidth,"")
			
			
			var _arc2 = [0,0,_arc[2],_arc[3]]
			var _gradPropsBottom = "0 0 0 "+_hGrad+" "+_col1+" "+_col2

			_c.fillStyle = _waPutFillLinearGradient(_c,_gradPropsBottom)

			_c.beginPath();
			var _yGrad0 = _h-_hGrad
			_waBasicDrawRoundedRect(_c,0,_yGrad0,_w,_hGrad,_arc2)
			_c.closePath();
			_c.fill()
			
			//tour
			
			if ((_bordColor0.length>0)&&(_borderWidth>0))
			{
				_c.fillStyle=""
				_c.strokeStyle = _bordColor0;
				_c.beginPath();
				_waBasicDrawRoundedRect(_c,0,0,_w,_h,_arc)
				_c.closePath();
				_c.stroke();
				//alert(_bordColor0+" "+_borderWidth)
			}
			

			
		}
		
		
	
	}
	else
	
	{
	//	alert(_gradProps)
	//	_gradProps="url:crbst_ironman160060.jpg"
		waDrawRoundedRectInSurface(_c,_w,_h,_arc,_gradProps,_borderWidth,_bordColor0)
	}


	//alert(_innerBorderColor)
	if (_innerBorderColor && (_innerBorderColor.length>0))
	{
		_c.fillStyle=""
		if (isMSIE_lower_than_ie9())
		{
			_c.strokeStyle = _innerBorderColor;
		}
		else
		{
			_c.strokeStyle = _waPutFillLinearGradient(_c,"0 "+Math.round(_h/2)+" 0 "+_h+" "+_innerBorderColor+" transparent")//_innerBorderColor;
		}

		_c.beginPath();
		_waBasicDrawRoundedRect(_c,1.5,1.5,_w-3,_h-3,_arc)
		_c.closePath();
		

		_c.stroke()
	}
		//alert('aqua '+_hasAquaEffect)
	if (_hasAquaEffect)
	{
	
		var _col1 = "rgba(255,255,255,0.5)"
		var _col2 = "rgba(255,255,255,0.1)"
		var _hGrad = Math.round(_h*0.5);

		var _corner = _arc[0]
		var _cornerGrad = _corner;
        _cornerGrad = Math.min(_cornerGrad,_hGrad/2);

		//alert(_cornerGrad+"  "+_arc[0])
		
		var _xDec = _corner-_cornerGrad;
        _xDec = Math.max(_xDec,0);
		var _gradProps = "0 0 0 "+_hGrad+" "+_col1+" "+_col2
		//alert(_gradProps)
		_c.fillStyle = _waPutFillLinearGradient(_c,_gradProps)
		_c.beginPath();
		var _yGrad0 = 0
		_waBasicDrawRoundedRect(_c,_xDec,_yGrad0,_w-2*_xDec,_yGrad0+_hGrad,_cornerGrad)
		_c.closePath();
		
		
		_c.fill()
		
	}
	
		
}	

function waHackGradient()
{
	if (isWebKit() || isFirefox())
	{
		return false;
	}
//
	waJSQuery(".wa-bg-gradient").each(function() 
	{
		var _o = waJSQuery(this)
		var _CSSStr = _o.attr("style");

		var _gradProps = extractParamInfo(_o,"grad")
		
		
	//	alert(_gradProps)
		
		var _array_borderProps = extractParamInfo(_o,"border").split(" ")
		
		var _borderWidth = 0
		var _borderColor = ""
		if (_array_borderProps.length>0)
		{
			_borderWidth = parseInt(_array_borderProps[0])
			if (isNaN(_borderWidth))_borderWidth = 0;
		}
		if (_array_borderProps.length>1)
		{
			_borderColor = _array_borderProps[1]
		}

		//	alert(_array_borderProps.length+"  "+_borderWidth+"  "+_borderColor)
		
		var _imgSrc = _o.css("backgroundImage")
		
		if ((_imgSrc.length>0)&&(_imgSrc!="none"))
		{
			_gradProps=null
		}
		//alert(_imgSrc)
		
		var _w = _o.width()+2*_borderWidth
		var _h = _o.height()+2*_borderWidth
		var _arc = waExtractRadiusFromCss(_o)

	
		_o.css({border:"0px none",backgroundColor:"transparent"})

//alert(_gradProps)
		waDrawRoundedRect(_o,_w,_h,_arc,_gradProps,_borderWidth,_borderColor)
		
		if (isMSIE())
		{
			_o.css({width:_w,height:_h})
		}
	})

}

function waHasButtonHacking()
{
//	return true
	if (isWebKit() || isFirefox())
	{
		return false;
	}
	return true;
}

function waHackButtons()
{

	//	alert("waHackButton")
	if (waHasButtonHacking()==false)
	{
		return false;
	}
	
	waJSQuery(".wa-button").each(function() 
	{
		var _o = waJSQuery(this)
		waHackButton(_o)
	
	})
}

function waPercentGradientButton(_but)
{
	var _hasAquaEffect= (extractParamInfo(_but,"aqua")=="1")
	var _percentYGrad = 40;
	if (_hasAquaEffect)
	{
		_percentYGrad = 70;
	}
	return _percentYGrad;
}

function waHackButton(_o)
{
	//alert("waHackButton")
	
	var _pars = _o.parent()
	var _waButInner=_pars.find(".waButInner")
	//alert(_waButInner.length)
	_waButInner.show()
	var _waGlossInner=_pars.find(".waButGlossInner")
	_waGlossInner.show()
	
	
	
	if (waHasButtonHacking()==false)
	{
		return false;
	}
	var _oldBg = _o.data("saved-background-image")
	if (_oldBg==null)
	{
		_o.data("saved-background-image",_o.css("background-image"))
	}

	var _bg = _o.data("saved-background-image")
	if ((_bg.indexOf("url(")>-1)&&(_bg.indexOf("wa_transparent.gif")==-1))
	{
		//_o.css("border","0px none")
		return false;
	}
	
	//alert(_bg)
	//hack pour IE9
	_o.css("background-color","")

	var _gradProps = extractParamInfo(_o,"grad")
	var _innerBorderColor = (extractParamInfo(_o,"inborder"))
	var _borderColor = (extractParamInfo(_o,"border"))

	waDrawButton(_o,_gradProps,_borderColor,_innerBorderColor)
}

function waHackButtonOver(_o)
{

	if (waHasButtonHacking()==false)
	{
		return false;
	}

	var _but = waJSQuery(">button",_o);
	
	var height = parseInt(_o.css("height"));

	var cl = _o.attr("class")
	
	
	var bg= extractParamInfo(_o,"bg")

	var _gradProps = null;

	
	var _percentYGrad = waPercentGradientButton(_but)
	if (bg && (bg.length>0))
	{
		var _hGrad = Math.round(height*_percentYGrad/100)
		var cols = bg.split(" ")
		_gradProps = "0 "+_hGrad+" 0 "+height+" "+cols[0]+" "+cols[1]		
	}
	
	var bg_img= extractParamInfo(_o,"bg_img")
	if (bg_img && (bg_img.length>0))
	{
		return;
	}

	var _borderColor = extractParamInfo(_o,"bord");
	var _innerBorderColor =extractParamInfo(_o,"inner_bord")
//alert("waDrawButton")
	waDrawButton(_but,_gradProps,_borderColor,_innerBorderColor)
}

function waHackButtonOut(_o)
{
	waHackButton(_o)
}


function waActivateOverButton(_butLink)
{
	
		var _bUseDiv = true;
		
		var _mainDiv = null
		
		if (_bUseDiv)
		{
			_mainDiv = _butLink;

		}
		else
		{
			_mainDiv = waJSQuery(">span",_butLink);
		}
		//_mainDiv.css("background-color","url(wa-market-def3.png)")		
		var o = _mainDiv

		var button = waJSQuery(">button",o);
		
		var txtSpan = null

		if (_bUseDiv)
		{
			txtSpan = waJSQuery(">div",button);
	//	txtSpan = waJSQuery(".wa-but-txt",button);
		//alert(txtSpan.length)
		}
		else
		{
			txtSpan = waJSQuery(">span",button);
		}
		
		var _ref = _butLink.attr("onclick")
		if (_ref=="javascript:void(0)")_ref=""
		if (_ref==undefined)_ref=""
		if (_ref=="#")_ref=""


		if ((o.hasClass('wa-js-action')==false)&&(_ref.length==0))

		{
			_butLink.css("cursor","default")
			o.css("cursor","default")
			button.css("cursor","default")
			txtSpan.css("cursor","default")	
		}
		else
		{
			_butLink.css("cursor","pointer")
			o.css("cursor","pointer")
			button.css("cursor","pointer")
			txtSpan.css("cursor","pointer")
		}

		//alert(button.css("background-image"))
		
		//_mainDiv.css("background-color","#ff0000")	
		if (isMSIE())
		{
			var _hasBgNormalImage = false;
			var _img = button.css("background-image")
	
			if ((_img && (_img.length==0))||(_img=="none"))
			{

				button.css("background-image","url(wa_transparent.gif)")	

				//sinon prob avec ie8 over
				_mainDiv.append("<div style='position:absolute;top:0px;left:0px;width:100%;height:100%;;background-image:url(wa_transparent.gif)'></div>")
			}
			else
			{
				_hasBgNormalImage = true;
				button.css("background-size",button.width()+" px "+button.height()+" px ")	
			}
			//

		}

		var _waButInner=o.find(".waButInner")
		
		var _wTextSpan = txtSpan.outerWidth()
		_wTextSpan = Math.min(_wTextSpan,button.width())
		
		
		var img = waJSQuery(">img",button);
		var _xInput = Math.round((button.width()-_wTextSpan)/2)
		var _yInput = Math.round((button.height()-txtSpan.outerHeight())/2)

//alert(button.width()+"  "+txtSpan.outerWidth()+" "+_wTextSpan)
		var _align = button.css("textAlign");

		if (_align=="center")
		{
			_xInput = Math.round((button.width()-_wTextSpan)/2)
		}
		if (_align=="left")
		{
			_xInput = 3
		}
		if (_align=="right")
		{
			_xInput = button.width()-_wTextSpan-3
		}
		
		//alert(img.attr("src"))
		if ((img.length==0)||(img.attr("src")==undefined))
		{
			//txtSpan.css({"top":_yInput})
			//alert(txtSpan.css("position"))
			//txtSpan.css({"position":"relative","left":_xInput,"top":_yInput})
		}

		//hover gestion
		
		var cl = o.attr("class")
		
		var clParam = extractClassInfo(cl,"param")


		_waButInner.css("border-bottom","0px none")
	
		var _objEventOver = o
		_objEventOver = _mainDiv
		
	//	alert(_objEventOver.html())
		_objEventOver.data("link_data",o)


		if (clParam!=null)
		_objEventOver.hover(

		  function () {

			var o = waJSQuery(this).data("link_data")
			var button = waJSQuery(">button",o);


			var _state = button.data("waButState")
			if (_state==undefined) _state = 0;

			if (_state!=0) return;

			button.data("waButState",1)

			var height = button.outerHeight()


			var _hasAquaEffect= (extractParamInfo(button,"aqua")=="1")
			

			var txtSpan = button.find(".wa-but-txt")
			
			//alert(txtSpan.length)
			
		//	txtSpan = button.find(".wa-but-txt")
			
			//alert(txtSpan.length)
			var imgTag = waJSQuery(">img",button);

			imgTag = button.find("img");//sinon bug avec button + texte
			var innerSpan = waJSQuery(">.waButInner",o);


			button.data('wa-style',button.attr('style'))
			if (isMSIE_lower_than_ie9())
			{
				button.data('wa-style-bg-img',button.css('background-image'))
			}
			
			txtSpan.data('wa-style',txtSpan.attr('style'))
			imgTag.data('wa-style',imgTag.attr('style'))
			innerSpan.data('wa-style',innerSpan.attr('style'))
			imgTag.data('wa-style-src',imgTag.attr('src'))
	
			//if (waHasButtonHacking()==false)
			{
				var bg= extractParamInfo(o,"bg")
				if (bg.length>0)
				{


					var cols = bg.split(" ")

					var _col1 = cols[0]
					var _col2 = _col1
					if (cols.length>1)_col2 = cols[1]

					var _infos = getBrowserInfos();

					//alert(bg+" # "+cols.length +" "+_col1+" "+_col2)


					var _percentYGrad = waPercentGradientButton(button)

					if (_infos.engine=="webkit")
					{
						var _hGrad = Math.round(height*_percentYGrad/100)
					//	alert(height+" "+_percentYGrad+"  "+"-webkit-gradient(linear,0 "+_hGrad+", 0 "+height+",from("+_col1+"),to("+_col2+"))")
						button.css("background","-webkit-gradient(linear,0 "+_hGrad+", 0 "+height+",from("+_col1+"),to("+_col2+"))")
					}
					if (_infos.engine=="ff")
					{
						button.css("background","-moz-linear-gradient(top left -90deg,"+_col1+" "+_percentYGrad+"%, "+_col2+" 100%)")
					}	

				}
				
				var borderCol=  extractParamInfo(button,"border");
				//alert(_borderColor2+"  "+_borderColor3)
				var borderColOver=  extractParamInfo(o,"bord");
				
				var _cBorderOver = new RGBColor(borderColOver)
				var _hasBorderOver = _cBorderOver.a>0;
				var _cBorder = new RGBColor(borderCol)
				var _hasBorder = _cBorder.a>0;
				
				if (_hasBorderOver)
				{
					//button.css("border-color",borderColOver)
					
					button.css("border","1px solid "+borderColOver)
				}
				else
				{
					button.css("border","0px")
				}


				///

				var bg_img= extractParamInfo(o,"bg_img");
				

				if (bg_img && (bg_img.length>0))
				{
					//
			//alert(_hasBorder+"  "+_hasBorderOver)
					var _lx = button.width();
					var _ly = button.height();
				
					if ((_hasBorder))
					{
						_lx+=2;
						_ly+=2;
					}

					button.css({"background-image":"url('"+bg_img+"')","background-size":""+_lx+"px "+_ly+"px"})
				}

			}


			var inner_borderCol= extractParamInfo(o,"inner_bord");
			if (inner_borderCol && (inner_borderCol.length>0))
			{
				innerSpan.css("border-color",inner_borderCol)
			}

			var txtCol= extractParamInfo(o,"txt");
			
			//alert(txtCol)
			if (txtCol && (txtCol.length>0))
			{
				//alert(txtCol)
				txtSpan.css("color",txtCol)
				button.css("color",txtCol)
			}


			var _underlineTxt= extractParamInfo(o,"u");
			if (_underlineTxt && (_underlineTxt.length>0))
			{
				if (_underlineTxt=="1")
				{
					txtSpan.css("textDecoration","underline")
					if (isMSIE())
					{
						button.css("textDecoration","underline")
					}
					
				}
				else
				{
					txtSpan.css("textDecoration","none")
					if (isMSIE())
					{
						button.css("textDecoration","none")
					}
					
				}

			}


			var img= extractParamInfo(o,"img");

			if (img!=undefined)
			{

				if (img.length==0)
				{
					imgTag.css("width",0)
				}
				else
				{
					var img_pars = img.split(" ")
					imgTag.attr("src",img_pars[0])
					imgTag.css("width",img_pars[1])
					imgTag.css("height",img_pars[2])

				}

			}

			
			//if (button.data("disabled_hack_over")!=true)
			{
				waHackButtonOver(o)
			}
			
			//

		  }, 
		  function () {
		//	alert('out')

			var o = waJSQuery(this).data("link_data")
		//	alert(o)
			var button = waJSQuery(">button",o);

			var _state = button.data("waButState")
			if (_state==undefined)_state = 0;
			if (_state!=1) return;
			button.data("waButState",0)

			var txtSpan = button.find(".wa-but-txt")
			var imgTag = waJSQuery(">img",button);
			imgTag = button.find("img");//sinon bug avec button + texte
			var innerSpan = waJSQuery(">.waButInner",o);


			button.attr("style",button.data("wa-style"))
			if (isMSIE_lower_than_ie9())
			{
				button.css("background-image",button.data("wa-style-bg-img"))
			}
			
			txtSpan.attr("style",txtSpan.data("wa-style"))
			imgTag.attr("style",imgTag.data("wa-style"))
			
			imgTag.attr("src",imgTag.data("wa-style-src"))

			innerSpan.attr("style",innerSpan.data("wa-style"))
			
			waHackButtonOut(button)


		  }
		);

}


function waActivateOverButtons()
{
	waJSQuery(".wa-button-link").each(function(i)
	{
		var _o = waJSQuery(this)
		//alert(_o.attr("onclick"))
		waActivateOverButton(_o)
	})

}

function _waTextMarqueeTimer(_o)
{
	wa_timeout(function(){_waTextMarqueeTimer(_o)},1000)

	var _divText = _o.find("div")
	_divText.position().top
	
	var _params = _divText.data("data-marquee")
	var _orientation = _params.orientation
	var _speed = _params.speed
}

function _waCallBackAnimationStep(_divText,now, fx)
{
	//window.status="_pos="+now
	if (isMSIE())
	{
		var _params = _divText.data("data-marquee")

		var _sizeCont = _params.size_cont;
		var _posX = 0;
		var _posY = 0;
		
		if (_params.orientation!=0) //horizontal
		{
			_posX = -now;
		}
		else
		{
			_posY = -now;
		}
		var _w = _sizeCont.width()
		var _h = _sizeCont.height() 
		
		var _offset = 0;
		var _xImg = _offset+_posX;
		var _yImg = _offset+_posY;
		var _xImg2 = _w+_posX;;
		var _yImg2 = _h+_posY
		_divText.css("clip","rect("+_yImg+"px,"+_xImg2+"px,"+_yImg2+"px,"+_xImg+"px)")
	}

	
}
function _waStartMarqueeAnimation2(_divText,_canRestart)
{
//	_canRestart = false
	var _params = _divText.data("data-marquee")

	var _prop=_params.prop
	var _l_size = _params.size
	var _l_inner = _params.innerSize
	var _compSize = _params.compSize



	var _pos = 0;
	var _pos2 = 0;
	var _paramsAnimation={}
	if (_params.orientation!=0)  //horizontal
	{
		if (_canRestart==false)
		{
			_pos = _divText.position().left;;
			_divText.css({"left":_pos})
		}
		else
		{
			var _firstPos = _divText.data("first-pos-marquee")
			if (_firstPos==undefined)
			{
				_firstPos = _divText.position().left;
				_divText.data("first-pos-marquee",_firstPos)
			}
			else
			{
				_divText.css({"left":_firstPos})	
			}

			_pos = _firstPos;	
		}
		
	//	window.status="pos="+_pos+"  _l_inner="+_l_inner
		if (_pos<=-_l_inner)
		{
			_pos = _compSize
			_divText.css(_prop,_pos)
		}
		_pos2 = -_l_size;
		_paramsAnimation={"left":_pos2}
	}
	else
	{
		if (_canRestart==false)
		{
			_pos = _divText.position().top;;
			_divText.css({"top":_pos})
		}
		else
		{
			var _firstPos = _divText.data("first-pos-marquee")
			if (_firstPos==undefined)
			{
				_firstPos = _divText.position().top;
				_divText.data("first-pos-marquee",_firstPos)
			}
			else
			{
				_divText.css({"top":_firstPos})	
			}

			_pos = _firstPos;	
		}
		
		
		
		if (_pos<=-_l_inner)
		{
			_pos = _compSize
			_divText.css(_prop,_pos)
		}
		_pos2 = -_l_size;
		_paramsAnimation={"top":_pos2}
	}

	var _duration = ((_pos-_pos2)*1000)/_params.speed

	var _animationOptions= {
		"duration":_duration,
		"easing":"linear",
		"complete":function() {_waStartMarqueeAnimation2(waJSQuery(this),true);},
		"step":function(now, fx) {_waCallBackAnimationStep(waJSQuery(this),now, fx);}
	};
	_divText.animate(_paramsAnimation,_animationOptions);
}

function _waStartMarqueeAnimation(_o)
{

	var _orientation = parseInt(extractParamInfo(_o,"orientation","param_marquee"))
	var _speed = parseInt(extractParamInfo(_o,"speed","param_marquee"))
	//_orientation=1
	//_speed = 10;
	var _divText = _o.find("div")
	var _prop="top"
	var _size = _divText.height()
	var _innerSize = _divText.innerHeight()
	var _compSize = _o.height();
	if (_orientation!=0) //horizontal
	{
		var _divText2 = _divText.find("div")
		var _html2 = _divText2.html()

		var _w0 = _divText.innerWidth(); 
		var _h = _divText2.innerHeight();
		var _minH = _h
		var _wMin = _w0;
		for (var _w = _w0;_w<10000;_w+=30)
		{
			_divText.css("width",_w)
			_h = _divText2.innerHeight();

			if (_h<_minH)
			{
				_minH = _h
				_wMin = _w
			}
		}
		
		_divText.css("width",_wMin+2)

	}

	if (_orientation!=0) //horizontal
	{
		 _compSize = _o.width();
		_prop="left"
		_size = _divText.width()
		_innerSize = _divText.innerWidth()
		//alert(_o.width()+"  "+_size)
		_divText.css(_prop,_compSize)
	//	alert(_innerSize)
		
	//	_divText.css(_prop,_innerSize)
	}
	else
	{
		 _compSize = _o.height();
		_prop="top"
		_size = _divText.height()
		_innerSize = _divText.innerHeight()
		_divText.css(_prop,_compSize)
	}
	

	
	
//	alert("_compSize="+_compSize+" _size="+_size+" _innerSize="+_innerSize+" _prop="+_prop+" orientation="+_orientation)
	_divText.data("data-marquee",{"speed":_speed,"orientation":_orientation,"size":_size,"innerSize":_innerSize,"prop":_prop,"compSize":_compSize,"size_cont":new Size(_o.width(),_o.height())})
	
	_divText.hover(function(){
		waJSQuery(this).stop();
	},
	function(){
		
		_waStartMarqueeAnimation2(waJSQuery(this),false)	
	});
	
	_waStartMarqueeAnimation2(_divText)	
}



function initializeWA_JQuery()
{
//	alert("initializeWA_JQuery")
////
	//hack pour certaines fontes web
	
	if (isMSIE())
	{

		var _arrayFamilies = new Array();
		var _descFamilies= waWebFontDescription.families
		for (var i=0;i<_descFamilies.length;i++)
		{
			var _fam = _descFamilies[i]
			_arrayFamilies.push(_fam+"::latin")
		}
		WebFontConfig = {
	    google: { families: _arrayFamilies }
	  };
		if (_arrayFamilies.length>0)
		{
			waLoadGoogleFonts()
		}
		
	}

	///
	IS_onload();


	
	///
	/*******************/
	/*    img       */
	/*******************/

	/////////
waJSQuery(".reflect").reflect();
	//warning waJSQuery

	waJSQuery(".wa-img").each(function() 
	{
	//	alert('wa-img')
		var _o = waJSQuery(this)
		
		
		var _over= extractParamInfo(_o,"over");
		
		
		if (isMobileBrowser()==false)
		if (_over.length>0)
		{
			_o.hover(
			  function () {
					var o = waJSQuery(this)
					var img = o
					var over= extractParamInfo(o,"over");
					
					var _imgDataOut = waJSQuery(this).data('src_out') //suite a un bug avecle cache
					if (_imgDataOut==undefined)
					{
						waJSQuery(this).data('src_out',img.attr('src'))
					}
					//img.attr('src')
					//waJSQuery(this).data('src',img.attr('src'))
					
					img.attr("src",over)
				  }, 
				  function () {
					
					var o = waJSQuery(this)
					var img = o
					
					img.attr("src",waJSQuery(this).data("src_out"))
					//alert('out '+waJSQuery(this).data("src"))
					///img.attr("src",waJSQuery(this).data("src"))
				  }
				);
		}

	})
	/*******************/
	/*  texte sous IE  */
	/*******************/
	
	waJSQuery(".wa-text").each(function() 
	{
		if (isMSIE())
		{
			var _w = waJSQuery(this).width()
			var _h = waJSQuery(this).height()
			var _innerDiv = waJSQuery(this).children("div")
			//waJSQuery ne supporte pas un shorthand sde type margin
			var _margin = parseInt(_innerDiv.css("marginTop"))
			if (isNaN(_margin))_margin = 0;
			
			var _border = parseInt(extractParamInfo(waJSQuery(this),"border","param"))
			//alert(_border)
			var _offset = _border;
			_innerDiv.css("margin",(_margin+_offset)+"px")

		}

		
		//_waStartMarqueeAnimation(waJSQuery(this))
	})
		/*******************/
		/*  texte defilant  */
		/*******************/
		
		waJSQuery(".wa-textmarquee").each(function() 
		{
		//	alert("test")
			_waStartMarqueeAnimation(waJSQuery(this))
		})
		
		
		/*******************/
		/*    button       */
		/*******************/	

	waActivateOverButtons()
	
	waHackGradient()
	waHackButtons()

waGlobalPatchIE()


}

function waGlobalPatchIE()
{
	if (isMSIE())
	{
		if (window.waPatchIE)
		{
			waPatchIE()
		}	
	}
}


/*!
	reflection.js for waJSQuery v1.1
	(c) 2006-2011 Christophe Beyls <http://www.digitalia.be>
	MIT-style license.
*/

(function(waJSQuery) {


waJSQuery.fn.extend({
	

	reflect: function(options) {
		
		var _o = waJSQuery(this)
		
		var _radius = waExtractRadiusFromCss(_o)
	//	alert(_radius)
		options = waJSQuery.extend({
			height: 1/3,
			opacity: 0.5,
			borderRadius:_radius
		}, options);

		return this.unreflect().each(function() {
			var img = this;
			if (/^img$/i.test(img.tagName)) {
				function doReflect() {
					var imageWidth = img.width, imageHeight = img.height, reflection, reflectionHeight, wrapper, context, gradient;
					//reflectionHeight = Math.floor((options.height > 1) ? Math.min(imageHeight, options.height) : imageHeight * options.height);
					reflectionHeight = Math.floor(imageHeight*options.height)
					reflection = waJSQuery("<canvas />")[0];
					if (reflection.getContext) {
						context = reflection.getContext("2d");
						try {
							
						//	waJSQuery(reflection).attr({width: imageWidth, height: reflectionHeight});
							waJSQuery(reflection).attr({width: imageWidth, height: imageHeight});
							
							context.save();
							context.translate(0, imageHeight-1);
							context.scale(1, -1);
							context.drawImage(img, 0, 0, imageWidth, imageHeight);
							context.restore();
							context.globalCompositeOperation = "destination-out";

							gradient = context.createLinearGradient(0, 0, 0, reflectionHeight);
							gradient.addColorStop(0, "rgba(255, 255, 255, " + (1 - options.opacity) + ")");
							gradient.addColorStop(1, "rgba(255, 255, 255, 1.0)");
							context.fillStyle = gradient;
						//	context.rect(0, 0, imageWidth, reflectionHeight);
							context.rect(0, 0, imageWidth, imageHeight);
							context.fill();
							
						} catch(e) {
							return;
						}
					} else {
						if (!waJSQuery.browser.msie) return;
						reflection = waJSQuery("<img />").attr("src", img.src).css({
							width: imageWidth,
							height: imageHeight,
							marginBottom: reflectionHeight - imageHeight,
							filter: "FlipV progid:DXImageTransform.Microsoft.Alpha(Opacity=" + (options.opacity * 100) + ", FinishOpacity=0, Style=1, StartX=0, StartY=0, FinishX=0, FinishY=" + (reflectionHeight / imageHeight * 100) + ")"
						})[0];
					}
					var _radius1 = options.borderRadius
				//	alert(_radius1[3])
					var _radius2 = new Array(_radius1[3],_radius1[2],_radius1[1],_radius1[0])
					
					var _cssRadius1 = _radius1.join("px ")+"px"
					var _cssRadius2 = _radius2.join("px ")+"px"
					waJSQuery(reflection).css({display: "block",borderRadius:_cssRadius2});
			//		waJSQuery(reflection).css({display: "block",WebkitBorderRadius:_cssRadius2,MozBorderRadius: _cssRadius2, BorderRadius: _cssRadius2});

					wrapper = waJSQuery(/^a$/i.test(img.parentNode.tagName) ? "<span />" : "<div />").insertAfter(img).append([img, reflection])[0];
					wrapper.className = img.className;
					waJSQuery.data(img, "reflected", wrapper.style.cssText = img.style.cssText);
					waJSQuery(wrapper).css({width: imageWidth, height: imageHeight + reflectionHeight, overflow: "hidden"});
				//	img.style.cssText = "display: block; border: 0px";

					img.style.cssText = "display: block;border:0px none;-webkit-border-radius:"+_cssRadius1+";-moz-border-radius:"+_cssRadius1+";border-radius:"+_cssRadius1+";width:"+imageWidth+"px;height:"+imageHeight+"px;"
				//	waJSQuery(img).css(display,"block")
					
					//waJSQuery(wrapper).css("rotate":)
					img.className = "reflected";
				}

				if (img.complete) doReflect();
				else waJSQuery(img).load(doReflect);
			}
		});
	},

	unreflect: function() {
		return this.unbind("load").each(function() {
			var img = this, reflected = waJSQuery.data(this, "reflected"), wrapper;

			if (reflected !== undefined) {
				wrapper = img.parentNode;
				img.className = wrapper.className;
				img.style.cssText = reflected;
				waJSQuery.removeData(img, "reflected");
				wrapper.parentNode.replaceChild(img, wrapper);
			}
		});
	}
});

})(waJSQuery);


/**
 * waJSQuery Plugin to obtain touch gestures from iPhone, iPod Touch and iPad, should also work with Android mobile phones (not tested yet!)
 * Common usage: wipe images (left and right to show the previous or next image)
 * 
 * @author Andreas Waltl, netCU Internetagentur (http://www.netcu.de)
 * @version 1.1.1 (9th December 2010) - fix bug (older IE's had problems)
 * @version 1.1 (1st September 2010) - support wipe up and wipe down
 * @version 1.0 (15th July 2010)
 */
(function(waJSQuery) { 
   waJSQuery.fn.touchwipe = function(settings) {
     var config = {
    		min_move_x: 20,
    		min_move_y: 20,
 			wipeLeft: function() { },
 			wipeRight: function() { },
 			wipeUp: function() { },
 			wipeDown: function() { },
			preventDefaultEvents: true
	 };
     
     if (settings) waJSQuery.extend(config, settings);
 
     this.each(function() {
    	 var startX;
    	 var startY;
		 var isMoving = false;

    	 function cancelTouch() {
    		 this.removeEventListener('touchmove', onTouchMove);
    		 startX = null;
    		 isMoving = false;
    	 }	
    	 
    	 function onTouchMove(e) {
    		 if(config.preventDefaultEvents) {
    			 e.preventDefault();
    		 }
    		 if(isMoving) {
	    		 var x = e.touches[0].pageX;
	    		 var y = e.touches[0].pageY;
	    		 var dx = startX - x;
	    		 var dy = startY - y;
	    		 if(Math.abs(dx) >= config.min_move_x) {
	    			cancelTouch();
	    			if(dx > 0) {
	    				config.wipeLeft();
	    			}
	    			else {
	    				config.wipeRight();
	    			}
	    		 }
	    		 else if(Math.abs(dy) >= config.min_move_y) {
		    			cancelTouch();
		    			if(dy > 0) {
		    				config.wipeDown();
		    			}
		    			else {
		    				config.wipeUp();
		    			}
		    		 }
    		 }
    	 }
    	 
    	 function onTouchStart(e)
    	 {
    		 if (e.touches.length == 1) {
    			 startX = e.touches[0].pageX;
    			 startY = e.touches[0].pageY;
    			 isMoving = true;
    			 this.addEventListener('touchmove', onTouchMove, false);
    		 }
    	 }    	 
    	 if ('ontouchstart' in document.documentElement) {
    		 this.addEventListener('touchstart', onTouchStart, false);
    	 }
     });
 
     return this;
   };
 
 })(waJSQuery);


////

/*
 WA_GetCookie(name) 
 WA_SetCookie (name, value)

*/




/*
waJSQuery(function() {
	var _param= {
	"enable_preview_redirect":false,
	"enabled_internal_redirect":false,
	"redirect":{
		"fr":"http://fr-fr.numento.com",
		"pt":"http://pt-br.numento.com",
		"es":"http://es-es.numento.com",
		"it":"http://it-it.numento.com",
		"ja":"http://ja-jp.numento.com",
		"de":"http://de-de.numento.com",
		},
	"restricted_host":["numento.com","www.numento.com"]
	}
	waAutoDetectAndRedirectLang(_param);
});
*/

//function waChgtLanguage('fr',"fr-fr.webacappella.com")

function waChgtLanguage(_lng,_host)
{
	var _langs = Translator.m_languages;
	var _pathname = window.location.pathname;
	var _curHref = window.location.href;
	var _curHost = window.location.host
	
	var _n = _pathname.lastIndexOf("/")
	var _path = ""
	var _filename = _pathname

	if (_n>-1)
	{
		_path= _pathname.substring(0,_n+1)
		_filename= _pathname.substring(_n+1)
	}
	
	
	if (_filename.length==0)
	{
		_filename = "index.html"
		_curHref+=_filename;
	}
	if (document.webaca_is_preview)
	{
		
		if (_langs!=undefined)
		{
			var _lngFilename = _langs[_lng]
			if (_lngFilename)
			{
				window.location.replace(_lngFilename)	
				return;
			}	
		}
	}
	else
	{
		var _newUrl  =_curHref
		_newUrl = _newUrl.replace(_curHost,_host);
		
		if (_langs!=undefined)
		{
			var _lngFilename = _langs[_lng]
			
			_newUrl = _newUrl.replace(_filename,_lngFilename);
		//	alert(_newUrl)
		
	//	alert(_newUrl)
			window.location.replace(_newUrl)	
		}
	
	}
	
}

function waAutoDetectAndRedirectLang(_param)
{
	if ((_param.enable_preview_redirect!=true) && document.webaca_is_preview)
	{
		return;
	}
	
	if (isProbablyRobot())
	{
		return;
	}
	//alert("waAutoDetectAndRedirectLang "+window.location.host+" "+_param.restricted_host+" "+document.webaca_is_preview)
	if ((_param.restricted_host!=undefined) && (document.webaca_is_preview!=true))
	{
		var _match = false;
		for (var i=0;i<_param.restricted_host.length;i++)
		{
			var _host = _param.restricted_host[i]
			if (window.location.host == _host)
			{
				_match = true;
				break;
			}
		}
		if (_match==false)
		{
			return;
		}

	}

	var _language = navigator.language;
	if (navigator.browserLanguage)
	_language = navigator.browserLanguage;


	var _n = _language.indexOf("-")
	if (_n>0)
	{
		_language = _language.substr(0,_n)
	}
	
	//language contient le code lanf  "fr"  "en"
	

	if (Translator.m_lang != _language)
	{
		//langue courant pas egale a la langue de la page
		if (_param.enabled_internal_redirect!=false)
		{
			var _langs = Translator.m_languages;
			if (_langs)
			{
				var _lng = _langs[_language]
				if (_lng)
				{
					window.location.replace(_lng)	
					return;
				}	
			}	
		}

	
		if (_param.redirect!=undefined)
		{
			var _host = _param.redirect[_language]
			if (_host!=undefined)
			{
				
				waChgtLanguage(_language,_host);
				//  waChgtLanguage(_lng,_host)
				//window.location.replace(_host)	
			}
		}

		
	}
}


-->
