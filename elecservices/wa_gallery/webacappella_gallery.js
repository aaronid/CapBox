
waJSQuery(window).load(function () {
	initializeAllWA_gallery();
	
});

function _launchDelayedResize() 
{
	
	var _cont = waJSQuery(".wa-fullscreen-contenair:visible");

	var _gallery = _cont.find(".wa-gallery")
	if (_gallery.length>0)
	{
		var _oldWinSize = _cont.data("wa-window-size")

		if ((_oldWinSize==undefined) ||  ((_oldWinSize.width()!=getWindowSize().width()) || (_oldWinSize.height()!=getWindowSize().height())))
		{
			var _root = _waGalleryGetRoot(_gallery)

			var _timer =_root.data("timer_resize")
			if (_timer!=null)
			{
				clearTimeout(_timer)
				_root.data("timer_resize",null)
			}
			_timer = wa_timeout(function() { _waDelayedResize(_gallery)},200);
			_root.data("timer_resize",_timer)
			_cont.data("wa-window-size",getWindowSize())
		}	

		
	}
}

waJSQuery(window).scroll(function() 
{
	_launchDelayedResize() 
	
});

waJSQuery(window).resize(function() 
{
	_launchDelayedResize() 
});


function centerGalleryContainer() 
{
	return;
var _cont = waJSQuery('#wa-dialog-container');
var _xBg = waJSQuery(window).scrollLeft();
var _yBg = waJSQuery(window).scrollTop();

	var _bgSize = getWindowSize() 

	var _gallery = _cont.find(".wa-gallery")
	if (_gallery.length>0)
	{
		_cont.css({left:_xBg,top:_yBg ,width:_bgSize.width(), height:_bgSize.height() })
		_cont.show()
	}

}


/*

http://www.ajaxload.info/ //gif animé
*/

function _waAlbumGotoPage(_o,_p2)
{
	if (_p2<0)_p2= 0;
	var _p1 = _waAlbumCurrentPage(_o);
	if (!_o.data("datas"))
	{
		alert('browser error')
		return;
	}

	var _nbImages = _waGalleryNbImages(_o)
	var _nbImgsPerPage = _waAlbumNbImgPerPage(_o);
	if (_nbImgsPerPage<=0) return;

	if (_p2+1>Math.ceil(_nbImages/_nbImgsPerPage)) return;
	
	if (_p1==_p2) return;
	
	
	var _pageSelector = _o.find(".wa-gallery-page-selector")
	
	//_pageSelector.hide()
	var _layout = _waAlbumFirstLayout(_o)
	var _secLayout =  (_layout==0)?1:0;

	var _pageFirst = _waAlbumGetPageLayout(_o,_layout); 
	var _pageSecond = _waAlbumGetPageLayout(_o,_secLayout);

	var _pane = _o.find(".wa-gallery-scroll-pane");
	var _duration= 500;

	if (_waAlbumIsBusy(_o))return;
	_waAlbumSetBusyFlag(_o,true)
	
	var _mode = _o.data("mode")

	var _typeGallery = _o.data("type_gallery")
	
//	alert(_mode)
	
	var _effect0=_o.data("datas").global_config.transition_effect/100;
	
	
	if (_mode!="fullscreen")
	{
		//alert(_typeGallery)
		if (_typeGallery==0)
		{
			_effect0 = 1;
		}
		
	}
	
	var _effect=_effect0;


	var _fadeEffect = true;
	
	if (_effect0>0.85)
	{
		_fadeEffect = false
		//_effect = 1
	}
	
	if (isMobileBrowser() && (isIPad()==false))
	{
		if (_effect0<0.5)
		{
			_effect = 0
		}
		else
		{
			_fadeEffect = false
			_effect = 1
		}
	}

//	alert(_fadeEffect)
	if (_fadeEffect)
	{
		_pageSecond.fadeIn(_duration)
		_pageFirst.fadeOut(_duration)
	}
	else
	{
		_pageSecond.show()
		
		//_pageFirst.hide()

	}


	var _newX =0;
	var _paneLeft = _pane.position().left
	
	

	if (_p2>_p1)
	{
		_newX = _pageFirst.position().left+_effect*_pageFirst.width();
		_paneLeft -=  _effect*_pageFirst.width();
	}
	if (_p2<_p1)
	{
		_newX = _pageFirst.position().left-_effect*_pageFirst.width();
		_paneLeft += _effect*_pageFirst.width();	
	}
	
	//prepare hidden page
	
	_pageFirst.css("z-index",1)
	_pageSecond.css("z-index",0)
	
	
	_pageSecond.css("left",_newX)	

	var _divImgs = waJSQuery(">.wa-gallery-image-contenair",_pageSecond);

	var _iImg0 = _p2*_nbImgsPerPage
	_divImgs.each(function(i) 
	{
		if (_iImg0 + i<_nbImages)
		{
			_waGallerySetImage(waJSQuery(this),_o,_iImg0 + i)
		}
		else
		{
			_waGallerySetImage(waJSQuery(this),_o,null)
		}
	});
	
	//////
	//
	//alert(_pane.position().left+" "+_paneLeft+"  "+(_pane.position().left == _paneLeft))
//	if (_pane.position().left != _paneLeft)
	{
		_pane.animate({left: _paneLeft}, _duration,function() {

			_waGalleryOnTransitionFinished(_o,_p2)

		  });	
	}


}


function _waGalleryOnTransitionFinished(_o,_p2)
{
	var _layout = _waAlbumFirstLayout(_o)
	var _secLayout =  (_layout==0)?1:0;

	// Animation complete.
	_waAlbumSetBusyFlag(_o,false)
    _o.data("page",_p2)
	_o.data("first-layout",_secLayout)
	///
	var _pane = _o.find(".wa-gallery-scroll-pane");

	var _pageFirst = _waAlbumGetPageLayout(_o,_layout); 
	var _pageSecond = _waAlbumGetPageLayout(_o,_secLayout);
	
	_pageFirst.css("left",_pageFirst.position().left+_pane.position().left)
	_pageSecond.css("left",_pageSecond.position().left+_pane.position().left)
	_pane.css("left",0)
	
	_pageFirst.hide()
	
	_waGalleryUpdateButtonsNavigation(_o)

	var _iImg0 = _p2* _waAlbumNbImgPerPage(_o) 
	_waGalleryGetRoot(_o).data("current_image",_iImg0);
	
	
	_waGalleryUpdateComment(_o)
}
function _waGalleryIsAutoDiapo(_o)
{
	var _root = _waGalleryGetRoot(_o);
	var _typeGallery = _o.data("type_gallery")
	var _autoDiapo = parseInt(_root.data("auto_diapo"))
	return ((_typeGallery==1)&&(_autoDiapo==1))
	//var _nav= _o.find(".wa-gallery-navigation")

}

function _waGalleryUpdateComment(_o)
{


//alert("_waGalleryUpdateComment")
	var _mode = _o.data("mode")
	var _typeGallery = _o.data("type_gallery")
	var _nav= _o.find(".wa-gallery-navigation")
	
	var _gallery = _waGalleryGetRoot(_o);
	var _globalConfig = _o.data("datas").global_config;
	
	
	var _commentZone= _o.find(".wa-gallery-comment-zone")
	_commentZone.empty()

	var _ind = _waAlbumCurrentPage(_o)
	var _sComment = "";

	if (_mode=="fullscreen")
	{
		if (_globalConfig.comment_display_ImageNumber)
		{
			_sComment+=(_ind+1)+" / "+_waGalleryNbImages(_o);
		}	
	}

	var _lnkUrl = _waGalleryMapImageInfo(_o,_ind,"link")
//alert(_mode+"  "+_typeGallery)
	if (_sComment.length>0)
	{
		_sComment+="<br>";
	}
	_sComment+=_waGalleryMapImageInfo(_o,_ind,"comment")

	_sComment = _sComment.replace(/<br>/gi,"\n")
	_sComment = waJSQuery.trim(_sComment)
	_sComment = _sComment.replace(/\n/gi,"<br>")

	
	if ((_sComment.length==0)||(_o.data("datas").global_config.show_comment==false))
	{
		_commentZone.hide()	
		return;
	}
	if ((_mode=="normal")&&(_typeGallery==1))
	{

	}
	else
	{
		if ((_mode!="fullscreen"))
		{
			_commentZone.hide()	
			return;
		}
	}

	var _w = getWindowSize().width();
	var _h = getWindowSize().height();

	var _sMaxReso = _waGalleryGetFullscreenMaxSize(_o)
	
	
	var _margin = 10;
		
	_commentZone.css("padding",_margin)
	_commentZone.show()

	if (isMSIE_lower_than_ie9())
	{
		_commentZone.append("<div class=\"wa-gallery-comment-bg\" style=\"position:absolute;background-color:#000000;filter:alpha(opacity=50); opacity:0.5;\"></div>")
	}
	
	_commentZone.append("<div class=\"wa-gallery-comment\" ></div>")
	
	var _heightMax = 80;

	var _comment= _commentZone.find(".wa-gallery-comment")
	_comment.css("width",_sMaxReso.width())
	//_comment.css("filter","alpha(opacity=100); opacity:1")

	_comment.html(_sComment)
	var _innerW = _comment.outerWidth(true)
	var _innerH = _comment.outerHeight(true)
	var newHeight = Math.min(_heightMax,_innerH)

	var _xBg = waJSQuery(window).scrollLeft();
	var _yBg = waJSQuery(window).scrollTop();

	var _left = (_w - _innerW)/2

	var _top = _h - newHeight-2*_margin

	if (_mode=="fullscreen")
	{
		_left+=_xBg
		_top+=_yBg
	}
	_comment.css("left",_left);
	_comment.css("height",newHeight);
	_comment.css("width",_innerW);

	
	_commentZone.css("left",0);
	_commentZone.css("top",_top);
	_commentZone.css("width",_w);
	_commentZone.css("height",newHeight+2*_margin);
	

	if ((_mode=="normal")&&(_typeGallery==1))
	{
		_sComment = _sComment.replace(/<br>/gi," ")
		
		//alert(_sComment)
		_comment.html(_sComment)
		
		var _decY = 0;
		
		if (_lnkUrl.length>0)
		{
			_decY = 16;
		}
		var _ly = 15+_decY;
		var _wContenair = _o.width()
		var _hContenair = _o.height()
		_comment.css("textAlign","left");
		_comment.css("left",0);
		_comment.css("top",0);
		_comment.css("height",_ly);
		_comment.css("width",_wContenair);
		_comment.css("fontSize",13);
		_comment.css("margin",3);
		
		_comment.css("overflow","hidden");
		_comment.css("whiteSpace","nowrap");
		_comment.css("textOverflow","ellipsis");

		_commentZone.css("left",0);
		_commentZone.css("top",_hContenair-_ly-50);
		_commentZone.css("width",_wContenair);
		_commentZone.css("height",_ly);
		
		var _layout = _waAlbumFirstLayout(_o)
		var _pageFirst = _waAlbumGetPageLayout(_o,_layout);
		
		var _img = _pageFirst.find(".wa-gallery-image");
		//
		var _divImgs = _pageFirst.find(".wa-gallery-image-contenair");

		var _yComm1 = _divImgs.position().top+_hContenair-35
		var _yComm2 = _divImgs.position().top+_img.height()-35-_decY
		var _yComm = Math.min(_yComm1,_yComm2)
		
		
		//_yComm = _divImgs.position().top+_img.height()-35-_decY
		
		//_yComm = _divImgs.position().top+_hContenair-35;
		
		_commentZone.css("top",_yComm);

		var _xComm =  (_wContenair-_img.width())/2
		
		
		_commentZone.css("left",_xComm);
		_comment.css("width",_img.width()-20);
		_commentZone.css("width",_img.width()-20);




	}
	else
	{
		_commentZone.hide()
		_commentZone.fadeIn()
	}

	if (isMSIE_lower_than_ie9())
	{
		var _commentBg= _commentZone.find(".wa-gallery-comment-bg")
		_commentBg.css({"left":0,"top":0,"width":_commentZone.outerWidth(true),"height":_commentZone.outerHeight(true)});
		
	}
}

/**
http://www.flickr.com/services/api/misc.urls.html
*/


function _waGalleryMapJsonThirdPartyRoot(_o,_datas)
{
	var _arrDatas = null
	if (_datas["photos"])
	{
		_arrDatas = _datas.photos
	}
	else
	if (_datas["photoset"])
	{
		_arrDatas = _datas.photoset
	}
	return _arrDatas;
}

function _waGalleryMapImageInfo(_o,_n,_key)
{
	var _onlineGalleryData = _waGalleryGetRoot(_o).data("3rdparty_datas")
	if (_onlineGalleryData)
	{	
		var _normalConfig= _o.data("config")
		var _thumbSize = _normalConfig.image_size;

		var _arrDatas = _waGalleryMapJsonThirdPartyRoot(_o,_onlineGalleryData)
		var _imgData = _arrDatas.photo[_n]

		var _farmId = _imgData.farm
		var _serverId = _imgData.server
		var _idImage = _imgData.id
		var _secret = _imgData.secret
		//var _url = "http://farm"+_farmId+".static.flickr.com/"+_serverId+"/"+_idImage+"_"+_secret+"_"
		
		if (_key=="comment")
		{
			return _imgData.title
		}
		var _codes = ["t","s","m","z","l"]
		
		var _BiggerUrl = "";
		var _BiggerWidth = 0;
		var _BiggerHeight = 0;
		for (var i=0;i<_codes.length;i++)
		{
			var _code=_codes[i]
			var _sUrl = _imgData["url_"+_code]
			if (_sUrl)
			{
				var _w = parseInt(_imgData["width_"+_code])
				var _h = parseInt(_imgData["height_"+_code])
				
				if ((_BiggerUrl.length==0)|| ((_w>_BiggerWidth)&&(_h>_BiggerHeight)))
				{
					_BiggerUrl = _sUrl;
					_BiggerWidth = _w
					_BiggerHeight = _h
				}
			}
		}
		
		if (_key=="th")
		{
			var _curUrl = ""
			for (var i=0;i<_codes.length;i++)
			{
				var _code=_codes[i]
				var _sUrl = _imgData["url_"+_code]
				if (_sUrl)
				{
					var _w = parseInt(_imgData["width_"+_code])
					var _h = parseInt(_imgData["height_"+_code])

					_curUrl = _sUrl

					if  ( (_w>_thumbSize)&&(_h>_thumbSize) )
					{
						break;
					}
				}
			}
			
			
			
		//	alert("return "+_curUrl+"   "+_w+"x"+_h+"   "+_thumbSize)
			return _curUrl;
		}
		if (_key=="big")
		{
			return _BiggerUrl//_url+"b"+".jpg"
		}
		if (_key=="sl_img")
		{
			return _BiggerUrl//_url+"b"+".jpg"
		}
		if (_key=="src")
		{
			return _BiggerUrl//_url+"b"+".jpg"
		}
		if (_key=="size")
		{
			return new Size(_BiggerWidth,_BiggerHeight)
		}
		return ""
	}

	if (_n>=_o.data("datas").images.length)
	{
		return ";"
	}
	var _imgData= _o.data("datas").images[_n]
	var _folder = _o.data("folder");
	if (_key=="th")
	{
		return _folder+"th_"+_imgData.fn+"?"+_imgData.mod_th
	}
	if (_key=="big")
	{
		return _folder+"big_"+_imgData.fn+"?"+_imgData.mod
	}
	
	if (_key=="sl_img")
	{
		return _folder+"sl_"+_imgData.fn+"?"+_imgData.mod
	}
	if (_key=="src")
	{
		return _folder+_imgData.fn+"?"+_imgData.mod
	}
	if (_key=="size")
	{
		return new Size(_imgData.size.w,_imgData.size.h)
	}	
	if (_key=="link")
	{
		if (_imgData.lnk && (_imgData.lnk.url.length>0))
		{
			var _url = _imgData.lnk.url;
			return _url;
		}
		return "";
	}
	if (_key=="comment")
	{
		var _comment=""
		if ( _imgData.comment)
		_comment+= _imgData.comment
		_comment = _comment.replace(/\n/gi,"<br>")
		if (_comment.length>0)_comment+="<br>"
		if (_imgData.lnk && (_imgData.lnk.url.length>0))
		{
			var _url = _imgData.lnk.url;
			var _onclick = waJSONLinkToOnClick(_imgData.lnk)
			_comment+="<div class='wa-gallery-comment-link' "+_onclick+" >"+_url+"</div>"
		}
		return _comment;
	}
	if (_key=="tooltip")
	{
		//alert(_imgData.tooltip)
		return (_imgData.tooltip)
	}
	
}




function _waGallerySetImage(_divImg,_o,_index)
{
	var _gallery = _waGalleryGetRoot(_o);
	var _globalConfig = _o.data("datas").global_config;
	var _typeGallery = _o.data("type_gallery");
	// htmlDynamicLoader
	var _loader = waJSQuery(">.wa-dyn-loader",_divImg);
	
	waActivateDynamicLoader(_divImg)
	var _img = waJSQuery(">.wa-gallery-image",_divImg);

	if (_index==null)
	{
		_loader.hide()
		_img.hide()
		_divImg.hide()
		return;
	}
	
	
	//alert("_waGallerySetImage")
	
	_loader.show()
	
	_img.hide()
	//return;

	_divImg.show()
	var _hasPointer = false;

	//_img.show()
	var _mode = _o.data("mode")
	var _folder = _o.data("folder");
	var _src =  "";
	var _gallerySource = extractParamInfo(_gallery,"source")
	
	
	var _fullscreenInWindow = _waGalleryFullscreenHasWindowContenair(_o);

	//_hasPointer =  true;
	
	if ((_mode=="normal") && (_typeGallery==0))
	{
		_hasPointer =  true;
	}
	
	if ((_mode=="normal") && (_typeGallery==1) && (_globalConfig.open_popup_when_clicking==true))
	{
		_hasPointer =  true;
	}
	/*
	if ((_mode=="fullscreen") && _fullscreenInWindow)
	{
		_hasPointer =  false;
	}
	if (_gallery.data("auto_diapo")==true)
	{
		_hasPointer =  false;
	}
	*/
//alert(_mode+" "+_fullscreenInWindow)
	if ((_mode=="fullscreen") || (_fullscreenInWindow==false))
	{	
		var _w = getWindowSize().width();
		var _h = getWindowSize().height();
		
		var _margin = 25;
		var _marginBottom = 0;
		if (_fullscreenInWindow==false)
		{
			 _w = _o.width();
			 _h = _o.height();	
			_margin = _globalConfig.inner_slideshow_image_margin;

		}

		//
		var _sMax = new Size(_w-2*_margin,_h-2*_margin-_marginBottom)
		var _s = _waGalleryMapImageInfo(_o,_index,"size");

		var _fitSlideshowImage = (((_typeGallery==1)|| (_typeGallery==2)) && (_globalConfig.fit_image_to_slideshow==true));
		
		
		var _rescaleImage = true;

		if ((_mode=="normal") && _fitSlideshowImage)
		{
			_rescaleImage = false;
		}
		
		if (_rescaleImage)
		{
			_s.scale(_sMax)
		}
		else
		{
			_s= new Size(_o.width(),_o.height());
		}


		if (_mode=="fullscreen") 
		{
			var _sMaxReso = _waGalleryGetFullscreenMaxSize(_o)
			_s.scale(_sMaxReso)
		}


		if (_mode=="normal")
		{
			_src = _waGalleryMapImageInfo(_o,_index,"sl_img");
		}
		else
		{
			_src = _waGalleryMapImageInfo(_o,_index,"big");
		}
		

		var _clipMainImage = false;
		if (_gallerySource.length>0)
		{
			if (_fitSlideshowImage)
			{
				_clipMainImage = true;
			}
			//manage clipping with flickr
			//alert(_gallerySource)
		}
		// 
		


		_img.css("width",_s.width())
		_img.css("height",_s.height())
		
		_divImg.css("width",_s.width())
		_divImg.css("height",_s.height())
		
		
		if (_clipMainImage)
		{
			var _sizeOriginal = _waGalleryMapImageInfo(_o,_index,"size");
			var _newSize = _sizeOriginal ;
			_newSize.scaleByExpanding(_s.clone())
			
			_img.css("width",_newSize.width())
			_img.css("height",_newSize.height())
			var _xImg = -(_newSize.width()-_s.width())/2;
			var _yImg = -(_newSize.height()-_s.height())/2;
			_img.css({"left":_xImg,"top":_yImg})
		}
		
		
		var _left = Math.round((_w-_s.width())/2)
		var _top = Math.round((_h-_marginBottom-_s.height())/2)
		
		
		var _xBg = waJSQuery(window).scrollLeft();
		var _yBg = waJSQuery(window).scrollTop();
		
		if (_mode!="normal") 
		{
			_left+=_xBg
			_top+=_yBg
		}
		
		_divImg.css("left",_left)
		_divImg.css("top",_top)

	}
	else
	{
		var _manageClipping = false;
		//var _gallerySource = extractParamInfo(_gallery,"source")
		if (_gallerySource.length>0)
		{
			_manageClipping=true;
		}

		if (_manageClipping)
		{
			var _normalConfig= _o.data("config")
			var _thumbSize = _normalConfig.image_size;
			/*
			clip:rect(haut, droite, bas, gauche)
			*/
			var _sizeThumb = new Size(_thumbSize,_thumbSize)
			var _s = _waGalleryMapImageInfo(_o,_index,"size");
			var _newSize = _s.clone();

			_newSize.scaleByExpanding(_sizeThumb)
			
			//alert(_newSize+"  "+_sizeThumb)
			if (_newSize.width()==_newSize.height())
			{
				var _imgSizeW = Math.min(_thumbSize,_s.width())
				var _imgSizeH = Math.min(_thumbSize,_s.height())

				_img.css({"width":_imgSizeW, "height":_imgSizeH, "clip":"rect(auto auto auto auto)", "left":(_sizeThumb.width()-_imgSizeW)/2, "top":(_sizeThumb.height()-_imgSizeH)/2 });
			}
			else
			{
				_img.css({width:_newSize.width(), height:_newSize.height()});
				if (_newSize.width()>_newSize.height())
				{
					var _wDec = Math.floor((_newSize.width()-_sizeThumb.width())/2);;
					_img.css({"left":-_wDec, "top":(_sizeThumb.height()-_newSize.height())/2,"clip":"rect(auto "+(_newSize.width() -_wDec)+"px auto "+_wDec+"px)"});
				}
				else
				{
					var _hDec = Math.floor((_newSize.height()-_sizeThumb.height())/2);;
					_img.css({"left":(_sizeThumb.width()-_newSize.width())/2,"top":-_hDec,"clip":"rect("+_hDec+"px auto "+(_newSize.height() -_hDec)+"px auto)"});
				}
			}
		}

		_src =  _waGalleryMapImageInfo(_o,_index,"th");
	}


	_divImg.css('cursor',(_hasPointer)?'pointer':'Default');
	
	var _oldSrc = _img.attr("src")	
	
	if (_oldSrc != _src)
	{
		_img.load(function() {
			var _img = waJSQuery(this);
			/////////////
			_loader.hide()
			_img.show()
		});	
	}
	else
	{
		/////////////
		_loader.hide()
		_img.show()
	}


	_img.attr("title",_waGalleryMapImageInfo(_o,_index,"tooltip"))
	_img.attr("src",_src)	
	
	_loader.css("left",(_img.width()-_loader.width())/2)
	_loader.css("top",(_img.height()-_loader.height())/2)
	
}



function _waGalleryLoaded(_o)
{
	var _root = _waGalleryGetRoot(_o);
	var _autoDiapo = parseInt(_root.data("auto_diapo"))
	var _typeGallery = parseInt(_root.data("type_gallery"))
	var _nbImages = _waGalleryNbImages(_o)
	
	if (isMSIE()) //hack pour detection hover sur fond transparent
	{
		_o.css("background-image","url(wa_transparent.gif)")
	}

	var _mode = _o.data("mode")
	var _normalConfig= _o.data("config")
	var _globalConfig= _o.data("datas").global_config
	var _htmlPage =""
	_htmlPage+= "<div style=\"position:absolute;left:"+_normalConfig.margin_left+"px;top:"+_normalConfig.margin_top+"px;padding:0px;";
	
	

//	_htmlPage+= "<div style=\"position:absolute;left:"+_normalConfig.margin_left+"px;top:0px;padding:0px;";

    _htmlPage+= "width:"+_o.width()+"px;\" class=\"wa-gallery-page\">"


	var _classShadowCssImg=""
//	alert(_autoDiapo)
//	if (_typeGallery==0)
	if ( _normalConfig.has_shadow )
	{
		_classShadowCssImg+="wa-gallery-shadow "
	}
 	
	var n = 0;
	var _y = _normalConfig.image_spacing;
	for (var _r=0;_r<_normalConfig.rows;_r++)
	{
		var _x = _normalConfig.image_spacing;
		for (var _c=0;_c<_normalConfig.cols;_c++)
		{
			_htmlPage += "<div class='wa-gallery-image-contenair "+_classShadowCssImg+"' style=\"position:absolute;left:"+_x+"px;top:"+_y+"px;width:"+_normalConfig.image_size+"px;height:"+_normalConfig.image_size+"px;\">"
			_htmlPage += "<img class='wa-gallery-image' style=\"position:absolute;left:0px;top:0px;width:"+_normalConfig.image_size+"px;height:"+_normalConfig.image_size+"px;border:none;\"/>"

			/////
			_htmlPage += htmlDynamicLoader(true,_o.width(),_o.height())
			/////
			
			_htmlPage += "</div>"
			_x+=_normalConfig.image_size+2*_normalConfig.image_spacing
			if (n>_nbImages)
			{
				break
			}
			n++;
		}	
		_y+=_normalConfig.image_size+2*_normalConfig.image_spacing

	}

	_htmlPage+="</div>";
	//
	var _pane= _o.find(".wa-gallery-scroll-pane")
	_pane.append(_htmlPage);
	_pane.append(_htmlPage);


	/////
	var _pageFirst = _waAlbumGetPageLayout(_o,0); 
	

	
	//	alert("test "+_nbImages)
	var _folder = _o.data("folder");
	if (_o.data("datas")==undefined)
	{
		alert("_folder="+_folder)
	}

	var _selectedIndexImg = _normalConfig.default_selected_image;

	var _p = 0;
	if (_selectedIndexImg)
	{
		_p = Math.floor(_selectedIndexImg/_waAlbumNbImgPerPage(_o))
	}
	_o.data("page",_p)

	var _divImgs = waJSQuery(">.wa-gallery-image-contenair",_pageFirst);
	
	var _iImg0 = _waAlbumCurrentPage(_o) * _waAlbumNbImgPerPage(_o) 
	
	

	_divImgs.each(function(i) 
	{
		if (_iImg0 + i<_nbImages)
		{
			_waGallerySetImage(waJSQuery(this),_o,_iImg0 + i)
		}
		else
		{
			_waGallerySetImage(waJSQuery(this),_o,null)
		}
	});

	var _pageSecond = _waAlbumGetPageLayout(_o,1); 
	_pageSecond.hide()
	
	
	///image onclick handler
	var _pages= _o.find(".wa-gallery-page")
	
	var _canClickToPopup = true;
	if ((_typeGallery==1)||(_typeGallery==2))
	{
		_canClickToPopup = false;
		if (_globalConfig.open_popup_when_clicking)
		{
			_canClickToPopup = true;
		}
	}
	if (_canClickToPopup)
	_pages.each(function(i) 
	{
		var _divImgs = waJSQuery(">.wa-gallery-image-contenair",waJSQuery(this));
		_divImgs.each(function(i) 
		{
			var _img = waJSQuery(this)
		/////	
			_img.css("cursor","pointer")
			_img.click(function() {
				//alert("click")
				var _p = _waAlbumCurrentPage(_o)
				var _nbImagePerPage = _waAlbumNbImgPerPage(_o)
				var _ind = _nbImagePerPage*_p+i
				_waAlbumClickOnThumbnail(_o,_ind)
				return false
			  //
			});
			
		});
		
	});

	//navigation
	
	var _nav= _o.find(".wa-gallery-navigation")
	
	
	var _classAction = "wa-gallery-bt-design wa-gallery-button "
	_classAction +=  (_mode=="normal")?"wa-gallery-bt-action-mini wa-gallery-corner-mini":"wa-gallery-bt-action-big wa-gallery-corner-big"

	var _classArrow = ""
	_classArrow +=  (_mode=="normal")?"wa-gallery-button wa-gallery-bt-design-arrow wa-gallery-arrow-mini wa-gallery-corner-mini":"wa-gallery-bt-design-arrow"
	
	_nav.append("<div class=\"wa-gallery-comment-zone\"></div>")
	//if (_typeGallery!=2)
	if (_waGalleryIsAutoDiapo(_o)==false)
	{
		_nav.append("<div class=\"wa-gallery-arrow  param[type(prev)] "+_classArrow+"\"></div>")
		_nav.append("<div class=\"wa-gallery-arrow param[type(next)] "+_classArrow+"\"></div>")
		

		_nav.append("<div class=\"wa-gallery-bt-action param[type(act-close)] wa-gallery-bt-corner\"></div>")
		_nav.append("<div class=\"wa-gallery-bt-action param[type(act-list)] wa-gallery-bt-corner\"></div>")
		_nav.append("<div class=\"wa-gallery-bt-action param[type(act-diapo)] wa-gallery-bt-corner\"></div>")
			
	}

	//bottom navigation

	var _clasPageSelector = "wa-gallery-bt-design "
	_clasPageSelector = ""
	_clasPageSelector +=  (_mode=="normal")?"wa-gallery-page-selector-mini wa-gallery-corner-mini":"wa-gallery-page-selector-big wa-gallery-corner-big"

	_nav.append("<div style='position:absolute;' class=\"wa-gallery-page-selector "+_clasPageSelector+"\"></div>")
	

	_o.find(".wa-gallery-arrow").each(function(i) 
	{
		var _bt = waJSQuery(this);
		var _type = extractParamInfo(_bt,"type")

		if (_type=="prev")
		{
			_bt.html("<img class='wa-gallery-arrow-left' style='display:none' src=\"wa_fancybox/fancy_nav_left.png\" border=0>")
		}
		else
		{
			_bt.html("<img class='wa-gallery-arrow-right' style='display:none' src=\"wa_fancybox/fancy_nav_right.png\" border=0>")
		}

		_bt.click(function()  //mouseup
		{
			var _gallery =  _bt.parents(".wa-gallery");
			_waAlbumGetPageLayout(_gallery,0)

			var _o = waJSQuery(this)
			var _page = _waAlbumCurrentPage(_gallery)
			var _newPage = (_type=="next")?(_page+1):(_page-1);
			
			
			_waAlbumGotoPage(_gallery,_newPage)
			return false
		});
		
		//if (_mode=="fullscreen")
		{
			var _subImg = _bt.find("img")
			_subImg.fadeOut()
			_bt.hover(
			  function () 
				{
					_subImg.stop(true, true).fadeIn()
			  	}, 
			  function () 
				{
					_subImg.stop(true, true).fadeOut()
			  	}
			);
		}

	});
	
	_o.find(".wa-gallery-bt-action").each(function(i) 
	{
		var _bt = waJSQuery(this);
		var _type = extractParamInfo(_bt,"type")
	
		_bt.css({"width":41,"height":28})
	//41,28
		if (_type=="act-diapo")
		{
			_bt.html("<img src='wa_gallery/wa_bt_start_diapo.png' border=0>")
		}
		else
		if (_type=="act-list")
		{
			_bt.html("<img src='wa_gallery/wa_bt_list.png' border=0>")
		}
		else
		if (_type=="act-close")
		{
			_bt.css({"width":30,"height":30})
			_bt.html("<img src='wa_fancybox/fancy_close.png' border=0>")	
		}

		centerElement(_bt,"div")
		
		_bt.click(function() 
		{
			var _gallery =  _bt.parents(".wa-gallery");
			
			_waAlbumPrepareFullscreenMode(_gallery)

			if (_type=="act-list")
			{
				var _indexImg = _waAlbumCurrentPage(_gallery) * _waAlbumNbImgPerPage(_gallery) 
				_waGalleryGetRoot(_gallery).data("fullscreen_contenair","windows");
				loadFullscreen("fullscreen_list",_indexImg)
			}
			if (_type=="act-diapo")
			{
				_waGalleryStartDiaporama(_waGalleryGetRoot(_gallery))
			}
			if (_type=="act-close")
			{
				closeFullscreen()
			}
			return false;
		});
	
	});
	
	//
	if (_mode=="normal")
	{

		
			if (_globalConfig.always_display_nav_elements)
			{
				_waGallerySetNavigationVisible(_o,true)
			}
			else
			{
				_o.hover(function () {_waGallerySetNavigationVisible(waJSQuery(this),true);}, 
						  function () {_waGallerySetNavigationVisible(waJSQuery(this),false);});

//alert('hide')
				_waGallerySetNavigationVisible(_o,false)	
			}
	
		
	
		
	}
	else
	{
		_waGallerySetNavigationVisible(_o,true)
		
	}

	//
	_waAlbumSetBusyFlag(_o,false)
	
	if (_waGalleryGetRoot(_o).data("auto_diapo")==1)
	{
		//_waGallerySetNavigationVisible(_o,false)
		_waGalleryStartDiaporamaTimer(_o)
	}
	else
	{
		_waGalleryUpdateButtonsNavigation(_o)
	}
	
	centerGalleryContainer() ;
	
	
	
	var _query_info = document.wa_global_query_info
	if (_query_info)
	{
	//	alert(_folder)
		if (_query_info.m_unid+"/"==_folder)
		{
			_waAlbumClickOnThumbnail(_o,_query_info.m_index_item)
				//alert(_query_info.m_unid+"@\n"+_idAlbum+"@")
		}
	}
}


function _waGallerySetNavigationVisible(_o,_b)
{
	//
	if (_b==_o.data("_is_visible"))
	{
		//sinon cause un bug sous safari
		return;
	}
	
	var _mode = _o.data("mode")
	var _normalConfig= _o.data("config")
	var _globalConfig= _o.data("datas").global_config
	var _typeGallery = _o.data("type_gallery");

	_o.data("_is_visible",_b);

//alert(_globalConfig.always_display_nav_elements)
	if (_globalConfig.always_display_nav_elements && (_b==false)) 
	{
		//alert('always_display_nav_elements')
		return;
	}

	{
		
		if (isMSIE_lower_than_ie9())
		{
			var _nav = _o.find(".wa-gallery-navigation"); 
			var _children = _nav.children()

			if (_b)
			{

				_children.stop(true, true).fadeIn();
				_waGalleryUpdateButtonsNavigation(_o)
			}
			else
			{
				_children.stop(true, true).fadeOut()	
			}
		}
		else
		{
			var _nav = _o.find(".wa-gallery-navigation"); 
			var _children = _nav.children()
			if (_b)
			{

				_children.stop(true, true).fadeIn();
				_waGalleryUpdateButtonsNavigation(_o)
			}
			else
			{
				_children.stop(true, true).fadeOut()	
			}
		}
	
	}
	
	
	_waGalleryUpdateComment(_o)
}


function _waGalleryUpdateButtonsNavigation(_o)
{

	//navigation
	var _nav= _o.find(".wa-gallery-navigation")

if (document.internalPreview)
{
	_nav.hide()
	return;
}
	var _gallery =  _o;
	var _typeGallery = _o.data("type_gallery");
	var _mode = _o.data("mode")
	var _isMiniSlideShow = _typeGallery>0
	var _globalConfig = _o.data("datas").global_config
	
	var _canClickToPopup = true;
	if ((_typeGallery==1)||(_typeGallery==2))
	{
		_canClickToPopup = false;
		if (_globalConfig.open_popup_when_clicking)
		{
			_canClickToPopup = true;
		}
	}
	
	var _hasLargeSensitiveZone = (_mode=="fullscreen")||((_mode=="normal") && (_canClickToPopup==false))
	
//	alert(_hasLargeSensitiveZone +"  "+_canClickToPopup+" "+_mode)
	var _nbImages= _waGalleryNbImages(_o);
	var _nbPages= _waAlbumNbPages(_o);
	
	var _wContenair = _o.width()
	var _hContenair = _o.height()
	if ((_mode=="fullscreen")||(_mode=="fullscreen_list"))
	{
		_wContenair = getWindowSize().width()
		_hContenair = getWindowSize().height()
	}
	//_waGalleryGetFullscreenMaxSize(_o)
	var _maxReso = _waGalleryMaxResolutionFullScreen(_o)//_o.data("datas").global_config.max_image_resolution
	var _wMaxReso = Math.min(_wContenair,_maxReso)
	var _hMaxReso = Math.min(_hContenair,_maxReso)
	
	if ((_mode=="fullscreen")||(_mode=="fullscreen_list"))
	{
		var _sMaxReso = _waGalleryGetFullscreenMaxSize(_o)
		 _wMaxReso = _sMaxReso.width()
		 _hMaxReso = _sMaxReso.height()
	}
	
	
	
	var _margin = 10;
	var _littleMargin = 3;

	var _left = (_wContenair - _wMaxReso)/2 + _margin
	var _right = (_wContenair - _wMaxReso)/2 +_wMaxReso -_margin
	
	var _top = (_hContenair - _wMaxReso)/2 + _margin
	
	var _xBg = waJSQuery(window).scrollLeft();
	var _yBg = waJSQuery(window).scrollTop();
	
	
	if (_mode=="normal")
	{
		_left = _littleMargin
		_right = _wContenair-_littleMargin
	}
	if (_mode=="fullscreen_list")
	{
		_left = _margin
		_right = _wContenair - _margin
	}

	var _layout = _waAlbumFirstLayout(_o)
	var _pageFirst = _waAlbumGetPageLayout(_o,_layout); 
	var _img = _pageFirst.find("img")
	
	var _widthImg = _img.width();
	_widthImg = Math.max(_widthImg,150)
	//_widthImg = Math.min(_widthImg,_wContenair*0.6)
	

	_o.find(".wa-gallery-arrow").each(function(i) 
	{
		var _bt = waJSQuery(this);


		var _subImg = _bt.find("img")

		//_subImg.fadeOut()
		
		
		var _type = extractParamInfo(_bt,"type")
		var _p1 = _waAlbumCurrentPage(_gallery);

		var _marginSubImg = 10
		var _xButton = 0;
		var _yButton = (_hContenair - _bt.height())/2;

		var _xSubImg = 0;
		if (_hasLargeSensitiveZone)
		{
			//_wContenair
			if (_mode=="normal")
			{
				_bt.css({"width":_wContenair/3,"height":_hContenair})
			}
			else
			{
				_bt.css({"width":_img.width()/3,"height":_img.height()*2/3})
			}
		}
		else
		{
			if (_mode=="normal")
			{
				_bt.css({"height":_hContenair})
			}
			else
			{
				_bt.css({"height":_img.height()*2/3})
			}
			
		}
	//	_bt.css("border","1px solid red")
		//alert(_hasLargeSensitiveZone+"  "+_isMiniSlideShow)
		if (_type=="prev")
		{
			_xButton = _left
			_xSubImg = 0;
			
			if (_mode=="normal")
			{
				_xButton = 0
			}
			else
			{
				_xButton = (_wContenair-_widthImg)/2
			}
			_yButton = (_hContenair-_bt.height())/2
			_xSubImg = _marginSubImg


			if (_p1==0)
			{
				_subImg.hide();
				_bt.hide();
			}
			 else 
			_bt.show();

		}
		else
		{
			_xButton = _right-_bt.width()

			_xSubImg = (_bt.width()-30)
			
			
			if (_mode=="normal")
			{
				_xButton = _wContenair -_bt.width();
			}
			else
			{
				_xButton = (_wContenair-_widthImg)/2+_widthImg-_bt.width()
			}
			_yButton = (_hContenair-_bt.height())/2
			
			_xSubImg = _bt.width()-30-_marginSubImg
			

			if (_p1>=_waAlbumNbPages(_o)-1) 
			{
				_subImg.hide();
				_bt.hide();
			}
			else _bt.show();
		}
		if ((_mode=="fullscreen")||(_mode=="fullscreen_list"))
		{
			_xButton = _xBg+_xButton
			_yButton = _yBg+_yButton
		}
		//alert(_xButton+"  "+_yButton)
		_bt.css({"left":_xButton,"top":_yButton})
		if (isMSIE())
		{
			_bt.css("background-image","url(wa_transparent.gif)")	
		}
		_subImg.css({"position":"absolute","left":_xSubImg,"top":(_bt.height()-30)/2})
		

		if (_waGalleryDiaporamaEnabled(_o))
		{
			_subImg.hide();
			_bt.hide();
		}


	});
	
	///
	var _pageSelector = _o.find(".wa-gallery-page-selector")

	if ( (_globalConfig.type_display_page_navigator!=0)  && /*(_typeGallery!=2) &&*/(_nbPages>1) /*&& (_waGalleryDiaporamaEnabled(_o)==false)*/ && ((_mode=="normal") || (_mode=="fullscreen_list")) )
	{
		

		var _usePuces = false;
		var _sizePuces = 20;
		
		var _widthPageBt = 20;
		var _heightPageSelector = _widthPageBt
		var _marginRightLeft = 12 // 25
		var _widthSelector = _wContenair-2*_marginRightLeft;  // - 50
		
		//_widthSelector = Math.min(_widthSelector,_wContenair-50)
		var _idealWidthSelectorWithPuces = _sizePuces*_nbPages+2*_marginRightLeft
		
		if (_idealWidthSelectorWithPuces > _widthSelector)
		{
			_usePuces = false;
			_heightPageSelector = 30
		}
		else
		{
			_usePuces = true;
			_widthPageBt = _sizePuces;
			_heightPageSelector = 30
		}
		
	//	alert("_pageSelector")
		var _idealWidthSelector = _widthPageBt*_nbPages+2*_marginRightLeft
		
		_widthSelector = Math.min(_widthSelector,_idealWidthSelector)
		
		

		
		_pageSelector.css("height",_heightPageSelector)



		_pageSelector.html("<div style='position:absolute;' class='wa-gallery-page-selector-inner'></div>")
		
		
		var _pageSelectorInner = _pageSelector.find(".wa-gallery-page-selector-inner")
		
		
		if (_usePuces)
		{
			//_pageSelectorInner.css({"background-color":"rgba(0,0,255,0.8)","border":"1px solid rgba(250,0,0,0.7)"})
		}
		else
		{
			
			//_pageSelectorInner.css({"background-color":"rgba(0,0,0,0.8)","border":"1px solid rgba(220,220,220,0.7)","border-radius":4})
			_pageSelectorInner.css({"background-color":"#000000","opacity":0.8,"border":"1px solid rgba(220,220,220,0.7)","border-radius":4})
		}
		
				
		var _current = _waAlbumCurrentPage(_o);
		
		var _heightPageBt = _widthPageBt
		var _nbBt = Math.floor(_widthSelector / _widthPageBt)
		//alert(_nbBt)
		_nbBt = Math.min(_nbBt,_nbPages)
		if (_nbBt>1)
		{
			
			if (_mode=="normal")
			{
				var _marginTopSelector = 2
				//

				if (_globalConfig.type_display_page_navigator==1) //inner
				{
					_pageSelector.css("top",_hContenair-_pageSelector.height()-_marginTopSelector)
				}
				else
				if (_globalConfig.type_display_page_navigator==2) //outer
				{
					_pageSelector.css("top",_hContenair)
				}
			}
			else
			{
				_pageSelector.css("top",_hContenair-50)
			}

			
			
			
			
			_pageSelector.css("width",_widthSelector)
			_pageSelector.css("left",(_wContenair-_pageSelector.width())/2)
		//	_pageSelector.show();
			
			
			
			_pageSelectorInner.css({"width":_widthSelector,"height":_widthPageBt,"top":_heightPageSelector-_widthPageBt})
			////////
			
			var _indexBut0 = Math.ceil(_current-(_nbBt/2))
			_indexBut0 = Math.max(_indexBut0,0)

			var _indexBut1 = _indexBut0 + _nbBt
			_indexBut1 = Math.min(_indexBut1,_nbPages)

			if (_indexBut1-_nbBt>=0)
			{
				_indexBut0=_indexBut1-_nbBt
			}
			
			var xBut = (_widthSelector-(_nbBt*_widthPageBt))/2
			var _html ="";
			for (var i=0;i<_nbBt;i++)
			{
				var _index = _indexBut0 + i;
				if (_index<_nbPages)
				{
					if (_usePuces)
					{
						_html += "<div class='wa-gallery-page-selector-bt-design' style='vertical-align:middle;line-height:"+_heightPageBt+"px;' ></div>";
						
					}
					else
					{
						_html += "<div class='wa-gallery-page-selector-bt-design' style='vertical-align:middle;line-height:"+_heightPageBt+"px;' >"+ (_index+1)+"</div>";
					}
					//		
				}
			}

			_pageSelectorInner.html(_html)

			var _indexButtons = _pageSelector.find(".wa-gallery-page-selector-bt-design")
			//alert('_indexButtons='+_indexButtons)
			_indexButtons.each(function(i){
				var _bt=waJSQuery(this)
				var _index = _indexBut0 + i;
				
				
				if (_usePuces)
				{
					if (_current==_index)
					{
						_bt.html("<img src='wa_gallery/wa_navigation_past_on.png' border=0>")
					}
					else
					{
						_bt.html("<img src='wa_gallery/wa_navigation_past_off.png' border=0>")
					}
				}
				else
				{
					if (_current==_index)
					{
						_bt.css({"font-size":"14px","font-weight":"bold"})
					}
					else
					{
						_bt.css({"font-size":"12px","font-weight":"normal"})
					}
				}

				
				_bt.css({"left":xBut,"top":0,"width":_widthPageBt,"height":_heightPageBt})
	
				xBut+=_widthPageBt;
				
				if (_current!=_index)
				{
					_bt.click(function()
					{	
						//alert('clic')
						_waAlbumGotoPage(_o,_index);
						return false
					})
				}

			})

//alert(_usePuces)
		}
		else 
		{
			_pageSelector.hide();
		}

	}
	else 
	{
		_pageSelector.hide();
	}
	
	

	var _xBut = 0;
	var _yBut = 0;
	
	var _totalWidth = 0;
	var _margin = 10;
	
	if ((_mode=="normal")||(_mode=="fullscreen_list"))
	{
			if (_mode=="normal")
			{
				_xBut = _wContenair
				_yBut = 0
			}
			if (_mode=="fullscreen_list")
			{
				_xBut = _wContenair - _margin
				_yBut = _margin
			}
	}
	else
	{
		var _sizeMax = _waGalleryGetFullscreenMaxSize(_o);

			_xBut = (_wContenair-_sizeMax.width)/2+_sizeMax.width
			_yBut = (_hContenair-_sizeMax.height)/2

	}

	var _spacingButton = 6;
	_o.find(".wa-gallery-bt-action").each(function(i) 
	{
		var _bt = waJSQuery(this);
		var _type = extractParamInfo(_bt,"type")

		var _vis = false;
		var _orderedButton = true
		////////// BOUTON PLANCHE CONTACT
	
		if (_type=="act-list")
		{

			//alert(_o.data("datas").global_config.has_fullscreen_thumbnail_mode)
			if (_globalConfig.has_fullscreen_thumbnail_mode)
			{
				_vis = ( (_waGalleryDiaporamaEnabled(_o)==false) &&(_mode=="fullscreen") && (_waAlbumNbPages(_o)>1)  )  
			}

		}

		if (_type=="act-diapo")
		{
		//	if (_o.data("datas").global_config.has_fullscreen_thumbnail_mode)
			{
				_vis = ( (_waGalleryDiaporamaEnabled(_o)==false) &&(_mode=="fullscreen") && (_waAlbumNbPages(_o)>1)  && (_globalConfig.show_diaporama_button==true))  
			}
		}

		var _fullscreenInWindow = _waGalleryFullscreenHasWindowContenair(_o);

		if (_type=="act-close")
		{
			_vis = (_mode!="normal")&&(_waGalleryDiaporamaEnabled(_o)==false)&&(_fullscreenInWindow==true)
			if (_mode=="fullscreen")
			{
				_orderedButton = false;
			}
			
			
		}

	//

		if (_vis && _orderedButton) 
		{
			var _temp = _bt.width()+_spacingButton
			_totalWidth+=_temp
			_xBut -= _temp
		}




		
		_bt.css("top",_yBut-_bt.height()-2)
		_bt.css("left",_xBut)
		
		 if (_vis) _bt.show(); else _bt.hide();
		
		_bt.data("wa_is_visible",_vis)
	});
	
	if ((_mode=="fullscreen")||(_mode=="fullscreen_list"))
	{
		var _x0 = (_wContenair-_totalWidth)/2
		
		var _layout = _waAlbumFirstLayout(_o)
		var _pageFirst = _waAlbumGetPageLayout(_o,_layout); 
		var _img = _pageFirst.find("img")
		var _xNoOrdered = (_wContenair-_img.width())/2+_img.width();
		
	//	alert('test')

		_o.find(".wa-gallery-bt-action").each(function(i) 
		{
			var _bt = waJSQuery(this);
			
			//if (_bt.filter(":visible"))
			if (_bt.data("wa_is_visible"))
			{
				var _type = extractParamInfo(_bt,"type")

				var _orderedButton = true

				if (_mode=="fullscreen")
				{
					_orderedButton = false;
				}
				var _xButton = 0;
				var _yButton = 0;

				var _btWidth = _bt.width();//_bt.width()
				
				if (_orderedButton)
				{
					_xButton = _x0;
					if (_mode=="fullscreen")
					{
						_yButton = Math.max(5,_top-30)
					}
					if (_mode=="fullscreen_list")
					{
						_yButton = 5;
					}

					_x0+=_btWidth+_spacingButton
				}
				else
				{
					/*
					if (_bt.width()==0)
					{
						var _subImg = _bt.find("img")
						alert(_type+" "+_subImg.width())
					}
					*/
					
					if (_type=="act-close")
					{
						_xNoOrdered = _xNoOrdered-_btWidth/2
						_xButton = _xNoOrdered
						 _yButton = (_hContenair-_img.height())/2-_bt.height()/2
					}
					if (_type=="act-list")
					{
						_xNoOrdered = _xNoOrdered-5
						_xNoOrdered = _xNoOrdered-_btWidth
						_xButton = _xNoOrdered

						 _yButton = (_hContenair-_img.height())/2-_bt.height()/2
					}

					if (_type=="act-diapo")
					{
						_xNoOrdered = _xNoOrdered-5
						_xNoOrdered = _xNoOrdered-_btWidth
						_xButton = _xNoOrdered

						 _yButton = (_hContenair-_img.height())/2-_bt.height()/2
					}

				}

				//alert(_yBg)
				_xButton+=_xBg
				_yButton+=_yBg
				_bt.css({"left":_xButton,"top":_yButton})
				
			}

			
		})
	}

 
}

function _waGalleryGetFullscreenMaxSize(_o)
{
	var _margin = 10;
	var _w = getWindowSize().width();
	var _h = getWindowSize().height();
	if (isIPhone())
	{
		return new Size(_w - 2*_margin,_h - 2*_margin);
	}
	var _maxReso = _waGalleryMaxResolutionFullScreen(_o)//_o.data("datas").global_config.max_image_resolution
	return new Size(Math.min(_maxReso,_w - 2*_margin),Math.min(_maxReso,_h - 2*_margin))
}


function _waGalleryMaxResolutionFullScreen(_o)
{
	var _maxReso = _o.data("datas").global_config.max_image_resolution
	if (_maxReso==-1) _maxReso = 6000;
	return _maxReso
}


//load le fichier javascript généré par flickr
function _waLoadjsonFlickrApi(url,_callback,_params) 
{
	
var e = document.createElement("script");
e.src = url;
e.type = "text/javascript";
e.onerror=function(){
	//####
	////callback(params,false);
	
	}// Other browsers
if (/msie/i.test(navigator.userAgent) && !/opera/i.test(navigator.userAgent)) {
  // IE
  e.onreadystatechange = function(){
    if ((this.readyState == 'complete')||(this.readyState == 'loaded')) {
		//####
		_callback(_params)
    }
  }
} else 
{
	e.onload=function(){
		_callback(_params)
		
		}// Other browsers
}
document.getElementsByTagName("head")[0].appendChild(e);
}

function wa_jsonFlickrApi(_onlineGalleryData)
{
	document.wa_current_datas_gallery = _onlineGalleryData
}

function _waLoadJsonFlickrDatas(_params)
{
	var _o = _params.objGallery
	//var json = document.wa_current_datas_gallery
	var _config = _params.config
	var _idAlbum = _params.idAlbum
	var json = _params.json
//	alert("jsonFlickrApi2 "+document.wa_current_datas_gallery)
	{
		//	alert(resp)
		var _onlineGalleryData = document.wa_current_datas_gallery

		if (_onlineGalleryData==null)
		{
			return ;
		}
		if (_onlineGalleryData.stat=="fail")
		{
			return;
		}
		//alert(_onlineGalleryData)
		_waGalleryGetRoot(_o).data("3rdparty_datas",_onlineGalleryData)
		_o.data("datas",json)
		if (!_config) _config	= _o.data("datas").normal_config;
		_o.data("config",_config)
		_o.data("folder",_idAlbum+"/")
		_waGalleryLoaded(_o);
  	}
}

function _waGalleryStart(_o,_config)
{
	_waAlbumSetBusyFlag(_o,true)

	var _idAlbum = extractParamInfo(_o,"config_key")
	var _idModif = extractParamInfo(_o,"modif_id")
	///
	var _gallerySource = extractParamInfo(_waGalleryGetRoot(_o),"source")

	//en preview pas de fichier de definition album
	var _urlAlbum  = "";
	
	if (_idAlbum.length>0)
	{
		_urlAlbum = _idAlbum+"/photo-album-definition"

		///alert(_urlAlbum)
		var _lng = Translator.m_lang_for_filename

		if (_lng.length>0)
		{
			_lng="_"+_lng;
		}

		_urlAlbum+= _lng+".js"
		_urlAlbum+="?t="+_idModif	
	}
	

//alert(_idAlbum)
	
/*
http://api.flickr.com/services/feeds/groups_pool .gne?id=675729@N22&lang=en-us&format=json&jsoncallback=?
"http://api.flickr.com/services/feeds/photos_public.gne?id=61783331@N04&format=json&lang=en-us&jsoncallback=?"

http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=21ae9ce20d7a6a8731a796b4b03adb52&format=json&user_id=61783331%40N04

http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=624245e80423b78999b7037a68645766&user_id=61783331%40N04&format=json&extras=url_l
*/
//
	//alert(_urlAlbum)
	
	
//alert("_waGalleryStart")
function _loadGalleyFromJsonDatas(json) 
{
	//alert("initializeAllWA_gallery _loadGalleyFromJsonDatas")	
	var _typeGallery = _o.data("type_gallery");
	var _mode = _o.data("mode")

	var _gallerySource = extractParamInfo(_waGalleryGetRoot(_o),"source")
	//_gallerySource = "wa"
	
	var _thirdParty_GalleryDatasUrl = null
	if (_gallerySource=="flickr")
	{
		var _userId = extractParamInfo(_waGalleryGetRoot(_o),"user_id") //"61783331@N04"
		var _setId = extractParamInfo(_waGalleryGetRoot(_o),"album") //"72157626513346577"

		var _method ="flickr.people.getPublicPhotos"
		
		if (_setId.length>0)
		{
			_method="flickr.photosets.getPhotos"
		}
		
		
		_thirdParty_GalleryDatasUrl = "http://api.flickr.com/services/rest/?method="+_method+"&api_key=624245e80423b78999b7037a68645766&user_id="+_userId
		_thirdParty_GalleryDatasUrl+="&extras=url_t, url_s, url_m, url_z, url_l, url_o"
	//	_thirdParty_GalleryDatasUrl+="&nojsoncallback=1"
		_thirdParty_GalleryDatasUrl+="&format=json"
		_thirdParty_GalleryDatasUrl+="&privacy_filter=1"
		
		_thirdParty_GalleryDatasUrl+="&photoset_id="+_setId
		
		_thirdParty_GalleryDatasUrl+="&jsoncallback=wa_jsonFlickrApi"

	
	}

	var _onlineGalleryData = _waGalleryGetRoot(_o).data("3rdparty_datas")
	

	if ((_thirdParty_GalleryDatasUrl) && (_onlineGalleryData==undefined))
	{
		var _params = {objGallery:_o,"config":_config,"idAlbum":_idAlbum,"json":json}
		
		//	alert("initializeAllWA_gallery _waGalleryStart"+_params)
		//obligé d'utiliser methode jsonp pour prob de cross domain sous ie
		_waLoadjsonFlickrApi(_thirdParty_GalleryDatasUrl,_waLoadJsonFlickrDatas,_params) 	
			////
			return;	
	}
	
	

	_o.data("datas",json)
	if (!_config) _config	= _o.data("datas").normal_config;
	_o.data("config",_config)
	_o.data("folder",_idAlbum+"/")
	_waGalleryLoaded(_o);
	
	

		if (isMobileBrowser())
		{
				_o.touchwipe({
				     wipeLeft: function() {
						_waGalleryGoNext(_o)
						return false
					},
				     wipeRight: function() {
						_waGalleryGoPrev(_o)
						return false
					 }
					,
					preventDefaultEvents: true
				}
				)

		}
		
	if (_mode!="normal")
	{
		if (waJSQuery.fn.mousewheel) 
		{
			_o.bind('mousewheel.fb', function(e, delta) 
			{
				e.preventDefault();
				if (delta > 0)
				{
					_waGalleryGoPrev(_o)

				}
				else
				{
					_waGalleryGoNext(_o)
				}
			});
		}	
	}
	

	
	
	
}
///
if (_idAlbum.length==0)
{
	//en preview interne
	// waPreviewJsonGalleryDatas est un json cree dans webbet interne
	_loadGalleyFromJsonDatas(waPreviewJsonGalleryDatas)
}
else
{

	waJSQuery.getJSON(_urlAlbum,{},_loadGalleyFromJsonDatas)
}

	////////////	
}



function _waAlbumKeypressEvent(_o,e)
{
	var _mode = _o.data("mode")

	if (_mode == "normal") return;
		
	if (e.which=='27')
	{
		closeFullscreen()
		e.preventDefault();
	}
	if (_waGalleryDiaporamaEnabled(_o)==false)
	{
		if (e.which=='37')
		{
			_waGalleryGoPrev(_o)
			e.preventDefault();
		}
		if (e.which=='39')
		{
			_waGalleryGoNext(_o)
			e.preventDefault();
		}
	}
}

function initializeAllWA_gallery()
{
	waJSQuery(".wa-gallery").each(function(index) 
	{
		var _o = waJSQuery(this)
		_o.data("mode","normal")
		
		//alert(_o)
	
		var _typeGallery = parseInt(extractParamInfo(_o,"type_gallery"))
		var _autoDiapo = parseInt(extractParamInfo(_o,"auto_diapo"))
		_o.data("type_gallery",_typeGallery)
		_o.data("auto_diapo",_autoDiapo)

		if (_typeGallery==1)
		{
			var _config = {
			"rows":1,
			"cols":1,
			"image_size":100,
			"image_spacing":0,
			"nb_images_per_page":1,
			"margin_left":0,
			"margin_top":0 ,
			"default_selected_image":0,
			"has_shadow":false
			}
			_waGalleryStart(_o,_config)
		}
		else
		{
			_waGalleryStart(_o)
		}
	});	
	
	
	////
	waJSQuery(window).keydown(function(e) {
		
		var _o = waJSQuery(".wa-fullscreen-contenair").find(".wa-gallery")
		if (_o&&(_o.length>0))
		{
			_waAlbumKeypressEvent(_o,e)
		}
	});


	
}

function _waAlbumPrepareFullscreenMode(_o)
{
	var _mode = _o.data("mode")

	if (_mode == "normal")
	{
	waJSQuery(document).data("origin_fullscreen_gallery",_o)
	}
	///////////////////
}

function _waDelayedResize(_o)
{
//	alert('_waDelayedResize')
	var _root = _waGalleryGetRoot(_o)

	var _iImg0 = _waGalleryGetRoot(_o).data("current_image");
	var _mode = _o.data("mode")
	loadFullscreen(_mode,_iImg0)
}

function _waAlbumClickOnThumbnail(_o,_n)
{
//	alert('_waAlbumClickOnThumbnail')
	if (_waGalleryDiaporamaEnabled(_o)) return;
	var _mode = _o.data("mode")
	if ((_mode == "normal") ||(_mode == "fullscreen_list"))
	{
		_waAlbumPrepareFullscreenMode(_o)
		loadFullscreen("fullscreen",_n)
	}
	else
	if (_mode == "fullscreen")
	{
		return
	}
}

function closeFullscreen()
{
	var _galleryOrigin = waJSQuery(document).data("origin_fullscreen_gallery")
	//_waGalleryGetRoot(_galleryOrigin).data("diaporama",false)
	_galleryOrigin.data("diaporama",false)
	var _cont = waJSQuery(".wa-fullscreen-contenair");
	
	_cont.fadeOut(200,function() {
		var _o = waJSQuery(document).data("origin_fullscreen_gallery")
		_cont.empty()
		_o.focus()
	})

	waSetVisibilityMainPageContenair(true)
	
//	_cont.empty()
//	alert('close')
}


function _waGalleryFullscreenHasWindowContenair(_o)
{
	var _mode = _o.data("mode")
	var _typeGallery = _waGalleryGetRoot(_o).data("type_gallery")

	if ((_mode=="normal")&&(_typeGallery==1)) return false;
	return true;
}


function loadFullscreen(_newMode,_selectedIndexImg)
{
		var _galleryOrigin = waJSQuery(document).data("origin_fullscreen_gallery")
		
		if (_selectedIndexImg==undefined)
		{
			_selectedIndexImg = _galleryOrigin.data("current_image");
		}
		else
		{
			_galleryOrigin.data("current_image",_selectedIndexImg);
		}


		//var _contenairWidth = getWindowSize().width()
		//var _contenairHeight = getWindowSize().height()
		var _contenairWidth = getDocumentSize().width()
		var _contenairHeight = getDocumentSize().height()


		
		waSetVisibilityMainPageContenair(false)
		//
		var _idAlbum = extractParamInfo(_galleryOrigin,"config_key")
		
		var _html=""
		
		_html+="<div class='wa-dialog-container-bg' style='position:absolute;left:0px;top:0px;;' ></div>"
		
		_html+= "<div style=\"";
		_html+="position:absolute;width:100%;height:100%;"
		_html+="overflow:hidden;";
//_html+= "background-color:#00ff00;";
		_html+= "\" class=\"wa-gallery  param[config_key("+_idAlbum+")]\">";
		_html+= "<div class=\"wa-gallery-scroll-pane\"></div>";

		///barre button navigation
		_html+= "<div class=\"wa-gallery-navigation\"></div>";

		///////////////////

		_html+= "</div>";

		var _cont = waJSQuery(".wa-fullscreen-contenair");



		
		
		_cont.empty()
		_cont.html(_html)
		

		_cont.css("width",_contenairWidth)
		_cont.css("height",_contenairHeight)
		_cont.show()

		var _contBg = _cont.find(".wa-dialog-container-bg");
		
		var _colBg = new RGBColor(CONST_WA_GLOBAL_SETTINGS.overlayColor)
		_contBg.css({"backgroundColor":_colBg.toHexaOpaqueColor(),"opacity":_colBg.a})

		_contBg.css({width:_contenairWidth, height:_contenairHeight })

		var _o = _cont.find(".wa-gallery")
	
		_o.click(function(){
			closeFullscreen()
			return false
					});
					
		_cont.css("cursor","pointer")

					
		//alert(_o.click)
		
		var _imageSize = 200;
		var _imageSpacing = 5;
		var _hasShadow = false;
		
		
		var _innerMarginWidth = 0;
		var _innerMarginTop = 0;
		var _innerMarginBottom = 0;
		
		if (_newMode == "fullscreen_list")
		{
			_innerMarginWidth = 50
			_innerMarginTop = 30
			if (_waAlbumNbPages(_o)>1)
			{
				_innerMarginBottom = 40
			}
			//alert(_innerMarginBottom)
		}	

		var _innerWidth = _contenairWidth  - 2*_innerMarginWidth
		var _innerHeight = _contenairHeight - (_innerMarginBottom + _innerMarginTop)
		
		
		if (_newMode == "fullscreen_list")
		{
			var _conf = _galleryOrigin.data("datas").fullscreen_list_config
			var _mini = Math.min(_innerWidth,_innerHeight)

			_imageSize = Math.min(_conf.image_size,_mini*0.8)
			
			var _image_spacing_percent = 10 //_conf.image_spacing
			 _imageSpacing = (_image_spacing_percent/2)*_imageSize/100;
			 _hasShadow = _conf.has_shadow;
			
		//	alert(_imageSize)
		}
		
		var _xBg = waJSQuery(window).scrollLeft();
			var _yBg = waJSQuery(window).scrollTop();
		
		var _nbCols = Math.floor((_innerWidth) / (_imageSize+2*_imageSpacing));
	    var _nbRows = Math.floor((_innerHeight) / (_imageSize +2*_imageSpacing));
		var _marginTop = _yBg+ _innerMarginTop + (_innerHeight- _nbRows*(_imageSize+2*_imageSpacing))/2;
	    var _marginLeft = _xBg + (_contenairWidth - (_nbCols*(_imageSize+2*_imageSpacing)) )/2;

		
		var _mode = _o.data("mode")

		if (_newMode == "fullscreen")
		{
			 _imageSize = 800;
			 _imageSpacing = 0;

			 _nbCols = 1;
		     _nbRows = 1;
			 _marginTop = 0;
		     _marginLeft = 0;
		
		
			//_o.click(function(){alert('close')});
		}

		_o.data("mode",_newMode)

		var _config = {
		"rows":_nbRows,
		"cols":_nbCols,
		"image_size":_imageSize,
		"image_spacing":_imageSpacing,
		"nb_images_per_page":_nbCols*_nbRows,
		"margin_left":_marginLeft,
		"margin_top":_marginTop ,
		"default_selected_image":_selectedIndexImg,
		"has_shadow":_hasShadow
		}
		_waGalleryStart(_o,_config)	
		
		
		
		
		
		return _o
		
}



function _waGalleryNbImages(_o)
{
	var _onlineGalleryData = _waGalleryGetRoot(_o).data("3rdparty_datas")
	if (_onlineGalleryData)
	{
		return _waGalleryMapJsonThirdPartyRoot(_o,_onlineGalleryData).photo.length
	}
	
	return _waGalleryGetRoot(_o).data("datas").images.length
}

function _waAlbumNbImgPerPage(_o)
{
	var _pageFirst = _waAlbumGetPageLayout(_o,0)
	var _imgs = waJSQuery(">.wa-gallery-image-contenair",_pageFirst);
	return _imgs.length;
}

function _waAlbumNbPages(_o)
{
	var _nbImgs = _waGalleryNbImages(_o);
	return Math.ceil(_nbImgs/_waAlbumNbImgPerPage(_o));
}


function _waAlbumCurrentPage(_o)
{
	var _n = _o.data("page")
	return (_n==undefined)?0:_n;
}

function _waAlbumGetPageLayout(_o,_n)
{
	var _pages= _o.find(".wa-gallery-page")
	var _match =null;
	_pages.each(function(i) 
	{
		if (i==_n)
		{
			_match = waJSQuery(this)
			return false;
		}
	});
	return _match;
}

function _waAlbumFirstLayout(_o)
{
	var _n = _o.data("first-layout")
	return (_n==undefined)?0:_n;
}

function _waAlbumIsBusy(_o)
{
	var _n = _o.data("isBusy")
	return (_n==undefined)?false:_n;
}

function _waAlbumSetBusyFlag(_o,b)
{
	_o.data("isBusy",b)
}


function _waGalleryGoPrev(_o)
{
	var _page = _waAlbumCurrentPage(_o)
	_waAlbumGotoPage(_o,_page-1)
}
function _waGalleryGoNext(_o)
{
	var _page = _waAlbumCurrentPage(_o)
	_waAlbumGotoPage(_o,_page+1)
}


function _waGalleryGetRoot(_o)
{
	if (_o.data("mode")!="normal") return waJSQuery(document).data("origin_fullscreen_gallery")
	return _o
}

function _waGalleryGetFullscreenGallery()
{
	var _o = waJSQuery(".wa-fullscreen-contenair").find(".wa-gallery")
	if (_o&&(_o.length>0))
	{
		return _o
	}
	return null;
}



function _waGalleryDiaporamaEnabled(_o)
{
	return _o.data("diaporama")==true
	//return _waGalleryGetRoot(_o).data("diaporama")==true
}


function _waGalleryStartDiaporamaTimer(_o)
{
	var _time = _waGalleryGetRoot(_o).data("datas").global_config.diaporama_time*1000;
	_o.data("diaporama",true)
	wa_timeout(function(){_waGalleryDiaporamaNext(_o)},_time)
}

function _waGalleryDiaporamaNext(_o)
{
	if (_waGalleryDiaporamaEnabled(_o)==false)
	{
		//_waGalleryGetRoot(_o).data("diaporama",false)
		return;
	}

	var _gal = null;//_waGalleryGetFullscreenGallery();
	if (_gal==null) _gal = _o;
	
	if (_waAlbumCurrentPage(_gal)>=_waAlbumNbPages(_gal)-1)
	{
		//var _n = Math.round((_waGalleryNbImages(_o)-1)*Math.random());
		//  _o.data("datas").global_config.random_diaporama
		_gal.data("page",-1)
	}
	
	if (_o.data("datas").global_config.random_diaporama)
	{
		var _n = Math.round((_waGalleryNbImages(_o)-1)*Math.random());
		_gal.data("page",_n-1)
	}
	_waGalleryGoNext(_gal)

	_waGalleryStartDiaporamaTimer(_o);
}

function _waGalleryStartDiaporama(_o)
{
	//_waGalleryGetRoot(_o).data("diaporama",true)
	//_o.data("diaporama",true)

	var _indexImg = _waAlbumCurrentPage(_o) * _waAlbumNbImgPerPage(_o) 
	var _fullGal = loadFullscreen("fullscreen",_indexImg)

	_waGalleryStartDiaporamaTimer(_fullGal)
}



