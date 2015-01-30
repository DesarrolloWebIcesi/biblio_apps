/*******************************************************************************
 jquery.mb.components
 Copyright (c) 2001-2010. Matteo Bicocchi (Pupunzi); Open lab srl, Firenze - Italy
 email: info@pupunzi.com
 site: http://pupunzi.com

 Licences: MIT, GPL
 http://www.opensource.org/licenses/mit-license.php
 http://www.gnu.org/licenses/gpl.html
 ******************************************************************************/

/*
 * Name:jquery.mb.gallery
 * Version: 2.0.2
 *
 *
 * It is possible to show EXIF metadata of your photos.
 * include: jquery.exif.js (http://www.nihilogic.dk/labs/exifjquery/)
 * set exifData: true 
 * to keep EXIF data in your jpeg from Photoshop© you can't use "save for the web" command; use "save as..." and save as .jpg instead.
 */

(function($){

  jQuery.mbGallery ={
    name:"mb.gallery",
    author:"Matteo Bicocchi",
    version:"2.0.2",
    defaults:{
      containment:"body",
      cssURL:"css/",
      skin:"white",
      overlayBackground:"#333",
      exifData:false, //todo

      galleryTitle:"My Gallery",
      imageSelector: ".imgFull",
      thumbnailSelector: ".imgThumb",
      titleSelector: ".imgTitle",
      descSelector: ".imgDesc",

      minWidth: 300,
      minHeight: 200,
      maxWidth: 0,
      maxHeight: 0,
      fullScreen:true,
      addRaster:false,
      overlayOpacity:.5,
      startFrom: 0,//"random"
      fadeTime: 500,
      slideTimer: 6000,
      autoSlide: true,

      onOpen:function(){},
      onBeforeClose:function(){},
      onClose:function(){},
      onChangePhoto:function(){}
    },
    buildMbGallery:function(options){
      var gallery= jQuery(this).get(0);
      if (gallery.initialized){
        jQuery(gallery).mb_closeGallery();
        return;
      }
      gallery.initialized = true;
      gallery.options = jQuery.extend({}, jQuery.mbGallery.defaults, options);
      if(gallery.options.onOpen) gallery.options.onOpen();

      var css= "<link rel='stylesheet' id='mbGalleryCss' type='text/css' href='"+gallery.options.cssURL+gallery.options.skin+".css' title='tyle'  media='screen'/>";
      jQuery("head").prepend(css);
      jQuery(gallery).hide();
      gallery.galleryID= "mb_gallery_"+gallery.id;
      jQuery(gallery).mb_getPhotos();

      var overlay=jQuery("<div/>").addClass("mb_overlay").one("click",function(){jQuery(gallery).mb_closeGallery();}).css({opacity:gallery.options.overlayOpacity,background: gallery.options.overlayBackground}).hide();
      var galleryScreen= jQuery("<div/>").attr("id",gallery.galleryID).addClass("galleryScreen").addClass("mbGall_"+gallery.options.skin);
      var galleryDesc=jQuery("<div/>").addClass("galleryDesc").css({opacity:.7}).hide();
      var galleryTitle=jQuery("<div/>").addClass("galleryTitle").html(gallery.options.galleryTitle);
      var galleryImg= jQuery("<div/>").addClass("galleryImg")
              .hover(function(){if (galleryDesc.html()) galleryDesc.slideDown();},function(){galleryDesc.slideUp();})
              .dblclick(function(){if (gallery.sliding) jQuery(gallery).mb_stopSlide(); else jQuery(gallery).mb_startSlide();});
      var galleryRaster= jQuery("<div/>").addClass("galleryRaster").css({width:"100%",height:"100%"});
      var galleryLoader= jQuery("<div/>").addClass("loader").mb_bringToFront().css("opacity",.7).hide();
      var galleryThumbs=jQuery("<div/>").addClass("galleryThumbs").hide();
      var galleryNav=jQuery("<div/>").addClass("galleryNav").hide();
      galleryScreen.bind("mouseleave",function(){
        jQuery(gallery).mb_hideThumbs();
      });
      if(gallery.options.containment=="body"){
        jQuery("body").append(overlay);
        overlay.fadeIn();
        jQuery("body").append(galleryScreen);
      }else{
        galleryScreen.addClass("conatined");
        jQuery("#"+gallery.options.containment).show();
        jQuery("#"+gallery.options.containment).append(galleryScreen);
      }
      galleryScreen.append(galleryNav);
      galleryScreen.append(galleryTitle);

      var galleryCloseIcon= jQuery("<div/>").addClass("galleryCloseIcon ico").one("click",function(){jQuery(gallery).mb_closeGallery();});//galleryCloseIcon
      galleryTitle.append(galleryCloseIcon);

      galleryScreen.append(galleryImg);
      galleryImg.append(galleryLoader);
      if(gallery.options.addRaster)
        galleryImg.append(galleryRaster).mb_bringToFront();
      galleryImg.append(galleryThumbs);
      galleryImg.append(galleryDesc);
      if(gallery.options.containment=="body")
        galleryScreen.css({
          minWidth:gallery.options.minWidth,
          minHeight:gallery.options.minHeight,
          top:"50%",
          marginTop:-(gallery.options.minHeight/2),
          left:"50%",
          marginLeft:-(gallery.options.minWidth/2)
        });
      galleryImg.css({
        minWidth:gallery.options.minWidth,
        minHeight:gallery.options.minHeight
      });
      gallery.sliding=gallery.options.autoSlide;
      gallery.idx=gallery.options.startFrom=="random"?Math.floor(Math.random()*(gallery.images.length-1)):gallery.options.startFrom;
      jQuery("#"+gallery.galleryID).find(".loader").addClass("loading").show();
      jQuery(gallery).mb_buildThumbs();
      jQuery(gallery).mb_selectThumb();
      jQuery(gallery).mb_buildNav();
      jQuery(gallery).mb_preload();
//      setTimeout(function(){galleryNav.fadeIn(500);},1000);
    },
    getPhotos: function(){
      var gallery= jQuery(this).get(0);
      gallery.images= new Array();
      jQuery(gallery).find(gallery.options.thumbnailSelector).each(function(i){
        var photo=new Object();
        photo.idx= i;
        photo.thumb= jQuery(this).attr("href");
        photo.full= jQuery(this).next("a").attr("href");
        photo.fullWidth= jQuery(this).attr("w")?jQuery(this).attr("w"):false;
        photo.fullHeight= jQuery(this).attr("h")?jQuery(this).attr("h"):false;
        photo.title= jQuery(this).nextAll(gallery.options.titleSelector).html();
        photo.description= jQuery(this).nextAll(gallery.options.descSelector).html();
        gallery.images.push(photo);
      });
    },
    preload:function(){
      var gallery= jQuery(this).get(0);
      if(!gallery.sliding) jQuery("#"+gallery.galleryID).find(".loader").addClass("loading").show();
      var rndVar=jQuery.browser.msie?"?"+new Date():"";
      var showExif=gallery.options.exifData;
      jQuery("<img/>").attr({"src":gallery.images[gallery.idx].full+rndVar,"exif":showExif}).load(
              function(){
                if(!gallery.sliding) jQuery("#"+gallery.galleryID).find(".loader").fadeOut(500,function(){jQuery("#"+gallery.galleryID).find(".loader").removeClass("loading");});
                jQuery(gallery).mb_changePhoto(rndVar);
                jQuery(gallery).mb_selectThumb();
              });

    },
    changePhoto:function(rndVar){
      var gallery= jQuery(this).get(0);
      jQuery("#"+gallery.galleryID).find(".loader").fadeOut(500,function(){jQuery("#"+gallery.galleryID).find(".loader").removeClass("loading");});
      var galleryImg=jQuery("#"+gallery.galleryID).find(".galleryImg");
      var photoTitle=jQuery("#"+gallery.galleryID).find(".photoTitle");
      var galleryDesc=jQuery("#"+gallery.galleryID).find(".galleryDesc");
      var galleryScreen=jQuery("#"+gallery.galleryID);
      var galleryNav=jQuery("#"+gallery.galleryID).find(".galleryNav");
      var newImg= jQuery("<img/>").addClass("highRes").attr({src:gallery.images[gallery.idx].full+rndVar}).css({position:"absolute",top:0,left:0}).hide();
      galleryImg.prepend(newImg);

      var dim=newImg.getDim(gallery,gallery.images[gallery.idx].fullWidth,gallery.images[gallery.idx].fullHeight);
      var w=parseFloat(dim[1]);
      var h=parseFloat(dim[0]);
      if(gallery.options.containment=="body")
        galleryScreen.animate({
          top:"50%",
          marginTop:-(h/2),
          left:"50%",
          marginLeft:-(w/2)
        },"slow");
      galleryImg.animate({
        width:w,
        height:h
      },"slow");

      newImg.fadeIn("slow",function(){galleryNav.fadeIn(500)});
      newImg.next("img").fadeOut("slow",function(){jQuery(this).remove();});
      photoTitle.fadeOut("slow",function(){photoTitle.html(gallery.images[gallery.idx].title); photoTitle.fadeIn();});
      galleryDesc.html(gallery.images[gallery.idx].description);
      if(gallery.sliding){
        galleryNav.find(".startStopIcon").addClass("selected");
        gallery.startGallery=setTimeout(function(){
          gallery.idx=gallery.idx==gallery.images.length-1?0:gallery.idx+1;
          jQuery(gallery).mb_preload();
        },gallery.options.slideTimer);
      }
      galleryNav.find(".photoCounter").html((gallery.idx+1)+" / <b>"+gallery.images.length+"</b>");
      if(galleryDesc.html()=="") galleryDesc.slideUp();
      if(gallery.options.onChangePhoto) gallery.options.onChangePhoto();
    },
    buildThumbs:function(){
      var gallery= jQuery(this).get(0);
      var galleryThumbs=jQuery("#"+gallery.galleryID).find(".galleryThumbs");
      galleryThumbs.empty();
      jQuery(gallery.images).each(function(i){
        var photo=this;
        var img=jQuery("<img/>").addClass("thumb");
        img.attr("src",photo.thumb);
        img.attr("id", gallery.galleryID+"_thumb_"+i);
        img.bind("click",function(){
          if(jQuery(this).is(".selected")) return;
          gallery.idx = photo.idx;
          jQuery(gallery).mb_selectThumb();
          jQuery(gallery).mb_stopSlide();
          jQuery(gallery).mb_preload();
          jQuery(gallery).mb_hideThumbs();
        });
        galleryThumbs.css("opacity",.9);
        galleryThumbs.append(img);
      });
    },
    buildNav:function(){
      var gallery= jQuery(this).get(0);
      var galleryNav=jQuery("#"+gallery.galleryID).find(".galleryNav");
      var galleryThumbs=jQuery("#"+gallery.galleryID).find(".galleryThumbs");

      var photoTitle= jQuery("<div/>").addClass("photoTitle");
      var thumbsIcon= jQuery("<div/>").addClass("thumbsIcon ico").bind("click",function(){
        if(galleryThumbs.is(":hidden")) jQuery(gallery).mb_showThumbs();
        else jQuery(gallery).mb_hideThumbs();
      });
      var startStopIcon= jQuery("<div/>").addClass("startStopIcon ico").bind("click",function(){
        if (gallery.sliding) jQuery(gallery).mb_stopSlide();
        else jQuery(gallery).mb_startSlide();
      });
      var prevIcon= jQuery("<div/>").addClass("prevIcon ico").bind("click",function(){
        jQuery(gallery).mb_galleryPrev();
      });
      var nextIcon= jQuery("<div/>").addClass("nextIcon ico").bind("click",function(){
        jQuery(gallery).mb_galleryNext();
      });

       var showExif=gallery.options.exifData;
       var exifIcon= showExif?jQuery("<div/>").addClass("exifIcon ico").bind("click",function(){
         jQuery(gallery).mb_showExifData();
       }):"";

      var photoCounter= jQuery("<div/>").addClass("photoCounter ico");

      var galleryBtns= jQuery("<div/>").addClass("galleryBtns");
      galleryNav.append(photoTitle);
      galleryNav.append(galleryBtns);
      galleryBtns.prepend(thumbsIcon).prepend(startStopIcon).prepend(prevIcon).prepend(nextIcon).prepend((showExif?exifIcon:"")).prepend(photoCounter);
    },
    //   todo
    showExifData:function(){
      var gallery= jQuery(this).get(0);
      /*
      EXIF methods:
      jQuery(this).exif(key): a specific key;
      jQuery(this).exifPretty(): all key as string;
      jQuery(this).exifAll(): all key as object;
       */
     // console.debug(jQuery("#"+gallery.galleryID).find(".highRes").exifAll());
      jQuery(gallery).mb_stopSlide();
    },
    selectThumb:function(){
      var gallery= jQuery(this).get(0);
      var galleryThumbs=jQuery("#"+gallery.galleryID).find(".galleryThumbs");
      var actualThumb=jQuery("#"+gallery.galleryID+"_thumb_"+gallery.idx);
      galleryThumbs.find(".thumb").removeClass("selected").css("opacity",1);
      actualThumb.addClass("selected").css("opacity",.4);
    },
    startSlide:function(idx){
      var gallery= jQuery(this).get(0);
      var galleryNav=jQuery("#"+gallery.galleryID).find(".galleryNav");
      gallery.sliding=true;

      gallery.idx=idx?idx: gallery.idx==gallery.images.length-1?0:gallery.idx+1;
      jQuery(gallery).mb_preload();
      galleryNav.find(".startStopIcon").addClass("selected");
    },
    stopSlide:function(){
      var gallery= jQuery(this).get(0);
      var galleryNav=jQuery("#"+gallery.galleryID).find(".galleryNav");
      gallery.sliding=false;
      clearTimeout(gallery.startGallery);
      galleryNav.find(".startStopIcon").removeClass("selected");
    },
    prev:function(){
      var gallery= jQuery(this).get(0);
      jQuery(gallery).mb_stopSlide();
      gallery.sliding=false;
      gallery.idx=gallery.idx==0?gallery.images.length-1:gallery.idx-1;
      jQuery(gallery).mb_preload();
    },
    next:function(){
      var gallery= jQuery(this).get(0);
      jQuery(gallery).mb_stopSlide();
      gallery.sliding=false;
      gallery.idx=gallery.idx==gallery.images.length-1?0:gallery.idx+1;
      jQuery(gallery).mb_preload();
    },
    gotoIDX:function(idx){
      var gallery= jQuery(this).get(0);
      gallery.idx = idx-1;
      jQuery(gallery).mb_selectThumb();
      jQuery(gallery).mb_stopSlide();
      jQuery(gallery).mb_preload();
      jQuery(gallery).mb_hideThumbs();

    },
    loader:function(){
      var gallery= jQuery(this).get(0);
      var galleryNav=jQuery("#"+gallery.galleryID).find(".galleryNav");
      galleryNav.find(".thumbsIcon").addClass("selected");
      var galleryThumbs=jQuery("#"+gallery.galleryID).find(".galleryThumbs");
      galleryThumbs.slideDown();
    },
    hideThumbs:function(){
      var gallery= jQuery(this).get(0);
      var galleryNav=jQuery("#"+gallery.galleryID).find(".galleryNav");
      galleryNav.find(".thumbsIcon").removeClass("selected");
      var galleryThumbs=jQuery("#"+gallery.galleryID).find(".galleryThumbs");
      galleryThumbs.slideUp();
    },
    closeGallery:function(){
      var gallery= jQuery(this).get(0);
      if(gallery.options.onBeforeClose) gallery.options.onBeforeClose();
      if(!jQuery.browser.msie)
        jQuery("#"+gallery.galleryID).animate({position:"absolute",top:-1000},"slow",
                function(){
                  jQuery("#"+gallery.galleryID).remove();
                  jQuery("#"+gallery.options.containment).slideUp();
                  if (gallery.options.onClose) gallery.options.onClose();
                });
      else{
        jQuery("#"+gallery.galleryID).remove();
        jQuery("#"+gallery.options.containment).hide();
      }
      jQuery(".mb_overlay").slideUp("slow",function(){jQuery(".mb_overlay").remove();});
      jQuery(gallery).mb_stopSlide();
      gallery.initialized=false;
    }
  };

  jQuery.fn.extend({
    getDim:function(gallery,w,h){
      var nw=w?w:jQuery(this).outerWidth();
      var nh=h?h:jQuery(this).outerHeight();
      var wh=gallery.options.containment=="body"?jQuery(window).height():jQuery("#"+gallery.options.containment).innerHeight();
      var ww=gallery.options.containment=="body"?jQuery(window).width():jQuery("#"+gallery.options.containment).innerWidth();
      if (gallery.options.galleryMaxHeight>0 && jQuery(this).outerHeight()>gallery.options.galleryMaxHeight){nh=gallery.options.galleryMaxHeight;}
      if (gallery.options.galleryMaxWidth>0 && jQuery(this).outerWidth()>gallery.options.galleryMaxWidth){nw=gallery.options.galleryMaxWidth;}


      if (parseFloat(nh)+120>=wh || gallery.options.fullScreen){
        nh= wh-130;
        nw=(nh*jQuery(this).outerWidth())/jQuery(this).outerHeight();
        jQuery(this).attr("height", nh);
        jQuery(this).attr("width", nw);
      }
      if (parseFloat(nw)+100>=ww ){
        nw= ww-120;
        nh=(nw*jQuery(this).outerHeight())/jQuery(this).outerWidth();
        jQuery(this).attr("width", nw);
        jQuery(this).attr("height", nh);
      }

      return [nh,nw];
    }
  });

  // public methods
  jQuery.fn.mbGallery= jQuery.mbGallery.buildMbGallery;
  jQuery.fn.mb_getPhotos= jQuery.mbGallery.getPhotos;
  jQuery.fn.mb_buildThumbs= jQuery.mbGallery.buildThumbs;
  jQuery.fn.mb_buildNav= jQuery.mbGallery.buildNav;
  jQuery.fn.mb_preload= jQuery.mbGallery.preload;
  jQuery.fn.mb_changePhoto= jQuery.mbGallery.changePhoto;
  jQuery.fn.mb_selectThumb= jQuery.mbGallery.selectThumb;
  jQuery.fn.mb_showExifData= jQuery.mbGallery.showExifData;

  jQuery.fn.mb_galleryNext= jQuery.mbGallery.next;
  jQuery.fn.mb_galleryPrev= jQuery.mbGallery.prev;
  jQuery.fn.mb_gotoIDX= jQuery.mbGallery.gotoIDX;
  jQuery.fn.mb_startSlide= jQuery.mbGallery.startSlide;
  jQuery.fn.mb_stopSlide= jQuery.mbGallery.stopSlide;

  jQuery.fn.mb_showThumbs= jQuery.mbGallery.loader;
  jQuery.fn.mb_hideThumbs= jQuery.mbGallery.hideThumbs;
  jQuery.fn.mb_closeGallery= jQuery.mbGallery.closeGallery;

  jQuery.fn.mb_bringToFront= function(){
    var zi=10;
    jQuery('*').each(function() {
      if(jQuery(this).css("position")=="absolute" || jQuery(this).css("position")=="fixed"){
        var cur = parseInt(jQuery(this).css('zIndex'));
        zi = cur > zi ? parseInt(jQuery(this).css('zIndex')) : zi;
      }
    });
    jQuery(this).css('zIndex',zi+=1);
    return jQuery(this);
  };

})(jQuery);